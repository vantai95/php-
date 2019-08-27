<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Session, Log;

class SubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     * @internal param Request $request
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.sub_categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/categories'),
                    'text' => __('admin.sub_categories.breadcrumbs.sub_category_index')
                ]
            ]
        ];
        $lang = Session::get('locale');
        $keyword = $request->get('q');
        $status = $request->get('status');
        $categoryId = $request->get('category_id');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $subCategories = SubCategory::select('sub_categories.*', "categories.name_$lang as category_name")
            ->join('categories', 'sub_categories.category_id', 'categories.id')
            ->orderBy('sub_categories.sequence', 'asc');

        if ($status == SubCategory::STATUS_FILTER['inactive']) {
            $subCategories = $subCategories->where('sub_categories.active', '=', false);
        } elseif ($status == SubCategory::STATUS_FILTER['active']) {
            $subCategories = $subCategories->where('sub_categories.active', '=', true);
        } else {
            $status = "";
        }

        if (!empty($categoryId)) {
            $subCategories->where('sub_categories.category_id', $categoryId);
        }

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $subCategories = $subCategories->where(function ($query) use ($keyword) {
                $query->orWhere('sub_categories.name_en', 'LIKE', $keyword);
                $query->orWhere('sub_categories.name_vi', 'LIKE', $keyword);
                $query->orWhere('sub_categories.name_ja', 'LIKE', $keyword);
            });
        }
        $subCategories = $subCategories->paginate($perPage);
        return view('admin.sub_categories.index', compact('subCategories', 'status', 'categoryId', 'breadcrumbs', 'lang'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function sequenceIndex(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.sub_categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.layouts.breadcrumbs.change_sequence')
                ]
            ]
        ];
        $categoryId = $request->get('category_id');

        $subCategories = SubCategory::select('sub_categories.*');

        if (!empty($categoryId)) {
            $subCategories->where('category_id', $categoryId)
                ->orderBy('sequence', 'asc');
        } else {
            $subCategories = $subCategories->where('category_id', '');
        }
        $subCategories = $subCategories->get();
        return view('admin.sub_categories.sequence_index', compact('subCategories', 'breadcrumbs', 'categoryId'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.sub_categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/sub-categories'),
                    'text' => __('admin.sub_categories.breadcrumbs.sub_category_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.sub_categories.breadcrumbs.add_sub_category')
                ]
            ]
        ];
        $categories = Category::orderBy('sequence', 'asc')->pluck("name_$lang", 'id');
        return view('admin.sub_categories.create', compact('categories', 'breadcrumbs','lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_en' => 'required',
            'description_en' => 'required',
            'category_id' => 'required',
        ]);

        $requestData = $request->all();

        $subCategoryNumb = SubCategory::where('category_id', $requestData['category_id'])->count();

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        if(!$requestData['parent_id']){
            unset($requestData['parent_id']);
        }

        $requestData['sequence'] = $subCategoryNumb + 1;

        $category = Category::findOrfail($requestData['category_id']);

        $category->subCategories()->create($requestData);

        Session::flash('flash_message', trans('admin.sub_categories.flash_messages.new'));

        return redirect('admin/sub-categories');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.sub_categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/sub-categories'),
                    'text' => __('admin.sub_categories.breadcrumbs.sub_category_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.sub_categories.breadcrumbs.edit_sub_category')
                ]
            ]
        ];
        $subCategory = SubCategory::findOrFail($id);
        $categories = Category::orderBy('sequence', 'asc')->pluck("name_$lang", 'id');

        return view('admin.sub_categories.edit', compact('subCategory', 'categories', 'breadcrumbs','lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name_en' => 'required',
            'description_en' => 'html_required',
            'category_id' => 'required',
        ]);

        $requestData = $request->all();

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        if(!$requestData['parent_id']){
            unset($requestData['parent_id']);
        }

        $subCategory = SubCategory::findOrFail($id);

        $subCategory->update($requestData);

        Session::flash('flash_message', trans('admin.sub_categories.flash_messages.update'));

        return redirect('admin/sub-categories');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateSequence(Request $request)
    {
        $requestDatas = $request->all();
        foreach ($requestDatas['sub_categories'] as $requestData) {
            SubCategory::where('sub_categories.id', $requestData['id'])
                ->update(['sequence' => $requestData['sequence'],
                ]);
        }
        return response('updated', 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subSubCategories = SubCategory::where('parent_id',$id)->get();

        foreach ($subSubCategories as $subSubCategory){
            $subSubCategory->delete();
        }
        $subCategory->delete();

        Session::flash('flash_message', trans('admin.sub_categories.flash_messages.destroy'));

        return redirect('admin/sub-categories');
    }


    public function getSubSubCategories($id)
    {
        $arr = [];
        $lang = Session::get('locale');
        $arr['subCategory'] = SubCategory::where('category_id',$id)->whereNull('parent_id')->get(['id', "name_$lang as name"]);
        return response()->json($arr);

    }

}
