<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Items;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\DirectExport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class AdministrationController extends Controller
{
    public function admindirect()
    {
        // $transaction = Transaction::where('pic_approval', 'Pending')->get();
        $transaction = Transaction::where('purchase_type', 'Direct Pick Up')->orderBy('created_at', 'desc')->get();
        // return $transaction;
        return view('main.admin.direct', [
            "title" =>  "Direct Pick Up List",
            "transaction" => $transaction
        ]);
    }
    public function adminpr()
    {
        // $transaction = Transaction::where('pic_approval', 'Pending')->get();
        $transaction = Transaction::where('purchase_type', 'Purchase Request Proposal')->orderBy('created_at', 'desc')->get();
        return view('main.admin.pr', [
            "title" =>  "Purchase Request List",
            "transaction" => $transaction
        ]);
    }
    public function postreceipt(Request $request)
    {
        // return $request;
        // $transaction = Transaction::where('pic_approval', 'Pending')->get();
        Transaction::firstWhere('id', $request->idtransaction)->update(['receipt' => $request->receipt]);
        return to_route('admin.pr')->with('success', 'Receipt successfully updated');
    }
    public function masteritem()
    {
        // $transaction = Transaction::where('pic_approval', 'Pending')->get();
        $items = Items::all();
        return view('main.admin.master', [
            "title" =>  "Item Master Data",
            "items" => $items
        ]);
    }

    public function show($id)
    {
        //
        $items = Items::firstWhere('id', $id);
        if ($items) {
            return response()->json([
                'status' => 200,
                'items' => $items
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data notfound',
            ]);
        }
        // return $items;
    }

    public function saveitem(Request $request)
    {
        //

        // return $request;


        $destinationPath = 'storage/item/';
        if ($request->file('picture')) {
            $files = $request->file('picture'); // will get all files
            $file_name = $request->item_id . "." . $files->getClientOriginalExtension(); //Get file original name
            $files->move($destinationPath, $file_name); // move files to destination folder
            Items::where('id', $request->item_id)
                ->update([
                    'item_name' => $request->item_name,
                    'item_unit' => $request->item_unit,
                    'item_stock' => $request->add_stock + $request->old_stock,
                    'item_stock_reminder' => $request->item_stock_reminder,
                    'price' => $request->price,
                    'picture' => $file_name
                ]);
        } else {
            Items::where('id', $request->item_id)
                ->update([
                    'item_name' => $request->item_name,
                    'item_unit' => $request->item_unit,
                    'item_stock' => $request->add_stock + $request->old_stock,
                    'item_stock_reminder' => $request->item_stock_reminder,
                    'price' => $request->price
                ]);
        }





        return to_route('admin.masteritem')->with('success', 'Item successfully updated');
    }
    public function additem(Request $request)
    {
        //

        // return $request;
        $destinationPath = 'storage/item/';
        $files = $request->file('picture'); // will get all files
        $file_name = $request->item_id . "." . $files->getClientOriginalExtension(); //Get file original name
        $files->move($destinationPath, $file_name); // move files to destination folder
        $newitem = new Items([
            'item_code' => $request->item_code,
            'item_name' => $request->item_name,
            'item_unit' => $request->item_unit,
            'item_stock' => $request->add_stock,
            'price' => $request->price,
            'picture' => $file_name
        ]);
        $newitem->save();


        return to_route('admin.masteritem')->with('success', 'Item successfully saved');
    }

    public function user()
    {
        // $transaction = Transaction::where('pic_approval', 'Pending')->get();
        $user = User::all();
        return view('main.admin.user', [
            "title" =>  "User Data",
            "user" => $user
        ]);
    }
    public function useradd()
    {
        // $transaction = Transaction::where('pic_approval', 'Pending')->get();
        // $user = User::all();
        return view('main.admin.useradd', [
            "title" =>  "Add User",
            "user" => '-'
        ]);
    }
    public function usersearch(Request $request)
    {
        $checkuser = User::firstWhere('username', $request->idemp);
        // return $checkuser;
        if ($checkuser) {
            return redirect('/admin/user/add')->with('registered', $checkuser->name . ' (' . $request->idemp . ') already registered');
        } else {
            $employee = Http::get(config('api.employee.base_url') . $request->idemp . '')->object();
            if (isset($employee->status)) {
                return back()->with('searcherror', 'Data not found');
            } else {
                return view('main.admin.useradd', [
                    "title" =>  "Add User",
                    "employee" => $employee
                ]);
            }
        }
    }

    public function storeuser(Request $request)
    {
        $checkuser = User::firstWhere('id_user_me', $request->getiduserme);
        if ($checkuser) {
            return redirect('/admin/user/add')->with('registered', $request->getiduserme . ' already registered.');
        } else {
            $newdata = new User([
                'id_user_me' =>  $request->getiduserme,
                'name' =>  $request->getname,
                'orgunit' =>  $request->getorgunit,
                'id_user_me_approver' =>  $request->getidapprover,
                'password' => Hash::make($request->getidemp),
                'username' =>  $request->getidemp
            ]);
            $newdata->save();
            //approver 1
            if ($request->getidapprover == null or $request->getidapprover == "") {
                // return "aaa";
            } else {
                $checkuser = User::firstWhere('id_user_me', $request->getidapprover);
                // return $checkuser;
                if ($checkuser) {
                    // return "aa";
                } else if ($request->getiduserme == $request->id_user_me_approver) {
                    // return "bb";
                    $approver = Http::get(config('api.employee.id_url') . $request->getidapprover . '')->object();
                    $newdataapprover = new User([
                        'id_user_me' =>  $approver->id_user,
                        'name' =>  $approver->name,
                        'orgunit' =>  $approver->orgunit,
                        'id_user_me_approver' =>  $approver->appr1,
                        'password' => Hash::make($approver->id_emp),
                        'username' =>  $approver->id_emp
                    ]);
                    $newdataapprover->save();
                } else {
                    // return "cc";
                    $approver = Http::get(config('api.employee.id_url') . $request->getidapprover . '')->object();
                    $newdataapprover = new User([
                        'id_user_me' =>  $approver->id_user,
                        'name' =>  $approver->name,
                        'orgunit' =>  $approver->orgunit,
                        'id_user_me_approver' =>  $approver->appr1,
                        'password' => Hash::make($approver->id_emp),
                        'username' =>  $approver->id_emp
                    ]);
                    $newdataapprover->save();
                    //approver2
                    if ($approver->appr1 == null or $approver->appr1 == "") {
                    } else {
                        $checkuser2 = User::firstWhere('id_user_me', $approver->appr1);
                        $approver2 = Http::get(config('api.employee.id_url') . $approver->appr1 . '')->object();
                        if ($checkuser2) {
                        } else if ($approver2->id_user == $approver2->appr1) {
                            $newdataapprover2 = new User([
                                'id_user_me' =>  $approver2->id_user,
                                'name' =>  $approver2->name,
                                'orgunit' =>  $approver2->orgunit,
                                'id_user_me_approver' =>  $approver2->appr1,
                                'password' => Hash::make($approver2->id_emp),
                                'username' =>  $approver2->id_emp
                            ]);
                            $newdataapprover2->save();
                        } else {

                            $newdataapprover2 = new User([
                                'id_user_me' =>  $approver2->id_user,
                                'name' =>  $approver2->name,
                                'orgunit' =>  $approver2->orgunit,
                                'id_user_me_approver' =>  $approver2->appr1,
                                'password' => Hash::make($approver2->id_emp),
                                'username' =>  $approver2->id_emp
                            ]);
                            $newdataapprover2->save();
                            //approver3
                            if ($approver2->appr1 == null or $approver2->appr1 == "") {
                            } else {
                                $checkuser3 = User::firstWhere('id_user_me', $approver2->appr1);
                                $approver3 = Http::get(config('api.employee.id_url') . $approver2->appr1 . '')->object();
                                if ($checkuser3) {
                                } else if ($approver3->id_user == $approver3->appr1) {
                                    $newdataapprover3 = new User([
                                        'id_user_me' =>  $approver3->id_user,
                                        'name' =>  $approver3->name,
                                        'orgunit' =>  $approver3->orgunit,
                                        'id_user_me_approver' =>  $approver3->appr1,
                                        'password' => Hash::make($approver3->id_emp),
                                        'username' =>  $approver3->id_emp
                                    ]);
                                    $newdataapprover3->save();
                                } else {

                                    $newdataapprover3 = new User([
                                        'id_user_me' =>  $approver3->id_user,
                                        'name' =>  $approver3->name,
                                        'orgunit' =>  $approver3->orgunit,
                                        'id_user_me_approver' =>  $approver3->appr1,
                                        'password' => Hash::make($approver3->id_emp),
                                        'username' =>  $approver3->id_emp
                                    ]);
                                    $newdataapprover3->save();
                                }
                            }
                        }
                    }
                }
            }

            return redirect('/admin/user/add')->with('success', 'Register successfull.');
            // return view('login.register');
        }
    }
    public function usershow($id)
    {
        //
        $users = User::firstWhere('id', $id);
        if ($users) {
            return response()->json([
                'status' => 200,
                'user' => $users
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data notfound',
            ]);
        }
        // return $items;
    }
    public function saveuser(Request $request)
    {
        //

        // return $request;



        User::where('id', $request->iduser)
            ->update([

                'priv' => $request->privilege
            ]);


        return to_route('admin.user')->with('success', 'User successfully updated');
    }

    public function export(Request $request)
    {
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required',
        ]);

        $from_date=$request->from_date;
        $to_date = $request->to_date;

        return Excel::download(new DirectExport($from_date,$to_date), 'Recapitulation_Direct_Pick_Up_'.$from_date.'_'.$to_date.'.xlsx');

    }
}
