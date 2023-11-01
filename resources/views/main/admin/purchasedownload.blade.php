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
            <th style="text-align: center">Price per-unit</th>
            <th style="text-align: center">Total Price</th>
            {{-- <th style="text-align: center">Vendor</th> --}}
            {{-- <th style="text-align: center">Apply Adjustment</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($transaction->detail as $list)
            <tr>
                <td>{{ $list->items[0]->item_code }}</td>
                <td>{{ $list->items[0]->item_name }}</td>
                <td>{{ $list->items[0]->item_unit }}</td>
                <td>{{ $list->qty }}</td>
                <td>{{ $list->tluser_qty }}</td>
                <td>{{ $list->pic_qty }}</td>
                <td>{{ $list->tlgam_qty }}</td>
                <td>{{ $list->transaction_price }}</td>
                <td>{{ $list->transaction_total_price }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
