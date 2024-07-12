<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $notification = Notification::where('user_id', auth()->user()->id_user_me)->where('status', 'unread')->get();
        // $notifpicapproverequest = Transaction::where('pic_approver', auth()->user()->id_user_me)->where('purchase_type', 'Purchase Request Proposal')->where('pic_approval', 'Pending')->count();
        // $notifpicapproverdirect = Transaction::where('pic_approver', auth()->user()->id_user_me)->where('purchase_type', 'Direct Pick Up')->where('pic_approval', 'Pending')->count();


        // $notiftluserapproverequest = Transaction::where('tl_approver', auth()->user()->id_user_me)->where('purchase_type', 'Purchase Request Proposal')->where('tl_approval', 'Pending')->count();
        // $notiftlgamapproverequest = Transaction::where('tlgam_approver', auth()->user()->id_user_me)->where('purchase_type', 'Purchase Request Proposal')->where('tlgam_approval', 'Pending')->count();


        $notifpicapproverdirect = Transaction::where('purchase_type', 'Direct Pick Up')->where('pic_approval', 'Pending')->count();

        $notiftluserapproverequest = Transaction::where('purchase_type', 'Purchase Request Proposal')->where('tl_approval', 'Pending')->whereHas('user', function ($query){
            $query->where('id_org_unit', auth()->user()->id_org_unit);
        })->count();
        $notiftlgamapproverequest = Transaction::where('purchase_type', 'Purchase Request Proposal')->where('tl_approval', 'Approved')->where('tlgam_approval', 'Pending')->whereHas('user', function ($query){
            $query->where('id_org_unit', auth()->user()->id_org_unit);
        })->count();

        // return $notification;
        return view('welcome', [
            "title" =>  "Main Home",
            "notification" => $notification,

            "picdir" => $notifpicapproverdirect,
            "tl" => $notiftluserapproverequest,
            "tlgam" => $notiftlgamapproverequest
        ]);
    }
}
