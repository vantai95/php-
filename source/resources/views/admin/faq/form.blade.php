<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('question_vi') ? 'has-danger' : ''}}">
            <label for="question_vi" class="col-form-label col-sm-12">@lang('admin.faq.forms.question_vi')
            <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('question_vi', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('question_vi', '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('question_en') ? 'has-danger' : ''}}">
            <label for="question_en" class="col-form-label col-sm-12">@lang('admin.faq.forms.question_en')
            </label>
            <div class="col-sm-12">
                {!! Form::text('question_en', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!} {!! $errors->first('question_en',
                '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('anwser_vi') ? 'has-danger' : ''}}">
            <label for="anwser_vi" class="col-form-label col-sm-12">@lang('admin.faq.forms.anwser_vi')
              </label>
            <div class="col-sm-12">
                {!! Form::textarea('anwser_vi', null, ['class' => 'summernote']) !!} {!! $errors->first('anwser_vi', '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('anwser_en') ? 'has-danger' : ''}}">
            <label for="anwser_en" class="col-form-label col-sm-12">@lang('admin.faq.forms.anwser_en')
                </label>
            <div class="col-sm-12">
                {!! Form::textarea('anwser_en', null, ['class' => 'summernote']) !!} {!! $errors->first('anwser_en', '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.faq.buttons.update'), ['class' =>
                'btn btn-accent m-btn m-btn--air m-btn--custom', 'id' => 'submitButton']) !!}
                <a href="{{url('admin/faqs')}}" type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom btn-cancel">
                        @lang('admin.faq.buttons.cancel')
                    </a>
            </div>
        </div>
    </div>
</div>
