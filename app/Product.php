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
    
    public static function getCurrencyRate($price)
    {
        $getCurrency = Currency::where('status',1)->get();
        
        foreach ($getCurrency as $currency)
        {
            if ($currency->currency_code == 'USD')
            {
                $USD_Rate = round($price/$currency->exchange_rate,2);
            }elseif ($currency->currency_code == 'EURO')
            {
                $EURO_Rate = round($price/$currency->exchange_rate,2);
            }
        }
        
        $currencyArr = array('USD_Rate'=>$USD_Rate, 'EURO_Rate'=>$EURO_Rate);
        return $currencyArr;
    }
    
    public static function getProductStock($product_id,$product_size)
    {
        $getProductStock = ProductsAttribute::select('stock')->where(['product_id'=>$product_id, 'size'=>$product_size])->first();
        return $getProductStock->stock;
    }
    
    public static function deleteCartProduct($product_id,$user_email)
    {
        DB::table('carts')->where(['product_id'=>$product_id,'user_email'=>$user_email])->delete();
    }
    
    public static function getProductStatus($product_id)
    {
        $getProductStatus = Product::select('status')->where('id',$product_id)->first();
        return $getProductStatus->status;
    }
    
    public static function getCategoryStatus($category_id)
    {
        $getCategoryStatus = Category::select('status')->where('id',$category_id)->first();
        return $getCategoryStatus->status;
    }
    
    public static function getCountAttributes($product_id, $product_size)
    {
        $getCountAttributes = ProductsAttribute::select('stock')->where(['product_id'=>$product_id, 'size'=>$product_size])->count();
        return $getCountAttributes;
    }
    
    public static function getShippingCharges($country)
    {
        $shippingDetails = ShippingCharge::where('country',$country)->first();
        $shipping_charges = $shippingDetails->shipping_charges;
        return $shipping_charges;
    }
}
