<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-5 {{ $errors->has('name') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.roles.column.role_name')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}}">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.users')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['USERS_VIEW'],isset($role) ? (\App\Services\CommonService::containString($role->permissions,'u1') ? true : false): false)!!}
                <span class="pl-2"> @lang('admin.roles.checkbox_title.users_view') </span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['USERS_MANAGE'],isset($role) ? (\App\Services\CommonService::containString($role->permissions,'u2') ? true : false) : false)!!}
                <span class="pl-2"> @lang('admin.roles.checkbox_title.users_manage') </span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}}">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.galleries')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['GALLERIES_VIEW'],isset($role) ? (\App\Services\CommonService::containString($role->permissions,'g1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.galleries_view') </span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['GALLERIES_MANAGE'],isset($role) ? (\App\Services\CommonService::containString($role->permissions,'g2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.galleries_manage')  </span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}}">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.gallery_types')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['GALLERY_TYPES_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'gt1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.gallery_types_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['GALLERY_TYPES_MANAGE'],isset($role) ? ( \App\Services\CommonService::containString($role->permissions,'gt2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.gallery_types_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}}">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.items')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['ITEMS_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'i1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.items_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['ITEMS_MANAGE'],isset($role) ? (\App\Services\CommonService::containString($role->permissions,'i2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.items_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.events')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['EVENTS_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'e1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.events_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['EVENTS_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'e2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.events_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.event_types')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['EVENT_TYPES_VIEW'],isset($role) ? ( \App\Services\CommonService::containString($role->permissions,'et1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.event_types_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['EVENT_TYPES_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'et2') ? true : false) :  false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.event_types_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.categories')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['CATEGORIES_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'c1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.categories_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['CATEGORIES_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'c2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.categories_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.sub_categories')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['SUB_CATEGORIES_VIEW'],isset($role) ? ( \App\Services\CommonService::containString($role->permissions,'sc1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.sub_categories_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['SUB_CATEGORIES_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'sc2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.sub_categories_manage')</span>
                {!! $errors->first('permission', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.menus')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['MENU_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'m1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.menus_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['MENU_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'m2') ? true : false) : false)!!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.menus_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.sub_menus')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['SUB_MENU_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'sm1') ? true : false): false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.sub_menus_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['SUB_MENU_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'sm2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.sub_menus_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.currencies')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['CURRENCIES_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'cu1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.currencies_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['CURRENCIES_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'cu2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.currencies_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.promotions')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['PROMOTIONS_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'p1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.promotions_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['PROMOTIONS_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'p2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.promotions_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.contacts')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['CONTACTS_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'ct1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.contacts_view')</span>
                {!! $errors->first('permission', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['CONTACTS_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'ct2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.contacts_manage')</span>
                {!! $errors->first('permission', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.roles')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['ROLES_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'r1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.roles_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['ROLES_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'r2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.roles_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.configurations')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['CONFIGURATIONS_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'co1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.configurations_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['CONFIGURATIONS_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'co2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.configurations_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.payment_methods')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['PAYMENT_METHOD_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'pmd1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.payment_methods_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['PAYMENT_METHOD_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'pmd2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.payment_methods_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.email_templates')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['EMAIL_TEMPLATE_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'emt1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.email_templates_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['EMAIL_TEMPLATE_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'emt2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.email_templates_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.weekly_menus')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['WEEKLY_MENU_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'w1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.weekly_menus_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['WEEKLY_MENU_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'w2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.weekly_menus_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.abouts_us')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['ABOUT_US_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'au1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.abouts_us_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['ABOUT_US_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'au2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.abouts_us_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-3 {{ $errors->has('permissions') ? 'has-danger' : ''}} mt-5">
            <label for="permissions" class="col-form-label col-sm-12 form-role-title">@lang('admin.roles.title.images_list')</label>
            <div class="col-sm-12">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['IMAGE_LIST_VIEW'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'il1') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.images_list_view')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
            <div class="col-sm-12 pt-3">
                {!! Form::checkbox('permissions[]',\App\Models\Role::PERMISSIONS['IMAGE_LIST_MANAGE'], isset($role) ? (\App\Services\CommonService::containString($role->permissions,'il2') ? true : false) : false) !!}
                <span class="pl-2">@lang('admin.roles.checkbox_title.images_list_manage')</span>
                {!! $errors->first('permissions', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.roles.buttons.form_create'), ['class' => 'btn btn-success']) !!}
                <a href="{{url('admin/roles')}}" class="btn btn-secondary">
                    @lang('admin.roles.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
