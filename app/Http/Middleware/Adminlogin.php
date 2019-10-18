<?php

namespace App\Http\Middleware;

use App\Admin;
use Closure;
use Session;
use Illuminate\Support\Facades\Route;

class Adminlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty(Session::has('AdminSession'))) {
            return redirect('/admin_login');
        }else{
            //Get admin/sub admin details
            $aminDetails = Admin::where('username',Session::get('AdminSession'))->first();
            $aminDetails = json_decode(json_encode($aminDetails),true);
            if($aminDetails['type'] == 'Admin')
            {
                $aminDetails['category_view_access'] = 1;
                $aminDetails['category_edit_access'] = 1;
                $aminDetails['category_full_access'] = 1;
                $aminDetails['brand_access'] = 1;
                $aminDetails['product_access'] = 1;
                $aminDetails['order_access'] = 1;
                $aminDetails['user_access'] = 1;
            }
            Session::put('adminDetails', $aminDetails);
            //echo Session::get('adminDetails')['category_access'];die;
            //echo "<pre>";print_r(Session::get('adminDetails'));die;
            
            //Get Current coute
             $currentPath= Route::getFacadeRoot()->current()->uri();
            
            if ($currentPath == "admin/view-category" && Session::get('adminDetails')['category_view_access']==0)
            {
                return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
            }
    
            if ($currentPath == "admin/edit-category" && Session::get('adminDetails')['category_edit_access']==0)
            {
                return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
            }
    
            if ($currentPath == "admin/edit-category" && Session::get('adminDetails')['category_full_access']==0)
            {
                return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
            }
    
            if ($currentPath == "admin/view-brand" && Session::get('adminDetails')['brand_access']==0)
            {
                return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
            }
    
            if ($currentPath == "admin/view-product" && Session::get('adminDetails')['product_access']==0)
            {
                return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
            }
    
            if ($currentPath == "admin/view-orders" && Session::get('adminDetails')['order_access']==0)
            {
                return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
            }
    
            if ($currentPath == "admin/view-users" && Session::get('adminDetails')['user_access']==0)
            {
                return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
            }
            
        }
        return $next($request);
    }
}
