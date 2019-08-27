<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsType;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Log;

class NewsTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        session(['mainPage' => $request->fullUrl()]);
        $breadcrumbs = [
            'title' => __('admin.news_types.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/news-types'),
                    'text' => __('admin.news_types.breadcrumbs.news_type_index')
                ]
            ]
        ];

        $keyword = $request->get('q');
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');

        $news_types = NewsType::orderBy('created_at', 'asc');

        if ($status == NewsType::STATUS_FILTER['inactive']) {
            $news_types = $news_types->where('active', '=', false);
        } elseif ($status == NewsType::STATUS_FILTER['active']) {
            $news_types = $news_types->where('active', '=', true);
        } else {
            $status = "";
        }

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $news_types = $news_types->where(function ($query) use ($keyword) {
                $query->orWhere('news_types.name_en', 'LIKE', $keyword);
                $query->orWhere('news_types.name_vi', 'LIKE', $keyword);
                $query->orWhere('news_types.name_ja', 'LIKE', $keyword);
            });
        }

        $news_types = $news_types->paginate($perPage);
        return view ('admin.news_types.index',compact('news_types', 'status', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.news_types.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/news-types'),
                    'text' => __('admin.news_types.breadcrumbs.news_type_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.news_types.breadcrumbs.add_news_type')
                ]
            ]
        ];

        return view('admin.news_types.create', compact('breadcrumbs'));
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
        $this->validate($request,[
            'name_vi' => 'required',
        ]);

        $requestData = $request->all();

        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        NewsType::create($requestData);

        Session::flash('flash_message', trans('admin.news_types.flash_messages.new'));

        return redirect('admin/news-types');
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
            'title' => __('admin.news_types.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/news-types'),
                    'text' => __('admin.news_types.breadcrumbs.news_type_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.news_types.breadcrumbs.edit_news_type')
                ]
            ]
        ];
        $news_type = NewsType::findOrFail($id);

        return view('admin.news_types.edit',compact('news_type', 'breadcrumbs' ));
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
        $this->validate($request,[
            'name_vi' => 'required',
        ]);
        $requestData = $request->all();

        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        $news_type = NewsType::findOrFail($id);

        $news_type->update($requestData);

        Session::flash('flash_message', trans('admin.news_types.flash_messages.update'));

        return redirect('admin/news-types');
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
        $news_type = NewsType::findOrFail($id);

        $news_type->delete();

        Session::flash('flash_message', trans('admin.news_types.flash_messages.destroy'));

        return redirect('admin/news-types');
    }
}
