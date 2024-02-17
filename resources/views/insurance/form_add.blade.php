@extends('layouts.main')

@section('title', 'Create Renewal Insurance')

@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Create Renewal Insurance</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">Insurance</li>
                            <li class="breadcrumb-item"><a href="#">Insurance Monitoring</a></li>
                            <li class="breadcrumb-item active">Create Renewal Insurance</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    <form id="form-add" action="{{ route('insurance.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Policy Number <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="policy_number" name="policy_number"
                                        value="{{ old('policy_number', $PoliceInsuranceAuto) }}" required readonly>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Type of Insurance <span class="text-danger">*</span></label>
                                    <select class="select" id="insurance_type" name="insurance_type" required>
                                        <option value="">-- Pilih Type--</option>
                                        @foreach ($ins_type as $value)
                                            <option value="{{ $value->typecode }}">{{ $value->typename }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-2">
                                <div class="form-group">
                                    <label>Inception Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" id="inception_date"
                                            name="inception_date" required>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <div class="form-group">
                                    <label>Expiry Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" id="expiry_date"
                                            name="expiry_date" required readonly>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="status" name="status" value="active" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Entity <span class="text-danger">*</span></label>
                                    <select class="select" id="entity" name="entity" required>
                                        <option value="">-- Pilih Entity--</option>
                                        @foreach ($company as $value)
                                            <option value="{{ $value->companycode }}">{{ $value->companyname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Broker <span class="text-danger">*</span>&nbsp;</label>
                                    <select class="select" id="broker" name="broker" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($ins_broker as $value)
                                            <option value="{{ $value->brokercode }}">{{ $value->brokername }}</option>
                                        @endforeach
                                        {{-- <option value="others"> Others ...</option> --}}
                                    </select>
                                </div>
                                <li class="fa fa-plus"><a href="#" data-toggle="modal" data-target="#add_broker"> Add
                                        Broker</a></i>

                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Insurer <span class="text-danger">*</span></label>
                                    <select class="select" id="insurer" name="insurer" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($ins_insurer as $value)
                                            <option value="{{ $value->insurercode }}">{{ $value->insurername }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Fully Paid <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" class="fully_paid" id="fully_paid" name="fully_paid"
                                                    value="yes"> YES
                                                &nbsp;<input type="radio" class="fully_paid" id="fully_paid"
                                                    name="fully_paid" value="no"> NO
                                            </label>
                                        </div>
                                        {{-- <div class="onoffswitch">
											<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_annual" checked>
											<label class="onoffswitch-label" for="switch_annual">
												<span class="onoffswitch-inner"></span>
												<span class="onoffswitch-switch"></span>
											</label>
										</div> --}}

                                    </div>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-review review-table mb-0"
                                        id="table_achievements">
                                        <thead>
                                            <tr>
                                                <th style="width: 20px">#</th>
                                                <th class="col-sm-2">Installment</th>
                                                <th class="col-md-6">Amount</th>
                                                <th style="width:100px;">Due Date</th>
                                                <th style="width: 64px;"><button type="button"
                                                        class="btn btn-primary btn-add-row"><i
                                                            class="fa fa-plus"></i></button></th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_achievements_tbody">
                                            <tr>
                                                <td>1</td>
                                                <td><input type="text" class="form-control" id="installment"
                                                        name="installment[]" value="1" readonly></td>
                                                <td><input type="number" class="form-control" id="line_amount"
                                                        name="line_amount[]"></td>
                                                <td>
                                                    <input type="date" class="form-control" id="duedate"
                                                        name="duedate[]"></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{-- <div class="table-responsive">
                                    <table id="form-dynamic" class="table table-hover table-white">
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right">Total Amount</td>
                                                <td style="text-align: right; padding-right: 30px;width: 230px">
                                                    <input class="form-control text-right" id="total_amount"
                                                        name="total_amount" value="0" type="text">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Other Information</label>
                                            <textarea class="form-control" rows="4" id="remarks" name="remarks"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            {{-- <button class="btn btn-primary submit-btn m-r-10">Save & Send</button> --}}
                            <button class="btn btn-primary submit-btn submit" type="submit"
                                onclick="validateTgl()">
                                <span class="btn-txt">Save</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>

                            <a class="btn btn-primary submit-btn m-r-10"
                                href="{{ route('insurance.renewal_monitoring') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->


    <!-- Add broker Modal -->
    @include('broker.add_modal')
    <!-- /Add broker Modal -->
@endsection



@section('under_body')
    {{-- <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/select2.min.css"> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#form-add").submit(function() {
                $(".spinner-border").removeClass("d-none");
                $(".submit").attr("disabled", true);
                $(".btn-txt").text("Processing ...");
            });
            // var paid_yes = $('input[name="fully_paid"][value="yes"]').prop('checked', true);
            $(".table-review").hide();
            $("#fully_paid").prop('required', true);
            // console.log(radioValue);
            // fullypaidjq();
            $(".fully_paid").change(function() {
                var radioValue = $(".fully_paid:checked").val();
                if (radioValue == "no") {
                    $(".table-review").show();
                    $("#total_amount").prop('readonly', true);
                    $("#line_amount").prop('required', true);
                    $("#duedate").prop('required', true);

                    $(".btn-add-row").show();
                    $("#installment").val(1);
                } else if (radioValue == "yes") {
                    $(".table-review").show();
                    $("#total_amount").prop('readonly', false);
                    $("#line_amount").prop('required', true);
                    $("#duedate").prop('required', true);


                    $(".btn-add-row").hide();
                    $("#installment").val('Fully Paid');
                    $('.table-review tbody tr').not(':first').remove();
                }
            });

            // SELECT2
            // $('#insurance_type').select2({
            //     width: 50%
            // });

            // Menambahkan event onBlur ke input text
            $('#inception_date').on('change', function(){
                // Mengambil nilai tanggal saat ini dari DateTimePicker
                var inception_date = new Date($(this).val());
                output_f=new Date(inception_date.setDate(inception_date.getDate()+365)).toISOString().split('.');
                console.log(output_f);

                output_s = output_f[0].split('T');
                $('#expiry_date').val(output_s[0]);
            });

        });


        $(function() {

            // GLOBAL SETUP
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on("click", '.btn-add-row', function() {
                var id = $(this).closest("table.table-review").attr('id'); // Id of particular table
                console.log(id);
                var div = $("<tr />");
                div.html(GetDynamicTextBox(id));
                $("#" + id + "_tbody").append(div);
            });
            $(document).on("click", "#comments_remove", function() {
                $(this).closest("tr").prev().find('td:last-child').html(
                    '<button type="button" class="btn btn-danger" id="comments_remove"><i class="fa fa-trash-o"></i></button>'
                    );
                $(this).closest("tr").remove();
            });

            function GetDynamicTextBox(table_id) {
                $('#comments_remove').remove();
                var rowsLength = document.getElementById(table_id).getElementsByTagName("tbody")[0]
                    .getElementsByTagName("tr").length + 1;
                // var rowsLengthh = document.getElementById(table_id).getElementsByTagName("tbody")[1].getElementsByTagName("tr").length+1;
                return '<td>' + rowsLength + '</td>' +
                    '<td><input type="text" id="installment" name = "installment[]" class="form-control" value = "' +
                    rowsLength + '" readonly></td>' +
                    '<td><input type="number" id="line_amount" name = "line_amount[]" class="form-control" value = ""></td>' +
                    '<td><input type="date" id="duedate" name = "duedate[]" class="form-control" value = ""></td>' +
                    '<td><button type="button" class="btn btn-danger" id="comments_remove"><i class="fa fa-trash-o"></i></button></td>'
            }

            // ADD BROKER
            $('#BtnSubmitBroker').click(function() {
                // Ambil data dari formulir
                var formData = $('#form-broker').serialize();
                // Kirim data ke server menggunakan Ajax
                $.ajax({
                    type: 'POST',
                    url: '{{ url('insurance/renewal_monitoring/saveBroker') }}',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        $('#add_broker').hide();

                        Swal.fire({
                            title: "Data Broker Berhasil ditambahkan!",
                            text: "You clicked the button!",
                            icon: "success"
                        })
                    },
                    error: function(error) {
                        // Tangani kesalahan jika ada
                        console.log(error);
                        alert('Terjadi kesalahan saat menyimpan data');
                    }
                });
            });
            // END ADD BROKER
        });
    </script>

@endsection
