<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Session, Log, Storage;


class GalleriesController extends Controller
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
        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.galleries.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/galleries'),
                    'text' => __('admin.galleries.breadcrumbs.gallery_index')
                ]
            ]
        ];
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $gallery_type_id = $request->get('gallery_type_id');

        $galleries = Gallery::join('gallery_types', 'gallery_types.id', 'galleries.gallery_type_id')
            ->select('galleries.*', "gallery_types.name_$lang as gallery_type_name");

        if (!empty($gallery_type_id)) {
            $galleries->where('galleries.gallery_type_id', $gallery_type_id);
        }

        $galleries = $galleries->paginate($perPage);
        return view('admin.galleries.index', compact('galleries', 'gallery_type_id', 'breadcrumbs', 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $lang = Session::get('locale');

        $imageList = Image::get();

        foreach ($imageList as $image) {
            $image->size = $image->getFileSize();
        }

        $breadcrumbs = [
            'title' => __('admin.galleries.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/galleries'),
                    'text' => __('admin.galleries.breadcrumbs.gallery_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.galleries.breadcrumbs.gallery_create')
                ]
            ]
        ];
        return view('admin.galleries.create', compact('breadcrumbs', 'lang', 'imageList'));
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
            'gallery_type_id' => 'required',
        ]);

        $requestData = $request->all();
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        Gallery::create($requestData);

        Session::flash('flash_message', trans('admin.galleries.flash_message.new'));
        return redirect('admin/galleries');
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

        $imageList = Image::get();
        foreach ($imageList as $image) {
            $image->size = $image->getFileSize();
        }
        $breadcrumbs = [
            'title' => __('admin.galleries.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/galleries'),
                    'text' => __('admin.galleries.breadcrumbs.gallery_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.galleries.breadcrumbs.gallery_update')
                ]
            ]
        ];
        $gallery = Gallery::findOrFail($id);
        //get all checked image
        $checkedImageList = $gallery->images;

        if (empty($gallery->images)) {
            $gallery->images = [];
        } else {
            $gallery->images = json_decode($gallery->images, false);
        }

        return view('admin.galleries.edit', compact('gallery', 'breadcrumbs', 'lang', 'imageList', 'checkedImageList'));
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
            'gallery_type_id' => 'required'
        ]);

        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];
        $gallery = Gallery::findOrFail($id);

        $gallery->update($requestData);

        Session::flash('flash_message', trans('admin.galleries.flash_message.update'));
        return redirect('admin/galleries');

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
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();
        Session::flash('flash_message', trans('admin.galleries.flash_message.destroy'));
        return redirect('admin/galleries');
    }


    public function upload()
    {
        return;
    }

}
