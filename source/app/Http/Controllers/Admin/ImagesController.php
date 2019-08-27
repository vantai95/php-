<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Log;
use Storage;
use App\Models\Image;

class ImagesController extends Controller
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
            'title' => __('admin.image_list.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/image-list'),
                    'text' => __('admin.image_list.breadcrumbs.image_list_index')
                ]
            ]
        ];

        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $imageLists = Image::orderBy('id', 'asc');

        $imageLists = $imageLists->paginate($perPage);
        return view('admin.image_list.index', compact('imageLists', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.image_list.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/image-list'),
                    'text' => __('admin.image_list.breadcrumbs.image_list_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.image_list.breadcrumbs.image_list_create')
                ],
            ]
        ];

        return view('admin.image_list.create', compact('breadcrumbs'));
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
        $requestData = $request->all();

        $image = '';
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $photoName = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path(config('constants.UPLOAD.IMAGE_LIST')),$photoName);
            $image = $photoName;
        }

        $requestData['image'] = $image;

        Image::create($requestData);

        Session::flash('flash_message', trans('admin.image_list.flash_message.new'));

        return response()->json(['url' => redirect('admin/image-list')->getTargetUrl(), 'success' => true]);
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
        $imageList = Image::findOrFail($id);

        $breadcrumbs = [
            'title' => __('admin.image_list.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/image-list'),
                    'text' => __('admin.image_list.breadcrumbs.image_list_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.image_list.breadcrumbs.image_list_update')
                ],
            ]
        ];


        return view('admin.image_list.edit', compact('imageList', 'breadcrumbs'));
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

        $imageList = Image::findOrFail($id);

        //retrieve image from database
        $image = empty($imageList->image) ? '' : $imageList->image;

        $flag = false;

        foreach ($requestData as $key => $value) {
            if (strpos($key, 'image_') !== false) {
                $photoName = str_replace("_", ".", substr($key, 6));
                //check if image added exist or not
                $is_exist = $photoName == $imageList->image ? true : false;
                //if added image not exist, then add it to database
                if (!$is_exist) {
                    $file = $request->file('file');
                    $photoName = time() . '.' . $file->getClientOriginalExtension();
                    File::delete(public_path(config('constants.UPLOAD.IMAGE_LIST')) . '/' . $imageList->image);
                    $file->move(public_path(config('constants.UPLOAD.IMAGE_LIST')),$photoName);
                    $image = $photoName;
                }
                $flag = true;
            }
        }

        if (!$flag) {
            $image = '';
            File::delete(public_path(config('constants.UPLOAD.IMAGE_LIST')) . '/' . $imageList->image);
        }

        $requestData['image'] = $image;

        $imageList->update($requestData);

        Session::flash('flash_message', trans('admin.image_list.flash_message.update'));

        return response()->json(['url' => redirect('admin/image-list')->getTargetUrl(), 'success' => true]);
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
        $image = Image::findOrFail($id);

        $image->delete();

        File::delete(public_path(config('constants.UPLOAD.IMAGE_LIST')) . '/' . $image->image);
        Session::flash('flash_message', trans('admin.image_list.flash_message.destroy'));

        return redirect('admin/image-list');
    }

    public function upload()
    {
        return;
    }

    public function uploadNewImage(Request $request)
    {
        $file = $request->file('image');

        $photoName = time() . '.' . $file->getClientOriginalExtension();

        Storage::disk(ENV('FILESYSTEM_CLOUD'))->put($photoName, base64_decode($file));

        $file->move(public_path(config('constants.UPLOAD.IMAGE_LIST')),$photoName);
        //add image to Database

        $requestData['image'] = $photoName;

        $image = Image::create($requestData);
        $imageId = $image->id;
        $imageSize = $image->getFileSize();

        return response()->json([
            'success' => true,
            'message' => trans('admin.image_list.flash_message.upload_img'),
            'image_name' => $image->image,
            'image_id' => $imageId,
            'image_size' => $imageSize
        ]);
    }

    public function uploadThumb(Request $request)
    {

        $file = $request->file('image');

        $photoName = 'thumb_' . time() . '.' . $file->getClientOriginalExtension();

        $file->move(public_path(config('constants.UPLOAD.IMAGE_LIST')),$photoName);
        //add image to Database

        $requestData['image'] = $photoName;

        $image = Image::create($requestData);
        $imageId = $image->id;
        $imageSize = $image->getFileSize();

        return response()->json([
            'success' => true,
            'message' => trans('admin.image_list.flash_message.upload_thumb_img'),
            'thumb_image_name' => $image->image,
            'image_id' => $imageId,
            'image_size' => $imageSize
        ]);
    }

    public function getImageList(Request $request){
      $images = Image::all();
      return response()->json(['data' => $images]);
    }

    public function uploadImageList(Request $request)
    {
        $imageNameList = [];
        $imageIdList = [];
        $imageSizeList = [];

        $files = $request->file('files');
        foreach ($files as $index => $file) {
            $photoName = time() . '.' . $index . '.' . $file->getClientOriginalExtension();
            Storage::disk('azure')->put($photoName, file_get_contents($file->getRealPath()));
            array_push($imageNameList, $photoName);
            $image = Image::create(['image' => $photoName ]);
            $imageIdList[] = $image->id;
            $imageSizeList[] = $image->getFileSize();
        }

        return response()->json([
            'success' => true,
            'message' => trans('admin.image_list.flash_message.upload_img'),
            'uploaded_image_list' => $imageNameList,
        ]);
    }

    public function deleteImages(Request $request){
      $requestImg = $request->input('imagesToDelete');
      $imgs = Image::whereIn('image', $requestImg)->get();
      foreach($imgs as $img){
        $img->delete();
      }
      Storage::disk('azure')->delete($requestImg);
        return response()->json([
          'success' => true,
          'message' => "Images deleted"
        ]);
    }
}
