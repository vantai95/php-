@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/items/items-sequence', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-bottom-20">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-5">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.items.search.category'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="category_id"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($categoryId == "" ? 'selected' : '') }} >
                                                    @lang('admin.items.text.category')
                                                </option>
                                                @foreach(\App\Models\Category::select('name_en','id')->get() as $cat)
                                                    <option value="{{ $cat->id }}" {{ $categoryId != $cat->id ? '' : 'selected' }}>{{ $cat->name_en }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.items.search.sub_category'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="sub_category_id"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="0" {{ (!$subCategoryId ? 'selected' : '') }} >
                                                    @lang('admin.items.text.sub_category')
                                                </option>
                                                @foreach(\App\Models\SubCategory::select('name_en','id')->get() as $sub_cat)
                                                    <option value="{{ $sub_cat->id }}" {{ $subCategoryId != $sub_cat->id ? '' : 'selected' }}>{{ $sub_cat->name_en }}</option>
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
                    <items-component :items="{{$items}}">

                    </items-component>
                </div>
            </div>
        </div>
    </div>
@endsection
