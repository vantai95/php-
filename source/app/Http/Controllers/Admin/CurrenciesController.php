<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Log;

class CurrenciesController extends Controller
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
            'title' => __('admin.currencies.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/currencies'),
                    'text' => __('admin.currencies.breadcrumbs.currency_index')
                ]
            ]
        ];
        $keyword = $request->get('q');
        $status = $request->get('status');

        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');

        $currencies = Currency::orderBy('created_at', 'asc');
        if ($status == Currency::STATUS_FILTER['inactive']) {
            $currencies = $currencies->where('currencies.active', '=', false);
        } elseif ($status == Currency::STATUS_FILTER['active']) {
            $currencies = $currencies->where('currencies.active', '=', true);
        } else {
            $status = "";
        }

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $currencies = $currencies->where(function ($query) use ($keyword) {
                $query->orWhere('code', 'LIKE', $keyword);
            });
        }
        $currencies = $currencies->paginate($perPage);
        return view ('admin.currencies.index',compact('currencies', 'status', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.currencies.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/currencies'),
                    'text' => __('admin.currencies.breadcrumbs.currency_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.currencies.breadcrumbs.add_currency')
                ]
            ]
        ];
        return view('admin.currencies.create', compact('breadcrumbs'));
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
            'code' => 'required',
            'symbol' => 'required',
            'exchange_rate' => 'required',
        ]);
        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        Currency::create($requestData);
        Session::flash('flash_message', trans('admin.currencies.flash_messages.new'));
        return redirect('admin/currencies');
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
            'title' => __('admin.currencies.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/currencies'),
                    'text' => __('admin.currencies.breadcrumbs.currency_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.currencies.breadcrumbs.edit_currency')
                ]
            ]
        ];
        $currency = Currency::findOrFail($id);
        return view('admin.currencies.edit',compact('currency', 'breadcrumbs'));
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
            'code' => 'required',
            'symbol' => 'required',
            'exchange_rate' => 'required',
        ]);
        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        $currency = Currency::findOrFail($id);
        $currency->update($requestData);
        Session::flash('flash_message', trans('admin.currencies.flash_messages.update'));
        return redirect('admin/currencies');
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
        $currency = Currency::findOrFail($id);
        $currency->delete();
        Session::flash('flash_message', trans('admin.currencies.flash_messages.destroy'));
        return redirect('admin/currencies');
    }
}
