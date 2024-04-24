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

                    <a class="btn btn-info btn-sm float-right btn-export">Export to Excell</a>

                    <table id="tb_default" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="display: none">ID</th>
                                <th>ID Employee</th>
                                <th>Name</th>
                                <th>Org Unit</th>
                                <th>Purchase Type</th>
                                <th>No Transaction</th>
                                <th>Date</th>
                                <th>TL Approval status</th>
                                <th>PIC Approval status</th>
                                <th>TL GAM Approval status</th>

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
                                    <td><a href="#" class="btn-detail" data-url="{{ route('transaction.detail', $transaction->id) }}" uid="row{{ $transaction->id }}"> {{ $transaction->transactionnumber }}</a>
                                    </td>
                                    <td style="text-align: center">{{ $transaction->created_at }}</td>
                                    <td style="text-align: center;">
                                        {{ $transaction->tl_approver_name }}<br><span @if ($transaction->tl_approval == 'Pending') style="color: red;" @else style="color: blue;" @endif>{{ $transaction->tl_approval }}</span>
                                    </td>
                                    <td style="text-align: center">
                                        {{ $transaction->pic_approver_name }}<br><span @if ($transaction->pic_approval == 'Pending') style="color: red;" @else style="color: blue;" @endif>{{ $transaction->pic_approval }}</span>
                                    </td>
                                    <td style="text-align: center">
                                        {{ $transaction->tlgam_approver_name }}<br><span @if ($transaction->tlgam_approval == 'Pending') style="color: red;" @else style="color: blue;" @endif>{{ $transaction->tlgam_approval }}</span>
                                    </td>

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
                                <th>Date</th>
                                <th>TL Approval status</th>
                                <th>PIC Approval status</th>
                                <th>TL GAM Approval status</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
                {{-- {{ $cart }} --}}
                {{-- @include('main.pr._directaddcart') --}}


                @include('main.admin._detaildirect')

                <!-- /.card-body -->

            </div>
            <!-- /.card -->


        </div>
    </section>

<!-- Modal export -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exportModalLabel">Export Data to Excell</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form id="exportForm" method="get" action="{{ route('admin.direct.export') }}">

            @csrf
            @method('GET')
            {{-- modal body --}}
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                            <label>From Date</label>
                            <div class="input-group date" data-target-input="nearest">
                                <input required type="text" name="from_date" id="from_date" class="format_tgl form-control datetimepicker-input @error('from_date') is-invalid @enderror" data-target="#from_date" value="{{old('from_date')}}">
                                <div class="input-group-append" data-target="#from_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @error('from_date')
                                <div class="error invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>To Date</label>
                            <div class="input-group date" data-target-input="nearest">
                                <input required type="text" name="to_date" id="to_date" class="format_tgl form-control datetimepicker-input @error('to_date') is-invalid @enderror" data-target="#to_date" value="{{old('to_date')}}">
                                <div class="input-group-append" data-target="#to_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @error('to_date')
                                <div class="error invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                      </div>
                    </div>
                  </div>

            </div>
            {{-- end modal body --}}
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="export_btnsubmit">Export</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </form>
      </div>
    </div>
  </div>
  <!-- End Modal export report-->

@endsection
@section('script')
    <script>
        $(document).on('click', '.btn-export', function(e) {
            e.preventDefault();
            $('#exportModal').modal('show');
        });
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
            //Date picker
            $('.format_tgl').datetimepicker({
                format: 'YYYY-MM-DD'
            });

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
