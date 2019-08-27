@php
$lang = Session::get('locale');
@endphp
@extends('layouts.app')
@section('content') {!! Form::open(['method' => 'GET', 'url' => '/events']) !!}
<div class="event">
    <div class="event-header">
        <div>
            <img class="img-banner" src="/b2c-assets/img/cover_img_event.png" alt="banner" title="banner">
        </div>
    </div>
    <div class="event-main">
        <div class="container">
            <div class="row m-2 m-sm-3">
                <div class="col-12 col-sm-12 text-center event-title">@lang('b2c.event.index.title.latest')</div>
                <div class="col-12 col-sm-12 text-center event-info">@lang('b2c.event.index.title.news_events')</div>
                <div class="col-12 col-sm-8 mb-sm-3 m-auto text-center event-content">Lorem ipsum dolor sit amet,
                    consectetur adipisicing elit, sedi do eiusmod tempor incididunt ut labore et
                    dolore magna loit aliqua.</div>
            </div>
            <div class="event-upcoming-top">

                <div class="row">
                    <div class="col-12 col-sm-4 banner-upcoming-events " style="">
                        @lang('b2c.event.index.title.upcoming_events')</div>
                    <div class="col-12 col-sm-8 btn-upcoming-events ">
                        <span class="dropdown-category">
                            <select class="dropdown custom-select" name="event_type_id" onchange="this.form.submit()">
                                <option value="" {{ ($event_type_id == "" ? 'selected' : '') }}>
                                    @lang('admin.categories.statuses.all')
                                </option>
                                @foreach ($event_types as $item)
                                <option value="{{$item->id}}" {{$event_type_id == $item->id ? 'selected' : ''}}>
                                    {{$item->name}}
                                </option>
                                @endforeach
                            </select>
                        </span>
                        <span class="datepicker-event">
                            <input class="datepicker btn-light border-0 datepicker-upcoming-events"
                                value="{{isset($date_upcoming_event) ? $date_upcoming_event : ''}}" placeholder="@lang('b2c.event.index.date')"
                                type="text" name="date_upcoming_event" id="date_upcoming_event">
                        </span>
                    </div>
                </div>

            </div>
            @foreach ($events as $item)

            <div class="mt-2 mt-sm-3 mb-2 mb-sm-3 event-upcoming-body">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <a href="{{url('events/detail/'.$item ->id)}}"><img class="img-comming-event"
                                src="{{\App\Services\ImageService::imageUrl($item->image) }}" alt="banner" title="banner"></a>
                    </div>
                    <div class="col-12 col-sm-7 content-upcomming-event">
                        <div class="event_title"><a href="events/detail/{{$item ->id}}">{{$item ->name}}</a> </div>
                        <div class="event_time_body">
                            <img src="/b2c-assets/img/promo-clock.png" alt="clock" title="clock">
                            <span class="event_time">{{$item ->timeline}}</span>
                        </div>
                        <div class="event_location_body">
                            <img src="/b2c-assets/img/icon_location.png" alt="location" title="location">
                            <span class="event_location">{{$item ->location}}</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-2 date-upcomming-event">
                        <div class="date_event">
                            <div class="date">{{ Carbon\Carbon::parse($item->date_begin)->format('d') }}</div>
                            <div class="month">{{ Carbon\Carbon::parse($item->date_begin)->format('M y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="mt-5 event-upcoming-top">
                <div class="row">
                    <div class="col-12 col-sm-4 banner-upcoming-events " style="">@lang('b2c.event.index.title.news')
                    </div>
                    <div class="col-12 col-sm-8 btn-upcoming-events ">
                        <span class="dropdown-category ">
                            <select class="dropdown custom-select" name="news_type_id" onchange="this.form.submit()">
                                <option value="" {{ ($news_type_id == "" ? 'selected' : '') }}>
                                    @lang('admin.categories.statuses.all')
                                </option>
                                @foreach ($news_types as $item)
                                <option value="{{$item->id}}" {{$news_type_id == $item->id ? 'selected' : ''}}>
                                    {{$item->name}}
                                </option>
                                @endforeach
                            </select>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row mt-2 mt-sm-3 mb-2 mb-sm-3 event-new-body">
                @foreach ($news as $item)
                <div class="col-12 col-sm-3 box">
                    <div class="event-image mt-1 mb-1">
                        <a href="{{url('news/detail/'.$item ->id)}}"><img class="img-new-event"
                                src="{{\App\Services\ImageService::imageUrl($item->image) }}" alt="banner" title="banner"></a>
                    </div>
                    <div class="event-type mt-1 mb-1">{{$item->news_type_name}}</div>
                    <div class="event-title mt-1 mb-1"><a
                            href="{{url('news/detail/'.$item ->id)}}">{{ $item ->name}}</a></div>
                    <div class="event-date mt-1 mb-1">{{ $item->created_at->toFormattedDateString() }}</div>
                    <div class="event-content mt-1 mb-1">{!! $item->short_description !!}</div>
                    <div class="mt-2 mb-2 mt-sm-4 mb-4 read-more"><a href="{{url('news/detail/'.$item ->id)}}"><span
                                class="text-read-more">@lang('b2c.home.latest_news.text.read_more')</span></a></div>
                </div>
                @endforeach
                <div class="col-12 text-center">
                    {!! $news->appends(['event_type_id' => Request::get('event_type_id'), 'news_type_id' =>
                    Request::get('news_type_id'),'date_upcoming_event' => Request::get('date_upcoming_event')])->render('vendor.pagination.front-end') !!}
                </div>

            </div>
        </div>
    </div>

</div>
{!! Form::close() !!}
@endsection

@section('extra_scripts')
<script>
    $('.datepicker').datepicker({
        language: '{{$lang}}',
        format: 'yyyy-mm-dd'
    }).on('hide',function(e){
        this.form.submit();
    });

</script>
@endsection
