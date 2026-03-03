<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Items;
use App\Models\CartDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    public function direct(Request $request)
    {
        $user_agent = request()->header('User-Agent');

        if (request()->ip() == '172.21.25.41' || request()->ip() == '::1' || request()->ip() == '172.21.25.205') {
            $entriesPage = $request->entries ?? 10;
            $search = $request->search ?? '';

            $baseQueryItems = Items::where(function ($query) {
                    $query->where('active', '!=', 'N')
                        ->orWhereNull('active');
                });

            if ($search)
                $baseQueryItems->where(function ($query) use ($search) {
                    $query->where('item_code', 'LIKE', "%$search%")
                        ->orWhere('item_name', 'LIKE', "%$search%");
                });

            $items = $baseQueryItems->orderBy('item_name')->paginate($entriesPage)->appends($request->query());

            $cart = Cart::where('id_user', auth()->user()->id_user_me)->firstWhere('cart_type', 'Direct Pick Up');
            if ($cart) {
                $idcart = $cart->id;
            } else {
                $idcart = null;
            }

            $cartdetail = CartDetail::with(['items'])->where('cart_id', $idcart)->get();

            return view('main.pr.direct', [
                "title" => "Direct Pick Up",
                "items" => $items,
                "cartdetail" => $cartdetail,
                "cart" => $cart,
                "entriesPage" => $entriesPage,
                "search" => $search,
            ]);
        } else {
            return view('main.pr.emptydirect', [
                "title" =>  "Direct Pick Up"
            ]);
        }
    }

    public function directadd(Request $request)
    {
        $id_user = auth()->user()->id_user_me;
        $cart = Cart::where('id_user', $id_user)->firstWhere('cart_type', 'Direct Pick Up');

        if ($cart) {
            $detail = CartDetail::where('cart_id', $cart->id)->firstWhere('items_id', $request->items_id);

            if ($detail) {
                CartDetail::where('id', $detail->id)
                    ->update(['qty' => $detail->qty + $request->qty]);
            } else {
                $newdata = new CartDetail([
                    'cart_id' => $cart->id,
                    'items_id' => $request->items_id,
                    'qty' => $request->qty
                ]);
                $newdata->save();
            }
        } else {
            $newdatacart = new Cart([
                'id_user' => $id_user,
                'cart_type' => 'Direct Pick Up'
            ]);

            $newdatacart->save();
            $newid = $newdatacart->id;
            $newdatacartdetail = new CartDetail([
                'cart_id' => $newid,
                'items_id' => $request->items_id,
                'qty' => $request->qty
            ]);

            $newdatacartdetail->save();
        }
        return to_route('purchase.direct')->with('success', 'Cart successfully updated');
    }

    public function checkout(Request $request)
    {
        $datenow = date("dmyhis");

        DB::beginTransaction();

        try {
            $lasttransaction = Transaction::whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->first();
            if ($lasttransaction) {
                $lasttransno = $lasttransaction->transno + 1;
            } else {
                $lasttransno = 1;
            }

            $cartType = $request->carttype;
            $currtransno = str_pad($lasttransno, 4, "0", STR_PAD_LEFT);
            $approver = User::firstWhere('id_user_me', auth()->user()->id_user_me_approver);
            $approver_pic = User::firstWhere('id_user_me', 2375);
            $approver_tlgam = User::firstWhere('id_user_me', 955);

            // Create transaction
            $newData = new Transaction();
            $newData->id_user = auth()->user()->id_user_me;
            $newData->id_emp = auth()->user()->username;
            $newData->name = auth()->user()->name;
            $newData->orgunit = auth()->user()->orgunit;
            $newData->status = 'Received';
            $newData->purchase_type = $cartType == 'direct' ? 'Direct Pick Up' : 'Purchase Request Proposal';
            $newData->purpose = $request->purpose;
            $newData->reason = $request->reason;
            $newData->transno = $lasttransno;
            $newData->tl_approval = $cartType == 'direct' ? '-' : 'Pending';
            $newData->tl_approver = $cartType == 'direct' ? NULL : $approver->id_user_me;
            $newData->tl_approver_name = $cartType == 'direct' ? NULL : $approver->name;
            $newData->tl_approver_name = $cartType == 'direct' ? NULL : $approver->name;
            $newData->pic_approval = 'Pending';
            $newData->pic_approver = $approver_pic->id_user_me;
            $newData->pic_approver_name = $approver_pic->name;
            $newData->tlgam_approval = $cartType == 'direct' ? '-' : 'Pending';
            $newData->tlgam_approver = $cartType == 'direct' ? NULL : $approver_tlgam->id_user_me;
            $newData->tlgam_approver_name = $cartType == 'direct' ? NULL : $approver_tlgam->name;
            $newData->transactionnumber = $datenow . $currtransno;
            $newData->save();

            $newtransid = $newData->id; // id transaction
            foreach ($request->qty as $x => $val) {
                $getprice = Items::firstWhere('id', $x);
                $newdatadetail = new TransactionDetail(([
                    'transaction_id' => $newtransid,
                    'items_id' => $x,
                    'qty' => $val,
                    'pic_qty' => $val,
                    'tluser_qty' => $val,
                    'tlgam_qty' => $val,
                    'transaction_price' => $getprice->price,
                    'transaction_total_price' => $getprice->price * $val
                ]));
                $newdatadetail->save(); // Create transaction detail
            }

            CartDetail::where('cart_id',  $request->cartid)->delete();
            Cart::where('id',  $request->cartid)->delete();

            DB::commit();

            $returnMessage = $cartType == 'direct' ? 'Checkout Success' : 'Request Submitted. Please inform your TL or ATL for your request approval.';

            return to_route('purchase.' . $cartType)->with('success', $returnMessage);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            session()->flash('danger', $e->getMessage());
            return to_route('purchase.direct');
        }
    }

    public function delete($id)
    {
        $cartdetail = CartDetail::firstWhere('id', $id);
        $idcart = $cartdetail->cart_id;

        if ($cartdetail) {
            CartDetail::where('id',  $id)->delete();
            Cart::where('id',  $idcart)->delete();

            return response()->json([
                'status' => 200,
                'uid' => $id
            ]);
        } else {
            return response()->json([
                'status' => 404
            ]);
        }
    }

    public function history()
    {
        $transaction = Transaction::where('id_user', auth()->user()->id_user_me)->get();
        return view('main.pr.history', [
            "title" =>  "Transaction History",
            "transaction" => $transaction
        ]);
    }


    public function propose()
    {
        if (auth()->user()->priv != 'picteam')
        {
            return abort(403);
        }

        $items = Items::all();
        $cart = Cart::where('id_user', auth()->user()->id_user_me)->firstWhere('cart_type', 'Purchase Request Proposal');
        if ($cart) {
            $idcart = $cart->id;
        } else {
            $idcart = null;
        }
        $cartdetail = CartDetail::with(['items'])->where('cart_id', $idcart)->get();
        return view('main.pr.propose', [
            "title" =>  "Purchase Request Proposal",
            "items" => $items,
            "cartdetail" => $cartdetail,
            "cart" => $cart
        ]);
    }
    public function proposeadd(Request $request)
    {
        $id_user = auth()->user()->id_user_me;
        $cart = Cart::where('id_user', $id_user)->firstWhere('cart_type', 'Purchase Request Proposal');
        if ($cart) {
            $detail = CartDetail::where('cart_id', $cart->id)->firstWhere('items_id', $request->items_id);
            // return $detail;
            if ($detail) {
                CartDetail::where('id', $detail->id)
                    ->update(['qty' => $request->qty]);
            } else {
                $newdata = new CartDetail([
                    'cart_id' => $cart->id,
                    'items_id' => $request->items_id,
                    'qty' => $request->qty
                ]);
                $newdata->save();
            }
        } else {
            $newdatacart = new Cart([
                'id_user' => $id_user,
                'cart_type' => 'Purchase Request Proposal'
            ]);
            $newdatacart->save();
            $newid = $newdatacart->id;
            $newdatacartdetail = new CartDetail([
                'cart_id' => $newid,
                'items_id' => $request->items_id,
                'qty' => $request->qty
            ]);
            $newdatacartdetail->save();
        }
        return to_route('purchase.propose')->with('success', 'Cart successfully updated');
        // return $cart;
    }
}
