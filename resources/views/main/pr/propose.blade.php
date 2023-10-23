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

                    <button title="Add to Cart" type="button" class="btn btn-info btn-sm btn-cart" id="aaaaaa" data-url="{{ route('items.showdirectcart', auth()->user()->id_user_me) }}"><i class="fas fa-cart-shopping"></i>&nbsp;View
                        cart</button>
                    <table id="tb_default" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Items</th>
                                <th>Unit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $items)
                                <tr>
                                    <td>{{ $items->item_code }}</td>
                                    <td>{{ $items->item_name }}</td>
                                    <td>{{ $items->item_unit }}</td>
                                    <td><button title="Add to Cart" type="button" class="btn btn-info btn-sm btn-addcart" data-url="{{ route('items.show', $items->id) }}" {{-- data-form-url="{{ route('visit.outpatient_update', $v->slug) }}" --}}>
                                            <i class="fas fa-cart-shopping"></i></button></td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Kode</th>
                                <th>Items</th>
                                <th>Unit</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                {{-- {{ $cart }} --}}
                @include('main.pr._proposeaddcart')
                <div class="modal fade" id="CartModal" role="dialog" aria-labelledby="proposeCart" aria-hidden="true">
                    <div class="modal-dialog modal-m" role="document">
                        <div class="modal-content">
                            <form action="{{ route('purchase.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cartid" value="{{ $cart->id ?? '' }}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="proposeCartLabel"><i class="fas fa-cart-shopping"></i>&nbsp;&nbsp;&nbsp;Purchase Request Proposal
                                        Cart</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body overlay-wrapper">

                                    {{-- <div class="overlay">
                                        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                    </div> --}}

                                    <ul id="save_errorList" class="alert alert-warning d-none"></ul>
                                    <style>
                                        .tablecart {
                                            width: 100%;
                                        }

                                        .tablecart tr td {
                                            /* border-left: 1px dashed black; */
                                            border-bottom: 1px dashed black;
                                            padding: 5px;
                                        }

                                        .tablecart tr td:nth-child(3) {
                                            width: 20px;
                                            text-align: center;
                                        }

                                        .tablecart tr th {
                                            border-bottom: 1px solid black;
                                        }

                                        .tablecart tr td:nth-child(4) {
                                            width: 40px;
                                        }

                                        .tablecart tr th:nth-child(4) {
                                            text-align: center;
                                        }

                                        .tablecart tr td:nth-child(5) {
                                            width: 40px;
                                        }

                                        .tablecart tr th:nth-child(5) {
                                            text-align: center;
                                        }
                                    </style>
                                    {{-- {{ dd($cart) }} --}}

                                    <table id="tablecart" class="tablecart">
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>Unit</th>
                                            <th>Qty</th>
                                            <th>Action</th>
                                        </tr>
                                        @if ($cart)
                                            @php
                                                $submitdis = '';
                                            @endphp
                                            @foreach ($cartdetail as $cartdetail)
                                                <tr id="row{{ $cartdetail->id }}">
                                                    {{-- {{ $cart->id }} --}}
                                                    <td width="10px">{{ $cartdetail->items[0]->item_code }}</td>
                                                    <td>{{ $cartdetail->items[0]->item_name }}</td>
                                                    <td>{{ $cartdetail->items[0]->item_unit }}</td>
                                                    <td><input name="qty[{{ $cartdetail->items[0]->id }}]" type="number" value="{{ $cartdetail->qty }}" size="5" style="width: 3em"></td>
                                                    <td>
                                                        <center><a href="#" class="btn-delete" data-url="{{ route('cart.delete', $cartdetail->id) }}" uid="row{{ $cartdetail->id }}"><i class="fas fa-trash"></i></a></center>
                                                    </td>
                                                    {{-- <td>{{ $cartdetail->item_name }}</td>
                                            <td>{{ $cartdetail->item_unit }}</td> --}}

                                                </tr>
                                            @endforeach
                                        @else
                                            @php
                                                $submitdis = 'disabled';
                                            @endphp
                                            <tr>
                                                <td colspan="5">
                                                    <center><i class="fas fa-cart-shopping"></i>&nbsp;&nbsp;&nbsp;Cart empty
                                                    </center>
                                                </td>
                                            </tr>
                                        @endif

                                        {{-- <tr>
                                            <td><b>Purpose</b></td>
                                            <td colspan="4"><input type="text" name="purpose" id="purpose" required>
                                            </td>
                                        </tr> --}}

                                        <tr>
                                            <td><b>Reason</b></td>
                                            <td colspan="4"><input type="text" name="reason" id="reason" required>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="carttype" value="propose">
                                    <input type="submit" {{ $submitdis }} class="btn btn-info btn-sm" value="Submit Request">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



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
                    [1, 'asc']
                ],
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
