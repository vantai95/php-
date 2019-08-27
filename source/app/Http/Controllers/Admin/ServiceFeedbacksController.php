<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceFeedback;
use App\Models\Image;
use Session,Log;
use App\Services\CommonService;
use Illuminate\Support\Facades\File;

class ServiceFeedbacksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.service_feedback.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/service-feedbacks'),
                    'text' => __('admin.service_feedback.breadcrumbs.service_feedback_index')
                ]
            ]
        ];

        $keyword = $request->get('q');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');
        $serviceFeedbacks = ServiceFeedback::select('services_feedbacks.*' )->orderBy('services_feedbacks.id', 'desc');
        
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $serviceFeedbacks = $serviceFeedbacks->where(function ($query) use ($keyword) {
                $query->orWhere('name_en', 'LIKE', $keyword);
                $query->orWhere('name_vi', 'LIKE', $keyword);
            });
        }
        $serviceFeedbacks = $serviceFeedbacks->paginate($perPage);

        return view('admin.service_feedback.index', compact('breadcrumbs','serviceFeedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $imageList = Image::get();

        foreach ($imageList as $image) {
            $image->size = $image->getFileSize();
        }
        $breadcrumbs = [
            'title' => __('admin.service_feedback.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/service-feedbacks'),
                    'text' => __('admin.service_feedback.breadcrumbs.service_feedback_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.service_feedback.breadcrumbs.add_service_feedback')
                ]
            ]
        ];
        return view('admin.service_feedback.create', compact( 'breadcrumbs', 'imageList'));
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
            'name_vi' => 'required',
        ]);
        $requestData = $request->all();
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];

        ServiceFeedback::create($requestData);
        Session::flash('flash_message', trans('admin.service_feedback.flash_messages.new'));
        return redirect('admin/service-feedbacks');
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
        $imageList = Image::get();

        foreach ($imageList as $image) {
            $image->size = $image->getFileSize();
        }
        $serviceFeedback = ServiceFeedback::findOrFail($id);
        //get all checked image
        $checkedImageList = $serviceFeedback->image;

        $breadcrumbs = [
            'title' => __('admin.service_feedback.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/service-feedbacks'),
                    'text' => __('admin.service_feedback.breadcrumbs.service_feedback_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.service_feedback.breadcrumbs.edit_service_feedback')
                ],
            ]
        ];

        if (empty($serviceFeedback->image)) {
            $serviceFeedback->image = '';
        } else {
            $serviceFeedback->image;
        }

        return view('admin.service_feedback.edit', compact('serviceFeedback', 'breadcrumbs', 'imageList', 'checkedImageList'));
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
            'name_vi' => 'required',
        ]);

        $requestData = $request->all();
        $serviceFeedback = serviceFeedback::findOrFail($id);
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];

        $serviceFeedback->update($requestData);
        Session::flash('flash_message', trans('admin.service_feedback.flash_messages.update'));
        return redirect('admin/service-feedbacks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $serviceFeedback = serviceFeedback::findOrFail($id);
        //delete image
        if (!empty($serviceFeedback->image) && File::exists(public_path(config('constants.UPLOAD.service_feedback_IMAGE')) . '/' . $serviceFeedback->image)) {
            unlink(public_path(config('constants.UPLOAD.service_feedback_IMAGE')) . '/' . $serviceFeedback->image);
        }
        $serviceFeedback->delete();

        Session::flash('flash_message', __('admin.service_feedback.flash_messages.destroy'));

        return redirect("admin/service-feedbacks");
    }

    public function upload()
    {
        return;
    }
}
