<div class="modal fade" id="detailModal" role="dialog" aria-labelledby="detailTransaction" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="detailTransactionLabel"><span id="purchase_type"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body overlay-wrapper">

                    <div class="row">
                        <div class="col-12">
                            {{-- <div class="callout callout-info">
                                <h5><i class="fas fa-info"></i> Note:</h5>
                                This page has been enhanced for printing. Click the print button at the bottom of the
                                invoice to test.
                            </div> --}}


                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            <img src="{{ asset('pic/') . '/logokp.png' }}" alt="Krakatau Posco" class="brand-image" style="height: 20px;">
                                            <small class="float-right">Date: <span id="datetransaction"></span> </small>
                                        </h4>
                                    </div>

                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        Requester
                                        <address>
                                            <strong><span id="transactionname"></span></strong><br>
                                            <span id="transactionorgunit"></span>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        Approver
                                        <address>
                                            <strong><span id="tl_approver_name">-</span></strong><br>
                                            <strong><span id="pic_approver_name">-</span></strong><br>
                                            <strong><span id="tlgam_approver_name">-</span></strong><br>

                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        <b>Transaction #<span id="transactionnumber"></span></b><br>
                                        {{-- <br>
                                        <b>Order ID:</b> 4F3S8J<br>
                                        <b>Payment Due:</b> 2/22/2014<br>
                                        <b>Account:</b> 968-34567 --}}
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped" id="detailTable">
                                            <thead>
                                                <tr>
                                                    <th>Item Code</th>
                                                    <th>Product</th>
                                                    <th>Unit</th>
                                                    <th style="text-align: center">Qty</th>
                                                    <th style="text-align: center">TL Adjustment</th>
                                                    <th style="text-align: center">GAM PIC Adjustment</th>
                                                    <th style="text-align: center">GAM TL Adjustment</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-6">
                                        <p class="lead">Request Purpose:</p>
                                        {{-- <img src="../../dist/img/credit/visa.png" alt="Visa">
                                        <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                                        <img src="../../dist/img/credit/american-express.png" alt="American Express">
                                        <img src="../../dist/img/credit/paypal2.png" alt="Paypal"> --}}

                                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                            <span id="purpose"></span>
                                        </p>
                                        <p class="lead">Request Reason:</p>

                                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                            <span id="reason"></span>
                                        </p>
                                    </div>
                                    <!-- /.col -->
                                    {{-- <div class="col-6">
                                        <p class="lead">Amount Due 2/22/2014</p>

                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th style="width:50%">Subtotal:</th>
                                                    <td>$250.30</td>
                                                </tr>
                                                <tr>
                                                    <th>Tax (9.3%)</th>
                                                    <td>$10.34</td>
                                                </tr>
                                                <tr>
                                                    <th>Shipping:</th>
                                                    <td>$5.80</td>
                                                </tr>
                                                <tr>
                                                    <th>Total:</th>
                                                    <td>$265.24</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div> --}}
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- this row will not appear when printing -->
                                {{-- <div class="row no-print">
                                    <div class="col-12">
                                        <a href="invoice-print.html" rel="noopener" target="_blank"
                                            class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                        <button type="button" class="btn btn-success float-right"><i
                                                class="far fa-credit-card"></i> Submit
                                            Payment
                                        </button>
                                        <button type="button" class="btn btn-primary float-right"
                                            style="margin-right: 5px;">
                                            <i class="fas fa-download"></i> Generate PDF
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                                <!-- /.invoice -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div>
                    <div class="modal-footer">
                        {{-- <input type="submit"> --}}
                    </div>
            </form>
        </div>
    </div>
</div>
@push('child-scripts')
    <script>
        $(document).on('click', '.btn-detail', function(e) {
            e.preventDefault();
            $(".overlay").removeClass('d-none');
            $('#detailModal').modal('show');
            $.ajax({
                type: "GET",
                url: $(this).data('url'),
                dataType: "json",
                success: function(response) {
                    // console.log(reponse.status);
                    if (response.status == 404) {
                        alert('Delete Failed');
                    } else {
                        // alert(response.transaction.id);
                        $("#detailTable tbody tr").remove();
                        // $("#detailTable:not(:first)").remove();
                        var tableheader = document.getElementById("detailTable").getElementsByTagName(
                            'thead')[0];

                        var datetransaction = document.getElementById("datetransaction");
                        document.getElementById("transactionnumber").innerHTML = response.transaction
                            .transactionnumber;
                        document.getElementById("transactionname").innerHTML = response.transaction
                            .name;
                        document.getElementById("transactionorgunit").innerHTML = response.transaction
                            .orgunit;
                        document.getElementById("purchase_type").innerHTML = response.transaction
                            .purchase_type;

                        document.getElementById("tl_approver_name").innerHTML = response.transaction
                            .tl_approver_name + ' (' + response.transaction
                            .tl_approval + ')';
                        document.getElementById("tl_approver_name").innerHTML = response.transaction
                            .tl_approver_name + ' (' + response.transaction
                            .tl_approval + ')';
                        document.getElementById("pic_approver_name").innerHTML = response.transaction
                            .pic_approver_name + ' (' + response.transaction
                            .pic_approval + ')';
                        document.getElementById("tlgam_approver_name").innerHTML = response.transaction
                            .tlgam_approver_name + ' (' + response.transaction
                            .tlgam_approval + ')';
                        document.getElementById("purpose").innerHTML = response.transaction
                            .purpose;
                        document.getElementById("reason").innerHTML = response.transaction
                            .reason;
                        datetransaction.innerHTML = response.formatted_date;
                        // var rowheader = tableheader.insertRow(0);
                        // var headerCell = document.createElement("TH");
                        // var cell1header = rowheader.insertCell(0);
                        // var cell2header = rowheader.insertCell(1);
                        // var cell3header = rowheader.insertCell(2);
                        // var cell4header = rowheader.insertCell(3);
                        // var cell5header = rowheader.insertCell(4);
                        // cell1header.innerHTML = "<b>Qty</b>";
                        // cell2header.innerHTML = "<b>Items</b>";
                        // cell3header.innerHTML = "<b>Serial</b>";
                        // cell4header.innerHTML = "<b>Description</b>";
                        // cell5header.innerHTML = "<b>Subtotal</b>";

                        var arraydetail = response.transaction.detail;
                        var arraylength = arraydetail.length;
                        var table = document.getElementById("detailTable").getElementsByTagName(
                            'tbody')[0];
                        for (var i = 0; i < arraylength; i++) {
                            var row = table.insertRow(0);

                            var cell1 = row.insertCell(0);
                            var cell2 = row.insertCell(1);
                            var cell3 = row.insertCell(2);
                            var cell4 = row.insertCell(3);
                            var cell5 = row.insertCell(4);
                            var cell6 = row.insertCell(5);
                            var cell7 = row.insertCell(6);
                            cell4.setAttribute("style", "text-align: center;");
                            cell5.setAttribute("style", "text-align: center;");
                            cell6.setAttribute("style", "text-align: center;");
                            cell7.setAttribute("style", "text-align: center;");
                            cell1.innerHTML = response.transaction.detail[i].items[0].item_code;
                            cell2.innerHTML = response.transaction.detail[i].items[0].item_name;
                            cell3.innerHTML = response.transaction.detail[i].items[0].item_unit;
                            cell4.innerHTML = response.transaction.detail[i].qty;
                            cell5.innerHTML = response.transaction.detail[i].tluser_qty;
                            cell6.innerHTML = response.transaction.detail[i].pic_qty;
                            cell7.innerHTML = response.transaction.detail[i].tlgam_qty;
                        }


                        $(".overlay").addClass('d-none');
                    }
                }
            });
        });
        //accident form
        // $(document).on('click', '.btn-addcart', function(e) {
        //     e.preventDefault();
        //     $(".overlay").removeClass('d-none');
        //     $('#addCartModal').modal('show');
        //     $.ajax({
        //         type: "GET",
        //         url: $(this).data('url'),
        //         dataType: "json",
        //         success: function(response) {
        //             if (response.status == 404) {
        //                 //toastr.error(response.message);
        //                 alert(response.message);
        //                 $('#addCartModal').modal('hide');
        //             } else {
        //                 // console.log(response);
        //                 document.getElementById("qty").setAttribute("max", response.items[0]
        //                     .item_stock);
        //                 document.getElementById("items_id").value = response.items[0].id;
        //                 document.getElementById("item_name").innerHTML = response.items[0].item_name;
        //                 document.getElementById("item_stock").innerHTML = response.items[0].item_stock;
        //                 $.ajax({
        //                     type: "GET",
        //                     url: "http://localhost/esupply/public/cart/direct/" + response
        //                         .items[0].id + "/23",
        //                     dataType: "json",
        //                     success: function(resp) {
        //                         // alert(resp.status);
        //                         document.getElementById("qty").value = resp.qty;
        //                         // if (resp.status == 404) {
        //                         //     document.getElementById("qty").value = resp.qty;
        //                         // } else {
        //                         //     document.getElementById("qty").value = resp.qty;
        //                         // }
        //                     }
        //                 });
        //                 $(".overlay").addClass('d-none');
        //             }
        //         }
        //     })
        // });
    </script>
@endpush
