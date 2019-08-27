<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Promotion;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Log;

class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('q');
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $promotions = Promotion::orderBy('sequence', 'asc');

        if ($status == Promotion::STATUS_FILTER['inactive']) {
            $promotions = $promotions->where('active', '=', false);
        } elseif ($status == Promotion::STATUS_FILTER['active']) {
            $promotions = $promotions->where('active', '=', true);
        } else {
            $status = "";
        }

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $promotions = $promotions->where(function ($query) use ($keyword) {
                $query->orWhere('name_en', 'LIKE', $keyword);
                $query->orWhere('name_vi', 'LIKE', $keyword);
            });
        }
        $promotions = $promotions->paginate($perPage);

        session(['mainPage' => $request->fullUrl()]);

        $breadcrumbs = [
            'title' => __('admin.promotions.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/promotions'),
                    'text' => __('admin.promotions.breadcrumbs.promotion_index')
                ]
            ]
        ];

        return view('admin.promotions.index', compact('promotions', 'status', 'breadcrumbs'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function sequenceIndex(Request $request)
    {
        $promotions = Promotion::orderBy('sequence', 'asc')->get();

        $breadcrumbs = [
            'title' => __('admin.promotions.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.layouts.breadcrumbs.change_sequence')
                ]
            ]
        ];

        return view('admin.promotions.sequence_index', compact('promotions', 'breadcrumbs'));
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
            'title' => __('admin.promotions.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/promotions'),
                    'text' => __('admin.promotions.breadcrumbs.promotion_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.promotions.breadcrumbs.add_promotion')
                ]
            ]
        ];

        return view('admin.promotions.create', compact('breadcrumbs', 'imageList'));
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
        ]);

        $requestData = $request->all();

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];
        isset($requestData['enable_detail_page']) ? $requestData['enable_detail_page'] = true : $requestData['enable_detail_page'] = false;
        isset($requestData['show_in_home_page']) ? $requestData['show_in_home_page'] = true : $requestData['show_in_home_page'] = false;

        // $requestData['sequence'] = Promotion::count() + 1;
        $promotionSequence = Promotion::orderBy('sequence','desc')->first();
        if(!empty($promotionSequence)){
          $requestData['sequence'] =  $promotionSequence->sequence + 1;
        }else {
            $requestData['sequence'] = 1;
        }

        Promotion::create($requestData);

        Session::flash('flash_message', trans('admin.promotions.flash_messages.new'));

        return redirect('admin/promotions');
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
        $promotion = Promotion::findOrFail($id);
        $checkedImageList = $promotion->image;

        $breadcrumbs = [
            'title' => __('admin.promotions.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/promotions'),
                    'text' => __('admin.promotions.breadcrumbs.promotion_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.promotions.breadcrumbs.edit_promotion')
                ]
            ]
        ];

        if (empty($promotion->image)) {
            $promotion->image = '';
        } else {
            $promotion->image;
        }

        return view('admin.promotions.edit', compact('promotion', 'breadcrumbs', 'imageList', 'checkedImageList'));
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
        ]);
        $requestData = $request->all();
        $promotion = Promotion::findOrFail($id);

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];
        isset($requestData['enable_detail_page']) ? $requestData['enable_detail_page'] = true : $requestData['enable_detail_page'] = false;
        isset($requestData['show_in_home_page']) ? $requestData['show_in_home_page'] = true : $requestData['show_in_home_page'] = false;
        $promotion->update($requestData);

        Session::flash('flash_message', trans('admin.promotions.flash_messages.update'));

        return redirect('admin/promotions');
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
        $proIds = $request->get('proIds');
        foreach ($proIds as $key=>$proId){
            Promotion::where('id',$proId)->update(['sequence'=> $key+1]);
        }
        return response()->json('updated', 200);
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
        $promotion = Promotion::findOrFail($id);
        //delete image
        if (!empty($promotion->image) && File::exists(public_path(config('constants.UPLOAD.PROMOTION_IMAGE')) . '/' . $promotion->image)) {
            unlink(public_path(config('constants.UPLOAD.PROMOTION_IMAGE')) . '/' . $promotion->image);
        }
        $promotion->delete();

        Session::flash('flash_message', trans('admin.promotions.flash_messages.destroy'));

        return redirect('admin/promotions');
    }

    public function upload()
    {
        return;
    }
}
