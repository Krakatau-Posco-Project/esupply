@extends('layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Main Home</h1>
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
                @if (session()->has('success'))
                    <br>
                    <div class="alert alert-success alert-dismissible" style="width:80%; margin:auto;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('success') }}
                    </div>
                    <br>
                @endif
                {{-- {{ $notification }} --}}
                {{-- @foreach ($notification as $notification)
                    <br>

                    @php
                        if ($notification->notif_type == 'Approved') {
                            $notifclass = 'success';
                        } else {
                            $notifclass = 'danger';
                        }
                    @endphp
                    <div class="alert alert-{{ $notifclass }} alert-dismissible" style="width:80%; margin:auto;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Purchase request for #{{ $notification->transaction_no }} has been {{ $notification->notif_type }}
                        by {{ $notification->approver_name }}
                    </div>
                @endforeach --}}
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- <p>Welcome, {{ auth()->user()->priv }}</p> --}}
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-olive">
                                <div class="inner">
                                    {{-- <h3>{{ $today }}</h3> --}}

                                    <h4>Item Stock</h4>
                                    <br>
                                </div>
                                <div class="icon">
                                    {{-- <i class="ion ion-bag"></i> --}}
                                    <i class="nav-icon fas fa-warehouse"></i>
                                </div>
                                <a href="{{ route('user.stock') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    {{-- <h3>{{ $today }}</h3> --}}

                                    <h4>Transaction History</h4>
                                    <br>
                                </div>
                                <div class="icon">
                                    {{-- <i class="ion ion-bag"></i> --}}
                                    <i class="nav-icon fas fa-book"></i>
                                </div>
                                <a href="{{ route('purchase.history') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    {{-- <h3>{{ $all }}<sup style="font-size: 20px"></sup></h3> --}}

                                    <h4>Purchase Request Proposal</h4>
                                    <br>
                                </div>
                                <div class="icon">
                                    {{-- <i class="ion ion-stats-bars"></i> --}}
                                    <i class="nav-icon fas fa-users"></i>
                                </div>
                                <a href="{{ route('purchase.propose') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        @canany(['pic', 'admin'])
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        {{-- <h3>{{ $patient }}</h3> --}}
                                        <h4>PIC Approval
                                            @if ($picdir == 0)
                                            @else
                                                <span class="badge badge-danger right">{{ $picdir }}</span>
                                            @endif
                                        </h4><br>
                                    </div>
                                    <div class="icon">
                                        {{-- <i class="ion ion-person-add"></i> --}}
                                        <i class="nav-icon fas fa-user-group"></i>
                                    </div>
                                    <a href="{{ route('approval.pic') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        @endcanany
                        @canany(['tluser', 'admin'])
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        {{-- <h3>{{ $patient }}</h3> --}}

                                        <h4>TL Approval
                                            @if ($tl == 0)
                                            @else
                                                <span class="badge badge-danger right">{{ $tl }}</span>
                                            @endif
                                        </h4><br>
                                    </div>
                                    <div class="icon">
                                        {{-- <i class="ion ion-person-add"></i> --}}
                                        <i class="nav-icon fas fa-user-group"></i>
                                    </div>
                                    <a href="{{ route('approval.pending') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        @endcanany
                        @canany(['tlgam', 'admin'])
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        {{-- <h3>{{ $patient }}</h3> --}}

                                        <h4>TL GAM Approval
                                            @if ($tlgam == 0)
                                            @else
                                                <span class="badge badge-danger right">{{ $tlgam }}</span>
                                            @endif
                                        </h4><br>
                                    </div>
                                    <div class="icon">
                                        {{-- <i class="ion ion-person-add"></i> --}}
                                        <i class="nav-icon fas fa-user-group"></i>
                                    </div>
                                    <a href="{{ route('approval.pending_ga') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        @endcanany
                        <!-- ./col -->


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
