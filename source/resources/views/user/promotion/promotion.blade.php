@extends('layouts.app')
@section('content')
<div class="promotion">
    <div class="promotion-header">
        <div>
            <img class="img-banner" src="/b2c-assets/img/promotion_img.png" alt="banner" title="banner">
        </div>
    </div>
    @foreach ($promotions as $key => $promotion)
    @if ($key % 2 ==0)
    <div class="promotion-body promotion-bg">
        <div class="container">
            <div class="row pt-3 pb-3 pt-sm-5 pb-sm-5  h-100 justify-content-center align-items-center">
                <div class="col-12 col-md-6 text-right">
                    <a href="">
                        <img class="promotion-image" src="{{\App\Services\ImageService::imageUrl($promotion->image) }}" alt="" title="">
                    </a>
                </div>
                <div class="col-12 col-md-6 text-center ">
                    <div class="content">
                        <div class="title">{{ $promotion->name}}</div>
                        <div class="short-description">{!! $promotion->short_description!!}</div>
                        <div class="button mt-4"><a
                                href="{{url('promotions/detail/'.$promotion->id)}}"><span>@lang('b2c.promotion.index.text.view_more')</span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="promotion-body">
        <div class="container">
            <div class="row pt-3 pb-3 pt-sm-5 pb-sm-5  h-100 justify-content-center align-items-center">
                <div class="col-12 col-md-6 text-center ">
                    <div class="content">
                        <div class="title">{{ $promotion->name}}</div>
                        <div class="short-description">{!! $promotion->short_description!!}</div>
                        <div class="button mt-4"><a
                                href="{{url('promotions/detail/'.$promotion->id)}}"><span>@lang('b2c.promotion.index.text.view_more')</span></a></div>
                    </div>
                </div>
                <div class="col-12 col-md-6 text-right">
                    <a href="">
                        <img class="promotion-image" src="/images/image_list/{{ $promotion->image}}" alt="" title="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
    <div class="container">
        <div class="text-center mt-4 mb-4">
            {!! $promotions->render('vendor.pagination.front-end') !!}
        </div>
    </div>

</div>
@endsection
