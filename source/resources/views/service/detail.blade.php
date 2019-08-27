@extends('layouts.app')
@section('content')
<div class="service-detail">
    <div class="service-detail-top">
        <div class="container">
            <div class="row" style="justify-content: flex-end;align-items: flex-end">
                <div class="img col-md-6">
                    <div class="mt-4 "><img src="/b2c-assets/img/service-detail-people.png"
                            alt="background service detail" title="background service detail"></div>
                </div>
                <div class="col-md-6">
                    <div class="text pt-4 pb-4 pt-md-5 pb-md-5">
                        <div class="title">NÂNG CƠ TRẺ HOÁ BẰNG CÔNG NGHỆ CAO</div>
                        <div class="description">
                            <div><img src="/b2c-assets/img/Path-service.png">What is Lorem Ipsum?</div>
                            <div><img src="/b2c-assets/img/Path-service.png">Why do we use it?</div>
                            <div><img src="/b2c-assets/img/Path-service.png">Where does it come from?
                            </div>
                            <div><img src="/b2c-assets/img/Path-service.png">Where can I get some?</div>
                        </div>
                        <a href="#" data-toggle="modal" data-target="#registerAdviceModal">
                            <h6>BOOK RESERVATION<span class="tip-right tip-right-top"></span></h6>
                        </a>
                        <!-- Modal -->
                        @include('service.register-advice-modal')
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="service-detail-main">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="service-detail-main-left">
                        <img src="{{ $serviceDetail->imageUrl() }}" alt="{{ $serviceDetail->short_description }}"
                            title="{{ $serviceDetail->short_description }}">
                        <div class="service-detail-main-left-text">
                            <div class="title mb-2">{{ $serviceDetail->name }}</div>
                            <h6><span class="tip-right tip-right-main"></span><a href="#">THERMAGE FXL</a></h6>
                            <h6><span class="tip-right tip-right-main"></span><a href="#">ULTHERAPY</a></h6>
                            <h6><span class="tip-right tip-right-main"></span><a href="#">RF</a></h6>
                            <div class="button">
                                <a class="view-price" href="#" data-toggle="modal" data-target="#registerAdviceModal">
                                    <h6>VIEW PRICING</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="service-detail-main-right">
                        <div class="row">
                            <div class="col-md-12 mb-3"> {!! $serviceDetail->description !!}</div>
                        </div>
                        <div class="service-text-right row">
                            <div class="col-md-12 mb-3">
                                <div class="title">TRƯỚC & SAU LIỆU TRÌNH</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <img src="/images/image_list/{{ $serviceDetail->image_before }}" alt="" title="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <img src="/images/image_list/{{ $serviceDetail->image_after }}" alt="" title="">
                            </div>
                        </div>
                        <div class="service-text-right row">
                            <div class="col-md-12 mb-3">
                                <div class="title">CÂU HỎI THƯỜNG GẶP</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                @foreach ($faqs as $faq)
                                <div class="row">
                                    <div class="policy-wrapper col-md-12">
                                        <div class="policy-header hide">
                                            <p>{!!$faq->question_vi!!}</p>
                                        </div>
                                        <div class="policy-content">
                                            <ul class="top-line">
                                                <li>{!!$faq->anwser_vi!!}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                            </div>
                        </div>
                        <div id="review" class="service-text-right row">
                            <div class="col-md-12 mb-3">
                                <div class="title">CẢM NHẬN CỦA KHÁCH HÀNG</div>
                            </div>
                            <div class="col-md-12">
                                <div class="slider-feedback">
                                    @foreach ($feedbacks as $feedback)
                                    <div>
                                        <div class="row review">
                                            <div class="col-md-4 text-center mb-3">
                                                <img src="/images/image_list/{{ $feedback->image }}"
                                                    class="rounded-circle img-feedback" alt="" title="">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="description mb-2">
                                                    <span class="tip-right-review"></span>
                                                    {!! $feedback->description_vi !!}
                                                </div>
                                                <div class="name text-center text-md-right">
                                                    {{ $feedback->name_vi }}</div>
                                            </div>

                                        </div>
                                    </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="service-text-right row">
                            <div class="col-md-12">
                                <iframe width="100%" height="360" src="{{$serviceDetail->video}}" frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
</div>
<script type="text/javascript">
    $('.policy-content').slideUp();
    $('.policy-header').click(function(event) {
        $(this).next('.policy-content').slideToggle();
        $(this).toggleClass('hide');
    });
</script>
<script>
    $(document).ready(function(){
        $('.slider-feedback').slick({
            dots:false,
            autoplay: false,
            autoplaySpeed: 5000,
            arrows : true,
            responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            dots:true,
                            arrows : false,
                        }
                    }
                ]
        });

        $('#btnBookNow').click(function(e){
            e.preventDefault();
            var data = $('#registerAdviceForm').serializeArray();
            $.ajax({
                url: '{{url('register-advice')}}',
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
                        $('#registerAdviceModal').modal('hide');
                        $('#registerAdviceForm').get(0).reset();
                    }
                }
            });
        });
    });
</script>

@endsection
