<div class="modal fade" id="customerServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="customer-service">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center title form-group">Customer Service</div>
                            <div class="form-group">
                                <div class="btn-live text-center">
                                    LIVE CHAT
                                </div>
                            </div>
                            <div class="text-center form-group">
                                <div class="row text-or">
                                    <div class="col-5">
                                        <div class="custom-hr"></div>
                                    </div>
                                    <div class="col-2 title">OR</div>
                                    <div class="col-5">
                                        <div class="custom-hr"></div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::open(['method' => 'POST', 'url' => '/customer-service', 'id' =>
                            'customerServiceForm']) !!}
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Full Name" name="name">
                                <div style="display:none" class="text-danger font-italic" id="error_name"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Phone Number" name="phone"
                                    onkeypress="return isNumber(event)">
                                <div style="display:none" class="text-danger font-italic" id="error_phone"></div>
                            </div>
                            <div class="form-group">
                                <select class="dropdown custom-select" name="province_id">
                                    <option value="" disabled {{ ($province_id == "" ? 'selected' : '') }}>
                                        Provincial
                                    </option>
                                    @foreach ($provinces as $item)
                                        <option value="{{$item->id}}">
                                            {{$item->name}}
                                        </option>
                                    @endforeach
                                </select>
                                <div style="display:none" class="text-danger font-italic" id="error_province_id"></div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="content"></textarea>
                                <div style="display:none" class="text-danger font-italic" id="error_content"></div>
                            </div>
                            <div class="form-group">
                                <div class="btn-send text-center pt-3">
                                    <span id="btnSend">SEND</span>
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
