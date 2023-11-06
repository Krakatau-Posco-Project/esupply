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

class PurchaseController extends Controller
{
    public function direct()
    {
        // return request()->header('User-Agent');
        // $aaa = explode(" ", request()->header('User-Agent'));
        // return $aaa;
        $user_agent = request()->header('User-Agent');
        // if (preg_match('/SM-T515/', $user_agent)) {
        // if (request()->header('User-Agent') == '*SM-T835*') {
        // if (request()->ip() == '172.21.25.205') {
        if (request()->ip() == '172.21.25.41') {
            $items = Items::all();
            $cart = Cart::where('id_user', auth()->user()->id_user_me)->firstWhere('cart_type', 'Direct Pick Up');
            if ($cart) {
                $idcart = $cart->id;
            } else {
                $idcart = null;
            }
            $cartdetail = CartDetail::with(['items'])->where('cart_id', $idcart)->get();
            // return $cartdetail;
            return view('main.pr.direct', [
                "title" =>  "Direct Pick Up",
                "items" => $items,
                "cartdetail" => $cartdetail,
                "cart" => $cart
            ]);
        } else if (request()->ip() == '::1' || request()->ip() == '172.21.25.205') {
            $items = Items::all();
            $cart = Cart::where('id_user', auth()->user()->id_user_me)->firstWhere('cart_type', 'Direct Pick Up');
            if ($cart) {
                $idcart = $cart->id;
            } else {
                $idcart = null;
            }
            $cartdetail = CartDetail::with(['items'])->where('cart_id', $idcart)->get();
            // return $cartdetail;
            return view('main.pr.direct', [
                "title" =>  "Direct Pick Up",
                "items" => $items,
                "cartdetail" => $cartdetail,
                "cart" => $cart
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
        // return $cart;
    }

    public function checkout(Request $request)
    {
        // $datenow = date("l jS \of F Y h:i:s A");
        $datenow = date("dmyhis");
        // return $datenow;
        $lasttransaction = Transaction::whereDate('created_at', Carbon::today())->orderBy('transno', 'desc')->first();
        if ($lasttransaction) {
            $lasttransno = $lasttransaction->transno + 1;
        } else {
            $lasttransno = 1;
        }
        // return $lasttransno;
        if ($request->carttype == 'direct') {
            $purchase_type = 'Direct Pick Up';
            $status = "Received";
            $returnmessage = "Checkout Success";
            $approver_pic = User::firstWhere('id_user_me', 2375);
            $aprrover_id = null;
            $approver_name = null;
            $pic_approver_id =  $approver_pic->id_user_me;
            $pic_approver_name =  $approver_pic->name;
            $tlgam_approver_id =  null;
            $tlgam_approver_name =  null;
            $tl_approval =  '-';
            $tlgam_approval =  '-';
        } else {
            $purchase_type = 'Purchase Request Proposal';
            $status = "Received";
            $returnmessage = "Request Submitted";
            $approver = User::firstWhere('id_user_me', auth()->user()->id_user_me_approver);
            $approver_pic = User::firstWhere('id_user_me', 2375);
            $approver_tlgam = User::firstWhere('id_user_me', 955);
            // return $approver;
            $aprrover_id = $approver->id_user_me;
            $approver_name = $approver->name;
            $pic_approver_id =  $approver_pic->id_user_me;
            $pic_approver_name =  $approver_pic->name;
            $tlgam_approver_id =  $approver_tlgam->id_user_me;
            $tlgam_approver_name =  $approver_tlgam->name;
            $tl_approval =  'Pending';
            $tlgam_approval =  'Pending';
            // return $approver_name;
        }
        $currtransno = str_pad($lasttransno, 4, "0", STR_PAD_LEFT);
        $newdata = new Transaction([
            'id_user' =>  auth()->user()->id_user_me,
            'id_emp' =>  auth()->user()->username,
            'name' =>  auth()->user()->name,
            'orgunit' =>  auth()->user()->orgunit,
            'status' =>  $status,
            'purchase_type' =>  $purchase_type,
            // 'purpose' =>  $request->purpose,
            'reason' =>  $request->reason,
            'transno' =>  $lasttransno,
            'tl_approval' =>  $tl_approval,
            'tl_approver' =>  $aprrover_id,
            'tl_approver_name' =>  $approver_name,
            'pic_approval' => 'Pending',
            'pic_approver' =>  $pic_approver_id,
            'pic_approver_name' =>  $pic_approver_name,
            'tlgam_approval' => $tlgam_approval,
            'tlgam_approver' =>  $tlgam_approver_id,
            'tlgam_approver_name' =>  $tlgam_approver_name,
            'transactionnumber' =>  $datenow . $currtransno
        ]);
        $newdata->save(); //create transaction
        $newtransid = $newdata->id; //id transaction
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
            $newdatadetail->save(); //create transaction detail

            // if ($request->carttype == 'direct') {
            //     $searchid = Items::firstWhere('id', $x);
            //     $lasstock = $searchid->item_stock - $val;
            //     Items::where('id', $x)
            //         ->update(['item_stock' => $lasstock]);
            // }
        }
        CartDetail::where('cart_id',  $request->cartid)->delete();
        Cart::where('id',  $request->cartid)->delete();

        return to_route('purchase.' . $request->carttype . '')->with('success', $returnmessage);
        // return $request;
    }
    public function delete($id)
    {
        $cartdetail = CartDetail::firstWhere('id', $id);
        // return $cartdetail;
        $idcart = $cartdetail->cart_id;
        // return $id
        if ($cartdetail) {
            CartDetail::where('id',  $id)->delete();
            $searchothercartdetail = CartDetail::where('cart_id', $idcart)->get();
            // return $searchothercartdetail;
            if (count($searchothercartdetail)) {
                // return "aa";
            } else {
                Cart::where('id',  $idcart)->delete();
                // return "bb";
            }
            return response()->json([
                'status' => 200,
                'uid' => $id
            ]);
        } else {
            return response()->json([
                'status' => 404
            ]);
        }

        // return $id;
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
