<div class="modal fade" id="addCartModal" role="dialog" aria-labelledby="directAddCart" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.saveitem') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="directAddCartLabel">Edit item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body overlay-wrapper">

                    <div class="overlay">
                        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                    </div>

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



                                /* .tablecart tr th {
                                    border-bottom: 1px solid black;
                                } */
                            </style>
                            <table class="tablecart">
                                <tr>
                                    <td>Item Code</td>
                                    <td>:</td>
                                    <td><input type="text" name="item_code" id="item_code" readonly></td>
                                    <td>Stock</td>
                                    <td>:</td>
                                    <td>
                                        <input type="hidden" name="old_stock" id="old_stock">
                                        <span id="item_stock"></span> + <input type="text" name="add_stock" id="add_stock">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Item</td>
                                    <td>:</td>
                                    <td><input type="text" name="item_name" id="item_name"></td>
                                    <td>Price</td>
                                    <td>:</td>
                                    <td><input type="text" name="price" id="price"></td>
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
                                            <option value="Box" id="Box">Box</option>
                                            <option value="Tube" id="Tube">Tube</option>
                                            <option value="Set" id="Set">Set</option>
                                            <option value="Pack" id="Pack">Pack</option>
                                            <option value="Roll" id="Roll">Roll</option>
                                            <option value="Ream" id="Ream">Ream</option>
                                        </select>
                                        {{-- <input type="text" name="item_unit" id="item_unit"> --}}
                                    </td>
                                    <td>Picture</td>
                                    <td>:</td>
                                    <td><input type="file" name="picture" id="picture" accept="image/png, image/gif, image/jpeg"></td>
                                </tr>
                                {{-- <tr>
                                    <td>Stock</td>
                                    <td>:</td>
                                    <td>
                                        <input type="hidden" name="old_stock" id="old_stock">
                                        <span id="item_stock"></span> + <input type="text" name="add_stock"
                                            id="add_stock">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td>:</td>
                                    <td><input type="text" name="price" id="price"></td>
                                </tr> --}}
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
</div>
@push('child-scripts')
    <script>
        //accident form
        $(document).on('click', '.btn-addcart', function(e) {
            e.preventDefault();
            $(".overlay").removeClass('d-none');
            $('#addCartModal').modal('show');
            // alert($(this).data('url'));
            $.ajax({
                type: "GET",
                url: $(this).data('url'),
                dataType: "json",
                success: function(response) {
                    if (response.status == 404) {
                        //toastr.error(response.message);
                        alert(response.message);
                        $('#addCartModal').modal('hide');
                    } else {
                        // alert(url);
                        // console.log(response);
                        // document.getElementById("qty").setAttribute("max", response.items
                        //     .item_stock);
                        // document.getElementById("id").value = response.items.id;
                        document.getElementById("item_id").value = response.items.id;
                        document.getElementById("item_code").value = response.items.item_code;
                        document.getElementById("item_name").value = response.items.item_name;
                        document.getElementById("old_stock").value = response.items.item_stock;
                        document.getElementById("item_stock").innerHTML = response.items.item_stock;
                        document.getElementById("item_unit").value = response.items.item_unit;
                        document.getElementById("price").value = response.items.price;
                        document.getElementById(response.items.item_unit).selected;
                        // var myloginid = document.getElementById("myloginid").innerHTML;

                        $(".overlay").addClass('d-none');
                    }
                }
            })
        });
    </script>
@endpush
