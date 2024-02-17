@foreach ($insurancePayment as $val)


<div id="update_payment_date{{ $val->id }}" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Payment Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-broker" action="{{ route('insurance_payment.update_payment_date', $val->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" value="{{ $val->id }}" name="id_insurancepayment">
                            <div class="form-group">
                                <label>Payment Date</label>
                                <input class="form-control" type="date" name="payment_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" id="BtnSubmitPaymentDate" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endforeach
