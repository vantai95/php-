<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CommonService;
use App\Services\Implement\CategoryService;
use Illuminate\Http\Request;
use Session, Log;


class CategoriesController extends Controller
{

  protected $categoryService;
  public function __construct(CategoryService $categoryService){
    $this->categoryService = $categoryService;
  }

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
            'title' => __('admin.categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/categories'),
                    'text' => __('admin.categories.breadcrumbs.category_index')
                ]
            ]
        ];
        $keyword = $request->get('q');
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');
        $categories = Category::orderBy('sequence', 'asc');
        if(!empty($status)) {
            if ($status == Category::STATUS_FILTER['inactive']) {
                $categories = $categories->where('active', '=', false);
            } elseif ($status == Category::STATUS_FILTER['active']) {
                $categories = $categories->where('active', '=', true);
            }
        }
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $categories = $categories->where(function ($query) use ($keyword) {
                $query->orWhere('name_en', 'LIKE', $keyword);
                $query->orWhere('name_vi', 'LIKE', $keyword);
                $query->orWhere('name_ja', 'LIKE', $keyword);
            });
        }
        $categories = $categories->paginate($perPage);
        return view('admin.categories.index', compact('categories', 'status', 'breadcrumbs'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function sequenceIndex(Request $request)
    {
        $categories = Category::orderBy('sequence', 'asc')->get();
        $breadcrumbs = [
            'title' => __('admin.categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.layouts.breadcrumbs.change_sequence')
                ]
            ]
        ];
        return view ('admin.categories.sequence_index', compact('categories', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/categories'),
                    'text' => __('admin.categories.breadcrumbs.category_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.categories.breadcrumbs.add_category')
                ]
            ]
        ];
        return view('admin.categories.create', compact( 'breadcrumbs'));
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
        ]);
        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        $requestData['sequence'] = Category::count() + 1;
        $requestData['type'] = isset($requestData['type'][0])?$requestData['type'][0]:0;

        $category = Category::create($requestData);
        $metaData = $request->input('category_metas');

        $this->categoryService->addMeta($category, $metaData);

        Session::flash('flash_message', trans('admin.categories.flash_messages.new'));
        return redirect('admin/categories');
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
        $breadcrumbs = [
            'title' => __('admin.categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/categories'),
                    'text' => __('admin.categories.breadcrumbs.category_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.categories.breadcrumbs.edit_category')
                ]
            ]
        ];
        $category = Category::findOrFail($id)->load('category_metas');
        return view('admin.categories.edit', compact('category', 'breadcrumbs'));
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
        ]);
        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        $requestData['type'] = isset($requestData['type'][0])?$requestData['type'][0]:0;
        $category = Category::findOrFail($id);
        $category->update($requestData);
        $metaData = $request->input('category_metas');
        $this->categoryService->editMeta($category, $metaData);
        Session::flash('flash_message', trans('admin.categories.flash_messages.update'));
        return redirect('admin/categories');
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
        foreach ($requestDatas['categories'] as $requestData){
            Category::where('id', $requestData['id'])->update([
                'sequence' => $requestData['sequence'],
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
        $category = Category::findOrFail($id);
        if (!$category->canDelete()) {
            Session::flash('flash_error', trans('admin.categories.flash_messages.can\'t_destroy'));
        } else {
            $category->delete();
            Session::flash('flash_message', trans('admin.categories.flash_messages.destroy'));
        }
        return redirect('admin/categories');
    }

}
