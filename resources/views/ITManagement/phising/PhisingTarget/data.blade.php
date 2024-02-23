@extends('layouts.main')

@section('title', 'Phising Management')

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
                        <h3 class="page-title">Data Phising Taget</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">IT Management</a></li>
                            <li class="breadcrumb-item active">Phising Taget</li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_phisingtarget"><i
                                class="fa fa-plus"></i> Add Phising Target</a>
                    </div>
                    <div class="btn-group">
                        <a href="{{ url('PhisingTarget/Mail/SendMail') }}" class="btn btn-dark"><i class="fa fa-plus"></i> Send
                            Mail Phising Target</a>
                    </div>
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

            <a href="{{ url('PhisingTarget/Mail/SendMail') }}"><i class="fa fa-plus"></i> Send
                Mail Phising Target</a>


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
                                    <th width="80px">Action</th>
                                    <th width="50px">#</th>
                                    <th>Type</th>
                                    <th>No Absen</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Is Send Mail</th>
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


        <!-- Add Role Modal -->
        @include('ITManagement.phising.PhisingTarget.add_modal')
        <!-- /Add Role Modal -->

        {{-- @include('ITManagement.phising.PhisingTarget.sendMail_modal') --}}


    </div>
    <!-- /Page Wrapper -->
@endsection



@section('under_body')


    {{-- <link rel="stylesheet" href="{{ asset('/') }}assets/css/select2.min.css"> --}}
    <script type="text/javascript">
        $(function() {

            // GLOBAL SETUP
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            table = $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('phisingtarget.data') }}",
                    type: "POST",
                    data: function(d) {
                        // d.policynumber_filter = $('#policynumber_filter').val()
                    }
                },
                columns: [{
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
                        data: 'phising_type',
                        name: 'phising_type'
                    },
                    {
                        data: 'no_absent_target',
                        name: 'no_absent_target'
                    },
                    {
                        data: 'name_target',
                        name: 'name_target'
                    },
                    {
                        data: 'email_target',
                        name: 'email_target'
                    },
                    {
                        data: 'is_sendMail',
                        name: 'is_sendMail'
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

            // get-mail
            // $('.get-mail').click(function() {

            //     Swal.fire({
            //         title: "Do you want to send mail?",
            //         showDenyButton: true,
            //         showCancelButton: true,
            //         confirmButtonText: "Send",
            //         denyButtonText: `Don't send`
            //     }).then((result) => {
            //         /* Read more about isConfirmed, isDenied below */
            //         if (result.isConfirmed) {
            //             $.ajax({
            //                 type: 'GET',
            //                 url: '{{ url('Phising/Mail') }}',
            //                 // data: formData,
            //                 dataType: 'json',
            //                 success: function(response) {
            //                     table.ajax.reload();
            //                     Swal.fire({
            //                         title: response.message,
            //                         text: "Send Mail Successfull!",
            //                         icon: response.icon,
            //                     })
            //                 },
            //                 error: function(error) {
            //                     // Tangani kesalahan jika ada
            //                     console.log(error);
            //                     Swal.fire({
            //                         title: response.message,
            //                         text: "You clicked the button!",
            //                         icon: "error"
            //                     })
            //                 }
            //             });
            //         } else if (result.isDenied) {
            //             Swal.fire("Changes are not send", "", "info");
            //         }
            //     });
            // });

            $('#btnFilter').on('click', function() {
                table.ajax.reload();
            });
            $('#btnReset').on('click', function() {
                location.reload();
            });

        });

        function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload();
                        Swal.fire(
                            'has been successfully',
                            'deleted data from the website!',
                            'success'
                        )
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }

        function sendEmail(url) {
            if (confirm('Yakin ingin Send Email data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'get'
                    })
                    .done((response) => {
                        console.log(response.phising_type)
                        table.ajax.reload();
                        Swal.fire(
                            'Send Email',
                            'has been successfully !',
                            'success'
                        )
                    })
                    .fail((errors) => {
                        alert('error send email');
                        return;
                    });
            }
        }
    </script>

@endsection
