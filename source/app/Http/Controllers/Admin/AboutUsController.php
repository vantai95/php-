<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Session, Log;
use App\Models\Image;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     *
     * @internal param Request $request
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.abouts_us.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/about-us'),
                    'text' => __('admin.abouts_us.breadcrumbs.abouts_us_index')
                ]
            ]
        ];
        $status = $request->get('status');

        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $aboutsUs = AboutUs::orderBy('id', 'asc');

        if (!empty($status)) {
            if ($status == AboutUs::STATUS_FILTER['INACTIVE']) {
                $aboutsUs = $aboutsUs->where('active', '=', false);
            } elseif ($status == AboutUs::STATUS_FILTER['ACTIVE']) {
                $aboutsUs = $aboutsUs->where('active', '=', true);
            }
        }
        $aboutsUs = $aboutsUs->paginate($perPage);
        return view('admin.abouts_us.index', compact('aboutsUs', 'status', 'breadcrumbs'));
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
            'title' => __('admin.abouts_us.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/about-us'),
                    'text' => __('admin.abouts_us.breadcrumbs.abouts_us_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.abouts_us.breadcrumbs.abouts_us_create')
                ],
            ]
        ];

        return view('admin.abouts_us.create', compact('breadcrumbs','imageList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *va
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        $validateList = [
            'name_en' => 'required',
            'short_description_en' => 'required',
            'description_en' => 'required',
        ];

        $this->validate($request, $validateList);

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        AboutUs::create($requestData);

        Session::flash('flash_message', trans('admin.abouts_us.flash_message.new'));

        return redirect('admin/about-us');
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

        $aboutUs = AboutUs::findOrFail($id);

        //get all checked image
        $checkedImageList = $aboutUs->image;

        $breadcrumbs = [
            'title' => __('admin.abouts_us.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/about-us'),
                    'text' => __('admin.abouts_us.breadcrumbs.abouts_us_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.abouts_us.breadcrumbs.abouts_us_update')
                ],
            ]
        ];


        return view('admin.abouts_us.edit', compact('aboutUs', 'breadcrumbs','imageList','checkedImageList'));
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
        $requestData = $request->all();

        $validateList = [
            'name_en' => 'required',
            'short_description_en' => 'html_required',
            'description_en' => 'html_required',
        ];

        $this->validate($request, $validateList);

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        $aboutUs = AboutUs::findOrFail($id);

        $aboutUs->update($requestData);

        Session::flash('flash_message', trans('admin.abouts_us.flash_message.update'));

        return redirect('admin/about-us');
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
        $aboutUs = AboutUs::findOrFail($id);

        $aboutUs->delete();

        Session::flash('flash_message', trans('admin.abouts_us.flash_message.destroy'));

        return redirect('admin/about-us');
    }

    public function upload()
    {
        return;
    }
}
