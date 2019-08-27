<div class="service-main">
    <div class="container">
        <div class="service-main-top">
            <div class="text text-center">
                <div class="title">@lang('b2c.service.index.title.treatments')</div>
                <div class="desciption"></div>
            </div>
            <div class="category">
                <span class="button "><a href="/services" class="{{ ($category_id == "" ? 'active' : '') }}"><span>@lang('b2c.service.index.all')</span></a></span>
                @foreach ($categories as $item)
                <span class="button">
                <a href="/services/?category_id={{$item->id}}" class="{{ ($category_id == $item->id ? 'active' : '') }}"><span>{{$item->name}}</span></a>
                </span>
                @endforeach
            </div>
        </div>
    </div>
    <div class="service-main-bottom">
        <div class="container">
            <div class="row">
                @foreach ($services as $item)
                <div class="col-12 col-md-4 text-center mb-3 mb-md-5">
                    <div class="content">
                        <div>
                            <img class="img-treatment" src="{{\App\Services\ImageService::imageUrl($item->image) }}" alt="" title="">
                        </div>
                        <div class="treatment-category mt-2 mb-2">{{$item->category_name}}</div>
                        <div class="treatment-title row">
                            <div class="col-10 m-auto">{{$item->service_name}}</div>
                        </div>
                        <div class="button"><a
                                href="{{url('services/detail/'.$item ->slug)}}"><span>@lang('b2c.service.index.text.view_more')</span></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="container">
        <div class="text-center mt-4 mb-4">
            {!! $services->appends(['category_id' => $category_id])->render('vendor.pagination.front-end') !!}
        </div>
    </div>
</div>
