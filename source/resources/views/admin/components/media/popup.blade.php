<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{$name}}MediaModal">
    @lang('admin.media_modal.button.upload')
</button>
<!-- Modal -->
<div class="modal fade" id="{{$name}}MediaModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">@lang('admin.media_modal.title')</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <ul class="nav nav-tabs image-tab">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab"
                               href="#{{$name}}_upload">@lang('admin.media_modal.tab.upload')</a>
                        </li>
                        <li class="nav-item image-tab">
                            <a class="nav-link" data-toggle="tab"
                               href="#{{$name}}_library">@lang('admin.media_modal.tab.library')</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                      @include('admin.components.media.upload',['name' => $name])
                      @include('admin.components.media.library',['name' => $name])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
