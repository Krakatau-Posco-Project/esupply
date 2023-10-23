<div class="modal fade" id="addCartModal" role="dialog" aria-labelledby="directAddCart" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.saveuser') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="directAddCartLabel">Edit user</h5>
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
                            <input type="hidden" name="iduser" id="iduser">
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
                                    <td>Name</td>
                                    <td>:</td>
                                    <td><span id="user_name"></span></td>

                                </tr>
                                <tr>
                                    <td>ID Employee</td>
                                    <td>:</td>
                                    <td><span id="id_emp"></span></td>
                                </tr>
                                <tr>
                                    <td>Privilege</td>
                                    <td>:</td>
                                    <td>
                                        <select name="privilege" id="privilege">
                                            <option value="user" id="user">User</option>
                                            <option value="pic" id="pic">PIC</option>
                                            <option value="tlgam" id="tlgam">Team Leader GAM</option>
                                            <option value="tluser" id="tluser">Team Leader</option>
                                        </select>
                                        {{-- <input type="text" name="item_unit" id="item_unit"> --}}
                                    </td>

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
                        document.getElementById("iduser").value = response.user.id;
                        document.getElementById("id_emp").innerHTML = response.user.username;
                        document.getElementById("user_name").innerHTML = response.user.name;
                        document.getElementById(response.user.priv).selected = true;
                        // var myloginid = document.getElementById("myloginid").innerHTML;

                        $(".overlay").addClass('d-none');
                    }
                }
            })
        });
    </script>
@endpush
