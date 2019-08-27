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
                {!! Form::open(['method' => 'GET', 'url' => '/admin/contacts', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-5">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label ">
                                            <label class="text-nowrap">
                                                @lang('admin.contacts.search.date')
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <input type="text" name="contact-date" class="form-control"
                                                   id="m_datepicker_1" onchange="this.form.submit()"
                                                   value="{{Request::get('contact-date')}}" readonly
                                                   placeholder="{{trans('admin.contacts.search.date_place_holder_text')}}"/>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input"
                                               placeholder="@lang('admin.contacts.search.place_holder_text')"
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
                    <tr class="table-dark text-center">
                        <th>@lang('admin.contacts.columns.name')</th>
                        <th>@lang('admin.contacts.columns.email')</th>
                        <th>@lang('admin.contacts.columns.content')</th>
                        <th>@lang('admin.contacts.columns.note')</th>
                        <th>@lang('admin.contacts.columns.created_date')</th>
                        <th style="width:10%">@lang('admin.contacts.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contactList as  $contact)
                        <tr>
                            <td class="align-middle text-center">{{ $contact->name }}</td>
                            <td class="align-middle text-center">{{ $contact->email }}</td>
                            <td class="align-middle text-center">{{ $contact->content }}</td>
                            <td class="align-middle text-center">{{ $contact->note }}</td>
                            <td class="align-middle text-center">{{ \App\Services\CommonService::formatSendDate($contact->created_at) }}</td>
                            <td class="text-nowrap align-middle text-center">
                                <a href="{{ url('/admin/contacts/' . $contact->id) }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="Show Detail">
                                    <i class="la la-book"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @if(count($contactList) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.contacts.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $contactList->appends(['q' => Request::get('q'),'contact-date' => Request::get('contact-date')])->render() !!}
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
