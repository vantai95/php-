<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <div class="col-10 ml-auto">
            <h3 class="m-form__section">1. @lang('admin.users.title.details')</h3>
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('full_name') ? 'has-danger' : ''}}">
        <label for="example-text-input"
               class="col-form-label form-control-label col-2 {{ $errors->has('full_name') ? 'has-danger' : ''}}">
            @lang('admin.users.columns.full_name')<span class="text-danger"> *</span></label>
        <div class="col-7">
            {!! Form::text('full_name', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
            {!! $errors->first('full_name', '<p class="form-control-feedback">:message</p>') !!}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('birth_day') ? 'has-danger' : ''}}">
        <label for="example-text-input" class="col-2 col-form-label">@lang('admin.users.columns.dob')<span class="text-danger"> *</span> </label>
        <div class="col-7">
            {!! Form::text('birth_day', null, [ 'class' => 'form-control','onkeydown' => 'return false;','id' => 'm_datepicker_1','readonly' => 'true']) !!}
            {!! $errors->first('birth_day', '<p class="form-control-feedback">:message</p>') !!}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('phone') ? 'has-danger' : ''}}">
        <label for="example-text-input" class="col-2 col-form-label">@lang('admin.users.columns.phone')<span class="text-danger"> *</span></label>
        <div class="col-7">
            {!! Form::text('phone', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
            {!! $errors->first('phone', '<p class="form-control-feedback">:message</p>') !!}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('address') ? 'has-danger' : ''}}">
        <label for="example-text-input" class="col-2 col-form-label">@lang('admin.users.columns.address')</label>
        <div class="col-7">
            {!! Form::text('address', null, ['class' => 'form-control m-input']) !!}
            {!! $errors->first('address', '<p class="form-control-feedback">:message</p>') !!}
        </div>
    </div>

    @if (!$isMyProfile)
        <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>

        <div class="form-group m-form__group row">
            <div class="col-10 ml-auto">
                <h3 class="m-form__section">2. @lang('admin.users.title.role')</h3>
            </div>
        </div>
        <div class="form-group m-form__group row {{ $errors->has('role_id') ? 'has-danger' : ''}}">
            <label for="role_id" class="col-2 col-form-label">@lang('admin.users.columns.role')</label>
            <div class="col-7">
                {!! Form::select('role_id', $roles, null, ['class' => 'form-control m-input',isset($user) && !$user->disableRole() ? 'disabled' : '']) !!}
                {!! $errors->first('role_id', '<p class="form-control-feedback">:message</p>') !!}
                @if(isset($user) && !$user->disableRole())
                    <p class="form-control-feedback text-info">Không thể đổi vai trò người dùng này vì chưa cập nhật email!</p>
                @endif
            </div>
        </div>
        <div class="form-group m-form__group row {{ $errors->has('is_locked') ? 'has-danger' : ''}}">
            <label for="is_locked" class="col-2 col-form-label">@lang('admin.users.columns.locked') </label>
            <div class="col-7">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('is_locked', 1,  isset($user) ? $user->is_locked: false, ['class' => 'form-control ','name'=>'is_locked','id'=>'is_locked']) !!}
                        <span></span>
                    </label>
                </div>
                {!! $errors->first('is_locked', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    @endif
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-7">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.save_change'), ['class' => 'btn btn-accent m-btn m-btn--air m-btn--custom']) !!}

                <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{{trans('admin.buttons.cancel')}}</button>
            </div>
        </div>
    </div>
</div>





