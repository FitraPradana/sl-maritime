<div id="add_broker" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Broker</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form id="form-broker" action="{{ route('broker.store') }}" method="POST" enctype="multipart/form-data"> --}}
                    <form id="form-broker">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Broker Code</label>
                                <input class="form-control" type="text" name="brokercode" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Broker Name</label>
                                <input class="form-control" type="text" name="brokername" required>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn-broker" id="BtnSubmitBroker" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
