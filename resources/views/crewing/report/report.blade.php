@extends('layouts.main')

@section('title', 'Data Report Crewing')

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
                        <h3 class="page-title">Report Crewing</h3>
                        <ul class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="index.html">Master Administration</a></li> --}}
                            <li class="breadcrumb-item active">Report Crewing</li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->


            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="datatables" class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    {{-- <th>Action</th> --}}
                                    <th>#</th>
                                    <th>Status</th>
                                    {{-- <th>Company</th> --}}
                                    <th>BizUnit</th>
                                    <th>VesselName</th>
                                    <th>CrewType</th>
                                    <th>CrewTitle</th>
                                    <th>NIK</th>
                                    <th>Name</th>
                                    <th>JoinDate (dd-mmm-yy)</th>
                                    <th>Sex</th>
                                    <th>Religion</th>
                                    <th>BirthPlace</th>
                                    <th>BirthDate (dd-mmm-yy)</th>
                                    <th>HomeAddress</th>
                                    <th>Mobile Number</th>
                                    <th>Email Address</th>
                                    <th>HR Status</th>
                                    <th>KTP</th>
                                    <th>NPWP</th>
                                    <th>BankName</th>
                                    <th>BankBranch</th>
                                    <th>Bank.AccountNo</th>
                                    <th>Bank.Beneficiary</th>
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
    </div>
    <!-- /Page Wrapper -->
@endsection



@section('under_body')
    <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/select2.min.css">
    <script type="text/javascript">
        $(function() {

            $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ url('crewing/report/json') }}",
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
                    // {data: 'NOREC',name: 'NOREC'},
                    {data: 'REMARK',name: 'REMARK'},
                    {data: 'ops',name: 'ops'},
                    {data: 'VESSELNO',name: 'VESSELNO'},
                    {data: 'STSPOSISI',name: 'STSPOSISI'},
                    {data: 'POSISI',name: 'POSISI'},
                    {data: 'NIK',name: 'NIK'},
                    {data: 'NAMA',name: 'NAMA'},
                    {data: 'tglweb',name: 'tglweb'},
                    {data: 'JNSKLM',name: 'JNSKLM'},
                    {data: 'AGAMA',name: 'AGAMA'},
                    {data: 'TMPLHR',name: 'TMPLHR'},
                    {data: 'TGLLHR',name: 'TGLLHR'},
                    {data: 'ALMSKR',name: 'ALMSKR'},
                    {data: 'TELPSKR',name: 'TELPSKR'},
                    {data: 'EmailCrew',name: 'EmailCrew'},
                    {data: 'MARITALCODE',name: 'MARITALCODE'},
                    // {data: 'STSPRK',name: 'STSPRK'},
                    {data: 'NOKTP',name: 'NOKTP'},
                    {data: 'NPWP',name: 'NPWP'},
                    {data: 'BANKNAME',name: 'BANKNAME'},
                    {data: 'BANKBRANCH',name: 'BANKBRANCH'},
                    {data: 'NOREKDLG',name: 'NOREKDLG'},
                    {data: 'NAMADLG',name: 'NAMADLG'},
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
