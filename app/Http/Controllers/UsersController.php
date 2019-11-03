<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Country;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

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

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $userStatus = User::where('email',$data['email'])->first();
                if ($userStatus->status == 0)
                {
                    return redirect()->back()->with('flash_message_error', 'Your Account is not active!! please check email & activate account');
                }
                Session::put('UserSession',$data['email']);
                
                if (!empty(Session::get('session_id'))){
    
                    $session_id = Session::get('session_id');
                    Cart::where('session_id', $session_id)->update(['user_email' => $data['email']]);
                }
    
    
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
                date_default_timezone_set('Asia/Dhaka');
                $user->created_at = date('Y-m-d H:i:s');
                $user->updated_at = date('Y-m-d H:i:s');
                $user->save();
    
                //send welcome email
//                $email = $data['email'];
//                $messageData = ['email' => $data['email'], 'name' => $data['name']];
//                Mail::send('email.register',$messageData,function ($message) use($email){
//                    $message->to($email)->subject('Registration with E-com Website');
//                });
                
                //send confirmation email
                $email = $data['email'];
                $messageData = ['email' => $data['email'], 'name' => $data['name'],
                    'code' => base64_encode($data['email'])];
                Mail::send('email.confirmation',$messageData,function ($message) use($email){
                    $message->to($email)->subject('Confirm Your E-com Account');
                });
    
                return redirect()->back()->with('flash_message_success', 'Please check your email to activate your account');
                
                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    Session::put('UserSession',$data['email']);
    
                    if (!empty(Session::get('session_id'))){
        
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_email' => $data['email']]);
                    }
                    
                    return redirect('/user/cart');
                }
            }

        }
    }
    
    public function confirmAccount($email)
    {
         $email = base64_decode($email);
         $userCount = User::where('email',$email)->count();
         if ($userCount > 0)
         {
             $userDetails = User::where('email',$email)->first();
             if ($userDetails->status == 1)
             {
                 return redirect('/user/login-register')->with('flash_message_success','Your Account is Already Activate You can login now!!');
             }else{
                  User::where('email',$email)->update(['status' => 1]);
                  
                  //send welcome email
                $messageData = ['email' => $email, 'name' => $userDetails->name];
                Mail::send('email.welcome',$messageData,function ($message) use($email){
                   $message->to($email)->subject('Welcome to E-com Website');
                });
                
                 return redirect('/user/login-register')->with('flash_message_success','Your Account has been Activated Successfully!!');
             }
         }else{
             abort(404);
         }
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('UserSession');
        Session::forget('session_id');
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
    
    public function viewUsers()
    {
        if(Session::get('adminDetails')['user_access'] == 0)
        {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
        }
        $users = User::all();
        return view('admin.users.view_users',compact('users'));
    }
    
    public function delete_user($id)
    {
        if(Session::get('adminDetails')['user_access'] == 0)
        {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
        }
        $user = User::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success', 'User Deleted Successfully');
    }
    
    public function user_forget_password(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
//            echo "<pre>"; print_r($data);die;
            $userCount = User::where('email',$data['email'])->count();
            if ($userCount == 0)
            {
                return redirect()-back()->with('flash_message_error','Email Does not Exist!!');
            }
            
            //Get user details
            $userDetails = User::where('email',$data['email'])->first();
            
            //generate random password
            $random_password = str_random(8);
            
            //Encode secure password
            $new_password = bcrypt($random_password);
            
            //Update new password
            User::where('email',$data['email'])->update(['password'=>$new_password]);
            
            //send forget email password
            $email = $data['email'];
            $name = $userDetails->name;
            $messageData = [
                'email'=>$email,
                'name' => $name,
                'password'=>$random_password
            ];
            Mail::send('email.forget_password',$messageData,function ($message) use ($email){
                $message->to($email)->subject('New Password E-com Website');
            });
            
            return redirect('/user/login-register')->with('flash_message_success','Please check your email for new password');
        }
        return view('user.register.forget_password');
    }
    
    public function exportUsers()
    {
        $usersData = User::select('id','name','email','address','city','state','country','pincode','mobile','created_at')
                           ->where('status',1)
                           ->orderBy('id','desc')
                           ->get();
        $usersData = json_decode(json_encode($usersData),true);
        
        return Excel::create('users'.rand(),function ($excel) use($usersData){
            $excel->sheet('mysheet',function ($sheet) use ($usersData){
                $sheet->fromArray($usersData);
            });
        })->download('xlsx');
    }
}
