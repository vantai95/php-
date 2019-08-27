<div class="modal fade" id="registerAdviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="register-advice">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-6 d-md-block d-none register-advice-left">
                            <img class="img-people" style="width:100%"
                                src="/b2c-assets/img/register_advice_people.png" alt="" />
                        </div>

                        <div class="col-md-6 register-advice-right">
                            <div class="text-center">
                                <img src="/b2c-assets/img/logo_register_service_modal.png" width="140px"
                                    title="{{trans('b2c.header.menu.glamer_clinic')}}"
                                    alt="{{trans('b2c.header.menu.glamer_clinic')}}" />
                            </div>
                            <div class="text-center title form-group">Register Advice</div>
                            {!! Form::open(['method' => 'POST', 'url' => '/register-advice', 'id' =>
                            'registerAdviceForm']) !!}
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Full Name" name="name">
                                <div style="display:none" class="text-danger font-italic" id="error_name"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Phone Number" name="phone" onkeypress="return isNumber(event)">
                                <div style="display:none" class="text-danger font-italic" id="error_phone"></div>
                            </div>
                            <div class="form-group">
                                <select class="dropdown custom-select" name="service_id">
                                    <option value="" disabled {{ ($service_id == "" ? 'selected' : '') }}>
                                        Choose treatments
                                    </option>
                                    @foreach ($services as $item)
                                    <option value="{{$item->id}}">
                                        {{$item->name}}
                                    </option>
                                    @endforeach
                                </select>
                                <div style="display:none" class="text-danger font-italic" id="error_service_id"></div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="btn-book text-center" id="btnBookNow">
                                    BOOK NOW
                                </div>
                            </div>
                            {!! Form::close()!!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
