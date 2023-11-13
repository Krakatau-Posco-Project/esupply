<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    public function employee(Request $request)
    {
        $checkuser = User::firstWhere('username', $request->idemp);
        if ($checkuser) {
            return redirect('/login')->with('nosession', 'ID already registered. Please login using your Employee ID as username & password');
        } else {
            $employee = Http::get(config('api.employee.base_url') . $request->idemp . '')->object();
            // return $employee;
            if (isset($employee->status)) {
                return back()->with('loginError', 'Data not found');
            } else {
                return view('login.register', [
                    "employee" => $employee
                ]);
            }
        }
    }
    public function register()
    {
        return view('login.register');
    }
    public function store(Request $request)
    {
        $checkuser = User::firstWhere('id_user_me', $request->getiduserme);
        if ($checkuser) {
            return redirect('/login')->with('nosession', 'ID already registered. Please login using your Employee ID as username & password');
        } else {
            $newdata = new User([
                'id_user_me' =>  $request->getiduserme,
                'name' =>  $request->getname,
                'orgunit' =>  $request->getorgunit,
                'id_user_me_approver' =>  $request->getidapprover,
                'password' => Hash::make($request->getidemp),
                'username' =>  $request->getidemp,
                'ssohash' =>  $request->newhash
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
                        'username' =>  $approver->id_emp,
                        'ssohash' =>  $approver->newhash
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
                        'username' =>  $approver->id_emp,
                        'ssohash' =>  $approver->newhash
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
                                'username' =>  $approver2->id_emp,
                                'ssohash' =>  $approver2->newhash
                            ]);
                            $newdataapprover2->save();
                        } else {

                            $newdataapprover2 = new User([
                                'id_user_me' =>  $approver2->id_user,
                                'name' =>  $approver2->name,
                                'orgunit' =>  $approver2->orgunit,
                                'id_user_me_approver' =>  $approver2->appr1,
                                'password' => Hash::make($approver2->id_emp),
                                'username' =>  $approver2->id_emp,
                                'ssohash' =>  $approver2->newhash
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
                                        'username' =>  $approver3->id_emp,
                                        'ssohash' =>  $approver3->newhash
                                    ]);
                                    $newdataapprover3->save();
                                } else {

                                    $newdataapprover3 = new User([
                                        'id_user_me' =>  $approver3->id_user,
                                        'name' =>  $approver3->name,
                                        'orgunit' =>  $approver3->orgunit,
                                        'id_user_me_approver' =>  $approver3->appr1,
                                        'password' => Hash::make($approver3->id_emp),
                                        'username' =>  $approver3->id_emp,
                                        'ssohash' =>  $approver3->newhash
                                    ]);
                                    $newdataapprover3->save();
                                }
                            }
                        }
                    }
                }
            }

            return redirect('/login')->with('successlogout', 'Register successfull. Please login using your Employee ID as username & password');
            // return view('login.register');
        }
    }
}
