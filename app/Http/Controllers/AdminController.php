<?php

namespace App\Http\Controllers;

use App\Admin;
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
             $adminCount = Admin::where(['username' => $data['username'],
                'password' => md5($data['password']), 'status' => 1])->count();
            if($adminCount > 0){
                // echo "Success"; die;
                Session::put('AdminSession', $data['username']);
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
        $adminDetails = Admin::where(['username' => Session::get('AdminSession')])->first();
//        echo "<pre>"; print_r($adminDetails);die;
        return view('admin.setting', compact('adminDetails'));
    }

    public function chkPassword(Request $request)
    {
        $data = $request->all();
        $adminCount = Admin::where(['username' => Session::get('AdminSession'),
            'password' => md5($data['current_pwd'])])->count();
        if($adminCount == 1)
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
            
            $adminCount = Admin::where(['username' => Session::get('AdminSession'),
                'password' => md5($data['current_pwd'])])->count();
            
            if($adminCount == 1)
            {
               $password = md5($data['new_pwd']);
               Admin::where('username',Session::get('AdminSession'))->update(['password' => $password]);
               return redirect('/admin/setting')->with('flash_message_success', 'Password Update Successfully');
            }else {
                return redirect('/admin/setting')->with('flash_message_error', 'Incorrect Current Password');
            }
        }
    }
}
