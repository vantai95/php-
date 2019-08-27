<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-form-label form-control-label col-3">
            @lang('admin.users.columns.current_password')<span class="text-danger"> *</span></label>
        <div class="col-7">
            {!! Form::password('current_password', ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
            <div style="display:none" class="form-control-feedback text-danger" id="error_current_password"></div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-form-label form-control-label col-3">
            @lang('admin.users.columns.new_password')<span class="text-danger"> *</span></label>
        <div class="col-7">
            {!! Form::password('new_password', ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
            <div style="display:none" class="form-control-feedback text-danger" id="error_new_password"></div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-form-label form-control-label col-3">
            @lang('admin.users.columns.confirm_new_password')<span class="text-danger"> *</span></label>
        <div class="col-7">
            {!! Form::password('confirm_new_password', ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
            <div style="display:none" class="form-control-feedback text-danger" id="error_confirm_new_password"></div>
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-7">
                {!! Form::button(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.save_change'), ['class' => 'btn btn-accent
                m-btn m-btn--air m-btn--custom', 'id' => 'change_password']) !!}
                <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{{trans('admin.buttons.cancel')}}</button>
            </div>
        </div>
    </div>
</div>

