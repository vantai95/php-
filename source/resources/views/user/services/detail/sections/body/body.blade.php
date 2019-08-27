<div class="service-detail-main">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="service-detail-main-left">
                    <img src="{{\App\Services\ImageService::imageUrl($serviceDetail->image)}}" alt="{{ $serviceDetail->short_description }}"
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
