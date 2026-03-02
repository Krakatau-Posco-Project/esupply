<div class="modal fade" id="addCartModal" role="dialog" aria-labelledby="directAddCart" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.saveitem') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body overlay-wrapper p-4">

                    <div class="overlay">
                        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                    </div>

                    <ul id="save_errorList" class="alert alert-warning d-none"></ul>

                    <div class="row">
                        <input type="hidden" name="item_id" id="item-id">
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
                                    <option value="Set" id="Set">Set</option>
                                    <option value="Pack" id="Pack">Pack</option>
                                    <option value="Roll" id="Roll">Roll</option>
                                    <option value="Ream" id="Ream">Ream</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="classification" class="form-label">Category</label>
                                <select name="classification" id="edit-classification" class="form-control">
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
                            <div class="form-group mb-0">
                                <label for="active" class="form-label">Active</label>
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline mr-5">
                                        <input class="form-check-input" type="radio" name="active" id="active_y" value="Y">
                                        <label class="form-check-label" for="active_y">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="active" id="active_n" value="N">
                                        <label class="form-check-label" for="active_n">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add-stock" class="form-label">Stock</label>
                                <input type="hidden" name="old_stock" id="old-stock">
                                <div class="d-flex align-items-center">
                                    <span id="item-stock"></span> <span class="mx-2">+</span> <input type="number" name="add_stock" id="add-stock" class="form-control" placeholder="0" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" name="price" id="price" class="form-control" placeholder="0" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="item-stock-reminder" class="form-label">Stock Reminder</label>
                                <input type="number" name="item_stock_reminder" id="item-stock-reminder" class="form-control" placeholder="0" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="picture" class="form-label">Picture</label>
                                <input type="file" name="picture" id="picture" class="form-control" accept="image/png, image/gif, image/jpeg">
                            </div>
                        </div>
                    </div>
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
                        document.getElementById("item-id").value = response.items.id;
                        document.getElementById("item-code").value = response.items.item_code;
                        document.getElementById("item-name").value = response.items.item_name;
                        document.getElementById("old-stock").value = response.items.item_stock;
                        document.getElementById("item-stock").innerHTML = response.items.item_stock;
                        document.getElementById("item-unit").value = response.items.item_unit;
                        document.getElementById("price").value = response.items.price;
                        $('#edit-classification').val(response.items.classification).change();
                        document.getElementById("item-stock-reminder").value = response.items.item_stock_reminder;
                        document.getElementById(response.items.item_unit).selected;

                        let $radios = $('input:radio[name=active]');
                        $radios.filter('[value='+response.items.active+']').prop('checked', true);

                        if (response.items.active == null){
                            $radios.prop('checked', false);
                        }

                        $(".overlay").addClass('d-none');
                    }
                }
            })
        });
    </script>
@endpush
