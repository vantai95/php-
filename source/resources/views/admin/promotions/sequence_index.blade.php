@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div id="app">
                    <promotions-component :promotions="{{$promotions}}">

                    </promotions-component>
                </div>
            </div>
        </div>
    </div>
@endsection