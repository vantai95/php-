<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Log;

class PaymentMethodsController extends Controller
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
            'title' => __('admin.payment_methods.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/payment_methods'),
                    'text' => __('admin.payment_methods.breadcrumbs.payment_methods_index')
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
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');
       
        $payment_methods = PaymentMethod::select('payment_methods.*', "payment_methods.name_$lang as name")
           ->orderBy('payment_methods.id', 'desc');

        if ($status == PaymentMethod::STATUS_FILTER['inactive']) {
            $payment_methods = $payment_methods->where('payment_methods.active', '=', false);
        } elseif ($status == PaymentMethod::STATUS_FILTER['active']) {
            $payment_methods = $payment_methods->where('payment_methods.active', '=', true);
        } else {
            $status = "";
        }
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $payment_methods = $payment_methods->where(function ($query) use ($keyword) {
                $query->orWhere('payment_methods.name_en', 'LIKE', $keyword);
                $query->orWhere('payment_methods.name_vi', 'LIKE', $keyword);
                $query->orWhere('payment_methods.name_ja', 'LIKE', $keyword);
            });
        }

        $payment_methods = $payment_methods->paginate($perPage);
        return view ('admin.payment_methods.index',compact('payment_methods', 'status', 'breadcrumbs','lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.payment_methods.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/payment_methods'),
                    'text' => __('admin.payment_methods.breadcrumbs.payment_methods_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.payment_methods.breadcrumbs.payment_methods_create')
                ]
            ]
        ];
        
        return view('admin.payment_methods.create', compact('breadcrumbs'));
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
            'name_en' => 'required',
            'description_en' => 'required'
        ]);
        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        
        PaymentMethod::create($requestData);

        Session::flash('flash_message', trans('admin.payment_methods.flash_message.new'));

        return redirect('admin/payment-methods');
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
            'title' => __('admin.payment_methods.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/payment_methods'),
                    'text' => __('admin.payment_methods.breadcrumbs.payment_methods_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.payment_methods.breadcrumbs.payment_methods_update')
                ]
            ]
        ];
        $payment_method = PaymentMethod::findOrFail($id);
        return view('admin.payment_methods.edit',compact('payment_method', 'breadcrumbs'));
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
            'name_en' => 'required',
            'description_en' => 'html_required'
        ]);
        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        $payment_method = PaymentMethod::findOrFail($id);
        $flag = false;

        $payment_method->update($requestData);
        Session::flash('flash_message', trans('admin.payment_methods.flash_message.update'));
        return redirect('admin/payment-methods');
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
        $payment_method = PaymentMethod::findOrFail($id);
        $payment_method->delete();
        Session::flash('flash_message', trans('admin.payment_methods.flash_message.destroy'));
        return redirect('admin/payment-methods');
    }

    public function upload(){
        return;
    }
}
