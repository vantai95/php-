@extends('layouts.app')
@section('content')
<div class="services">
    <div class="service-top">
        <div class="img">
            <img src="/b2c-assets/img/service_banner.png" alt="banner" title="banner">
        </div>
        <div class="desciption">
            <div class="container">
                <div class="text">
                    <div class="row">
                        <div class="col-12 title">@lang('b2c.service.index.text.welcome')</div>
                        <div class="col-12 col-sm-6 m-auto description">- @lang('b2c.service.index.text.description') -
                        </div>
                        <div class="col-12"><img src="/b2c-assets/img/icon-service.png"></div>
                        <div class="col-12 col-sm-10 m-auto info">@lang('b2c.service.index.text.info')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="service-main">
        <div class="container">
            <div class="service-main-top">
                <div class="text text-center">
                    <div class="title">@lang('b2c.service.index.title.treatments')</div>
                    <div class="desciption">Contrary to popular belief, Lorem Ipsum is not simply random text.</div>
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
                                <img class="img-treatment" src="/images/image_list/{{ $item->image }}" alt="" title="">
                            </div>
                            <div class="treatment-category mt-2 mb-2">{{$item->category_name}}</div>
                            <div class="treatment-title row">
                                <div class="col-10 m-auto">{{$item->service_name}}</div>
                            </div>
                            <div class="button"><a
                                    href="{{url('services/detail/'.$item ->id)}}"><span>@lang('b2c.service.index.text.view_more')</span></a>
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
    <div class="service-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 left pt-4 pt-sm-0">
                    <div class="img">
                        <img class="img-2" src="/b2c-assets/img/service-people.png" alt="" title="">
                    </div>
                </div>
                <div class="col-12 col-md-6 right">
                    <div class="row">
                        <div class="col-12 text pt-2 pt-sm-5 pb-2 pb-sm-5">
                            <div class="top">OUR DOCTORS OF EXPERTS</div>
                            <div class="between"><span style="color: #e8ba88">&minus;</span> Professional Solution For
                                Your Beauty</div>
                            <div class="bottom">Lorem Ipsum is simply dummy text of the printing and typesetting
                                industry.
                                Lorem
                                Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown
                                printer
                                took a galley of type and scrambled it to make a type specimen book</div>
                            <div class="text-sm-right mt-4 mb-4 mb-sm-0 mt-sm-4">
                                <a href="#" data-toggle="modal" data-target="#customerServiceModal">
                                    <span>@lang('b2c.service.index.schedule_now')</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('service.customer-service-modal')
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
