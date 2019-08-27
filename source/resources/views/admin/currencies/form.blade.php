<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('code') ? 'has-danger' : ''}}">
            <label for="code" class="col-form-label col-sm-12">@lang('admin.currencies.forms.code')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('code', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('code', '<p id="email-error" class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('symbol') ? 'has-danger' : ''}}">
            <label for="symbol" class="col-form-label col-sm-12">@lang('admin.currencies.forms.symbol')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('symbol', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('symbol', '<p id="email-error" class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('exchange_rate') ? 'has-danger' : ''}}">
            <label for="exchange_rate" class="col-form-label col-sm-12">@lang('admin.currencies.forms.exchange_rate')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::number('exchange_rate', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('exchange_rate', '<p id="email-error" class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-1 text-nowrap {{ $errors->has('active') ? 'has-error' : ''}}">
            <label for="active" class="col-form-label col-sm-12">@lang('admin.currencies.forms.status')</label>
        </div>
        <div class="col-lg-2 col-md-9 col-sm-12">
            <div class="m-checkbox-inline">
                <label class="m-checkbox">
                    {!! Form::checkbox('active', 1, isset($currency) ? $currency->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                    @lang('admin.currencies.forms.active')
                    <span></span>
                </label>
            </div>
            {!! $errors->first('active', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.currencies.buttons.create'), ['class' => 'btn btn-success']) !!}
                <a href="{{url('admin/currencies')}}" class="btn btn-secondary">
                    @lang('admin.currencies.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
