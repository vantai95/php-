<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.menus.forms.name_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_en', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">@lang('admin.menus.forms.name_vi')</label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_vi', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_ja') ? 'has-danger' : ''}}">
            <label for="name_ja" class="col-form-label col-sm-12">@lang('admin.menus.forms.name_ja')</label>
            <div class="col-sm-12">
                {!! Form::text('name_ja', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_ja', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('url') ? 'has-danger' : ''}}">
            <label for="url" class="col-form-label col-sm-12">@lang('admin.menus.forms.url')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('url', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('url', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('active') ? 'has-danger' : ''}}">
            <label for="active" class="col-form-label col-sm-12">@lang('admin.menus.forms.status')</label>
            <div class="col-sm-12">
                <div class="m-checkbox-inline">
                    {{--<p>{{$menu->active}}</p>--}}
                    <label class="m-checkbox">
                        {!! Form::checkbox('active', 1, isset($menu) ? $menu->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active'] ) !!}
                        @lang('admin.menus.forms.active')
                        <span></span>
                    </label>
                </div>
                {!! $errors->first('active', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.menus.buttons.create'), ['class' => 'btn btn-success']) !!}
                <a href="{{url('admin/menus')}}" class="btn btn-secondary">
                    @lang('admin.menus.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
