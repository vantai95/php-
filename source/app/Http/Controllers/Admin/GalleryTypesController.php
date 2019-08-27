<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GalleryType;
use Session,Log;

class GalleryTypesController extends Controller
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
            'title' => __('admin.gallery_types.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/gallery-types'),
                    'text' => __('admin.gallery_types.breadcrumbs.gallery_type_index')
                ]
            ]
        ];
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');

        $galleryTypes = GalleryType::orderBy('id', 'asc');
        if ($status == "Active") {
            $galleryTypes = $galleryTypes->where('active', '=', 1);
        } elseif ($status == "Inactive") {
            $galleryTypes = $galleryTypes->where('active', '=', 0);
        } else {
            $status = "All";
        }
        $galleryTypes = $galleryTypes->paginate($perPage);
        return view('admin.gallery_types.index', compact('galleryTypes','status','breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.gallery_types.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/gallery-types'),
                    'text' => __('admin.gallery_types.breadcrumbs.gallery_type_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.gallery_types.breadcrumbs.gallery_type_create')
                ]
            ]
        ];
        return view('admin.gallery_types.create',compact('breadcrumbs'));
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
        ]);
        $requestData = $request->all();

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        GalleryType::create($requestData);

        Session::flash('flash_message', trans('admin.gallery_types.flash_message.new'));

        return redirect('admin/gallery-types');
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
            'title' => __('admin.gallery_types.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/gallery-types'),
                    'text' => __('admin.gallery_types.breadcrumbs.gallery_type_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.gallery_types.breadcrumbs.gallery_type_update')
                ]
            ]
        ];
        $galleryType = GalleryType::findOrFail($id);

        return view('admin.gallery_types.edit', compact('galleryType','breadcrumbs'));
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
        ]);

        $requestData = $request->all();

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        $galleryType = GalleryType::findOrFail($id);

        $galleryType->update($requestData);

        Session::flash('flash_message', trans('admin.gallery_types.flash_message.update'));

        return redirect('admin/gallery-types');
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
        $galleryType = GalleryType::findOrFail($id);

        if (!$galleryType->canDelete()) {
            Session::flash('flash_error', trans('admin.gallery_types.flash_message.cant_delete'));

        } else {
            $galleryType->delete();
            Session::flash('flash_message', trans('admin.gallery_types.flash_message.destroy'));
        }

        return redirect('admin/gallery-types');
    }
}
