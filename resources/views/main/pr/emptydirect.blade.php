@extends('layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-success">Home</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="alert alert-info w-100 mb-0" role="alert">
                            <h4 class="alert-heading">Attention!</h4>
                            <h5 class="mb-0">For Direct Pickup, please input directly on GAM Team Tab / Computer (Located in GAM Office, PTKP HQ Ground Floor)</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
