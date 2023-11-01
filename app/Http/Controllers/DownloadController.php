<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\ExportPurchase;
use Maatwebsite\Excel\Facades\Excel;

class DownloadController extends Controller
{
    public function purchase(Request $request)
    {
        // return $request;
        return Excel::download(new ExportPurchase($request->transaction_id), now() . '_transaction.xlsx');
        // return $request;
        // $transaction = Transaction::with(['detail', 'detail.items'])->firstwhere('id', $request->transaction_id);
        // $transaction = Transaction::with(['detail' => function ($query) {
        //     $query->with('items');
        // }])->firstWhere('id', $request->transaction_id);
        // return $transaction;
        // return view('main.admin.purchasedownload', [
        //     "title" =>  "TL GAM Approval",
        //     "transaction" => $transaction
        // ]);
    }
}
