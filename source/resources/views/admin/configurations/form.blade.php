<div class="m-portlet__body">
    <div class="form-group m-form__group row">

        <div class="col-lg-12">
            <label for="config_key" class="col-form-label large-label text-uppercase">CẤU HÌNH CHUNG</label>
        </div>

        
        <div class="col-lg-7 col-md-9 col-sm-12">
            <div class="m-checkbox-inline">
                <label class="m-checkbox">
                    {!! Form::checkbox('enable_price', 1, isset($enable_price)? $enable_price->config_value: 0, ['class' => 'form-control ','id'=>'is_publish']) !!}
                    Hiển thị giá gói trị liệu
                    <span></span>
                </label>
            </div>
            {!! $errors->first('enable_price', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(trans('admin.configurations.buttons.upgrate'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                <button type="reset" class="btn btn-secondary" >
                    @lang('admin.configurations.buttons.reset')
                </button>
            </div>
        </div>
    </div>
</div>