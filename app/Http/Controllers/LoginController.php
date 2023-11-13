<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            "title" => 'Login'
        ]);
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->with('loginError', 'Login failed');
    }
    public function logout(Request $request)
    {
        // return $request;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('successlogout', 'Successfully Logout');
    }
    public function checksso()
    {
        Auth::logout();
        $getid = explode('$', request('ses'));
        $userget = User::firstWhere('ssohash', $getid[1]);
        if ($userget) {
            if (Auth::loginUsingId($userget->id)) {
                return redirect()->intended('/');
            } else {
                return back()->with('loginError', 'SSO failed, user not found');
            }
        } else {
            $employee = Http::get(config('api.employee.base_url_hash') . $getid[1] . '')->object();
            foreach ($employee as $key => $value) {
                $arrays[$key] = $value;
            }
            if ($employee) {
                if (isset($employee->status)) {
                    // return $employee->status;
                    return back()->with('loginError', 'SSO failed, user not found');
                } else {
                    $newdata = new User([
                        'id_user_me' =>  $employee->id_user,
                        'name' =>  $employee->name,
                        'orgunit' =>  $employee->orgunit,
                        'id_user_me_approver' =>  $employee->appr1,
                        'password' => Hash::make($employee->id_emp),
                        'username' =>  $employee->id_emp,
                        'ssohash' =>  $employee->newhash
                    ]);
                    $newdata->save();
                    //approver 1
                    if ($employee->appr1 == null or $employee->appr1 == "") {
                        // return "aaa";
                    } else {
                        $checkuser = User::firstWhere('id_user_me', $employee->appr1);
                        // return $checkuser;
                        if ($checkuser) {
                            // return "aa";
                        } else if ($employee->id_user == $employee->appr1) {
                            // return "bb";
                            $approver = Http::get(config('api.employee.id_url') . $employee->appr1 . '')->object();
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
                            $approver = Http::get(config('api.employee.id_url') . $employee->appr1 . '')->object();
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
                    // return redirect()->intended('/');
                    if (Auth::loginUsingId($newdata->id)) {
                        return redirect()->intended('/');
                    } else {
                        return back()->with('loginError', 'SSO failed, user not found');
                    }
                }
            }

            // $arrays['password'] =  Hash::make($employee->id_emp);
            // $user = User::create($arrays);

        }
    }
}
