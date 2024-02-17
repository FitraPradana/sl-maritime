@foreach ($navcompany as $val)
    <div id="edit_navcompany{{ $val->id }}" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Insurance Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit-navcompany" action="{{ route('navcompany.update', $val->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Company Code</label>
                                    <input class="form-control" type="text" name="companycode"
                                        value="{{ $val->companycode }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input class="form-control" type="text" name="companyname"
                                        value="{{ $val->companyname }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Company Description</label>
                                    <textarea class="form-control" name="companydescription" cols="30" rows="3">{{ $val->companydescription }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn-broker submit" id="BtnSubmitBroker" type="submit">
                                <span class="btn-txt">Update</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
