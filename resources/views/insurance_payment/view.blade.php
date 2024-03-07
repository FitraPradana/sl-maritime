@extends('layouts.main')

@section('title', 'Transaksi Insurance Payment')

@section('content')

    <style>
        .center {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            flex: 1 0 100%;
        }

        .select2-container.select2-container--default.select2-container--open {
            z-index: 5000;
        }
    </style>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Insurance Payment Monitoring</h3>
                        <ul class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="index.html">Master Administration</a></li> --}}
                            <li class="breadcrumb-item active">Payment Monitoring</li>
                        </ul>
                    </div>
                    {{-- <div class="btn-group">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_payment_insurance"><i
                                class="fa fa-plus"></i> Add Payment Insurance</a>
                    </div> --}}
                    {{-- <div class="col-auto float-right ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark btn-rounded dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Import Employee</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#import_emp">Import</a>
                                <a class="dropdown-item" href="#">Template Import Employee</a>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filter -->
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" value="" id="policynumber_filter">
                        <label class="focus-label">Policy Number</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" id="ins_type_filter">
                            <option value=""> -- Select -- </option>
                            @foreach ($ins_type as $val)
                                <option value="{{ $val->typecode }}">{{ $val->typename }}</option>
                            @endforeach
                        </select>
                        <label class="focus-label">Insurance Type</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" id="company_filter">
                            <option value=""> -- Select -- </option>
                            @foreach ($company as $val)
                                <option value="{{ $val->companycode }}">{{ $val->companyname }}</option>
                            @endforeach
                        </select>
                        <label class="focus-label">Company</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" id="broker_filter">
                            <option value=""> -- Select -- </option>
                            @foreach ($ins_broker as $val)
                                <option value="{{ $val->brokercode }}">{{ $val->brokername }}</option>
                            @endforeach
                        </select>
                        <label class="focus-label">Broker</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" id="insurer_filter">
                            <option value=""> -- Select -- </option>
                            @foreach ($ins_insurer as $val)
                                <option value="{{ $val->insurercode }}">{{ $val->insurername }}</option>
                            @endforeach
                        </select>
                        <label class="focus-label">Insurer</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" id="status_filter">
                            <option value=""> -- Select Status -- </option>
                            <option value="success"> Success </option>
                            <option value="pending"> Pending </option>
                        </select>
                        <label class="focus-label">Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" id="flag_filter">
                            <option value=""> -- Select Flag -- </option>
                            <option value="green"> H-30 s/d H-31 (Green)</option>
                            <option value="yellow"> H-30 s/d H-11 (Yellow)</option>
                            <option value="red"> H-10 s/d H+10 (Red)</option>
                        </select>
                        <label class="focus-label">Flag</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <a href="#" class="btn btn-success btn-block" id="btnFilter"> Search </a>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <a href="#" class="btn btn-info btn-block" id="btnReset"> Clear </a>
                </div>
                {{-- <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">To</label>
                    </div>
                </div> --}}
            </div><br>
            <!-- /Search Filter -->


            <div class="row">
                <div class="col-md-12">
                    @if (session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    {{-- @if ($room->isEmpty())
                    <div class="alert alert-danger" role="alert">
                        Data Room Masih KOSONG !!! Harap di Input terlebih dahulu
                    </div>
                @endif --}}

                    @if (session()->has('failures'))
                        <div class="alert alert-danger" role="alert">
                            Room Code (
                            @foreach (session()->get('failures') as $validasi)
                                {{ $validasi->values()[$validasi->attribute()] . ',' }}
                            @endforeach
                            ) is Duplicate
                        </div>
                    @endif

                    @if (isset($errors) && $errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif


                    <div class="table-responsive">
                        <table id="datatables" class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>#</th>
                                    <th>Remark</th>
                                    <th>Payment Status</th>
                                    <th>Policy Number</th>
                                    <th>Insurance Type</th>
                                    <th>Entity</th>
                                    <th>Installment</th>
                                    <th>Due Date</th>
                                    <th>Payment Date</th>
                                    <th>Broker</th>
                                    <th>Insurer</th>

                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->


        <!-- Update Modal -->
        @include('insurance_payment.modal_payment_date')
        <!-- /Update Modal -->

        <!-- Add Employee Modal -->
        {{-- @include('employee.edit_modal') --}}
        <!-- /Add Employee Modal -->


    </div>
    <!-- /Page Wrapper -->
@endsection



@section('under_body')
    {{-- <link rel="stylesheet" href="{{ asset('/') }}assets/css/select2.min.css"> --}}

    <script type="text/javascript">
        $(document).ready(function() {
            $("#form-payment-insurance").submit(function() {
                $(".spinner-border").removeClass("d-none");
                $(".submit").attr("disabled", true);
                $(".btn-txt").text("Processing ...");
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {

            // GLOBAL SETUP
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('insurance_payment_monitoring.index') }}",
                    type: "POST",
                    data: function(d) {
                        d.policynumber_filter = $('#policynumber_filter').val(),
                            d.ins_type_filter = $('#ins_type_filter').val(),
                            d.company_filter = $('#company_filter').val(),
                            d.broker_filter = $('#broker_filter').val(),
                            d.insurer_filter = $('#insurer_filter').val(),
                            d.status_filter = $('#status_filter').val()
                    }
                },
                columns: [{
                        "class": "details-control",
                        "orderable": false,
                        "data": null,
                        "defaultContent": ""
                    },
                    {
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'remark_color',
                        name: 'remark_color'
                    },
                    {
                        data: 'status_payment',
                        name: 'status_payment'
                    },
                    {
                        data: 'policynumber',
                        name: 'policynumber'
                    },
                    {
                        data: 'typename',
                        name: 'typename'
                    },
                    {
                        data: 'company',
                        name: 'company'
                    },
                    {
                        data: 'installment_ke',
                        name: 'installment_ke'
                    },
                    {
                        data: 'duedate',
                        name: 'duedate'
                    },
                    {
                        data: 'paymentdate',
                        name: 'paymentdate'
                    },
                    {
                        data: 'brokername',
                        name: 'brokername'
                    },
                    {
                        data: 'insurername',
                        name: 'insurername'
                    },


                    // {
                    //     data: 'remark',
                    //     name: 'remark'
                    // },

                ],
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                buttons: [
                    'pageLength',
                    {
                        "extend": "colvis",
                        "text": "Show/Hide Columns"
                    },
                    'copy', 'csv',
                    {
                        extend: "excel",
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'print'
                ],
            });
            $('#btnFilter').on('click', function() {
                table.ajax.reload();
            });
            $('#btnReset').on('click', function() {
                location.reload();
            });
        });
    </script>

@endsection
