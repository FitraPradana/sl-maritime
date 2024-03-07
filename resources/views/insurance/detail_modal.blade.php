@foreach ($trans_ins_header as $val)
<div id="detail_police{{ $val->tran_insurance_header_id }}" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Police Number</th>
                            <th>Payment Status</th>
                            <th>Installment</th>
                            <th>Due Date</th>
                            <th>Payment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($insurancePayment->where('tran_insurance_header_id', $val->tran_insurance_header_id) as $item)
                            <tr>
                                <td></td>
                                <td>{{ $item->tran_insurance_header_id }}</td>
                                <td>{{ $item->status_payment }}</td>
                                <td>{{ $item->installment_ke }}</td>
                                <td>{{ date('d F Y', strtotime($item->duedate)) }}</td>
                                <td>
                                    @if ($item->paymentdate == null OR $item->paymentdate == '')
                                        <a class="btn btn-info btn-sm" href="#" data-toggle="modal" data-target="#update_payment_date{{  $item->id }}"><i class="fa fa-money m-r-5"></i>PAID</a>
                                    @else
                                        {{ date('d F Y', strtotime($item->paymentdate)) }}
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>

            </div>
        </div>
    </div>
</div>

@endforeach
