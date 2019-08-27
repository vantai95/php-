@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/promotions', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-4">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.promotions.search.status'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="status"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                                    @lang('admin.promotions.statuses.all')
                                                </option>
                                                <option value="{{ \App\Models\Promotion::STATUS_FILTER['active'] }}" {{ ($status == \App\Models\Promotion::STATUS_FILTER['active'] ? 'selected' : '') }}>
                                                    @lang('admin.promotions.statuses.active')
                                                </option>
                                                <option value="{{ \App\Models\Promotion::STATUS_FILTER['inactive'] }}" {{ ($status == \App\Models\Promotion::STATUS_FILTER['inactive'] ? 'selected' : '') }}>
                                                    @lang('admin.promotions.statuses.inactive')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>

                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input" name="q"
                                               value="{{ Request::get('q') }}"
                                               class="form-control m-input"
                                               placeholder="@lang('admin.promotions.search.place_holder_text')"
                                               id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="{{ url('/admin/promotions/create') }}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>
                                    @lang('admin.promotions.breadcrumbs.new_promotion')
                                </span>
                            </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark text-center">
                        <th>@lang('admin.promotions.columns.sequence')</th>
                        <th>@lang('admin.promotions.columns.image')</th>
                        <th>@lang('admin.promotions.columns.name_vi')</th>
                        <th>@lang('admin.promotions.columns.begin_date')</th>
                        <th>@lang('admin.promotions.columns.end_date')</th>
                        <th>@lang('admin.promotions.columns.status')</th>
                        <th>@lang('admin.promotions.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body" id="promotions_sort">
                    @foreach($promotions as $key => $item)
                        <tr id="{{$item->id}}" class="text-center drag-cursor"
                                title="{{trans('admin.tooltip_title.change_sequence')}}">
                            <td class="align-middle">{{$item->sequence}}</td>
                            <td class="align-middle">
                                <img src="{{\App\Services\ImageService::imageUrl($item->image) }}" width="40" height="40" class="img-circle"
                                     style="border: 1px solid #ddd;">
                            </td>
                            <td class="align-middle">{{ $item->name_vi }}</td>
                            <td class="align-middle">{{ $item->begin_date }}</td>
                            <td class="align-middle">{{ $item->end_date }}</td>
                            <td class="align-middle">
                                <span class="m-badge {{ $item->status_class() }} m-badge--wide">{{ $item->status() }}</span>
                            </td>
                            <td class="text-nowrap align-middle">
                                <a href="{{ url('/admin/promotions/' . $item->id . '/edit') }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="@lang('admin.promotions.breadcrumbs.edit_promotion')">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                   'method' => 'DELETE',
                                   'url' => ['/admin/promotions', $item->id],
                                   'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this)"
                                   title="@lang('admin.promotions.breadcrumbs.delete_promotion')">
                                    <i class="la la-remove"></i>
                                </a>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    @if(count($promotions) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.promotions.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! Form::open(['method' => 'GET', 'url' => '/admin/promotions', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $promotions->appends(['q' => Request::get('q'), 'status' => $status])->render() !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('extra_scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(function () {
        $('#promotions_sort').sortable({
            cursor: "move",
            stop: function (event, ui) {

                var proIds = [];
                $('tbody tr').each(function () {
                    proIds.push($(this).attr('id'));
                });
                $.ajax({
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{url('admin/promotions/update-sequence')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: {proIds: proIds},
                    success: function (response) {
                        var sequence = 1;
                        $('tbody tr').each(function () {
                            var sequenceE = $(this).find('td').first();
                            sequenceE.text(sequence);
                            sequence = sequence + 1;
                        });
                        toastr.success('{{trans('admin.promotions.flash_messages.change_sequence')}}');
                    },
                    error: function (error) {
                        console.log(error);
                        toastr.error('{{trans('admin.promotions.flash_messages.change_sequence_error')}}');
                        $("#promotions_sort").sortable("cancel");
                    }
                })
            }
        });
    })
</script>
@endsection
