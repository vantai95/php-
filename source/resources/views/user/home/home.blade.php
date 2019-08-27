@extends('layouts.app')
@section('content')
<div class="homepage">
    @foreach($sections as $section)
      @include($section->template,['section' => $section])
    @endforeach

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
