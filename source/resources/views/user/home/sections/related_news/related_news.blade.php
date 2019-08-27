<div class="related-news pt-2 pt-sm-5 pb-2 pb-sm-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-12 title mb-2 mb-sm-4"><span style="font-weight:bold">&minus;</span>
                @lang('b2c.home.latest_news.title.latest_news') <span style="font-weight:bold">&minus;</span></div>
        </div>
        <div class="row mt-2 mt-sm-3 mb-2 mb-sm-3 news-body">
            @foreach ($news as $item)
            <div class="col-sm-6 col-md-3 box">
                <div class="news-image mt-1 mb-1">
                    <a href="{{url('news/detail/'.$item ->id)}}">
                      <img class="latest-news-img"
                            src="{{\App\Services\ImageService::imageUrl($item->image) }}" alt="banner" title="banner"></a>
                </div>
                <div class="news-type mt-1 mb-1">{{$item->news_type_name}}</div>
                <div class="news-title mt-1 mb-1"><a href="{{url('news/detail/'.$item ->id)}}">{{ $item ->name}}</a>
                </div>
                <div class="news-date mt-1 mb-1">{{ $item->created_at->toFormattedDateString() }}</div>
                <div class="news-content mt-1 mb-1">{!! $item->short_description !!}</div>
                <div class="mt-2 mb-2 mt-sm-4 mb-4 read-more"><a href="{{url('news/detail/'.$item ->id)}}"><span
                            class="text-read-more">@lang('b2c.home.latest_news.text.read_more')</span></a> </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
