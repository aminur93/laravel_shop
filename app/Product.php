<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;
use DB;

class Product extends Model
{
    public function attributes()
    {
        return $this->hasMany('App\ProductsAttribute','product_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand','brand_id','id');
    }
    
    public static function cartCount()
    {
        if (Auth::check())
        {
            //user is loged in we will use auth
            $user_email = Auth::user()->email;
            $cartCount = DB::table('carts')->where('user_email',$user_email)->sum('quantity');
        }else{
            //user is not loged in we will use session
            $session_id = Session::get('session_id');
            $cartCount = DB::table('carts')->where('session_id',$session_id)->sum('quantity');
        }
        
        return $cartCount;
    }
    
    /**
     * @param $cat_id
     * @return mixed
     */
    public static function productCount($cat_id)
    {
        $catCount = Product::where(['category_id' => $cat_id, 'status' => 1])->count();
        //dd($catCount);exit;
        return $catCount;
    }
}
