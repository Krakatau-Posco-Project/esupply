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
                        <li class="breadcrumb-item"><a href="#" class="text-success">Home</a></li>
                        <li class="breadcrumb-item active"><a href="#" class="text-success">{{ $title }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

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
                                    <th style="width: 150px">Picture</th>
                                    <th>Kode</th>
                                    <th>Item</th>
                                    <th>Unit</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <a href="javascript:;" class="btn-showpicture" data-url="{{ asset('storage/item') }}/{{ $item->picture }}">
                                                <img src="{{ asset('storage/item') }}/{{ $item->picture }}" alt="{{ $item->item_name }}" style="width: 130px;">
                                            </a>
                                        </td>
                                        <td>{{ $item->item_code }}</td>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->item_unit }}</td>
                                        <td>{{ $item->item_stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="width: 150px">Picture</th>
                                    <th>Kode</th>
                                    <th>Items</th>
                                    <th>Unit</th>
                                    <th>Stock</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{ $items->links('pagination::bootstrap-5') }}

                </div>
                <div class="modal fade" id="picModal" role="dialog" aria-labelledby="picModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="directAddCartLabel">Add item</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <img src="" alt="" id="showpic">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).on('click', '.btn-showpicture', function(e) {
            e.preventDefault();
            $(".overlay").removeClass('d-none');
            $('#picModal').modal('show');
            document.getElementById("showpic").src = $(this).data('url');
            // alert($(this).data('url'));
        });

        $('#entries').on('change', () => {
            $('#form-search').submit();
        });

        // $(function() {
        //     $("#tb_default").DataTable({
        //         "responsive": true,
        //         "lengthChange": false,
        //         "autoWidth": false,
        //         "order": [
        //             [1, 'asc']
        //         ],
        //         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        // });
    </script>
@endsection
