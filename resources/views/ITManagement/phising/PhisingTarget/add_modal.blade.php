<div id="add_phisingtarget" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Phising Target</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-add-phisingtarget" action="{{ route('phisingtarget.phisingtarget_save') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Phising Type</label>
                                <select class="form-control" name="phising_type" id="phising_type" required>
                                    <option value="">Select Type</option>
                                    <option value="Gaji-Bulanan">Gaji-Bulanan</option>
                                    <option value="Kenaikan-Gaji">Kenaikan-Gaji</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>No Absen</label>
                                <input class="form-control" type="text" name="no_absent_target" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Target</label>
                                <input class="form-control" type="text" name="name_target" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email Target</label>
                                <input class="form-control" type="email" name="email_target" required>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn-broker submit" id="BtnSubmitBroker" type="submit">
                            <span class="btn-txt">Save</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
