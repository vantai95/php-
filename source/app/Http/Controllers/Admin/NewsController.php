<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsType;
use App\Models\Image;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Log;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.news.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/news'),
                    'text' => __('admin.news.breadcrumbs.news_index')
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

        $news = News::select('news.*')->orderBy('news.id', 'desc');

        if ($status == News::STATUS_FILTER['inactive']) {
            $news = $news->where('news.active', '=', false);
        } elseif ($status == News::STATUS_FILTER['active']) {
            $news = $news->where('news.active', '=', true);
        } else {
            $status = "";
        }

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $news = $news->where(function ($query) use ($keyword) {
                $query->orWhere('news.name_en', 'LIKE', $keyword);
                $query->orWhere('news.name_vi', 'LIKE', $keyword);
            });
        }

        $news = $news->paginate($perPage);
        return view('admin.news.index', compact('news', 'status', 'breadcrumbs', 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $imageList = Image::get();

        foreach ($imageList as $image) {
            $image->size = $image->getFileSize();
        }

        $breadcrumbs = [
            'title' => __('admin.news.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/news'),
                    'text' => __('admin.news.breadcrumbs.news_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.news.breadcrumbs.add_news')
                ]
            ]
        ];

        $lang = Session::get('locale');
        $news_types = NewsType::orderBy('name_en', 'asc')->pluck("name_$lang", 'id');
        return view('admin.news.create', compact('breadcrumbs', 'imageList','news_types'));
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
            'name_vi' => 'required',
            'date_begin' => 'date_format:Y-m-d'
        ]);
        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];

        News::create($requestData);
        Session::flash('flash_message', trans('admin.news.flash_messages.new'));

        return redirect('admin/news');
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
        $imageList = Image::get();

        foreach ($imageList as $image) {
            $image->size = $image->getFileSize();
        }

        $news = News::findOrFail($id);
        $checkedImageList = $news->image;

        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.news.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/news'),
                    'text' => __('admin.news.breadcrumbs.news_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.news.breadcrumbs.edit_news')
                ],
            ]
        ];

        if (empty($news->image)) {
            $news->image = '';
        } else {
            $news->image;
        }
        $news_types = NewsType::orderBy('name_en', 'asc')->pluck("name_$lang", 'id');
        
        return view('admin.news.edit', compact('news', 'breadcrumbs', 'imageList', 'checkedImageList','news_types'));
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
            'name_vi' => 'required',
            'date_begin' => 'date_format:Y-m-d'
        ]);

        $requestData = $request->all();
        $News = News::findOrFail($id);
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];

        $News->update($requestData);
        Session::flash('flash_message', trans('admin.news.flash_messages.update'));
        return redirect('admin/news');
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
        $News = News::findOrFail($id);
        //delete image
        if (!empty($News->image) && File::exists(public_path(config('constants.UPLOAD.news_IMAGE')) . '/' . $News->image)) {
            unlink(public_path(config('constants.UPLOAD.news_IMAGE')) . '/' . $News->image);
        }
        $News->delete();

        Session::flash('flash_message', __('admin.news.flash_messages.destroy'));

        return redirect("admin/news");
    }

    public function upload()
    {
        return;
    }
}
