@extends('layouts.app')
@section('content')
<div class="event-detail">
    <div class="event-detail-main pt-2 pt-sm-5 pb-2 pb-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8">
                    <div class="banner">
                        <img src="{{url('images/image_list/'.$news ->image)}}" alt="" title="">
                    </div>
                    <div class="event_time">
                        <div class="row event_time_content">
                            <div class="col-6 event_time_date"> <img src="/b2c-assets/img/promo-clock.png" alt="clock" title="clock">
                                <span class="date">{{ $news->created_at->toFormattedDateString() }}</span></div>
                            <div class="col-6 text-right event_time_social">
                                <span><a href="#"><img  src="/b2c-assets/img/icon-facebook.png" alt="" title=""></a></span>
                                <span><a href="#"><img  src="/b2c-assets/img/icon-google-plus.png" alt="" title=""></a></span>
                                <span><a href="#"><img  src="/b2c-assets/img/icon-pinterest.png" alt="" title=""></a></span>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="event_title">
                            {{$news->name }}
                        </div>
                        <div class="event_body">
                            {!!$news ->description!!}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="related-new">
                        <div class="related-new-content">
                            <div class="related-new-title">
                                @lang('b2c.news.detail.title.related_events')
                            </div>
                            @foreach ($events as $item)
                            <div class="related-new-body">
                                <a href="{{url('news/detail/'.$item ->id)}}"><img class="img-related-new" src="{{url('images/image_list/'.$item ->image)}}" alt="" title=""></a>
                                <div class="date-clock">
                                    <img class="img-clock" src="/b2c-assets/img/promo-clock.png" alt="" title="">
                                    <span class="date">{{ $item->created_at->toFormattedDateString() }}</span>
                                </div>
                                <div class="description"><a href="{{url('events/detail/'.$item ->id)}}">{{$item ->name}}</a></div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="event-detail-bottom">
        <div class="container">
            <div class="related-treatment">
                <div class="row">
                    <div class="col-12 text-center mb-2 mb-sm-4">
                        <div class="title">@lang('b2c.news.detail.title.related_treatments')</div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($service as $item)
                    <div class="col-12 col-sm-4 text-center">
                        <div class="content">
                            <div>
                                <img class="img-treatment" src="/images/image_list/{{ $item->image }}" alt="" title="">
                            </div>
                            <div class="treatment-category mt-2 mb-2">{{$item->category_name}}</div>
                            <div class="treatment-title row">
                                <div class="col-10 m-auto">{{$item->service_name}}</div>
                            </div>
                            <div class="button"><a href="{{url('services/detail/'.$item ->id)}}"><span>@lang('b2c.news.detail.text.view_more')</span></a></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
