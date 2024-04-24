@if (!blank($data))
    <table>
    <thead>
        <tr>
            <th style="width: 30px">No.</th>
            <th>Date</th>
            <th>Transaction No</th>
            <th>Id Emp</th>
            <th style="width: 200px">Employee Name</th>
            <th style="width: 250px">Team</th>
            <th>Code Item</th>
            <th>Category</th>
            <th>Item</th>
            <th>Unit</th>
            <th>Qty</th>
            <th>Purpose</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($data as $list)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ date("d/m/Y", strtotime($list->created_at)) }}</td>
            <td>'{{ $list->transaction->transactionnumber }}</td>
            <td>{{ $list->transaction->id_emp }}</td>
            <td>{{ $list->transaction->name }}</td>
            <td>{{ $list->transaction->orgunit }}</td>
            <td>{{ $list->item->item_code ?? '' }}</td>
            <td>{{ $list->item->classification ?? '' }}</td>
            <td>{{ $list->item->item_name ?? '' }}</td>
            <td>
                {{ $list->item->item_unit ?? '' }}
            </td>
            <td>{{ $list->qty }}</td>
            <td>
                {{ $list->transaction->purpose }}
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>
@else
    <table>
        <tr>
            <td>No Direct Pick Up data yet</td>
        </tr>
    </table>
@endif
