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
                    {{-- <button title="Add Item" type="button" class="btn btn-info btn-sm btn-cart" id="buttonAddItemModal"><i
                            class="fas fa-cart-shopping"></i>&nbsp;Add Item</button> --}}
                    {{-- <button title="Add to Cart" type="button" class="btn btn-info btn-sm btn-cart" id="aaaaaa"
                        data-url="{{ route('items.showdirectcart', auth()->user()->id_user_me) }}"><i
                            class="fas fa-cart-shopping"></i>&nbsp;View
                        cart</button> --}}
                    <a href="{{ route('admin.useradd') }}" class="btn btn-info">&nbsp;Add User</a>
                    {{-- <button title="Add User" type="button" class="btn btn-info btn-sm btn-cart" id="buttonAddItemModal"><i
                            class="fas fa-cart-shopping"></i>&nbsp;Add User</button> --}}
                    <table id="tb_default" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>username</th>
                                <th>Organization Unit</th>
                                <th>Privilege</th>
                                <th>Privilege</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->orgunit }}</td>

                                    <td>
                                        @switch($user->priv)
                                            @case('user')
                                                User
                                            @break

                                            @case('pic')
                                                PIC
                                            @break

                                            @case('tluser')
                                                Team Leader
                                            @break

                                            @case('tlgam')
                                                Team Leader GAM
                                            @break

                                            @default
                                                User
                                        @endswitch


                                    </td>
                                    <td> <button title="Edit Item" type="button" class="btn btn-info btn-sm btn-addcart" data-url="{{ route('admin.usershow', $user->id) }}">
                                            <i class="fas fa-pencil"></i></button></td>
                                    {{-- <td>
                                        <button title="Edit Item" type="button" class="btn btn-info btn-sm btn-addcart"
                                            data-url="{{ route('admin.itemshow', $items->id) }}">
                                            <i class="fas fa-pencil"></i></button>
                                    </td> --}}
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>username</th>
                                <th>Organization Unit</th>
                                <th>Privilege</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @include('main.admin._edituser')
                {{-- @include('main.admin._edititem')
                <div class="modal fade" id="addItemModal" role="dialog" aria-labelledby="directAddCart" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form action="{{ route('admin.additem') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="directAddCartLabel">Add item</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body overlay-wrapper">

                              
                                    <ul id="save_errorList" class="alert alert-warning d-none"></ul>


                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-10" style="align-content: center">
                                            <input type="hidden" name="item_id" id="item_id">
                                            <style>
                                                .tablecart {
                                                    width: 100%;
                                                    margin: 0 auto;
                                                    left: 0;
                                                    right: 0;
                                                    display: inline-block;
                                                }

                                                .tablecart tr td {
                                                    border: 0px dashed black;
                                                    padding: 15px;
                                                }



                                            </style>
                                            <table class="tablecart">
                                                <tr>
                                                    <td>Item Code</td>
                                                    <td>:</td>
                                                    <td><input type="text" name="item_code" id="item_code" required></td>
                                                    <td>Stock</td>
                                                    <td>:</td>
                                                    <td>
                                                        <input type="text" name="add_stock" id="add_stock" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Item</td>
                                                    <td>:</td>
                                                    <td><input type="text" name="item_name" id="item_name" required></td>
                                                    <td>Price</td>
                                                    <td>:</td>
                                                    <td><input type="text" name="price" id="price" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Unit</td>
                                                    <td>:</td>
                                                    <td>
                                                        <select name="item_unit" id="item_unit">
                                                            <option value="Pcs" id="Pcs">Pcs</option>
                                                            <option value="Rim" id="Rim">Rim</option>
                                                            <option value="Ktk" id="Ktk">Ktk</option>
                                                            <option value="Duz" id="Duz">Duz</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>


                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}




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
        $(document).on('click', '#buttonAddItemModal', function(e) {
            $('#addItemModal').modal('show');
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
