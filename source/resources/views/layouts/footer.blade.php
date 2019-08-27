<div class="footer">
    <div class="container content-footer">
        <div class="inner-content-footer">
            <div class="row">
                <div class="col-12 col-sm-4 info-text text-center" style="margin-top:-30px">
                    <div style="">
                    <a href="/">
                    <img src="/b2c-assets/img/logo_white_sign_new.png" alt="{{trans('b2c.header.menu.glamer_clinic')}}"
                    title="{{trans('b2c.header.menu.glamer_clinic')}}" />
                    </a>
                </div>
                </div>
                <div class="col-12 col-sm-4 info-text">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="glamer-title">{{trans('b2c.footer.open')}}</div>
                            <div class="glamer-info">
                                <div>{{trans('b2c.footer.mon-fri')}}: 9AM - 6PM</div>
                                <div>{{trans('b2c.footer.saturday')}}: 9AM - 4PM</div>
                                <div>{{trans('b2c.footer.sunday')}}: {{trans('b2c.footer.closed')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4 info-text">
                    <div class="glamer-title">{{trans('b2c.footer.newsletter')}}</div>
                    {!! Form::open(['method' => 'POST', 'url' => '/subscribe', 'id' => 'subscribeForm']) !!}
                    <div class="glamer-info box-subcribe">
                        <input class="input-subscribe" type="text" placeholder="info@yoursite.com" name="email" id="">
                        <button class="btn-subscribe" id="btnSubscribe" type="button">{{trans('b2c.footer.subcribe')}}</button>
                    </div>
                    {!! Form::close()!!}
                    <div class="row glamer-info">
                        <div class="col-12 link-social">
                        <a href="https://www.facebook.com/pages/category/Health-Beauty/Glamer-Clinic-349360785695661/" target="_blank"><i class="fab fa-facebook-square fa-2x" style="margin-right: 0.5rem;"></i>glamerclinic</a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="information row">
                {{--facebook mesage--}}
                <div id="online-support" class="online-support-form text-white rounded position-fixed pr-0 pl-0 mh-100">
                    <div id="online-support-header" class="col-12 pb-1 pt-1 online-support-header">
                        <div  id="online-support-title" class="online-support-title btn-message lead font-weight-bold d-inline-flex pl-0 pr-0">
                            <i class="fa fa-comment pt-1" aria-hidden="true"></i>
                            <div class="pl-2">@lang('b2c.footer.text.online_support')</div>
                        </div>
                        <div class="float-right lead flex-fill pl-0 pr-0 pt-1 online-support-close"><i id="online-support-hide" class="fa fa-times close-message "></i></div>
                    </div>

                    <div  class="col-12 bg-white message-modal">
                        <iframe src="https://www.facebook.com/plugins/page.php?href={{$facebook_message_url}}&tabs=messages&width=300&height=300&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false"
                                 class="facebook-iframe"></iframe>
                    </div>
                </div>
                {{--end of facebook mesage--}}
            </div>
        </div>
    </div>
    <div class="row custom-hr"></div>
    <div class=" text-center col-md-12 text-copyright">Glamer Clinic 2019. All Rights Reserved</div>
</div>




<script type="text/javascript">
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            if ($(".message-modal").css("display") == "none") {
                $('.online-support-form').css("bottom",$('.footer').outerHeight());
            }else{
                $('.online-support-form').css("bottom","2px");
            }
        }else{
            $('.online-support-form').css("bottom","2px");
        }
    });

    $('#btnSubscribe').click(function(e){
        e.preventDefault();
        var data = $('#subscribeForm').serializeArray();
        $.ajax({
            url: '{{url('subscribe')}}',
            type: 'post',
            data: data,
            success:function(response){
                if(!response.success){
                    toastr.error(response.message['email']);
                }
                else{
                    $('#subscribeForm').get(0).reset();
                    toastr.success('Bạn đã đăng ký nhận bản tin thành công!!!');
                }
            }
        });
    });

</script>
