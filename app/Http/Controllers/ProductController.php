<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Product;
use Image;
use Illuminate\Support\Facades\Input;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Cart;
use Session;
use DB;

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

            if (empty($data['status'])) {
                $status = 0;
            }else {
                $status = 1;
            }

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
        $products = Product::orderBy('id','DESC')->get();
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

            if (empty($data['status'])) {
                $status = 0;
            }else {
                $status = 1;
            }
           
            $product->price = $data['price'];
            $product->image = $filename;
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
           $productAll = Product::whereIn('category_id', $cat_ids)->where('status',1)->get();
            $productAll = json_decode(json_encode($productAll));
        //    echo"<pre>";print_r($productAll);die;
       }else {
           // if url is subcategoru url
           $productAll = Product::where(['category_id' => $categoryDetails->id])->where('status',1)->get();
       }

      

       return view('user.products.listing',compact('categoryDetails','productAll','categories','brands'));
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

       $productAll = Product::where(['brand_id' => $brandDetails->id])->where('status',1)->get();

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
        $products = Product::with('brands','attributes')->where('id',$id)->first();
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
        $data = $request->all();
        // echo "<pre>";print_r($data);die;

        if (empty($data['user_email'])) {
            $data['user_email'] = '';
        }

        $session_id = Session::get('session_id');
        if(empty($session_id)){
            $session_id = str_random(30);
            Session::put('session_id',$session_id);
        }
        

        $sizeArr = explode("-",$data['size']);

        $countCarts = Cart::where(['product_id'=>$data['product_id'], 
        'product_color'=>$data['product_color'], 'size'=>$sizeArr[1], 'session_id'=>$session_id])->count();
        if ($countCarts>0) {
           return redirect()->back()->with('flash_message_error','Product Already exist');
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
        $session_id = Session::get('session_id');
        $userCart = DB::table('carts')->where(['session_id' => $session_id])->get();
        foreach ($userCart as $key => $product) {
          $products = Product::where('id',$product->product_id)->first();
          $userCart[$key]->image = $products->image;
        }
        // echo "<pre>";print_r($userCart);
        return view('user.cart.cart',compact('userCart'));
    }

    public function delete_cart($id)
    {
        $usercart = Cart::findOrFail($id);

        $usercart->delete();

        return redirect()->back()->with('flash_message_success','Cart Item Deleted Successfully');
    }

    public function update_quantity($id, $quantity)
    {
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
}
