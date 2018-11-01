<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Country;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function user_login()
    {
        return view('user.register.login_register');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'admin' => 0])) {
                Session::put('UserSession',$data['email']);
                return redirect('/user/cart');
            }else {
                return redirect()->back()->with('flash_message_error', 'Email and Password is Wrong');
            }
        }
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //  echo "<pre>";print_r($data);die;
            
             //check if user already exist
            $userCount = User::where('email', $data['email'])->count();

            if ($userCount>0) {
                return redirect()->back()->with('flash_message_error', 'Email Already exist');
            }else {
                $user = new User();
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);

                $user->save();
                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    Session::put('UserSession',$data['email']);
                    return redirect('/user/cart');
                }
            }

        }
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('UserSession');
        return redirect('/');
    }

    public function check_email(Request $request)
    {
        $data = $request->all();
          //check if user already exist
          $userCount = User::where('email', $data['email'])->count();

          if ($userCount>0) {
              echo "false";
          }else {
              echo "true";
          }
    }

    public function account(Request $request)
    {
        $user_id = Auth::user()->id;
        $userDetails = User::findOrFail($user_id);
        $countries = Country::get();
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo"<pre>";print_r($data);die;

            if (empty($data['name'])) {
                return redirect()->back()->with('flash_message_error','Please enter your name to update details');
            }

            if (empty($data['address'])) {
                $data['address'] = '';
            }

            if (empty($data['city'])) {
                $data['city'] = '';
            }

            if (empty($data['state'])) {
                $data['state'] = '';
            }

            if (empty($data['country'])) {
                $data['country'] = '';
            }

            if (empty($data['pincode'])) {
                $data['pincode'] = '';
            }

            if (empty($data['mobile'])) {
                $data['mobile'] = '';
            }


            $user = User::findOrFail($user_id);
            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];

            $user->save();

            return redirect('/user/user-account')->with('flash_message_success','User Account Updated Successfully');
        }
        return view('user.account.user_account',compact('countries','userDetails'));
    }

    public function ChkUserPassword(Request $request)
    {
        $data = $request->all();
        // echo "<pre>";print_r($data);die;
        $current_password = $data['current_pwd'];
        $user_id = Auth::user()->id;
        $check_password = User::where('id',$user_id)->first();
        if (Hash::check($current_password, $check_password->password)) {
            echo "true";die;
        }else {
            echo "false";die;
        } 
    }

    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo"<pre>";print_r($data);die;
            $old_pwd = User::where('id',Auth::user()->id)->first();
            $current_pwd = $data['current_pwd'];
            if (Hash::check($current_pwd, $old_pwd->password)) {
                //update password

                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id',Auth::user()->id)->update(['password' => $new_pwd]);
                return redirect()->back()->with('flash_message_success',' password is Updated Successfully');

            }else {
                return redirect()->back()->with('flash_message_error','Current password is Incorrect');
            }
        }
    }
}
