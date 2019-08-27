<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CommonService;
use Session, Log;
use Carbon\Carbon;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.contacts.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/contacts'),
                    'text' => __('admin.contacts.breadcrumbs.contact_index')
                ]
            ]
        ];
        $keyword = $request->get('q');
        $orderDate = $request->get('order-date');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $contactList = Contact::orderBy('created_at', 'desc');
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $contactList = $contactList->where('email', 'LIKE', $keyword);
        }

        if (!empty($orderDate)) {
            $contactList = $contactList->whereDate('created_at', '=', Carbon::parse($orderDate)->toDateString());
        }
        $contactList = $contactList->paginate($perPage);
        return view('admin.contacts.index', compact('contactList', 'breadcrumbs'));
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
            'title' => __('admin.contacts.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/contacts'),
                    'text' => __('admin.contacts.breadcrumbs.contact_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.contacts.breadcrumbs.contact_update')
                ]
            ]
        ];
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.edit', compact('contact', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $requestData = $request->all();
        $contact = Contact::findOrFail($id);
        $contact->update($requestData);
        Session::flash('flash_message', trans('admin.contacts.flash_message.update'));
        return redirect('admin/contacts');
    }

    public function booking(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.orders.breadcrumbs.title_booking'),
            'links' => [
                [
                    'href' => url('admin/orders/booking'),
                    'text' => __('admin.orders.breadcrumbs.booking_index')
                ]
            ]
        ];
        $keyword = $request->get('q');
        $orderDate = $request->get('order_date');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $bookingList = Order::where("order_type", "<", 2)->orderBy('created_at', 'desc');
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $bookingList = $bookingList->where(function ($query) use ($keyword) {
                $query->orWhere('email', 'LIKE', $keyword);
                $query->orWhere('phone_number', 'LIKE', $keyword);
            });
        }

        if (!empty($orderDate)) {
            $bookingList = $bookingList->whereDate('created_at', '=', Carbon::parse($orderDate)->toDateString());
        }
        $bookingList = $bookingList->paginate($perPage);
        $is_booking = true;
        return view('admin.orders.booking', compact('bookingList', 'is_booking', 'breadcrumbs'));
    }

    public function viewBooking($id)
    {
        $breadcrumbs = [
            'title' => __('admin.orders.breadcrumbs.title_booking'),
            'links' => [
                [
                    'href' => url('admin/orders/booking'),
                    'text' => __('admin.orders.breadcrumbs.booking_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.orders.breadcrumbs.booking_view')
                ]
            ]
        ];

        $lang = Session::get('locale');
        $order = Order::with(['items' => function ($query) use ($lang) {
            $query->select("items.name_$lang as item_name", 'order_items.quantity as item_quantity', 'order_items.price as item_price');
        }])->findOrFail($id);
        $is_booking = true;
        return view('admin.orders.view_booking', compact('order', 'is_booking', 'breadcrumbs'));
    }


    public function order(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.orders.breadcrumbs.title_order'),
            'links' => [
                [
                    'href' => url('admin/orders/order'),
                    'text' => __('admin.orders.breadcrumbs.order_index')
                ]
            ]
        ];
        $keyword = $request->get('q');
        $orderDate = $request->get('order_date');

        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $bookingList = Order::where("order_type", 2)->orderBy('created_at', 'desc');
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $bookingList = $bookingList->where(function ($query) use ($keyword) {
                $query->orWhere('email', 'LIKE', $keyword);
                $query->orWhere('phone_number', 'LIKE', $keyword);
            });
        }

        if (!empty($orderDate)) {
            $bookingList = $bookingList->whereDate('created_at', '=', Carbon::parse($orderDate)->toDateString());
        }
        $bookingList = $bookingList->paginate($perPage);
        $is_booking = false;
        return view('admin.orders.booking', compact('bookingList', 'is_booking', 'breadcrumbs'));
    }

    public function viewOrder($id)
    {
        $breadcrumbs = [
            'title' => __('admin.orders.breadcrumbs.title_order'),
            'links' => [
                [
                    'href' => url('admin/orders/order'),
                    'text' => __('admin.orders.breadcrumbs.order_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.orders.breadcrumbs.order_view')
                ]
            ]
        ];

        $lang = Session::get('locale');
        $order = Order::with(['items' => function ($query) use ($lang) {
            $query->select("items.name_$lang as item_name", 'order_items.quantity as item_quantity', 'order_items.price as item_price');
        }])->findOrFail($id);
        $is_booking = false;
        return view('admin.orders.view_booking', compact('order', 'is_booking', 'breadcrumbs'));
    }

}
