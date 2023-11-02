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
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-success">Home</a></li>
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
                    {{-- <h3 class="card-title">{{ $setting->name }}</h3> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- <p>Welcome, {{ auth()->user()->priv }}</p> --}}
                    <div class="row">
                        <center>
                            {{ request()->ip() }}
                            <h4 style="text-align: center">For Direct Pickup, please input directly on GAM Team Tab / Computer
                                (Located in GAM Office, PTKP
                                HQ
                                Ground
                                Floor)</h4>
                        </center>
                        {{-- <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">

                                    <p>Visits today</p>
                                </div>
                                <div class="icon">
                                    <i class="nav-icon fas fa-book"></i>
                                </div>
                                <a href="route('formdoctor')" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div> --}}

                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->


        </div>
    </section>
@endsection
