<?php

namespace App\Http\Controllers;

use App\Banner;
use App\ShippingCharge;
use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
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

             //echo "<pre>";
             //print_r($data);die;

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
    
            if(!empty($data['weight'])){
                $product->weight = $data['weight'];
            }else {
                $product->weight = '';
            }
    
            if(!empty($data['sleeve'])){
                $product->sleeve = $data['sleeve'];
            }else {
                $product->sleeve = '';
            }
    
            if(!empty($data['pattern'])){
                $product->pattern = $data['pattern'];
            }else {
                $product->pattern = '';
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
            
            //upload video
            if ($request->hasFile('video'))
            {
                $video_temp = Input::file('video');
                
                $video_name = $video_temp->getClientOriginalName();
                $video_path = 'admin/videos/';
                $video_temp->move($video_path,$video_name);
                
                $product->video = $video_name;
                
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
        
        //sleeve drop down option
        $sleeveArray = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
        
        //pattern drop down option
        $patternArray = array('checked','plain','printed','self','solid');
        
       return view('admin.product.add_product', compact('brand','categories_dropdown','sleeveArray','patternArray'));
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
    
            //upload video
            if ($request->hasFile('video'))
            {
                $video_temp = Input::file('video');
        
                $video_name = $video_temp->getClientOriginalName();
                $video_path = 'admin/videos/';
                $video_temp->move($video_path,$video_name);
        
            }elseif (!empty($data['current_video'])){
                 $video_name = $data['current_video'];
            }else{
                $video_name = '';
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
    
            if(!empty($data['weight'])){
                $product->weight = $data['weight'];
            }else {
                $product->weight = '';
            }
    
            if(!empty($data['sleeve'])){
                $product->sleeve = $data['sleeve'];
            }else {
                $product->sleeve = '';
            }
    
            if(!empty($data['pattern'])){
                $product->pattern = $data['pattern'];
            }else {
                $product->pattern = '';
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
            $product->video = $video_name;
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
    
        //sleeve drop down option
        $sleeveArray = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
    
        //pattern drop down option
        $patternArray = array('checked','plain','printed','self','solid');

        return view('admin.product.edit_product',
            compact('product','categories_dropdown','brand_down','sleeveArray','patternArray'));
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
    
    public function delete_product_video($id)
    {
        
        $product = Product::where(['id' => $id])->first();
        
        $video_path = public_path().'/admin/videos/'.$product->video;
        
        unlink($video_path);
    
        Product::where(['id' => $id])->update(['video' => '']);
        return redirect()->back()->with('falsh_message_success', 'Product Video Has Been Deleted');
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

    public function products($url=null)
    {
        //return $url;
        //show 404 page when category url is not found
        $countCategory = Category::where(['url' => $url, 'status' => 1])->count();
        if ($countCategory == 0) {
            abort(404);
        }
         //get all brands
         $brands = Brand::get();
    
        //get all banners
        $banners = Banner::where('status',1)->get();

        //get all categories and sub categories
        $categories = Category::with('cate')->where(['parent_id' => 0])->get();

       $categoryDetails = Category::where(['url' => $url])->first();

       if ($categoryDetails->parent_id == 0) {
           // if url is main category url
           $subCategories = Category::where(['parent_id' => $categoryDetails->id])->get();
           $subCategories = json_decode(json_encode($subCategories));
           foreach ($subCategories as $subcat) {
               $cat_ids[] = $subcat->id;
               //dd($cat_ids);
           }
           $productAll = Product::whereIn('category_id', $cat_ids)->where('status',1)->orderBy('id','DESC');
           $breadcrumb = "<a href='/'>Home</a> / <a href='".$categoryDetails->url."'>".$categoryDetails->name."</a>";
       }else {
           // if url is subcategoru url
           $productAll = Product::where(['category_id' => $categoryDetails->id])->where('status',1)->orderBy('id','DESC');
           $mainCategory = Category::where('id',$categoryDetails->parent_id)->first();
           
           $breadcrumb = "<a href='/'>Home</a> / <a href='".$mainCategory->url."'>".$mainCategory->name."</a>
            / <a href='".$categoryDetails->url."'>".$categoryDetails->name."</a>";
       }
       
       if (!empty($_GET['color']))
       {
           $colorArray = explode('-', $_GET['color']);
           $productAll = Product::whereIn('product_color',$colorArray);
       }
    
        if (!empty($_GET['sleeve']))
        {
            $sleeveArray = explode('-', $_GET['sleeve']);
            $productAll = Product::whereIn('sleeve',$sleeveArray);
        }
    
        if (!empty($_GET['pattern']))
        {
            $patternArray = explode('-', $_GET['pattern']);
            $productAll = Product::whereIn('pattern',$patternArray);
        }
    
        if (!empty($_GET['size']))
        {
            $sizeArray = explode('-', $_GET['size']);
            $productAll = DB::table('products')
                          ->select('products.*','products_attributes.product_id','products_attributes.size')
                          ->groupBy('products_attributes.product_id')
                          ->join('products_attributes','products.id','=','products_attributes.product_id')
                         ->whereIn('products_attributes.size',$sizeArray);
        }
       
       $productAll = $productAll->paginate(9);
       
       //$colorArray = array('black','blue','brown','bold','orange','pink','purple','red','silver','white','yellow','green');
        
        $colorArray = Product::select('product_color')->groupBy('product_color')->get();
        $colorArray = array_flatten(json_decode(json_encode($colorArray),true));
    
        $sleeveArray = Product::select('sleeve')->where('sleeve','!=','')->groupBy('sleeve')->get();
        $sleeveArray = array_flatten(json_decode(json_encode($sleeveArray),true));
    
        $patternArray = Product::select('pattern')->where('pattern','!=','')->groupBy('pattern')->get();
        $patternArray = array_flatten(json_decode(json_encode($patternArray),true));
        
        $sizeArray = ProductsAttribute::select('size')->where('size','!=','')->groupBy('size')->get();
        $sizeArray = array_flatten(json_decode(json_encode($sizeArray), true));
        //dd($sizeArray);
       
       return view('user.products.listing')
           ->with(compact('categoryDetails','productAll','categories','brands','url',
               'colorArray','sleeveArray','patternArray','sizeArray','breadcrumb','banners'));
    }
    
    public function filter(Request $request)
    {
        $data = $request->all();
        //echo "<pre>"; print_r($data);exit;
        
        $colorUrl = '';
        if(!empty($data['colorFilters']))
        {
            foreach ($data['colorFilters'] as $color)
            {
                if (empty($colorUrl))
                {
                    $colorUrl = "&color=".$color;
                }else{
                    $colorUrl .= '-'.$color;
                }
            }
        }
    
        $sleeveUrl = '';
        if(!empty($data['sleeveFilters']))
        {
            foreach ($data['sleeveFilters'] as $sleeve)
            {
                if (empty($sleeveUrl))
                {
                    $sleeveUrl = "&sleeve=".$sleeve;
                }else{
                    $sleeveUrl .= '-'.$sleeve;
                }
            }
        }
    
        $patternUrl = '';
        if(!empty($data['patternFilters']))
        {
            foreach ($data['patternFilters'] as $pattern)
            {
                if (empty($patternUrl))
                {
                    $patternUrl = "&pattern=".$pattern;
                }else{
                    $patternUrl .= '-'.$pattern;
                }
            }
        }
    
        $sizeUrl = '';
        if(!empty($data['sizeFilters']))
        {
            foreach ($data['sizeFilters'] as $size)
            {
                if (empty($sizeUrl))
                {
                    $sizeUrl = "&size=".$size;
                }else{
                    $sizeUrl .= '-'.$size;
                }
            }
        }
        
        $finalUrl = "user/products/".$data['url']."?".$colorUrl.$sleeveUrl.$patternUrl.$sizeUrl;
        
        return redirect::to($finalUrl);
    }
    
    public function search_products(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
//            echo "<pre>"; print_r($data);die;
            
            $categories = Category::with('cate')->where(['parent_id' => 0])->get();
    
            $brands = Brand::get();
    
            //get all banners
            $banners = Banner::where('status',1)->get();
            
            $search_product = $data['product'];
            
//            $productAll = Product::where('product_name','like','%'.$search_product.'%')
//                          ->orwhere('product_code',$search_product)
//                           ->where('status',1)->paginate();
            
            $productAll = Product::where(function ($query) use ($search_product){
                $query->where('product_name','like','%'.$search_product.'$')
                       ->orwhere('product_code','like','%'.$search_product.'%')
                      ->orwhere('product_color','like','%'.$search_product.'%')
                     ->orwhere('description','like','%'.$search_product.'%');
            })->where('status',1)->get();
    
            $breadcrumb = "<a href='/'>Home</a> /  ".$search_product;
            
            return view('user.products.listing',compact('search_product',
                'productAll','categories','brands','banners','breadcrumb'));
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
    
        //get all banners
        $banners = Banner::where('status',1)->get();

        //get all categories and sub categories
        $categories = Category::with('cate')->where(['parent_id' => 0])->get();

       $brandDetails = Brand::where(['url' => $url])->first();

       $productAll = Product::where(['brand_id' => $brandDetails->id])->where('status',1)->paginate(4);

       return view('user.products.brand_listing',compact('productAll','categories','brands','brandDetails','url','banners'));
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
        $meta_title = $products->product_name;
        $meta_description = $products->description;
        $meta_keyword = $products->product_code;
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
    
        $categoryDetails = Category::where('id', $products->category_id )->first();
    
        if ($categoryDetails->parent_id == 0) {
            $breadcrumb = "<a href='/'>Home</a> / <a href='".$categoryDetails->url."'>".$categoryDetails->name."</a> / ".$products->product_name;
        }else {
            $mainCategory = Category::where('id',$categoryDetails->parent_id)->first();
        
            $breadcrumb = "<a href='/' style='color: #333333;'>Home</a> / <a href='".$mainCategory->url."'>".$mainCategory->name."</a>
            / <a href='/user/products/".$categoryDetails->url."'>".$categoryDetails->name."</a> / ".$products->product_name;
        }

         $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');

        return view('user.details.product_details', compact('relatedProducts',
            'total_stock','products','brands','categories','productAltimages',
            'meta_title','meta_description','meta_keyword','breadcrumb'));
    }

    public function getProductPrice(Request $request)
    {
        $data = $request->all();
        // echo"<pre>";print_r($data);die;
        $proArr = explode("-",$data['idSize']);
        $proAttr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        
        $getCurrencyRates = Product::getCurrencyRate($proAttr->price);
        
        echo $proAttr->price."-".$getCurrencyRates['USD_Rate']."-".$getCurrencyRates['EURO_Rate'];
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
    
            //pincode check
            $pincode_count = DB::table('pincodes')->where('pincode',$data['shipping_pincode'])->count();
    
            if ($pincode_count == 0)
            {
                return redirect()->back()->with('flash_message_error','your location is not avaiable for delivery, place chose another location');
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
        $total_weight = 0;
        
        foreach ($userCart as $key => $product) {
          $products = Product::where('id',$product->product_id)->first();
          $userCart[$key]->image = $products->image;
          $total_weight = $total_weight + $products->weight;
        }
        
        //cod pincode check
        $cod_pincode_count = DB::table('cod_pincodes')->where('cod_pincode',$shippingDetails->pincode)->count();
    
        //prepaid pincode check
        $prepaid_pincode_count = DB::table('prepaid_pincodes')->where('prepaid_pincode',$shippingDetails->pincode)->count();

        // Fetch shipping charges
         $shipping_charge = Product::getShippingCharges($total_weight,$shippingDetails->country);
        Session::put('ShippingCharges', $shipping_charge);
    
        return view('user.order.order_review',
            compact('userDetails','shippingDetails','country','userCart',
                'cod_pincode_count','prepaid_pincode_count','shipping_charge'));
    }

    public function placeOrder(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;
            
            //prevent out of stock products from orders
            $userCart = DB::table('carts')->where('user_email',$user_email)->get();
             foreach ($userCart as $cart)
             {
                 $getCountAttributes = Product::getCountAttributes($cart->product_id,$cart->size);
                 
                 if ($getCountAttributes == 0)
                 {
                     Product::deleteCartProduct($cart->product_id,$user_email);
                     return redirect('/user/cart')->with('flash_message_error','One of product size is not available in stock ! Remove from cart ! Please Try Another Product');
                 }
                 
                 $product_stock = Product::getProductStock($cart->product_id,$cart->size);
                 
                 if ($product_stock == 0)
                 {
                     Product::deleteCartProduct($cart->product_id,$user_email);
                     return redirect('/user/cart')->with('flash_message_error','One of product is sold out ! Remove from cart');
                 }
                 
                 if ($cart->quantity > $product_stock)
                 {
                     return redirect('/user/cart')->with('flash_message_error','Reduce product stock ! Please Try again');
                 }
                 
                 $product_status = Product::getProductStatus($cart->product_id);
                 if ($product_status == 0)
                 {
                     Product::deleteCartProduct($cart->product_id,$user_email);
                     return redirect('/user/cart')->with('flash_message_error','Product is Disabled Remove From Cart! Please Try Another Product');
                 }
                 
                 $getCategoryId = Product::select('category_id')->where('id',$cart->product_id)->first();
                 $category_status = Product::getCategoryStatus($getCategoryId->category_id);
                 if ($category_status == 0)
                 {
                     Product::deleteCartProduct($cart->product_id,$user_email);
                     return redirect('/user/cart')->with('flash_message_error','Product Catgeory is desable ! Product Remove from cart ! Please Try Another Product');
                 }
             }

            //Get Shipping details from user
            $shippingDetails = DeliveryAddress::where(['user_email' => $user_email])->first();
            
            //pincode check
            $pincode_count = DB::table('pincodes')->where('pincode',$shippingDetails->pincode)->count();
            
            if ($pincode_count == 0)
            {
                return redirect()->back()->with('flash_message_error','your location is not avaiable for delivery, place chose another location');
            }

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
            $order->shipping_charge = Session::get('ShippingCharges');
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
                
                $getProductStock = ProductsAttribute::where('sku', $pro->product_code)->first();
                $newStock = $getProductStock->stock - $pro->quantity;
                if ($newStock < 0)
                {
                    $newStock = 0;
                }
                ProductsAttribute::where('sku',$pro->product_code)->update(['stock'=>$newStock]);
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
        if(Session::get('adminDetails')['product_access'] == 0)
        {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
        }
        
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
    
    public function checkPincode(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
            //echo "<pre>"; print_r($data);die;
            echo $pincode_count = DB::table('pincodes')->where('pincode',$data['pincode'])->count();
            
//            if ($pincode_count > 0)
//            {
//                echo "This Pincode is available for delivery";
//            }else{
//                echo "This Pincode is not available for delivery";
//            }
        }
    }
    
}
