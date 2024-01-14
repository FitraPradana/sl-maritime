<!-- Add Insurance Modal -->
<div id="add_insurance" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Insurance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('insurance.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Insurance Type</label>
                                <select class="select" id="ins_type" name="ins_type" required>
                                    <option value="">-- Pilih Type--</option>
                                    @foreach ($ins_type as $value)
                                        <option value="{{ $value->typecode }}">{{ $value->typename }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Entity</label>
                                <select class="select" id="entity" name="entity" required>
                                    <option value="">-- Pilih Entity--</option>
                                    @foreach ($company as $value)
                                        <option value="{{ $value->companycode }}">{{ $value->companyname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Broker / Intermediary</label><br>
                                <select class="select" id="broker" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($ins_broker as $value)
                                        <option value="{{ $value->brokercode }}">{{ $value->brokername }}</option>
                                    @endforeach
                                    <option value="others"> Others ...</option>
                                </select>
                                {{-- <input type="text" name="broker"> --}}
                            </div>
                            <div class="form-group">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Inception Date</label>
                                {{-- <input class="form-control datetimepicker" type="text" name="inception_date" required> --}}
                                <div class="cal-icon"><input class="form-control datetimepicker" type="text" name="inception_date" required></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Expiry Date</label>
                                <div class="cal-icon"><input class="form-control datetimepicker" type="text" name="expiry_date" required></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Insurer</label>
                                <select class="select" id="insurer" name="insurer" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($ins_insurer as $value)
                                        <option value="{{ $value->insurercode }}">{{ $value->insurername }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea class="form-control" name="remarks"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Status</label>
                            <select class="select select2-hidden-accessible" data-select2-id="select2-data-4-ygw9" tabindex="-1" aria-hidden="true">
                                <option data-select2-id="select2-data-6-8zo7">Active</option>
                                <option data-select2-id="select2-data-19-v83p">Inactive</option>
                            </select><span class="select2 select2-container select2-container--default select2-container--below select2-container--focus" dir="ltr" data-select2-id="select2-data-5-zh9n" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-5ve3-container" aria-controls="select2-5ve3-container"><span class="select2-selection__rendered" id="select2-5ve3-container" role="textbox" aria-readonly="true" title="Active">Active</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Insurance Modal -->
