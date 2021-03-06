@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div id="app">
                    <menus-component :menus="{{$menus}}">

                    </menus-component>
                </div>
            </div>
        </div>
    </div>
@endsection
