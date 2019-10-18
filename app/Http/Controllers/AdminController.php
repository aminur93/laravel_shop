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
    
    public function viewAdmins()
    {
        $admins = Admin::get();
//        $admins = json_decode(json_encode($admins));
//        echo "<pre>";print_r($admins);die;\
        
        return view('admin.admins.view_admins', compact('admins'));
    }
    
    public function addAdmins(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
            
            $admincount = Admin::where('username',$data['username'])->count();
            
            if ($admincount > 0)
            {
                return redirect()->back()->with('flash_message_error','Admin/Sub-Admin Already Exist');
            }else{
                if ($data['type'] == 'Admin')
                {
                    $admin = new Admin();
                    $admin->type = $data['type'];
                    $admin->username = $data['username'];
                    $admin->password = md5($data['password']);
                    $admin->status = $data['status'];
    
                    $admin->save();
    
                    return redirect()->back()->with('flash_message_success','Admin Added Successfully');
                }elseif ($data['type'] == 'Sub-Admin'){
                    $admin = new Admin();
                    $admin->type = $data['type'];
                    $admin->username = $data['username'];
                    $admin->password = md5($data['password']);
                    
                    if(!empty($data['category_view_access'])){
                        $admin->category_view_access = $data['category_view_access'];
                    }else {
                        $admin->category_view_access = 0;
                    }
    
                    if(!empty($data['category_edit_access'])){
                        $admin->category_edit_access = $data['category_edit_access'];
                    }else {
                        $admin->category_edit_access = 0;
                    }
    
                    if(!empty($data['category_full_access'])){
                        $admin->category_full_access = $data['category_full_access'];
                        $admin->category_view_access = 1;
                        $admin->category_edit_access = 1;
                    }else {
                        $admin->category_full_access = 0;
                    }
    
                    if(!empty($data['brand_access'])){
                        $admin->brand_access = $data['brand_access'];
                    }else {
                        $admin->brand_access = 0;
                    }
    
                    if(!empty($data['product_access'])){
                        $admin->product_access = $data['product_access'];
                    }else {
                        $admin->product_access = 0;
                    }
    
                    if(!empty($data['order_access'])){
                        $admin->order_access = $data['order_access'];
                    }else {
                        $admin->order_access = 0;
                    }
    
                    if(!empty($data['user_access'])){
                        $admin->user_access = $data['user_access'];
                    }else {
                        $admin->user_access = 0;
                    }
                    
                    $admin->status = $data['status'];
    
                    $admin->save();
    
                    return redirect()->back()->with('flash_message_success','Sub Admin Added Successfully');
                }
            }
        }
        return view('admin.admins.add_admins');
    }
    
    public function editAdmins(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
        
            $admincount = Admin::where('id',$id)->get();
            
            foreach ($admincount as $ac)
            {
                $current_p = $ac->password;
            }
            
            //return $current_p;die;
            
                if ($data['type'] == 'Admin')
                {
                    $admin = Admin::findOrFail($id);
                    $admin->type = $data['type'];
                    $admin->username = $data['username'];
                    if(!empty($data['password'])) {
                        $admin->password = md5($data['password']);
                    }else{
                        $admin->password = $current_p;
                    }
                    $admin->status = $data['status'];
                
                    $admin->save();
                
                    return redirect()->back()->with('flash_message_success','Admin Updated Successfully');
                }elseif ($data['type'] == 'Sub-Admin'){
                    $admin = Admin::findOrFail($id);
                    $admin->type = $data['type'];
                    $admin->username = $data['username'];
                    
                    if(!empty($data['password'])) {
                        $admin->password = md5($data['password']);
                    }else{
                        $admin->password = $current_p;
                    }
                
                    if(!empty($data['category_view_access'])){
                        $admin->category_view_access = $data['category_view_access'];
                    }else {
                        $admin->category_view_access = 0;
                    }
    
                    if(!empty($data['category_edit_access'])){
                        $admin->category_edit_access = $data['category_edit_access'];
                    }else {
                        $admin->category_edit_access = 0;
                    }
    
                    if(!empty($data['category_full_access'])){
                        $admin->category_full_access = $data['category_full_access'];
                        $admin->category_view_access = 1;
                        $admin->category_edit_access = 1;
                    }else {
                        $admin->category_full_access = 0;
                    }
                
                    if(!empty($data['brand_access'])){
                        $admin->brand_access = $data['brand_access'];
                    }else {
                        $admin->brand_access = 0;
                    }
                
                    if(!empty($data['product_access'])){
                        $admin->product_access = $data['product_access'];
                    }else {
                        $admin->product_access = 0;
                    }
                
                    if(!empty($data['order_access'])){
                        $admin->order_access = $data['order_access'];
                    }else {
                        $admin->order_access = 0;
                    }
                
                    if(!empty($data['user_access'])){
                        $admin->user_access = $data['user_access'];
                    }else {
                        $admin->user_access = 0;
                    }
                
                    $admin->status = $data['status'];
                
                    $admin->save();
                
                    return redirect()->back()->with('flash_message_success','Sub Admin Updated Successfully');
                }
            }
        
        $admin = Admin::findOrFail($id);
        return view('admin.admins.edit_admins', compact('admin'));
    }
}
