<script>
    $('#m_datepicker_1').datepicker({
        language: '{{$lang}}',
        format: 'yyyy-mm-dd'
    });

    $('#change_password').click(function(e){
        e.preventDefault();
        var data = $('#change_password_form').serializeArray();
           $.ajax({
               url: '{{url('admin/change-password')}}',
               type: 'post',
               data: data,
               success:function(response){
                    console.log(response.success);
                    if(!response.success)
                    {
                        $('div[id^="error_"]').html('');
                        $.each( response.message, function( key, value ) {

                            $('#error_' +key).show();
                            $('#error_' +key).html(value);
                        });
                    }
                    else
                    {
                        $('div[id^="error_"]').hide();
                    }

                    if(response.error === false)
                    {
                        $('#change_password_form').get(0).reset();
                        $('div[id^="error_"]').hide();
                        toastr.success('Your Password has been update');
                    }
                    else if (response.error === true)
                    {
                        $('#change_password_form').get(0).reset();
                        $('div[id^="error_"]').hide();
                        toastr.error('Mật khẩu hiện tại không đúng');
                    }
               }
           });
    });
</script>
