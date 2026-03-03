<div class="modal fade" id="addCartModal" role="dialog" aria-labelledby="directAddCart" aria-hidden="true">
    <div class="modal-dialog modal-m" role="document">
        <div class="modal-content">
            <form action="{{ route('purchase.directadd') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add to Cart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body overlay-wrapper">

                    <div class="overlay">
                        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                    </div>

                    <ul id="save_errorList" class="alert alert-warning d-none"></ul>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Request</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span id="item_name"></span></td>
                                <td class="text-center"><span id="item_stock"></span></td>
                                <td>
                                    <input type="hidden" name="items_id" id="items_id">
                                    <input type="number" name="qty" id="qty" size="5" min="1" class="form-control form-control-sm" placeholder="0" autocomplete="off">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

@push('child-scripts')
    <script>
        //accident form
        $(document).on('click', '.btn-addcart', function(e) {
            e.preventDefault();
            $(".overlay").removeClass('d-none');
            $('#addCartModal').modal('show');
            $.ajax({
                type: "GET",
                url: $(this).data('url'),
                dataType: "json",
                success: function(response) {
                    if (response.status == 404) {
                        alert(response.message);
                        $('#addCartModal').modal('hide');
                    } else {
                        document.getElementById("qty").setAttribute("max", response.items[0].item_stock);
                        document.getElementById("items_id").value = response.items[0].id;
                        document.getElementById("item_name").innerHTML = response.items[0].item_name;
                        document.getElementById("item_stock").innerHTML = response.items[0].item_stock;
                        $(".overlay").addClass('d-none');
                    }
                }
            })
        });
    </script>
@endpush
