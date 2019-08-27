@php
  $imgList = json_decode($data->data);
@endphp
<div class="welcome text-center " style="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="padding:0">
                <div class="slider-welcome">
                    @foreach($imgList as $img)
                      <div class="default-slider">
                          <div class="row default-slider-img" style="">
                            <img style="width:100%;height:100%" src="{{config('filesystems.disks.azure.url').$img}}">
                          </div>
                      </div>
                    @endforeach
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
