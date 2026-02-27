<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

class UserStockController extends Controller
{
    public function index(Request $request)
    {
        $entriesPage = $request->entries ?? 10;
        $search = $request->search ?? '';

        // $transaction = Transaction::where('pic_approval', 'Pending')->get();
        $baseQueryItems = Items::where('active', '!=', 'N')
            ->orWhereNull('active');

        if ($search)
            $baseQueryItems->where(function ($query) use ($search) {
                $query->where('item_code', 'LIKE', '%' . $search . '%')
                    ->orWhere('item_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('item_unit', 'LIKE', '%' . $search . '%')
                    ->orWhere('item_stock', 'LIKE', '%' . $search . '%');
            });

        $items = $baseQueryItems->paginate($entriesPage);

        return view('main.stock.index', [
            "title" => "Item Stock",
            "items" => $items,
            "entriesPage" => $entriesPage,
            "search" => $search,
        ]);
    }
}
