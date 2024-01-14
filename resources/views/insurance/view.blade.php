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
                        <a href="{{ route('insurance.form_add_renewal') }}" class="btn add-btn"><i
                                class="fa fa-plus"></i> Add Insurance</a>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark btn-rounded dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Import Insurance</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#import_emp">Import</a>
                                <a class="dropdown-item" href="#">Template Import Insurance</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->



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
                                    <th>Policy Number</th>
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
            $('#ins_type').select2({width: '100%'});
            $('#entity').select2({width: '100%'});
            $('#broker').select2({width: '100%'});

            $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ url('insurance/renewal_monitoring/json') }}",
                columns: [
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        sortable: false
                    },
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
                    {
                        data: 'remark',
                        name: 'remark'
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

        });

    </script>

@endsection
