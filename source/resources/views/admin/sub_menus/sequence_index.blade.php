@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/sub-menus/sub-menus-sequence', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-bottom-20">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-5">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.sub_menus.search.menu'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="menu_id"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($menuId == "" ? 'selected' : '') }} >
                                                    @lang('admin.sub_menus.search.choose')
                                                </option>
                                                @foreach(\App\Models\Menu::select('name_en','id')->get() as $menu)
                                                    <option value="{{ $menu->id }}" {{ $menuId != $menu->id ? '' : 'selected' }}>{{ $menu->name_en }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div id="app">
                    <sub-menus-component :sub_menus="{{$sub_menus}}">

                    </sub-menus-component>
                </div>
            </div>
        </div>
    </div>
@endsection
