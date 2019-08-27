<div class="custom-slider">
    <div class="container center-div text-center">
        <div class="row">
            <div class="col-md-12 text-package"><span style="font-weight:bold;color: #e8ba88">&minus;</span> @lang('b2c.home.combo_packages.title.combo_packages') <span style="font-weight:bold;color: #e8ba88">&minus;</span></div>
            <div class="col-md-12 text-package-info">@lang('b2c.home.combo_packages.text.description')</div>
            <div class="col-md-12">
                <div class="testslider row">
                    @foreach($categories as $category)
                    @php
                      $url = \URL::to('services').'?category_id='.$category->id;
                    @endphp
                    <div class="clip col-md-4">
                        <div class="box-slider">
                            <div class="text-center">
                                <a href="{{ $url }}" target="_blank"><img title="Image" alt="Image" class="img-slide"
                                        src="{{ config('filesystems.disks.azure.url').$category->image }}"></a>
                                <div class="title_slide">
                                    <a href="{{ $url }}"  target="_blank">{{ $category->name }}</a>
                                </div>
                                <div class="info_slide">
                                  {!! $category->description !!}
                                </div>
                                <div class="content-slide">
                                    @foreach($category->category_metas as $meta)
                                    <div class="row">
                                        <div class="col-md-10 text-left">{{ $meta->name }}</div>
                                        <div class="col-md-2 text-right"><i class="fas fa-plus"></i></div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
