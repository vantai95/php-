<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\CategoryMeta;

class CategoryMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.category_meta.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/category-meta'),
                    'text' => __('admin.category_meta.breadcrumbs.category_meta_index')
                ]
            ]
        ];
        session(['mainPage' => $request->fullUrl()]);

        $keyword = $request->get('q');
        $status = $request->get('status');

        $lang = Session::get('locale');

        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $category_meta = CategoryMeta::select('category_meta.*')->orderBy('category_meta.id', 'desc');


        if (!empty($keyword)) {
            $category_meta = $category_meta->where(function ($query) use ($keyword) {
                $query->orWhere('category_meta.name_en', 'LIKE', $keyword);
                $query->orWhere('category_meta.name_vi', 'LIKE', $keyword);
            });
        }

        $category_meta = $category_meta->paginate($perPage);
        return view('admin.category_meta.index', compact('category_meta', 'breadcrumbs', 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.category_meta.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/category-meta'),
                    'text' => __('admin.category_meta.breadcrumbs.category_meta_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.category_meta.breadcrumbs.add_category_meta')
                ]
            ]
        ];
        $categories = Category::where('active',1)->get();
        return view('admin.category_meta.create', compact('breadcrumbs','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_vi' => 'required'
        ]);
        $requestData = $request->all();
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];

        CategoryMeta::create($requestData);
        Session::flash('flash_message', trans('admin.category_meta.flash_messages.new'));

        return redirect('admin/category-meta');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_meta = CategoryMeta::findOrFail($id);

        $categories = Category::where('active',1)->get();
        $breadcrumbs = [
            'title' => __('admin.category_meta.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/category-meta'),
                    'text' => __('admin.category_meta.breadcrumbs.category_meta_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.category_meta.breadcrumbs.edit_category_meta')
                ],
            ]
        ];
        return view('admin.category_meta.edit', compact('categories', 'breadcrumbs','category_meta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name_vi' => 'required'
        ]);
        $requestData = $request->all();
        $category_meta = CategoryMeta::findOrFail($id);
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];

        $category_meta->update($requestData);
        Session::flash('flash_message', trans('admin.category_meta.flash_messages.update'));
        return redirect('admin/category-meta');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category_meta = CategoryMeta::findOrFail($id);
        $category_meta->delete();

        Session::flash('flash_message', __('admin.category_meta.flash_messages.destroy'));

        return redirect("admin/category-meta");
    }

    public function upload()
    {
        return;
    }
}
