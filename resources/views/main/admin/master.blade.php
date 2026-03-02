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
                        <li class="breadcrumb-item"><a href="javascript:;" class="text-success">Administrator</a></li>
                        <li class="breadcrumb-item">Item Master Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <a href="javascript:;" id="buttonAddItemModal" class="btn btn-sm btn-info">
                            <i class="fas fa-cart-shopping mr-2"></i>Add Item
                        </a>
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
                                    <th class="text-center" style="width: 150px">Picture</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Stock Reminder</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr @if ($item->item_stock < $item->item_stock_reminder) style="background-color: #ffb8c2" @endif>
                                        <td>
                                            <a href="javascript:;" class="btn-showpicture" data-url="{{ asset('storage/item') }}/{{ $item->picture }}">
                                                <img src="{{ asset('storage/item') }}/{{ $item->picture }}" alt="{{ $item->item_name }}" style="width: 130px;">
                                            </a>
                                        </td>
                                        <td>{{ $item->item_code }}</td>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->item_unit }}</td>
                                        <td>{{ $item->item_stock }}</td>
                                        <td>{{ $item->item_stock_reminder ?? '#N/A' }}</td>
                                        <td class="text-right">{{ $item->price != '' ? number_format($item->price) : 0 }}</td>
                                        <td class="text-center">
                                            @if($item->active == 'N')
                                                <div class="badge bg-danger text-white">Inactive</div>
                                            @else
                                                <div class="badge bg-success text-white">Active</div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button title="Edit Item" type="button" class="btn btn-info btn-sm btn-addcart" data-url="{{ route('admin.itemshow', $item->id) }}">
                                                <i class="fas fa-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">Picture</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Stock Reminder</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{ $items->links('pagination::bootstrap-5') }}

                </div>

                @include('main.admin._edititem')

                {{-- Modal Show Picture --}}
                <div class="modal fade" id="picModal" role="dialog" aria-labelledby="picModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add item</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <img src="" alt="" id="showpic">
                        </div>
                    </div>
                </div>

                {{-- Modal Add Item --}}
                <div class="modal fade" id="addItemModal" role="dialog" aria-labelledby="addItemModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form action="{{ route('admin.additem') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Add item</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body overlay-wrapper p-4">

                                    <ul id="save_errorList" class="alert alert-warning d-none"></ul>

                                    <input type="hidden" name="item_id" id="item_id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="item-code" class="form-label">Item Code</label>
                                                <input type="text" name="item_code" id="item-code" class="form-control" placeholder="Item Code..." autocomplete="off" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="item-name" class="form-label">Item Name</label>
                                                <input type="text" name="item_name" id="item-name" class="form-control" placeholder="Item Name..." autocomplete="off" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="item-unit" class="form-label">Unit</label>
                                                <select name="item_unit" id="item-unit" class="form-control">
                                                    <option value="Pcs" id="Pcs">Pcs</option>
                                                    <option value="Rim" id="Rim">Rim</option>
                                                    <option value="Ktk" id="Ktk">Ktk</option>
                                                    <option value="Duz" id="Duz">Duz</option>
                                                    <option value="Box" id="Box">Box</option>
                                                    <option value="Tube" id="Tube">Tube</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="add-stock" class="form-label">Stock</label>
                                                <input type="number" name="add_stock" id="add-stock" class="form-control" placeholder="0" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="number" name="price" id="price" class="form-control" placeholder="0" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="classification" class="form-label">Category</label>
                                                <select name="classification" id="classification" class="form-control">
                                                    <option value="" id="">-Pilih-</option>
                                                    <option value="Battery" id="Battery">Battery</option>
                                                    <option value="Clip" id="Clip">Clip</option>
                                                    <option value="Cutting" id="Cutting">Cutting</option>
                                                    <option value="Document File" id="Document File">Document File</option>
                                                    <option value="Drinking Water" id="Drinking Water">Drinking Water</option>
                                                    <option value="Envelope" id="Envelope">Envelope</option>
                                                    <option value="Office Supply" id="Office Supply">Office Supply</option>
                                                    <option value="Paper" id="Paper">Paper</option>
                                                    <option value="Pin" id="Pin">Pin</option>
                                                    <option value="Post it" id="Post it">Post it</option>
                                                    <option value="Stapler" id="Stapler">Stapler</option>
                                                    <option value="Sticker" id="Sticker">Sticker</option>
                                                    <option value="Tape" id="Tape">Tape</option>
                                                    <option value="Toner" id="Toner">Toner</option>
                                                    <option value="Water" id="Water">Water</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="picture" class="form-label">Picture</label>
                                        <input type="file" name="picture" id="picture" class="form-control" accept="image/png, image/gif, image/jpeg">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary">
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
        $('#entries').on('change', () => {
            $('#form-search').submit();
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

        $(document).on('click', '#buttonAddItemModal', function(e) {
            $('#addItemModal').modal('show');
        });

        $(document).on('click', '.btn-showpicture', function(e) {
            e.preventDefault();
            $(".overlay").removeClass('d-none');
            $('#picModal').modal('show');
            document.getElementById("showpic").src = $(this).data('url');
        });
    </script>
@endsection
