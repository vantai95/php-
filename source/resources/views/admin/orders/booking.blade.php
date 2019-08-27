@extends('admin.layouts.app')

@section('content')
    @php
        $lang = Session::get('locale');
    @endphp
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <!--begin: Search Form -->
                @if($is_booking)
                {!! Form::open(['method' => 'GET', 'url' => '/admin/orders/booking', 'class' => '', 'role' => 'search'])  !!}
                @else
                {!! Form::open(['method' => 'GET', 'url' => '/admin/orders/order', 'class' => '', 'role' => 'search'])  !!}
                @endif
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-5">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label ">
                                            <label class="text-nowrap">
                                                @lang('admin.orders.search.date')
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <input type="text" name="order_date" class="form-control"
                                                   id="m_datepicker_1" onchange="this.form.submit()"
                                                   value="{{Request::get('order_date')}}" readonly
                                                   placeholder="{{trans('admin.orders.search.date_place_holder_text')}}"/>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                                <div class="col-md-5">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input"
                                               placeholder="@lang('admin.orders.search.place_holder_text')"
                                               onchange="this.form.submit()"
                                               name="q"
                                               value="{{Request::get('q')}}"
                                               id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Search Form -->
                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark">
                        <th>@lang('admin.orders.columns.name')</th>
                        <th>@lang('admin.orders.columns.email')</th>
                        <th>@lang('admin.orders.columns.phone')</th>
                        <th>@lang('admin.orders.columns.total')</th>
                        <th>@lang('admin.orders.columns.note')</th>
                        <th>@lang('admin.orders.columns.created_date')</th>
                        <th style="width:10%">@lang('admin.orders.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bookingList as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone_number }}</td>
                            <td>
                            {{\App\Services\CommonService::formatPriceVND($item->total)}}
                            </td>
                            <td>{{ $item->note }}</td>
                            <td>{{ \App\Services\CommonService::formatSendDate($item->created_at) }}</td>
                            <td class="text-nowrap">
                            @if($is_booking)
                                <a href="{{ url('/admin/orders/booking/' . $item->id . '/view') }}"
                            @else
                                <a href="{{ url('/admin/orders/order/' . $item->id . '/view') }}"
                            @endif
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="View">
                                    <i class="la la-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @if(count($bookingList) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.orders.not_found_booking')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $bookingList->appends(['q' => Request::get('q'),'order_date' => Request::get('order_date')])->render() !!}
                    </div>
                </div>
                <!--end: Datatable -->
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script type="text/javascript">
        $('#m_datepicker_1').datepicker({
            language: '{{$lang}}',
            format: 'yyyy-mm-dd'
        });
    </script>
@endsection