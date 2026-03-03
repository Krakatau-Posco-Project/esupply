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
                        <li class="breadcrumb-item"><a href="javascript:;" class="text-success">Home</a></li>
                        <li class="breadcrumb-item">Purchase Request</li>
                        <li class="breadcrumb-item active"><a href="#" class="text-success">{{ $title }}</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    @if (session()->has('success') || session()->has('danger'))
                        <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session('success') ? session('success') : session('danger')}}
                        </div>
                    @endif

                    <div class="mb-3">
                        <button title="Add to Cart" type="button" class="btn btn-info btn-sm btn-cart" id="aaaaaa" data-url="{{ route('items.showdirectcart', auth()->user()->id_user_me) }}">
                            <i class="fas fa-cart-shopping"></i>&nbsp;View cart
                        </button>
                    </div>

                    <form action="" method="get" id="form-search" class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <span>Show</span>
                                <select name="entries" id="entries" class="form-control mx-2">
                                    <option value="10" {{ $entriesPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $entriesPage == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $entriesPage == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $entriesPage == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span>Entries</span>
                            </div>
                            <div class="input-group w-25">
                                <input type="text" name="search" id="search" class="form-control" value="{{ $search }}" placeholder="Search..." autocomplete="off">
                                <button type="submit" class="btn-primary px-2"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->item_code }}</td>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->item_unit }}</td>
                                        <td>{{ $item->item_stock }}</td>
                                        <td class="text-center">
                                            <button title="Add to Cart" type="button" class="btn btn-info btn-sm btn-addcart" data-url="{{ route('items.show', $item->id) }}">
                                                <i class="fas fa-cart-shopping"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{ $items->links('pagination::bootstrap-5') }}
                </div>

                @include('main.pr._directaddcart')

                {{-- Modal Direct Pick-up Cart --}}
                <div class="modal fade" id="CartModal" role="dialog" aria-labelledby="directCart" aria-hidden="true">
                    <div class="modal-dialog modal-m" role="document">
                        <div class="modal-content">
                            <form action="{{ route('purchase.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cartid" value="{{ $cart->id ?? '' }}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="directCartLabel"><i class="fas fa-cart-shopping"></i>&nbsp;&nbsp;&nbsp;Direct Pick-up Cart</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body overlay-wrapper">

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

                                    <table id="tablecart" class="tablecart">
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>Stock</th>
                                            <th>Unit</th>
                                            <th>Action</th>
                                        </tr>
                                        @if ($cart)
                                            @php
                                                $submitdis = '';
                                            @endphp
                                            @foreach ($cartdetail as $cartdetail)
                                                <tr id="row{{ $cartdetail->id }}">
                                                    <td width="10px">{{ $cartdetail->items[0]->item_code }}</td>
                                                    <td>{{ $cartdetail->items[0]->item_name }}</td>
                                                    <td>{{ $cartdetail->items[0]->item_unit }}</td>
                                                    <td>
                                                        <input name="qty[{{ $cartdetail->items[0]->id }}]" type="number" value="{{ $cartdetail->qty }}" size="5" style="width: 3em" max="{{ $cartdetail->items[0]->item_stock }}" class="form-control form-control-sm">
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="javascript:;" class="text-danger btn-delete" data-url="{{ route('cart.delete', $cartdetail->id) }}" uid="row{{ $cartdetail->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @php
                                                $submitdis = 'disabled';
                                            @endphp
                                            <tr>
                                                <td class="text-center" colspan="5">
                                                    <i class="fas fa-cart-shopping"></i>&nbsp;&nbsp;&nbsp;Cart empty
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td><b>Purpose</b></td>
                                            <td colspan="4">
                                                <input type="text" name="purpose" id="purpose" class="form-control form-control-sm" autocomplete="off" required>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="carttype" value="direct">
                                    <input type="submit" {{ $submitdis }} class="btn btn-info btn-sm" value="Checkout">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
