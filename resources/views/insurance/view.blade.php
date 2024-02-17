@extends('layouts.main')

@section('title', 'Data Insurance')

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
                        <h3 class="page-title">Insurance Renewal Monitoring</h3>
                        <ul class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="index.html">Master Administration</a></li> --}}
                            <li class="breadcrumb-item active">Renewal Monitoring</li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('insurance.form_add_renewal') }}" class="btn add-btn"><i class="fa fa-plus"></i>
                            Create Insurance</a>
                    </div>&nbsp;&nbsp;&nbsp;
                    <div class="btn-group">
                        <a href="#" class="btn btn-dark btn-rounded btn-sm get-btn"><i class="fa fa-cloud"></i> Get
                            Renewal Insurance</a>
                    </div>
                    {{-- <form action="{{ route('insurance.testing') }}">
                    @csrf
                        <button class="btn add-btn" type="submit">TESTING</button>
                    </form> --}}
                    {{-- <div class="col-auto float-right ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark btn-rounded dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Import Insurance</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#import_emp">Import</a>
                                <a class="dropdown-item" href="#">Template Import Insurance</a>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>
            <!-- /Page Header -->

            <!-- Insurance Statistics -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Active</h6>
                        <h4>{{ $activeIns }} / {{ $totalIns }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Need Action</h6>
                        <h4>{{ $needActionIns }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Expired</h6>
                        <h4>{{ $ExpiredIns }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>New Active Today</h6>
                        <h4>{{ $todayActiveIns }}</h4>
                    </div>
                </div>
            </div>
            <!-- /Insurance Statistics -->

            <!-- Search Filter -->
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" id="policynumber_filter">
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
                    <a href="#" class="btn btn-success btn-block" id="btnFilter"> Search </a>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <a href="#" class="btn btn-danger btn-block" id="btnReset"> Reset </a>
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
                            <option value="active"> Active </option>
                            <option value="need_action"> Need Action </option>
                            <option value="expired"> Expired</option>
                        </select>
                        <label class="focus-label">Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" id="flag_filter">
                            <option value=""> -- Select Flag -- </option>
                            <option value="green"> H-60 s/d H-31 (Green)</option>
                            <option value="yellow"> H-30 s/d H-11 (Yellow)</option>
                            <option value="red"> H-10 s/d H+10 (Red)</option>
                        </select>
                        <label class="focus-label">Flag</label>
                    </div>
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
                                    {{-- <th>Action</th> --}}
                                    <th>#</th>
                                    <th>Policy Number</th>
                                    <th>Reference Policy Number</th>
                                    <th>Insurance Type</th>
                                    <th>Entity</th>
                                    <th>Inception Date</th>
                                    <th>Expiry Date</th>
                                    <th>Broker</th>
                                    <th>Insurer</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
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


        <!-- Add insurance Modal -->
        @include('insurance.add_modal')
        <!-- /Add insurance Modal -->

    </div>
    <!-- /Page Wrapper -->
@endsection



@section('under_body')
    <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/select2.min.css">
    <script type="text/javascript">
        $(function() {

            // SELECT2
            $('#ins_type').select2({
                width: '100%'
            });
            $('#entity').select2({
                width: '100%'
            });
            $('#broker').select2({
                width: '100%'
            });

            table = $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('insurance.renewal_monitoring') }}",
                    // type: "POST",
                    data: function(d) {
                        d.policynumber_filter = $('#policynumber_filter').val(),
                        d.ins_type_filter = $('#ins_type_filter').val(),
                        d.company_filter = $('#company_filter').val(),
                        d.broker_filter = $('#broker_filter').val(),
                        d.insurer_filter = $('#insurer_filter').val(),
                        d.status_filter = $('#status_filter').val(),
                        d.flag_filter = $('#flag_filter').val()
                    }
                },
                columns: [
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     searchable: false,
                    //     sortable: false
                    // },
                    {
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'policynumber',
                        name: 'policynumber'
                    },
                    {
                        data: 'oldtransnumber',
                        name: 'oldtransnumber'
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
                        data: 'inceptiondate',
                        name: 'inceptiondate'
                    },
                    {
                        data: 'expirydate',
                        name: 'expirydate'
                    },
                    {
                        data: 'brokername',
                        name: 'brokername'
                    },
                    {
                        data: 'insurername',
                        name: 'insurername'
                    },

                    {
                        data: 'status',
                        name: 'status'
                    },
                    // {
                    //     data: 'remark',
                    //     name: 'remark'
                    // },
                    {
                        data: 'remark_color',
                        name: 'remark_color'
                    },
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


            // get-btn
            $('.get-btn').click(function() {
                $.ajax({
                    type: 'GET',
                    url: '{{ url('insurance/get_renewal') }}',
                    // data: formData,
                    dataType: 'json',
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire({
                            title: response.message,
                            text: "You clicked the button!",
                            icon: response.icon,
                        })
                    },
                    error: function(error) {
                        // Tangani kesalahan jika ada
                        console.log(error);
                        Swal.fire({
                            title: response.message,
                            text: "You clicked the button!",
                            icon: "error"
                        })
                    }
                });
            });

            $('#btnFilter').on('click', function() {
                table.ajax.reload();
            });
            $('#btnReset').on('click', function() {
                location.reload();
            });

            // Menangani tindakan POST saat tombol diklik
            $('#datatables tbody').on('click', '.btn-need-action', function () {
                var Id = $(this).data('id');

                // Redirect ke halaman lain dan kirim nilai menggunakan formulir
                var form = $('<form action="{{ route("insurance.form_update_renewal") }}" method="POST">' +
                                '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                '<input type="hidden" name="transinsheader_id" value="' + Id + '">' +
                             '</form>');
                $('body').append(form);
                form.submit();
            });

        });
    </script>

@endsection
