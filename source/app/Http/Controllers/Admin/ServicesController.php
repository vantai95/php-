<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CommonService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\Faq;
use App\Models\ServiceFeedback;
use App\Models\Service;
use App\Models\Image;
use App\Models\Promotion;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.services.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/services'),
                    'text' => __('admin.services.breadcrumbs.service_index')
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

        $services = Service::select('services.*')->orderBy('services.id', 'desc');

        if ($status == Service::STATUS_FILTER['inactive']) {
            $services = $services->where('services.active', '=', false);
        } elseif ($status == Service::STATUS_FILTER['active']) {
            $services = $services->where('services.active', '=', true);
        } else {
            $status = "";
        }

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $services = $services->where(function ($query) use ($keyword) {
                $query->orWhere('services.name_en', 'LIKE', $keyword);
                $query->orWhere('services.name_vi', 'LIKE', $keyword);
            });
        }

        $services = $services->paginate($perPage);
        return view('admin.services.index', compact('services', 'status', 'breadcrumbs', 'lang'));
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
            'title' => __('admin.services.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/services'),
                    'text' => __('admin.services.breadcrumbs.service_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.services.breadcrumbs.add_service')
                ]
            ]
        ];
        $categories = Category::where('active',1)->get();
        $faqs = Faq::get();
        $serviceFeedbacks = ServiceFeedback::get();
        $promotions = Promotion::where('active',1)->get();
        return view('admin.services.create', compact('breadcrumbs', 'imageList','categories','faqs','serviceFeedbacks','promotions'));
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
            'video' => 'embed_link'
        ]);
        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];

        isset($requestData['faqs']) ? $requestData['faqs'] = json_encode($requestData['faqs']) :$requestData['faqs'] = "";
        isset($requestData['services_feedbacks']) ? $requestData['services_feedbacks'] = json_encode($requestData['services_feedbacks']) : $requestData['services_feedbacks'] = "";

        Service::create($requestData);
        Session::flash('flash_message', trans('admin.services.flash_messages.new'));

        return redirect('admin/services');
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
        $service = Service::findOrFail($id);
        ($service->faqs == null) ? $service->faqs = [] : $service->faqs = json_decode($service->faqs);
        ($service->services_feedbacks == null) ? $service->services_feedbacks = [] : $service->services_feedbacks = json_decode($service->services_feedbacks);
        //get all checked image
        $checkedImageList = $service->image_after;
        $checkedThumbImageList = $service->image_before;

        $categories = Category::where('active',1)->get();
        $breadcrumbs = [
            'title' => __('admin.services.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/services'),
                    'text' => __('admin.services.breadcrumbs.service_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.services.breadcrumbs.edit_service')
                ],
            ]
        ];

        if (empty($service->image)) {
            $service->image = '';
        } else {
            $service->image;
        }

        $faqs = Faq::get();
        $serviceFeedbacks = ServiceFeedback::get();
        $promotions = Promotion::where('active',1)->get();
        return view('admin.services.edit', compact('service', 'breadcrumbs', 'imageList', 'checkedImageList','checkedThumbImageList','categories','faqs','serviceFeedbacks','promotions'));
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
            'video' => 'embed_link'
        ]);
        $requestData = $request->all();
        $services = Service::findOrFail($id);
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];

        isset($requestData['faqs']) ? $requestData['faqs'] = json_encode($requestData['faqs']) :$requestData['faqs'] = "";
        isset($requestData['services_feedbacks']) ? $requestData['services_feedbacks'] = json_encode($requestData['services_feedbacks']) : $requestData['services_feedbacks'] = "";
        $services->update($requestData);
        Session::flash('flash_message', trans('admin.services.flash_messages.update'));
        return redirect('admin/services');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $services = Service::findOrFail($id);
        //delete image
        if (!empty($services->image) && File::exists(public_path(config('constants.UPLOAD.SERVICE_IMAGE')) . '/' . $services->image)) {
            unlink(public_path(config('constants.UPLOAD.SERVICE_IMAGE')) . '/' . $services->image);
        }
        $services->delete();

        Session::flash('flash_message', __('admin.services.flash_messages.destroy'));

        return redirect("admin/services");
    }

    public function upload()
    {
        return;
    }
}
