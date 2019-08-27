@extends('layouts.app')
@section('content')
<div class="homepage">
    <div class="welcome text-center " style="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" style="padding:0">
                    <div class="slider-welcome">
                        <div class="default-slider">
                            <div class="row default-slider-img" style="">
                              <img style="width:100%;height:100%" src="/b2c-assets/img/slider_cover_img.jpg">
                            </div>
                        </div>
                        <div class="default-slider">
                            <div class="row default-slider-img" style="">
                              <img style="width:100%;height:100%" src="/b2c-assets/img/slider_cover_img_2.jpg">
                            </div>
                        </div>
                        @foreach($promotions as $promotion)
                        <div>
                          <div class="row">
                            <img style="width:100%;height:100%" src="{{$promotion->image}}">
                          </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="custom-slider">
        <div class="container center-div text-center">
            <div class="row">
                <div class="col-md-12 text-package"><span style="font-weight:bold;color: #e8ba88">&minus;</span> @lang('b2c.home.combo_packages.title.combo_packages') <span style="font-weight:bold;color: #e8ba88">&minus;</span></div>
                <div class="col-md-12 text-package-info">@lang('b2c.home.combo_packages.text.description')</div>
                <div class="col-md-12">
                    <div class="testslider">
                        <div class="clip">
                            <div class="box-slider">
                                <div class="col-md-12 text-center">
                                    <a href="services" target="_blank"><img title="Image" alt="Image" class="img-slide"
                                            src="/b2c-assets/img/slide_image1.png"></a>
                                    <div class="title_slide">
                                        <a href="services" target="_blank">Giảm Cân</a>
                                    </div>
                                    <div class="info_slide">
                                        Take your spa on the go with our <br> beautifully designed appointments
                                    </div>
                                    <div class="content-slide">
                                        <div class="row">
                                            <div class="col-md-10 text-left">DYSPOR / BOTOX</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">FILLER</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">THREADLIFT</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">PRP</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">HA Baby Face (Redensity)</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="clip">
                            <div class="box-slider">
                                <div class="col-md-12 text-center">
                                    <a href="services" target="_blank"><img title="Image" alt="Image" class="img-slide"
                                            src="/b2c-assets/img/slide_image2.png"></a>
                                    <div class="title_slide">
                                        <a href="services" target="_blank"> Chăm sóc cơ bản</a>
                                    </div>
                                    <div class="info_slide">
                                        Take your spa on the go with our <br> beautifully designed appointments
                                    </div>
                                    <div class="content-slide">
                                        <div class="row">
                                            <div class="col-md-10 text-left">DYSPOR / BOTOX</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">FILLER</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">THREADLIFT</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">PRP</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">HA Baby Face (Redensity)</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="clip">
                            <div class="box-slider">
                                <div class="col-md-12 text-center">
                                    <a href="services" target="_blank"><img title="Image" alt="Image" class="img-slide"
                                            src="/b2c-assets/img/slide_image1.png"></a>
                                    <div class="title_slide">
                                        <a href="services" target="_blank">Tăng cân</a>
                                    </div>
                                    <div class="info_slide">
                                        Take your spa on the go with our <br> beautifully designed appointments
                                    </div>
                                    <div class="content-slide">
                                        <div class="row">
                                            <div class="col-md-10 text-left">DYSPOR / BOTOX</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">FILLER</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">THREADLIFT</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">PRP</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">HA Baby Face (Redensity)</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="clip">
                            <div class="box-slider">
                                <div class="col-md-12 text-center">
                                    <a href="services" target="_blank"><img title="Image" alt="Image" class="img-slide"
                                            src="/b2c-assets/img/slide_image3.png"></a>
                                    <div class="title_slide">
                                        <a href="services" target="_blank">Nâng Cơ Trẻ Hóa</a>
                                    </div>
                                    <div class="info_slide">
                                        Take your spa on the go with our <br> beautifully designed appointments
                                    </div>
                                    <div class="content-slide">
                                        <div class="row">
                                            <div class="col-md-10 text-left">DYSPOR / BOTOX</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">FILLER</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">THREADLIFT</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">PRP</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-left">HA Baby Face (Redensity)</div>
                                            <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="custom-why-choose">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 why-choose-left pl-0 pr-0 pt-0 pb-0 pt-md-5 pb-md-5">
                    <img title="Image" alt="Image" class="img-why-choose"
                        src="/b2c-assets/img/why-choose-us-people.png">
                </div>
                <div class="col-md-6 why-choose-right">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="title pt-4 pb-4"><span style="font-weight:bold">&minus;</span> @lang('b2c.home.why_choose_glamerclinic.title.why_choose_glamerclinic')
                            </div>
                            <div class="content-box">
                                <div class="box mb-4">
                                    <div>
                                        <img title="Image" alt="Image" class="rounded-circle img-why-choose"
                                            src="/b2c-assets/img/why_choose_us_24_07_2019.jpg">
                                    </div>
                                    <div class="content">
                                        <div class="title">
                                            @lang('b2c.home.why_choose_glamerclinic.title.our_doctors')
                                        </div>
                                        <div class="description">
                                            @lang('b2c.home.why_choose_glamerclinic.title.choose_glamerclinic_reason.our_doctors')
                                        </div>
                                    </div>
                                </div>
                                <div class="box mb-4">
                                    <div>
                                        <img title="Image" alt="Image" class="rounded-circle img-why-choose"
                                            src="/b2c-assets/img/why-choose-us-people1.png">
                                    </div>
                                    <div class="content">
                                        <div class="title">
                                             @lang('b2c.home.why_choose_glamerclinic.title.services')
                                        </div>
                                        <div class="description">
                                            @lang('b2c.home.why_choose_glamerclinic.title.choose_glamerclinic_reason.services')
                                        </div>
                                    </div>
                                </div>
                                <div class="box mb-4">
                                    <div>
                                        <img title="Image" alt="Image" class="rounded-circle img-why-choose"
                                            src="/b2c-assets/img/why-choose-us-new.jpg">
                                    </div>
                                    <div class="content">
                                        <div class="title">
                                            @lang('b2c.home.why_choose_glamerclinic.title.customer_appointment')
                                        </div>
                                        <div class="description">
                                            @lang('b2c.home.why_choose_glamerclinic.title.choose_glamerclinic_reason.customer_appointment')
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="custom-about-us">
        <div class="pt-4 pb-4 pt-lg-5 pb-lg-5">
            <div class="container ">
                <div class="row ">
                    <div class="col-12 title text-center"><span style="font-weight:bold">&minus;</span>
                        @lang('b2c.home.about_us.title.about_us') <span style="font-weight:bold">&minus;</span></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info mb-4 mt-4">@lang('b2c.home.about_us.title.overview')</div>
                        <div class="description">{!! trans('b2c.home.about_us.title.overview__text') !!}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info mb-4 mt-4">@lang('b2c.home.about_us.title.our_misstion')</div>
                        <div class="description">{!! trans('b2c.home.about_us.title.our_misstion__text') !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="custom-introduction">
        <div class="container">
            <div class="row pt-4 pb-4 pt-lg-5 pb-lg-5">
                <div class="col-md-6 col-sm-12 text-intro">
                    <div class="col-md-12 text-center">
                        <div class="title-intro">Wellcome to our</div>
                        <div class="info-intro"><span style="color: #e8ba88">&minus;</span> Naturally Effective <br>
                            Health
                            Solutions <span style="color: #e8ba88">&minus;</span></div>
                        <div class="content-intro">
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                            tincidunt ut laoreet dolore magna
                            aliquam erat volutpat. Ut wisi enim ad minim veniam.
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-left">
                    <iframe class="video_intro" width="100%" height="215"
                        src="https://www.youtube.com/embed/wQA1dPJWa_o" frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="custom-quote">
        <div class="container">
            <div class="pt-4 pb-4 pt-lg-5 pb-lg-5">
                <div class="slider-quote">
                    <div>
                        <div class="row">
                            <div class="box-slider col-md-12">
                                <div class="col-md-12 text-center">
                                    <div class="content-slide mb-4">
                                        &quot;Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy
                                        nibh euismod tincidunt ut laoreet dolore magna
                                        aliquam erat volutpat. Ut wisi enim ad minim veniam.&quot;
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center mb-4">
                                <img title="Image" alt="Image" class="rounded-circle img-slide"
                                    src="/b2c-assets/img/image-quote.png">
                            </div>
                            <div class="title_slide col-md-12 text-center mb-4 mb-md-0">
                                <span>Ca sĩ</span> Hồ Ngọc Hà
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="box-slider col-md-12">
                                <div class="col-md-12 text-center">
                                    <div class="content-slide mb-4">
                                        &quot;Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy
                                        nibh euismod tincidunt ut laoreet dolore magna
                                        aliquam erat volutpat. Ut wisi enim ad minim veniam.&quot;
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center mb-4">
                                <img title="Image" alt="Image" class="rounded-circle img-slide"
                                    src="/b2c-assets/img/image-quote.png">
                            </div>
                            <div class="title_slide col-md-12 text-center mb-4 mb-md-0">
                                <span>Ca sĩ</span> Hồ Ngọc Hà
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
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
                        <a href="{{url('news/detail/'.$item ->id)}}"><img class="latest-news-img"
                                src="{{$item ->image}}" alt="banner" title="banner"></a>
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
    <div>
        <div id="map">
            <iframe width="100%" height="300px;"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.3644333147686!2d106.69421231480085!3d10.783374992316851!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3685aeb0e5%3A0x417ba0853972ddba!2zNDAgVHLhuqduIENhbyBWw6JuLCBQaMaw4budbmcgNiwgUXXhuq1uIDMsIEjhu5MgQ2jDrSBNaW5o!5e0!3m2!1svi!2s!4v1557756875313!5m2!1svi!2s"
                frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </div>
    @endsection

    @section('extra_scripts')
    <script>
        $(document).ready(function(){
            $('.slider-welcome').slick({
                dots:false,
                autoplay: false,
                autoplaySpeed: 5000,
                arrows : true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            dots : true,
                            arrows : false,
                        }
                    }
                ]
            });
            $('.testslider').slick({
                slidesToShow: 3,
                dots:true,
                centerMode: true,
                autoplay: true,
                autoplaySpeed: 5000,
                arrows : true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            arrows : false,
                            centerMode: false,
                        }
                    }
                ]
            });
            $('.slider-quote').slick({
                dots:false,
                autoplay: true,
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
        });
    </script>
    @endsection
