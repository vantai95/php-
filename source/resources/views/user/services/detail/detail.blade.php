@extends('layouts.app')
@section('content')
<div class="service-detail">
    @include('user.services.detail.sections.top.top')
    @include('user.services.detail.sections.body.body')
    @include('user.services.detail.sections.bottom.bottom')
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
