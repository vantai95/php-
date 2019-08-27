@extends('layouts.app')
@section('content')
<div class="promotion-detail">
    <div class="banner">
        <img src="/b2c-assets/img/bg-promotion.png" alt="" title="">
    </div>
    <div class="content pt-2 pt-sm-5 pb-2 pb-sm-5">
        <div class="container">
            <div class="content-main row">
                <div class="col-12 col-sm-8">
                    <div class="title">{!! $promotion->name !!}
                    </div>
                    <div class="short-desciption">{!! $promotion->short_description !!}</div>
                    <div class="description">{!! $promotion->description !!}</div>
                    <div class="button">
                        <a href="#" data-toggle="modal" data-target="#customerServiceModal">
                            <div class="btn-order">@lang('b2c.promotion.detail.booking_now')</div>
                        </a>
                    </div>
                    <!-- Modal -->
                    @include('service.customer-service-modal')
                </div>
                <div class="col-12 col-sm-4">
                    <div class="related-new">
                        <div class="related-new-content">
                            <div class="related-new-title">
                                @lang('b2c.promotion.detail.title.related_news')
                            </div>
                            @foreach ($news as $item)
                            <div class="related-new-body">
                                <a href="{{url('news/detail/'.$item ->id)}}"><img class="img-related-new"
                                        src="{{url('images/image_list/'.$item ->image)}}" alt="" title=""></a>
                                <div class="date-clock">
                                    <img class="img-clock" src="/b2c-assets/img/promo-clock.png" alt=""
                                        title="">
                                    <span class="date">{{ $item->created_at->toFormattedDateString() }}</span>
                                </div>
                                <div class="description"><a
                                        href="{{url('news/detail/'.$item ->id)}}">{{$item ->name}}</a></div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="content-bottom pt-2 pt-sm-5 pb-2 pb-sm-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-12 title mb-2 mb-sm-4">@lang('b2c.promotion.detail.title.related_promotions')</div>
                <div class="col-12">
                    @foreach ($related_promotions as $key => $promotion)
                    @if ($key % 2 ==0)
                    <div class="related-promotion-body">
                        <div class="row pt-3 pb-3 pt-sm-5 pb-sm-5  h-100 justify-content-center align-items-center">
                            <div class="col-12 col-md-6 text-right">
                                <a href="">
                                    <img class="promotion-image" src="/images/image_list/{{ $promotion->image}}" alt=""
                                        title="">
                                </a>
                            </div>
                            <div class="col-12 col-md-6 text-center ">
                                <div class="content">
                                    <div class="title">{{ $promotion->name}}</div>
                                    <div class="short-description">{!! $promotion->short_description!!}</div>
                                    <div class="button mt-4"><a
                                            href="{{url('promotions/detail/'.$promotion->id)}}"><span>@lang('b2c.promotion.detail.text.view_more')</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="related-promotion-body">
                        <div class="row pt-3 pb-3 pt-sm-5 pb-sm-5  h-100 justify-content-center align-items-center">
                            <div class="col-12 col-md-6 text-center ">
                                <div class="content">
                                    <div class="title">{{ $promotion->name}}</div>
                                    <div class="short-description">{!! $promotion->short_description!!}</div>
                                    <div class="button mt-4"><a
                                            href="{{url('promotions/detail/'.$promotion->id)}}"><span>@lang('b2c.promotion.detail.text.view_more')</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 text-right">
                                <a href="">
                                    <img class="promotion-image" src="/images/image_list/{{ $promotion->image}}" alt=""
                                        title="">
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_scripts')
    <script>
        $(".btn-live").click(function() {
            $('#customerServiceModal').modal('hide');
            $(".message-modal").show();
            $("#online-support-hide").show();
            document.cookie = "open=true";
            if($(window).scrollTop() + $(window).height() == $(document).height()) {
                $('.online-support-form').css("bottom","2px");
            }else{
                $('.online-support-form').css("bottom","2px");
            }
        });

        $('#btnSend').click(function(e){
            e.preventDefault();
            var data = $('#customerServiceForm').serializeArray();
            $.ajax({
                url: '{{url('customer-service')}}',
                type: 'post',
                data: data,
                success:function(response){
                    if(!response.success){
                        $('div[id^="error_"]').html('');
                        $.each(response.message,function(key,value){
                            $('#error_' +key).show();
                            $('#error_' +key).html(value);
                        });
                    }
                    else{
                        $('div[id^="error_"]').hide();
                    }

                    if(response.error === false)
                    {
                        toastr.success(response.done);
                        $('#customerServiceModal').modal('hide');
                        $('#customerServiceForm').get(0).reset();
                    }
                }
            });
        });
    </script>
@endsection
