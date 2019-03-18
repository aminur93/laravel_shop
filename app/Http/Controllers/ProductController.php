<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\Mail;
use Image;
use Illuminate\Support\Facades\Input;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Cart;
use Session;
use DB;
use App\Cupon;
use App\Order;
use App\OrdersProduct;
use App\User;
use Auth;
use App\Country;
use App\DeliveryAddress;

class ProductController extends Controller
{
    public function add_product(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            // echo "<pre>";
            // print_r($data);die;

            if (empty($data['category_id'])) {
                return redirect()->back()->with('flash_message_error','Under category is missing');
            }elseif (empty($data['brand_id'])) {
                return redirect()->back()->with('flash_message_error','Brand is missing');
            }
            
            $product = new Product();

            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];

            if(!empty($data['description'])){
                $product->description = $data['description'];
            }else {
                $product->description = '';
            }

            if(!empty($data['care'])){
                $product->care = $data['care'];
            }else {
                $product->care = '';
            }
           
            $product->price = $data['price'];
            
            //upload image

            if($request->hasFile('image')){

                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extenson = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extenson;
                    $large_image_path = 'admin/products/large/'.$filename;
                    $medium_image_path = 'admin/products/medium/'.$filename;
                    $small_image_path = 'admin/products/small/'.$filename;

                    //Resize Image
                    Image::make($image_tmp)->resize(1200,1200)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                    //store product image in data table

                    $product->image = $filename;
                }
            }
    
            if (empty($data['feature_item'])) {
                $feature_item = 0;
            }else {
                $feature_item = 1;
            }

            if (empty($data['status'])) {
                $status = 0;
            }else {
                $status = 1;
            }
            
            $product->feature_item = $feature_item;

            $product->status = $status;

            $product->save();

            return redirect('/admin/view-product')->with('flash_message_success', 'Product Added Successfully');
        }

        //category drop down start
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option selected disabled>Select Category</option>";

        foreach($categories as $cat){
            $categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."<option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $categories_dropdown .= "<option value='".$sub_cat->id."'>&nbsp; --&nbsp;".$sub_cat->name."<option>";
            }
        }

        $brand = Brand::get();
       return view('admin.product.add_product', compact('brand','categories_dropdown'));
    }

    public function view_product()
    {
        $products = Product::latest()->get();
        foreach ($products as $key => $val) {
            $category_name = Category::where(['id' => $val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }

        foreach ($products as $key => $val) {
            $brand_name = Brand::where(['id' => $val->brand_id])->first();
            $products[$key]->brand_name = $brand_name->name;
        }
        return view('admin.product.view_product', compact('products'));
    }

    public function edit_product(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;

            //upload image

            if($request->hasFile('image')){

                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extenson = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extenson;
                    $large_image_path = 'admin/products/large/'.$filename;
                    $medium_image_path = 'admin/products/medium/'.$filename;
                    $small_image_path = 'admin/products/small/'.$filename;

                    //Resize Image
                    Image::make($image_tmp)->resize(1200,1200)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                }
            }else {
                $filename = $data['current_image'];
            }

            if (empty($data['category_id'])) {
                return redirect()->back()->with('flash_message_error','Under category is missing');
            }elseif (empty($data['brand_id'])) {
                return redirect()->back()->with('flash_message_error','Brand is missing');
            }
            
            $product = Product::findOrFail($id);

            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];

            if(!empty($data['description'])){
                $product->description = $data['description'];
            }else {
                $product->description = '';
            }

            if(!empty($data['care'])){
                $product->care = $data['care'];
            }else {
                $product->care = '';
            }
    
            if (empty($data['feature_item'])) {
                $feature_item = 0;
            }else {
                $feature_item = 1;
            }

            if (empty($data['status'])) {
                $status = 0;
            }else {
                $status = 1;
            }
           
            $product->price = $data['price'];
            $product->image = $filename;
            $product->feature_item = $feature_item;
            $product->status = $status;
            
            $product->save();

            return redirect('/admin/view-product')->with('flash_message_success', 'Product Updated Successfully');
        }

        $product = Product::where('id',$id)->first();

        //category drop down start
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option selected disabled>Select Category</option>";

        foreach($categories as $cat){
            if ($cat->id == $product->category_id) {
                $selected = "selected";
            }else {
                $selected = "";
            }
            $categories_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->name."<option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                if ($sub_cat->id == $product->category_id) {
                    $selected = "selected";
                }else {
                    $selected = "";
                }
                $categories_dropdown .= "<option value='".$sub_cat->id."' ".$selected.">&nbsp; --&nbsp;".$sub_cat->name."<option>";
            }
        }
        //Category drop down ends

        $brands = Brand::get();
        $brand_down = "<option selected disabled>Select Brand</option>";
        foreach ($brands as $brand) {
            if ($brand->id == $product->brand_id) {
                $selected = "selected";
            }else {
                $selected = "";
            }

            $brand_down .= "<option value='".$brand->id."' ".$selected.">".$brand->name."<option>";
        }

        return view('admin.product.edit_product', compact('product','categories_dropdown','brand_down'));
    }

    public function delete_product($id)
    {
        $product = Product::findOrFail($id);
        
        $image_path = public_path().'/admin/products/large/'.$product->image;
        $image_second = public_path().'/admin/products/medium/'.$product->image;
        $image_third = public_path().'/admin/products/small/'.$product->image;

        unlink($image_path);
        unlink($image_second);
        unlink($image_third);

        $product->delete();

        return redirect()->back()->with('flash_message_success', 'Product Data Deleted Successfully');
    }

    public function delete_product_image($id)
    {
        $product = Product::where(['id' => $id])->first();

        $image_path = public_path().'/admin/products/large/'.$product->image;
        $image_second = public_path().'/admin/products/medium/'.$product->image;
        $image_third = public_path().'/admin/products/small/'.$product->image;

        unlink($image_path);
        unlink($image_second);
        unlink($image_third);

        
        Product::where(['id' => $id])->update(['image' => '']);
        return redirect()->back()->with('falsh_message_success', 'Product Image Has Been Deleted');
    }

    public function add_attributes(Request $request, $id)
    {
        $product = Product::with('attributes')->where(['id' => $id])->first();
        //$product = json_decode(json_encode($product));
         //echo "<pre>";print_r($product); die;


        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data); die;

            foreach ($data['sku'] as $key => $val) {
                if (!empty($val)) {
                    //Prevnt Duplicate SKu check 
                    $attrSkuCount = ProductsAttribute::where('sku', $val)->count();
                    if ($attrSkuCount>0) {
                        return redirect('/admin/add-attributes/'.$id)->with('flash_message_error', 'SKU Already Exist! Please Add Another SKU');
                    }

                    //Prevent Duplicate Size Check
                    $attrCountSizes = ProductsAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();
                    if ($attrCountSizes>0) {
                        return redirect('/admin/add-attributes/'.$id)->with('flash_message_error', '"'.$data['size'][$key].'" Size Already Exist! Please Add Another Size');
                    }

                    $attribute = new ProductsAttribute();
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }

            return redirect('/admin/add-attributes/'.$id)->with('flash_message_success', 'Product Attributes Added Successfully');
        }
        return view('admin.product.add_attributes',compact('product'));
    }

    public function edit_attributes(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo"<pre>";print_r($data);die;

            foreach ($data['idAttr'] as $key => $attr) {
               $productAttr = ProductsAttribute::where(['id' => $data['idAttr'][$key]])
               ->update(['price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);
            }
            
            return redirect()->back()->with('flash_message_success', 'Product Attributes Updated Successfully');
        }
    }

    public function delete_attributes($id)
    {
        $product_attribute = ProductsAttribute::findOrFail($id);
        $product_attribute->delete();

        return redirect()->back()->with('flash_message_success','Product Attributes Deleted Successfully');

    }

    public function products($url)
    {
        //show 404 page when category url is not found
        $countCategory = Category::where(['url' => $url, 'status' => 1])->count();
        if ($countCategory == 0) {
            abort(404);
        }
         //get all brands
         $brands = Brand::get();

        //get all categories and sub categories
        $categories = Category::with('cate')->where(['parent_id' => 0])->get();

       $categoryDetails = Category::where(['url' => $url])->first();

       if ($categoryDetails->parent_id == 0) {
           // if url is main category url
           $subCategories = Category::where(['parent_id' => $categoryDetails->id])->get();
           foreach ($subCategories as $subcat) {
               $cat_ids[] = $subcat->id;
           }
           $productAll = Product::whereIn('category_id', $cat_ids)->where('status',1)->paginate(6);
            $productAll = json_decode(json_encode($productAll));
        //    echo"<pre>";print_r($productAll);die;
       }else {
           // if url is subcategoru url
           $productAll = Product::where(['category_id' => $categoryDetails->id])->where('status',1)->paginate(6);
       }

      

       return view('user.products.listing',compact('categoryDetails','productAll','categories','brands'));
    }
    
    public function search_products(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
//            echo "<pre>"; print_r($data);die;
            
            $categories = Category::with('cate')->where(['parent_id' => 0])->get();
    
            $brands = Brand::get();
            
            $search_product = $data['product'];
            
            $productAll = Product::where('product_name','like','%'.$search_product.'%')
                          ->orwhere('product_code',$search_product)
                           ->where('status',1)->get();
            return view('user.products.listing',compact('search_product','productAll','categories','brands'));
        }
    }

    public function brand($url)
    {
        //show 404 page when brand url is not found
        $countBrand = Brand::where(['url' => $url])->count();
        if ($countBrand == 0) {
            abort(404);
        }
        
        //get all brands
        $brands = Brand::get();

        //get all categories and sub categories
        $categories = Category::with('cate')->where(['parent_id' => 0])->get();

       $brandDetails = Brand::where(['url' => $url])->first();

       $productAll = Product::where(['brand_id' => $brandDetails->id])->where('status',1)->paginate(4);

       return view('user.products.brand_listing',compact('productAll','categories','brands','brandDetails'));
    }

    public function product_details($id)
    {
        //show 404 page
        $productCount = Product::where(['id' => $id, 'status' => 1])->count();
        if ($productCount == 0) {
            abort(404);
        }
         //get all brands
         $brands = Brand::get();

         //get all categories and sub categories
         $categories = Category::with('cate')->where(['parent_id' => 0])->get();

         //get details product
        $products = Product::with('brand','attributes')->where('id',$id)->first();
        $products = json_decode(json_encode($products));
        // echo "<pre>";print_r($products);die;

         //realted products
         $relatedProducts = Product::where('id', '!=', $id)->where(['category_id' =>  $products->category_id])->where('status',1)->get();
        //  $relatedProducts = json_decode(json_encode($relatedProducts));
        //  echo "<pre>";print_r($relatedProducts);die;

        // foreach($relatedProducts->chunk(3) as $chunk){
        //     foreach ($chunk as $item) {
        //         echo $item; echo "<br>";
        //     }
        //     echo "<br><br><br>";
        // }
    
        //product alternet image
        $productAltimages = ProductsImage::where('product_id',$id)->get();
        // $productAltimages = json_decode(json_encode($productAltimages));
        // echo "<pre>";print_r($productAltimages);die;

         $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');

        return view('user.details.product_details', compact('relatedProducts','total_stock','products','brands','categories','productAltimages'));
    }

    public function getProductPrice(Request $request)
    {
        $data = $request->all();
        // echo"<pre>";print_r($data);die;
        $proArr = explode("-",$data['idSize']);
        $proAttr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();

        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;
    }

    public function add_attributes_image(Request $request, $id)
    {
        $product = Product::with('attributes')->where(['id' => $id])->first();

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo"<pre>";print_r($data);die;
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                foreach ($files as $file) {
                    $image = new ProductsImage();
                    $extenson = $file->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extenson;
                    $large_image_path = 'admin/products/large/'.$filename;
                    $medium_image_path = 'admin/products/medium/'.$filename;
                    $small_image_path = 'admin/products/small/'.$filename;
    
                     //Resize Image
                     Image::make($file)->resize(1200,1200)->save($large_image_path);
                     Image::make($file)->resize(600,600)->save($medium_image_path);
                     Image::make($file)->resize(300,300)->save($small_image_path);

                     $image->product_id = $data['product_id'];
                     $image->image = $filename;
                    
                     $image->save();
                }
               
            }
            return redirect('/admin/add-image/'.$id)->with('flash_message_success','Multiple Images Added Successfully');
        }

        $product_Images = ProductsImage::where(['product_id' => $id])->get();
        return view('admin.product.add_image', compact('product','product_Images'));
    }

    public function delete_image($id)
    {
        $productimages = ProductsImage::where(['id' => $id])->first();

        $image_path = public_path().'/admin/products/large/'.$productimages->image;
        $image_second = public_path().'/admin/products/medium/'.$productimages->image;
        $image_third = public_path().'/admin/products/small/'.$productimages->image;

        unlink($image_path);
        unlink($image_second);
        unlink($image_third);

        $productimages->delete();

        return redirect()->back()->with('falsh_message_success', 'Product Image Has Been Deleted');
    }

    public function add_cart(Request $request)
    {
        Session::forget('couponAmount');
        Session::forget('coupon_code');
        $data = $request->all();
        // echo "<pre>";print_r($data);die;
        
        //check products stock is available or not
        $product_size = explode('-',$data['size']);
        $getProductStock = ProductsAttribute::where(['product_id' => $data['product_id'], 'size' => $product_size[1]])->first();
        if ($getProductStock->stock < $data['quantity'])
        {
            return redirect()->back()->with('flash_message_error','Required Quantity is not available');
        }
        
        if (empty(Auth::user()->email)) {
            $data['user_email'] = '';
        }else {
            $data['user_email'] = Auth::user()->email;
        }

        $session_id = Session::get('session_id');
        if(empty($session_id)){
            $session_id = str_random(30);
            Session::put('session_id',$session_id);
        }
        

        $sizeArr = explode("-",$data['size']);
        
        if (empty(Auth::check()))
        {
            $countCarts = Cart::where(['product_id'=>$data['product_id'],
                'product_color'=>$data['product_color'], 'size'=>$sizeArr[1], 'session_id'=>$session_id])->count();
            if ($countCarts>0) {
                return redirect()->back()->with('flash_message_error','Product Already exist');
            }
    
        }else{
            $countCarts = Cart::where(['product_id'=>$data['product_id'],
                'product_color'=>$data['product_color'], 'size'=>$sizeArr[1], 'user_email'=>$data['user_email']])->count();
            if ($countCarts>0) {
                return redirect()->back()->with('flash_message_error','Product Already exist');
            }
        }
    
    
        $getSku = ProductsAttribute::select('sku')->where(['product_id'=>$data['product_id'], 'size'=>$sizeArr[1]])->first();
            
        $cart = new Cart();

        $cart->product_id = $data['product_id'];
        $cart->product_name = $data['product_name'];
        $cart->product_code = $getSku->sku;
        $cart->product_color = $data['product_color'];
        $cart->price = $data['price'];
        $cart->size =  $sizeArr[1];
        $cart->quantity = $data['quantity'];
        $cart->user_email = $data['user_email'];
        $cart->session_id = $session_id;

        $cart->save();

        return redirect('/user/cart')->with('flash_message_success','Product Item Add To Cart Successfully');
    }

    public function cart()
    {
        if (Auth::check()) {
            $user_email = Auth::user()->email;
            $userCart = DB::table('carts')->where(['user_email' => $user_email])->get();
        }else {
            $session_id = Session::get('session_id');
            $userCart = DB::table('carts')->where(['session_id' => $session_id])->get();
        }
        foreach ($userCart as $key => $product) {
          $products = Product::where('id',$product->product_id)->first();
          $userCart[$key]->image = $products->image;
        }
        // echo "<pre>";print_r($userCart);
        return view('user.cart.cart',compact('userCart'));
    }

    public function delete_cart($id)
    {
        Session::forget('couponAmount');
        Session::forget('coupon_code');
        $usercart = Cart::findOrFail($id);

        $usercart->delete();

        return redirect()->back()->with('flash_message_success','Cart Item Deleted Successfully');
    }

    public function update_quantity($id, $quantity)
    {
        Session::forget('couponAmount');
        Session::forget('coupon_code');
        $getCartDetails = DB::table('carts')->where('id',$id)->first();
        $getAttributesStock = ProductsAttribute::where('sku',$getCartDetails->product_code)->first();
        echo $getAttributesStock->stock;
        $updated_quantity = $getCartDetails->quantity+$quantity;
        if ($getAttributesStock->stock >= $updated_quantity) {
            DB::table('carts')->where('id',$id)->increment('quantity',$quantity);
            return redirect()->back()->with('flash_message_success','Product Quantity Updated');
        }else {
            return redirect()->back()->with('flash_message_error','Stock Is Out');
        }
        
    }

    public function apply_coupons(Request $request)
    {
        Session::forget('couponAmount');
        Session::forget('coupon_code');

        $data = $request->all();
        // echo"<pre>";print_r($data);die;
        $couponCount = Cupon::where('coupon_code',$data['coupon_code'])->count();
        if ($couponCount == 0) {
            return redirect()->back()->with('flash_message_error','Coupon is not Valid');
        }else {
            //Get coupon details
           $couponDetails = Cupon::where('coupon_code',$data['coupon_code'])->first();

           //if coupon is inactive
           if ($couponDetails->status == 0) {
               return redirect()->back()->with('flash_message_error','Coupon is not Active');
           }

           //is coupon expire date
             $expire_date = $couponDetails->expire_date;
             $current_date = date('Y-m-d');
             if ($expire_date < $current_date) {
                 return redirect('/user/cart')->with('flash_message_error','This Coupon is Expired');
             }

             //coupon is valid for discount

             //Get cart total amount 
             $session_id = Session::get('session_id');
             $userCart = DB::table('carts')->where(['session_id' => $session_id])->get();
             $total_amount = 0;
             foreach ($userCart as $item) {
              $total_amount = $total_amount + ($item->price * $item->quantity);
             }

             //check if amount type is fixed or percentage
             if ($couponDetails->amount_type == "Fixed") {
                 $couponAmount = $couponDetails->amount;
             }else {
                 $couponAmount = $total_amount * ($couponDetails->amount/100);
             }

             //Add Coupon Code & Amount in Session
             Session::put('couponAmount',$couponAmount);
             Session::put('coupon_code',$data['coupon_code']);

             return redirect()->back()->with('flash_message_success','Coupon Code is Successfully Applied. You Are Availing for Discount');
        }
    }

    public function checkout(Request $request)
    {
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::find($user_id);
        $country = Country::get();

        //check if shipping address exist
        $shipping_count = DeliveryAddress::where('user_id',$user_id)->count();
        $shippingDetails = array();
        if ($shipping_count > 0) {
            $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        }

        //Update cart table
        $session_id = Session::get('session_id');
        DB::table('carts')->where(['session_id' => $session_id])->update(['user_email' => $user_email]);

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;

            //Return to check page if any field empty
            if (empty($data['billing_name']) || empty($data['billing_address']) || 
            empty($data['billing_city']) || empty($data['billing_state']) || empty($data['billing_country']) ||
            empty($data['billing_pincode']) || empty($data['billing_mobile']) || empty($data['shipping_name']) ||
            empty($data['shipping_address']) || empty($data['shipping_city']) || empty($data['shipping_state']) ||
            empty($data['shipping_country']) || empty($data['shipping_pincode']) || empty($data['shipping_mobile'])) {

                return redirect()->back()->with('flash_message_error','Field Must Not Be Empty');
            }

            //user data update

            $user = User::findOrFail($user_id);

            $user->name = $data['billing_name'];
            $user->address = $data['billing_address'];
            $user->city = $data['billing_city'];
            $user->state = $data['billing_state'];
            $user->country = $data['billing_country'];
            $user->pincode = $data['billing_pincode'];
            $user->mobile = $data['billing_mobile'];

            $user->save();

            if ($shipping_count > 0) {
                //Update shipping address
                DeliveryAddress::where('user_id',$user_id)->update(['name' => $data['shipping_name'], 
                'address' => $data['shipping_address'], 'city' => $data['shipping_city'], 'state' => $data['shipping_state'],
                'country' => $data['shipping_country'], 'pincode' => $data['shipping_pincode'], 'mobile' => $data['shipping_mobile']]);
            }else {
                //Add new shipping address
                $shippingNew = new DeliveryAddress;

                $shippingNew->user_id = $user_id;
                $shippingNew->user_email = $user_email;

                $shippingNew->name = $data['shipping_name'];
                $shippingNew->address = $data['shipping_address'];
                $shippingNew->city = $data['shipping_city'];
                $shippingNew->state = $data['shipping_state'];
                $shippingNew->country = $data['shipping_country'];
                $shippingNew->pincode = $data['shipping_pincode'];
                $shippingNew->mobile = $data['shipping_mobile'];

                $shippingNew->save();
            }
            return redirect('/user/order-review')->with('flash_message_success','Billing and Shipping Information Submitted Successfully');

        }

        return view('user.checkout.checkout', compact('userDetails','country','shippingDetails'));
    }

    public function orderReview(Request $request)
    {
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::where('id',$user_id)->first();
        $country = Country::get();
        $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        $shippingDetails = json_decode(json_encode($shippingDetails));
        $userCart = DB::table('carts')->where(['user_email' => $user_email])->get();
        foreach ($userCart as $key => $product) {
          $products = Product::where('id',$product->product_id)->first();
          $userCart[$key]->image = $products->image;
        }

        // echo"<pre>";print_r($userCart);die;

        return view('user.order.order_review', compact('userDetails','shippingDetails','country','userCart'));
    }

    public function placeOrder(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;

            //Get Shipping details from user
            $shippingDetails = DeliveryAddress::where(['user_email' => $user_email])->first();

            // echo "<pre>";print_r($data);die;
            if (empty(Session::get('coupon_code'))) {
               $coupon_code = '';
            }else {
                $coupon_code = Session::get('coupon_code');
            }

            if (empty(Session::get('couponAmount'))) {
                $coupon_amount = '';
            }else {
                $coupon_amount = Session::get('couponAmount');
            }

            $order = new Order;

            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $shippingDetails->name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->state = $shippingDetails->state;
            $order->pincode = $shippingDetails->pincode;
            $order->country = $shippingDetails->country;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = $coupon_code;
            $order->coupon_amount = $coupon_amount;
            $order->order_status = "New";
            $order->payment_method = $data['payment_method'];
            $order->grand_total = $data['grand_total'];

            $order->save();

            $order_id = DB::getPdo()->lastInsertId();

            $cartProducts = DB::table('carts')->where(['user_email' => $user_email])->get();

            foreach ($cartProducts as $pro) {
                $catpro = new OrdersProduct();

                $catpro->order_id = $order_id;
                $catpro->user_id = $user_id;
                $catpro->product_id = $pro->product_id;
                $catpro->product_code = $pro->product_code;
                $catpro->product_name = $pro->product_name;
                $catpro->product_size = $pro->size;
                $catpro->product_color = $pro->product_color;
                $catpro->product_price = $pro->price;
                $catpro->product_qty = $pro->quantity;
                $catpro->save();
            }

            Session::put('order_id', $order_id);
            Session::put('grand_total', $data['grand_total']);
            
            if($data['payment_method'] == "COD"){
                
                $productDetails = Order::with('orders')->where('id',$order_id)->first();
                $productDetails = json_decode(json_encode($productDetails),true);
//                echo "<pre>"; print_r($productDetails);die;
    
                $usersDetails = User::where('id',$user_id)->first();
                $usersDetails = json_decode(json_encode($usersDetails),true);
//                echo "<pre>"; print_r($usersDetails);die;
                
                /*code for order email start*/
                $email = $user_email;
                $messageData = [
                    'email' => $email,
                    'name' => $shippingDetails->name,
                    'order_id' => $order_id,
                    'productDetails' => $productDetails,
                    'usersDetails' => $usersDetails
                ];
                Mail::send('email.order',$messageData,function ($message) use ($email){
                    $message->to($email)->subject('Order Pleaced E-com Website');
                });
                /*code for order email end*/
                
                
                //cod - redirect
                return redirect('/user/thanks');
            }else{
                //paypal - redirect
                return redirect('/order/paypal');
            }
        }
    }

    public function thanks(Request $request)
    {
        $user_email = Auth::user()->email;
        DB::table('carts')->where(['user_email' => $user_email])->delete();
        return view('user.thanks.thank');
    }
    
    public function thanksPaypal(Request $request)
    {
        return view('user.order.thanks_paypal');
    }
    
    public function cancelPaypal()
    {
        return view('user.order.cancel_paypal');
    }
    
    public function paypal(Request $request)
    {
        $user_email = Auth::user()->email;
        DB::table('carts')->where(['user_email' => $user_email])->delete();
        return view('user.order.paypal');
    }

    public function userOrders()
    {
        $user_id = Auth::user()->id;
        $orders = Order::with('orders')->where('user_id',$user_id)->latest()->get();
        
        return view('user.order.users_order', compact('orders'));
    }

    public function OrdersDetails($order_id)
    {
        $user_id = Auth::user()->id;
        $ordersDetails = Order::with('orders')->where('id',$order_id)->first();
        $ordersDetails = json_decode(json_encode($ordersDetails));
        // echo "<pre>"; print_r($ordersDetails);die;
        return view('user.order.order_details', compact('ordersDetails'));
    }
    
    public function view_orders()
    {
        $orders = Order::with('orders')->latest()->get();
        $orders = json_decode(json_encode($orders));
        return view('admin.order.view_orders',compact('orders'));
    }
    
    public function view_orders_details($order_id)
    {
        $orderdetails = Order::with('orders')->where('id',$order_id)->first();
        $orderdetails = json_decode(json_encode($orderdetails));
//        echo "<pre>"; print_r($orderdetails);die;
        $user_id = $orderdetails->user_id;
        $userDetails = User::where('id',$user_id)->first();
        $userDetails = json_decode(json_encode($userDetails));
//        echo "<pre>"; print_r($userDetails);die;
        return view('admin.order.order_details',compact('orderdetails','userDetails'));
    }
    
    public function view_orders_invoice($order_id)
    {
        $orderdetails = Order::with('orders')->where('id',$order_id)->first();
        $orderdetails = json_decode(json_encode($orderdetails));
//        echo "<pre>"; print_r($orderdetails);die;
        $user_id = $orderdetails->user_id;
        $userDetails = User::where('id',$user_id)->first();
        $userDetails = json_decode(json_encode($userDetails));
//        echo "<pre>"; print_r($userDetails);die;
        return view('admin.order.order_invoice',compact('orderdetails','userDetails'));
    }
    
    public function UpdateOrderStatus(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
            Order::where('id',$data['order_id'])->update(['order_status' => $data['order_status']]);
            return redirect()->back()->with('flash_message_success', 'Order status Updated Successfully');
        }
    }
    
}
