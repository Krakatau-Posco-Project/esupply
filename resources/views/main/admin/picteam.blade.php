@extends('layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                {{ session('success') }}
            </div>
            @endif

          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">PIC Team</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Administrator</li>
                <li class="breadcrumb-item active">PIC Team</li>
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
                <div class="card-header">
                  <h3 class="card-title">PIC Team Assignment</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">

                          <div class="card card-primary">
                            <div class="card-header">
                              <h3 class="card-title">PIC Team List</h3>
                            </div>
                            <div class="card-body">

                            @if (!blank($picteam))
                            <table class="table table-bordered table-striped table-sm">
                              <thead class="thead-dark">
                                <tr>
                                  <th style="width: 10px">#</th>
                                  <th>ID Employee</th>
                                  <th>Name</th>
                                  <th>Team</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>

                              @foreach ($picteam as $item)
                                  <tr>
                                      <td>{{ $loop->iteration }}</td>
                                      <td>{{ $item->username }}</td>
                                      <td>{{ $item->name }}</td>
                                      <td>{{ $item->orgunit }}</td>
                                      <td>
                                        <form action="{{ route('admin.destroypicteam', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs btn-block" onclick="return confirm('Are you sure want to delete this data?')">Delete</button>
                                        </form>
                                      </td>
                                  </tr>
                              @endforeach
                              </tbody>
                            </table>
                            @else
                              <p class="text-center">No PIC Team data yet</p>
                            @endif

                            </div>
                            <!-- /.card-body -->
                          </div>
                          <!-- /.card -->


                        </div>
                        <!-- /.col (left) -->
                        <div class="col-md-6">
                          <div class="card card-primary">
                            <div class="card-header">
                              <h3 class="card-title">Add PIC Team</h3>
                            </div>

                            <form method="POST" action="{{ route('admin.storepicteam') }}">
                                @csrf
                                @method('POST')
                            <div class="card-body">

                              <div class="form-group">
                                <label>Employee:</label>
                                <select name="emp" class="select2 form-control @error('emp') is-invalid @enderror">
                                    <option value="">Select employee...</option>
                                    @foreach ($user as $emp)
                                    <option value="{{$emp->id}}">{{$emp->username}} | {{$emp->name}} ({{$emp->orgunit}})</option>
                                    @endforeach
                                </select>
                                @error('emp')
                                <div class="error invalid-feedback">{{ $message }}</div>
                                @enderror
                              </div>

                              <div>
                                <button type="submit" class="btn btn-primary">Assign as PIC Team</button>
                              </div>

                            </div>

                            </form>
                            <!-- /.card-body -->
                          </div>
                          <!-- /.card -->


                        </div>
                        <!-- /.col (right) -->
                      </div>
                      <!-- /.row -->

                </div>
                <!-- /.card-body -->

              </div>
              <!-- /.card -->

        </div>
    </section>

@endsection

@section('script')
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>
@endsection
