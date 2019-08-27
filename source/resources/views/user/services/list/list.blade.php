@extends('layouts.app')
@section('content')
<div class="services">
    @foreach($sections as $section)
      @include($section->template,['section' => $section])
    @endforeach
    @include('user.services.popup.customer-service-modal')
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
