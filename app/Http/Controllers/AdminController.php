<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use App\User;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if($request->isMethod('post')){

            $data = $request->input();
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'admin' => '1'])){
                // echo "Success"; die;
               // Session::put('adminSession', $data['email']);

                return redirect('/admin/dashboard');
            }else{
                //echo "Failes"; die;
                return redirect('/admin_login')->with('flash_message_error', 'Invalid Email And Password');
            }
        }
        return View('admin.admin_login');
    }

    public function dashboard()
    {
        // if(Session::has('adminSession')){
        //     //perform all deshboard task
        // }else{
        //     return redirect('/admin_login')->with('flash_message_error', 'Please login to Access');
        // }
        return view('admin.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/admin_login')->with('flash_message_success', 'Logged out Successfully');
    }

    public function setting()
    {
        return view('admin.setting');
    }

    public function chkPassword(Request $request)
    {
        $data = $request->all();
        $current_password = $data['current_pwd'];
        $check_password = User::where(['admin' => '1'])->first();
        if(Hash::check($current_password, $check_password->password))
        {
            echo "true";die;
        }else {
            echo "false"; die;
        }
    }

    public function update_password(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            //print_r($data);
            $check_password = User::where(['email' => Auth::user()->email])->first();
            $current_password = $data['current_pwd'];
            if(Hash::check($current_password, $check_password->password))
            {
               $password = bcrypt($data['new_pwd']);
               User::where('id','1')->update(['password' => $password]);
               return redirect('/admin/setting')->with('flash_message_success', 'Password Update Successfully');
            }else {
                return redirect('/admin/setting')->with('flash_message_error', 'Incorrect Current Password');
            }
        }
    }
}
