<div class="service-detail-bottom">
    <div class="container">
        <div class="related-treatment">
            <div class="row">
                <div class="col-12 text-center mb-2 mb-sm-4">
                    <div class="title">@lang('b2c.service.detail.title.related_treatments')</div>
                </div>
            </div>
            <div class="row">
                @foreach ($relatedTreament as $item)
                <div class="col-12 col-sm-4 text-center">
                    <div class="content">
                        <div>
                            <img class="img-treatment" src="/images/image_list/{{ $item->image }}" alt="" title="">
                        </div>
                        <div class="treatment-category mt-2 mb-2">{{$item->category_name}}</div>
                        <div class="treatment-title row">
                            <div class="col-10 m-auto">{{$item->service_name}}</div>
                        </div>
                        <div class="button"><a
                                href="{{url('services/detail/'.$item ->id)}}"><span>@lang('b2c.service.detail.text.view_more')</span></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
