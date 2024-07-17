<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApprovalController extends Controller
{
    public function pic()
    {
        // $transaction = Transaction::where('pic_approval', 'Pending')->get();
        //$transaction = Transaction::where('created_at', '>', now()->subDays(31)->endOfDay())->get();
        $transaction = Transaction::where('created_at', '>', now()->subDays(31)->endOfDay())->where('purchase_type', 'Direct Pick Up')->where('pic_approval', 'Pending')->get();
        return view('main.appr.pic', [
            "title" =>  "PIC Approval",
            "transaction" => $transaction
        ]);
    }
    public function tluser()
    {
        // $transaction = Transaction::where('pic_approval', 'Pending')->get();
        $transaction = Transaction::where('created_at', '>', now()->subDays(31)->endOfDay())->where('tl_approver', auth()->user()->id_user_me)->where('purchase_type', 'Purchase Request Proposal')->get();
        return view('main.appr.tluser', [
            "title" =>  "TL Approval",
            "transaction" => $transaction
        ]);
    }
    public function tlgam()
    {
        // $transaction = Transaction::where('pic_approval', 'Pending')->get();
        $transaction = Transaction::where('created_at', '>', now()->subDays(31)->endOfDay())->where('purchase_type', 'Purchase Request Proposal')->get();
        return view('main.appr.tlgam', [
            "title" =>  "TL GAM Approval",
            "transaction" => $transaction
        ]);
    }

    public function approvepic(Request $request)
    {


        //return $request;
        if ($request->hiddenvalue) {
            $detailvalue = $request->hiddenvalue;
            $arrayvalue = explode(",", $detailvalue);
            foreach ($arrayvalue as $value) {
                $separate = explode("|", $value);
                $transactiondetail = TransactionDetail::firstWhere('id', $separate[0]);
                $items = Items::firstWhere('id', $transactiondetail->items_id);
                // echo $items->id . "<br>";
                TransactionDetail::firstWhere('id', $separate[0])->update([
                    'pic_qty' => $separate[1],
                    'transaction_total_price' => $separate[1] * $items->price
                ]);
                Items::firstWhere('id', $transactiondetail->items_id)->update(['item_stock' => $items->item_stock - $separate[1]]);
            }
        }

        // return "";
        $transaction = Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej));
        $newnotification = new Notification([
            'transaction_id' => $request->transactionidappr ?? $request->transactionidrej,
            'user_id' => $transaction->id_user,
            'transaction_no' => $transaction->transactionnumber,
            'notif_type' => $request->process,
            'approver_name' => $transaction->pic_approver_name
        ]);

        $newnotification->save();
        Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['pic_approval' => $request->process]);
        if ($request->process == 'Approved') {
            if ($transaction->purchase_type == 'Purchase Request Proposal') {
                if ($transaction->tl_approval == 'Approved' and $transaction->tlgam_approval == 'Approved') {
                    Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['status' => 'On Progress']);
                }
            }
        } else if ($request->process == 'Rejected') {
            Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['status' => $request->process]);
            if ($transaction->purchase_type == 'Purchase Request Proposal') {
                // Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['tl_approval' => $request->process, 'tlgam_approval' => $request->process]);
            }
        }
        return to_route('approval.pic')->with('success', 'Successfully processed');
    }
    public function approvetluser(Request $request)
    {
        // return $request;
        $detailvalue = $request->hiddenvalue;
        $arrayvalue = explode(",", $detailvalue);
        foreach ($arrayvalue as $value) {
            $separate = explode("|", $value);
            TransactionDetail::firstWhere('id', $separate[0])->update(['tluser_qty' => $separate[1]]);
        }
        Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update([
            'tl_approval' => $request->process,
            'tl_note' => $request->hiddennote
        ]);
        $transaction = Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej));
        if ($request->process == 'Approved') {
            if ($transaction->purchase_type == 'Purchase Request Proposal') {
                if ($transaction->pic_approval == 'Approved' and $transaction->tlgam_approval == 'Approved') {
                    Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['status' => 'On Progress']);
                }
            }
        } else if ($request->process == 'Rejected') {
            Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['status' => 'Rejected']);
        }
        return to_route('approval.tluser')->with('success', 'Successfully processed');
    }
    public function approvetlgam(Request $request)
    {
        // return $request;
        $detailvalue = $request->hiddenvalue;
        $arrayvalue = explode(",", $detailvalue);
        foreach ($arrayvalue as $value) {
            $separate = explode("|", $value);
            $getprice = TransactionDetail::firstWhere('id', $separate[0]);
            TransactionDetail::firstWhere('id', $separate[0])->update([
                'tlgam_qty' => $separate[1],
                'transaction_total_price' => $separate[1] * $getprice->transaction_price
            ]);
        }
        Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['tlgam_approval' => $request->process]);
        $transaction = Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej));
        if ($request->process == 'Approved') {
            if ($transaction->purchase_type == 'Purchase Request Proposal') {
                if ($transaction->pic_approval == 'Approved' and $transaction->tl_approval == 'Approved') {
                    Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['status' => 'On Progress']);
                }
            }
        }
        return to_route('approval.tlgam')->with('success', 'Successfully processed');
    }
    public function savedatatlgam(Request $request)
    {
        // return $request;
        $detailvalue = $request->hiddenvalue;
        $arrayvalue = explode(",", $detailvalue);
        foreach ($arrayvalue as $value) {
            $separate = explode("|", $value);
            $getprice = TransactionDetail::firstWhere('id', $separate[0]);
            TransactionDetail::firstWhere('id', $separate[0])->update([
                'tlgam_qty' => $separate[1],
                'transaction_total_price' => $separate[1] * $getprice->transaction_price
            ]);
        }
        // Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['tlgam_approval' => $request->process]);
        return to_route('approval.tlgam')->with('success', 'Successfully processed');
    }
    public function finish(Request $request)
    {
        // return $request;

        Transaction::firstWhere('id', ($request->transactionid))->update(['status' => 'Finished']);
        $transaction = Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej));
        if ($request->process == 'Approved') {
            if ($transaction->purchase_type == 'Purchase Request Proposal') {
                if ($transaction->pic_approval == 'Approved' and $transaction->tl_approval == 'Approved') {
                    Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['status' => 'On Progress']);
                }
            }
        }
        return to_route('admin.pr')->with('success', 'Successfully processed');
    }

    // public function getdetail($id, $newval)
    // {

    //     $transactiondetail = TransactionDetail::firstWhere('id', $id);
    //     // return $transactiondetail;
    //     if ($transactiondetail) {
    //         // TransactionDetail::firstWhere('id', $id)
    //         //     ->update(['pic_qty' => $lasstock]);
    //         return response()->json([
    //             'status' => 200,
    //             'aaa' => $newval,
    //             'transactiondetail' => $transactiondetail
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => 'Data notfound',
    //         ]);
    //     }
    // }
    public function getdetail(Request $request)
    {
        //dd($request);
        $id = str_replace("col", "", $request->id);
        $transactiondetail = TransactionDetail::firstWhere('id', $id);
        // return $transactiondetail;
        if ($transactiondetail) {
            TransactionDetail::firstWhere('id', $id)
                ->update(['pic_qty' => $request->val]);
            return response()->json([
                'status' => 200,
                'message' => 'Update Success'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Update failed. Data notfound',
            ]);
        }
    }
    public function getdetailtluser(Request $request)
    {
        $id = str_replace("col", "", $request->id);
        $transactiondetail = TransactionDetail::firstWhere('id', $id);
        // return $transactiondetail;
        if ($transactiondetail) {
            TransactionDetail::firstWhere('id', $id)
                ->update(['tluser_qty' => $request->val]);
            return response()->json([
                'status' => 200,
                'message' => 'Update Success'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Update failed. Data notfound',
            ]);
        }
    }
    public function getdetailtlgam(Request $request)
    {
        //dd($request);
        $id = str_replace("col", "", $request->id);
        $transactiondetail = TransactionDetail::firstWhere('id', $id);
        // return $transactiondetail;
        if ($transactiondetail) {
            TransactionDetail::firstWhere('id', $id)
                ->update(['tlgam_qty' => $request->val]);
            return response()->json([
                'status' => 200,
                'message' => 'Update Success'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Update failed. Data notfound',
            ]);
        }
    }

    public function pending()
    {
        $transaction = Transaction::where('created_at', '>', now()->subDays(31)->endOfDay())->whereHas('user', function ($query){
                                        $query->where('id_org_unit', auth()->user()->id_org_unit);
                                    })
                                    ->where('purchase_type', 'Purchase Request Proposal')->where('tl_approval', 'Pending')->get();
        return view('main.appr.pending', [
            "title" =>  "Pending Approval",
            "transaction" => $transaction
        ]);
    }

    public function approve_tl_atl(Request $request)
    {
        //dd($request);
        if ($request->hiddenvalue) {
            $detailvalue = $request->hiddenvalue;
            $arrayvalue = explode(",", $detailvalue);
            foreach ($arrayvalue as $value) {
                $separate = explode("|", $value);
                TransactionDetail::firstWhere('id', $separate[0])->update(['tluser_qty' => $separate[1]]);
            }
        }
        Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update([
            'tl_approval' => $request->process,
            'tl_note' => $request->hiddennote,
            'tl_approver_name' => auth()->user()->name
        ]);
        $transaction = Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej));
        if ($request->process == 'Approved') {
            if ($transaction->purchase_type == 'Purchase Request Proposal') {
                if ($transaction->tlgam_approval == 'Approved') {
                    Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['status' => 'On Progress', 'tl_approver_name' => auth()->user()->name]);
                }
            }
        } else if ($request->process == 'Rejected') {
            Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['status' => 'Rejected', 'tl_approver_name' => auth()->user()->name]);
        }
        return to_route('approval.pending')->with('success', 'Successfully processed');
    }

    public function pending_ga()
    {
        $transaction = Transaction::where('created_at', '>', now()->subDays(31)->endOfDay())->where('purchase_type', 'Purchase Request Proposal')->where('tl_approval', 'Approved')->where('tlgam_approval', 'Pending')->get();
        return view('main.appr.pending_ga', [
            "title" =>  "Pending GA Approval",
            "transaction" => $transaction
        ]);
    }

    public function approve_ga_tl(Request $request)
    {
        //return $request;
        if ($request->hiddenvalue) {
            $detailvalue = $request->hiddenvalue;
            $arrayvalue = explode(",", $detailvalue);
            foreach ($arrayvalue as $value) {
                $separate = explode("|", $value);
                $getprice = TransactionDetail::firstWhere('id', $separate[0]);
                TransactionDetail::firstWhere('id', $separate[0])->update([
                    'tlgam_qty' => $separate[1],
                    'transaction_total_price' => $separate[1] * $getprice->transaction_price
                ]);
            }
        }
        Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['tlgam_approval' => $request->process]);
        $transaction = Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej));
        if ($request->process == 'Approved') {
            if ($transaction->purchase_type == 'Purchase Request Proposal') {
                if ($transaction->tl_approval == 'Approved') {
                    Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['status' => 'On Progress']);
                }
            }
        }
        return to_route('approval.pending_ga')->with('success', 'Successfully processed');
    }

    public function savedata_tlgam(Request $request)
    {
        // return $request;
        $detailvalue = $request->hiddenvalue;
        $arrayvalue = explode(",", $detailvalue);
        foreach ($arrayvalue as $value) {
            $separate = explode("|", $value);
            $getprice = TransactionDetail::firstWhere('id', $separate[0]);
            TransactionDetail::firstWhere('id', $separate[0])->update([
                'tlgam_qty' => $separate[1],
                'transaction_total_price' => $separate[1] * $getprice->transaction_price
            ]);
        }
        // Transaction::firstWhere('id', ($request->transactionidappr ?? $request->transactionidrej))->update(['tlgam_approval' => $request->process]);
        return to_route('approval.pending_ga')->with('success', 'Successfully processed');
    }
}
