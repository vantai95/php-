@extends('layouts.empty')

@section('content')
    <div class="container indiegogo normalize-font-size" >

        <div class="text-center thank-you-page">
            <div class="ss-blog-post kt-blog-post">
                <div class="mg-t20">
                    <h3 style="color: #ff002d">Reset Password Token Invalid!</h3>
                    <h5>Your reset password token is not correct.</h5>
                    <h5>Please check and click the correct reset password link in your email!</h5>
                    <h5><a class="btn btn-success" href="{{url('/')}}">Back to GlamerClinic.com</a></h5>
                </div>
            </div>

        </div>
    </div>
@endsection
