@extends('layouts.main')

@section('title', 'Ticketing Job IT SLM')

@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Tickets</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tickets</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_ticket"><i class="fa fa-plus"></i> Add Ticket</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        {{-- <div class="row">
            <div class="col-md-12">
                <div class="card-group m-b-30">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">New Tickets</span>
                                </div>
                                <div>
                                    <span class="text-success">+10%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">112</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Solved Tickets</span>
                                </div>
                                <div>
                                    <span class="text-success">+12.5%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">70</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Open Tickets</span>
                                </div>
                                <div>
                                    <span class="text-danger">-2.8%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">100</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Pending Tickets</span>
                                </div>
                                <div>
                                    <span class="text-danger">-75%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">125</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Search Filter -->
        <div class="row filter-row">
            {{-- <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option> -- Select -- </option>
                        <option> Pending </option>
                        <option> Approved </option>
                        <option> Returned </option>
                    </select>
                    <label class="focus-label">Status</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option> -- Select -- </option>
                        <option> High </option>
                        <option> Low </option>
                        <option> Medium </option>
                    </select>
                    <label class="focus-label">Priority</label>
                </div>
            </div> --}}
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" id="from_date" name="from_date" type="text">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" id="to_date" name="to_date" type="text">
                    </div>
                    <label class="focus-label">To</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <a href="#" class="btn btn-success btn-block" id="btnFilter"> Search </a>
            </div>
        </div>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div id="datatable" class="table-responsive">
                    <table id="datatables" class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ticket Code</th>
                                <th>Date</th>
                                <th>Priority</th>
                                <th>User</th>
                                <th>Company</th>
                                <th>Vessel</th>
                                <th>Division</th>
                                <th>Email</th>
                                <th>Category</th>
                                <th>Problem</th>
                                <th>Status</th>
                                <th>Job By</th>
                                <th>Start Time</th>
                                <th>Finish Time</th>
                                {{-- <th>Working Time</th> --}}
                                <th>Problem Solving</th>
                                <th>Remarks</th>
                                {{-- <th>Priority</th> --}}
                                {{-- <th class="text-right">Actions</th> --}}
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
            columnDefs: [
                { orderable: false, targets: 0 }
            ],
            order: [[1, 'asc']]
            ajax: {
                    url: "{{ route('ticketing.index') }}",
                    type: "POST",
                    data: function(d) {
                        d.from_date = $('#from_date').val()
                        d.to_date = $('#to_date').val()
                    },
                    error: function (xhr, error, thrown) {
                        var from_date = $("#from_date").val();
                        var to_date = $("#to_date").val();

                        if(to_date < from_date){
                            alert('To Date tidak boleh lebih kecil dari From Date');
                            $("#to_date").val('');
                            location.reload();
                        }
                    }
                },

            columns: [
                {
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: 'TicketCode',
                    name: 'TicketCode'
                },
                {
                    data: 'TicketDate',
                    name: 'TicketDate'
                },
                {
                    data: 'TicketPriority',
                    name: 'TicketPriority'
                },
                {
                    data: 'Username',
                    name: 'Username'
                },
                {
                    data: 'Company',
                    name: 'Company'
                },
                {
                    data: 'Vessel',
                    name: 'Vessel'
                },
                {
                    data: 'Division',
                    name: 'Division'
                },
                {
                    data: 'Email',
                    name: 'Email'
                },
                {
                    data: 'Category',
                    name: 'Category'
                },
                {
                    data: 'Problem',
                    name: 'Problem'
                },
                {
                    data: 'TicketStatus',
                    name: 'TicketStatus'
                },
                {
                    data: 'InsertBy',
                    name: 'InsertBy'
                },
                {
                    data: 'StartTime',
                    name: 'StartTime'
                },
                {
                    data: 'EndTime',
                    name: 'EndTime'
                },
                // {
                //     data: 'WorkTime',
                //     name: 'WorkTime'
                // },
                {
                    data: 'Action',
                    name: 'Action'
                },
                {
                    data: 'Remarks',
                    name: 'Remarks'
                },
                // {
                //     data: 'actions',
                //     name: 'actions',
                //     searchable: false,
                //     sortable: false
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


        $("#btnFilter").click(function(){
            table.ajax.reload();
        });
    });
</script>


@endsection
