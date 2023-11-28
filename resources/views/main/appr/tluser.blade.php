@extends('layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#" class="text-success">Home</a></li>
                        <li class="breadcrumb-item">Purchase Request</li>
                        <li class="breadcrumb-item active"><a href="#" class="text-success">{{ $title }}</a>
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                {{-- @include('partials.content-script') --}}
                {{-- <div class="card-header">
                    <h3 class="card-title">Search Patient</h3>
                </div> --}}
                {{-- <div class="card-body">
                    
                </div> --}}
                <!-- /.card-header -->
                {{-- {{ $listemployee }} --}}
                @if (session()->has('success'))
                    <br>
                    <div class="alert alert-success alert-dismissible" style="width:80%; margin:auto;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('success') }}
                    </div>
                    <br>
                @endif
                <div class="card-body">


                    <table id="tb_default" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="display: none">ID</th>
                                <th>ID Employee</th>
                                <th>Name</th>
                                <th>Org Unit</th>
                                <th>Purchase Type</th>
                                <th>No Transaction</th>
                                <th>TL Approval status</th>
                                <th>PIC User Approval status</th>
                                <th>TL GAM Approval status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction as $transaction)
                                <tr>
                                    <td style="display: none">{{ $transaction->id }}</td>
                                    <td>{{ $transaction->id_emp }}</td>
                                    <td>{{ $transaction->name }}</td>
                                    <td>{{ $transaction->orgunit }}</td>
                                    <td>{{ $transaction->purchase_type }}</td>
                                    <td><a href="#" class="btn-detail" data-url="{{ route('transaction.detail', $transaction->id) }}" uid="row{{ $transaction->id }}"> {{ $transaction->transactionnumber }}</a></td>
                                    <td>{{ $transaction->tl_approval }}
                                        @if ($transaction->tl_approval == 'Pending')
                                            {{-- <span class="badge badge-danger right">!</span> --}}
                                            &nbsp;<span class="fa-solid fa-circle-exclamation text-danger"></span>
                                        @else
                                        @endif
                                    </td>
                                    <td>{{ $transaction->pic_approval }}</td>
                                    <td>{{ $transaction->tlgam_approval }}</td>
                                    <td><button title="Approve" type="button" class="btn btn-info btn-sm btn-detail" data-url="{{ route('transaction.detail', $transaction->id) }}" {{-- data-form-url="{{ route('visit.outpatient_update', $v->slug) }}" --}}>
                                            <i class="fas fa-stamp"></i></button></td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="display: none">ID</th>
                                <th>ID Employee</th>
                                <th>Name</th>
                                <th>Org Unit</th>
                                <th>Purchase Type</th>
                                <th>No Transaction</th>
                                <th>TL Approval status</th>
                                <th>PIC User Approval status</th>
                                <th>TL GAM Approval status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                {{-- {{ $cart }} --}}
                {{-- @include('main.pr._directaddcart') --}}


                @include('main.appr._detailtluser')

                <!-- /.card-body -->

            </div>
            <!-- /.card -->


        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).on('click', '.btn-delete', function(e) {
            $.ajax({
                type: "GET",
                url: $(this).data('url'),
                dataType: "json",
                success: function(response) {
                    if (response.status == 404) {
                        alert('Delete Failed');
                    } else {
                        document.getElementById("row" + response.uid).style.display = "none";
                    }
                }
            });
        });
        $(document).on('click', '.btn-cart', function(e) {
            $('#CartModal').modal('show');
        });
        $(function() {
            $("#tb_default").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "order": [
                    [0, 'desc']
                ],
                columnDefs: [{
                    target: 0,
                    visible: false,
                    searchable: false
                }],
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
