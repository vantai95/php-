<div class="m-portlet__body">
    <div class="m-invoice-2">
        <div class="m-invoice__wrapper">
            <div class="m-invoice__head" style="background-image: url(../../assets/app/media/img//logos/bg-6.jpg);">
                <div class="m-invoice__container m-invoice__container--centered">
                    <div class="m-invoice__logo">
                        <a href="#">
                            <h1>
                                INVOICE
                            </h1>
                        </a>
                        <a href="#">
                            <img src="../../assets/app/media/img//logos/logo_client_color.png">
                        </a>
                    </div>
                    <span class="m-invoice__desc">
                        <span>
                            Cecilia Chapman, 711-2880 Nulla St, Mankato
                        </span>
                        <span>
                            Mississippi 96522
                        </span>
                    </span>
                    <div class="m-invoice__items">
                        <div class="m-invoice__item">
                            <span class="m-invoice__subtitle">
                                DATA
                            </span>
                            <span class="m-invoice__text">
                                Dec 12, 2017
                            </span>
                        </div>
                        <div class="m-invoice__item">
                            <span class="m-invoice__subtitle">
                                INVOICE NO.
                            </span>
                            <span class="m-invoice__text">
                                GS 000014
                            </span>
                        </div>
                        <div class="m-invoice__item">
                            <span class="m-invoice__subtitle">
                                INVOICE TO.
                            </span>
                            <span class="m-invoice__text">
                                Iris Watson, P.O. Box 283 8562 Fusce RD.
                                <br>
                                Fredrick Nebraska 20620
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-invoice__body m-invoice__body--centered">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                DESCRIPTION
                            </th>
                            <th>
                                HOURS
                            </th>
                            <th>
                                RATE
                            </th>
                            <th>
                                AMOUNT
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                Creative Design
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                $40.00
                            </td>
                            <td class="m--font-danger">
                                $3200.00
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Front-End Development
                            </td>
                            <td>
                                120
                            </td>
                            <td>
                                $40.00
                            </td>
                            <td class="m--font-danger">
                                $4800.00
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Back-End Development
                            </td>
                            <td>
                                210
                            </td>
                            <td>
                                $60.00
                            </td>
                            <td class="m--font-danger">
                                $12600.00
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="m-invoice__footer">
                <div class="m-invoice__table  m-invoice__table--centered table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                BANK
                            </th>
                            <th>
                                ACC.NO.
                            </th>
                            <th>
                                DUE DATE
                            </th>
                            <th>
                                TOTAL AMOUNT
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                BARCLAYS UK
                            </td>
                            <td>
                                12345678909
                            </td>
                            <td>
                                Jan 07, 2018
                            </td>
                            <td class="m--font-danger">
                                20,600.00
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-group m-form__group">
        <div class='col-6'>
            <div class="row col-form-label">
                @lang('admin.orders.columns.name') : {{$order->name}}
            </div>
            <div class="row col-form-label">
                @lang('admin.orders.columns.email') : {{$order->email}}
            </div>
        </div>
        <div class='col-6'>
            <div class="row">
                @lang('admin.orders.columns.name') : {{$order->name}}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
        <label for="name" class="col-form-label col-lg-3 col-sm-12">@lang('admin.orders.columns.name')</label>
        <div class="col-form-label col-lg-6 col-md-9 col-sm-12">
            {{$order->name}}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('email') ? 'has-danger' : ''}}">
        <label for="email" class="col-form-label col-lg-3 col-sm-12">@lang('admin.orders.columns.email')</label>
        <div class="col-form-label col-lg-6 col-md-9 col-sm-12">
            {{$order->email}}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('content') ? 'has-danger' : ''}}">
        <label for="content" class="col-form-label col-lg-3 col-sm-12">@lang('admin.orders.columns.phone')</label>
        <div class="col-form-label col-lg-6 col-md-9 col-sm-12">
            {{$order->phone_number}}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('created_at') ? 'has-danger' : ''}}">
        <label for="created_at"
               class="col-form-label col-lg-3 col-sm-12">@lang('admin.orders.columns.created_date')</label>
        <div class="col-form-label col-lg-6 col-md-9 col-sm-12">
            {{\App\Services\CommonService::formatSendDate($order->created_at)}}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('note') ? 'has-danger' : ''}}">
        <label for="note" class="col-form-label col-lg-3 col-sm-12">@lang('admin.orders.columns.note')</label>
        <div class="col-lg-6 col-md-9 col-sm-12">
            {!! Form::text('note', null, ['class' => 'form-control m-input']) !!}
            {!! $errors->first('note', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success']) !!}
                <a href="{{url('admin/contacts')}}" class="btn btn-secondary">
                    @lang('admin.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>