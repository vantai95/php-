@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__body">
				<div class="m-invoice-2">
					<div class="m-invoice__wrapper">
						<div class="m-invoice__head">
							<div class="m-invoice__container ">								
								<div class="m-invoice__items">
									<div class="m-invoice__item">
										<span class="m-invoice__subtitle">
										@lang('admin.orders.columns.data').
										</span>
										<span class="m-invoice__text">
										@lang('admin.orders.columns.created_date') : {{\App\Services\CommonService::formatSendDate($order->created_at)}}
										@if($is_booking) 	
										<br>@lang('admin.orders.columns.datetime_reservation') : {{\App\Services\CommonService::formatDateTime($order->datetime_reservation)}}
										@else
										<br>@lang('admin.orders.columns.datetime_delivery') : {{\App\Services\CommonService::formatDateTime($order->datetime_delivery)}}											
										@endif	
												</span>
										<span class="m-invoice__subtitle">
											@lang('admin.orders.columns.status').
										</span>
										<span class="m-invoice__text">
											{{$order->orderStatus()}}
											</span>
									</div>
									<div class="m-invoice__item">
										<span class="m-invoice__subtitle">
										@lang('admin.orders.columns.invoice_info').
										</span>
										<span class="m-invoice__text">
											@lang('admin.orders.columns.name') : {{$order->name}}
											<br>
											@lang('admin.orders.columns.email') : {{$order->email}}
											<br>
											@lang('admin.orders.columns.phone') : {{$order->phone_number}}
											@if($is_booking) 
											<br>@lang('admin.orders.columns.address') : {{$order->address}}											
											<br>@lang('admin.orders.columns.pax') : {{$order->pax}}
											@else
											<br>@lang('admin.orders.columns.gender') : {{$order->gender}}
											<br>@lang('admin.orders.columns.delivery_address') : {{$order->address}}
											<br>@lang('admin.orders.columns.district') : {{$order->district}}
										@endif
										</span>
									</div>
									<div class="m-invoice__item">
										<span class="m-invoice__subtitle">
										@lang('admin.orders.columns.notes').
										</span>
										<span class="m-invoice__text">
										{{$order->note}}										
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="m-invoice__body ">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>
											@lang('admin.orders.columns.item')
											</th>
											<th>
											@lang('admin.orders.columns.unit_price')
											</th>
											<th>
											@lang('admin.orders.columns.quantity')
											</th>
											<th>											
											@lang('admin.orders.columns.total_amount_item')
											</th>
										</tr>
									</thead>
									<tbody>
									@foreach($order->items as  $item)
										<tr>
											<td>
												{{$item->item_name}}
											</td>
											<td>
												
											{{\App\Services\CommonService::formatPriceVND($item->item_price)}}
											</td>
											<td>
											{{$item->item_quantity}}
											</td>
											<td class="m--font-danger">
											
											{{\App\Services\CommonService::formatPriceVND($item->item_price * $item->item_quantity)}}
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						<div class="m-invoice__footer">
							<div class="m-invoice__table  m-invoice__table--centered table-responsive">
								<table class="table">
									<thead>
										<tr>
										
											<th>
											@lang('admin.orders.columns.total_amount_invoice')
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										
											<td class="m--font-danger">
											{{\App\Services\CommonService::formatPriceVND($order->total)}}
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
	

			</div>
	

        </div>
    </div>
@endsection


