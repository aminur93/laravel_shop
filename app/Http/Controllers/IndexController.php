<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;
use App\Banner;

class IndexController extends Controller
{
    public function index()
    {
        //In Asending Order by(default)
        $productAlls = Product::get();

        //In Desending Order By
        $productAll = Product::orderBy('id','DESC')->get();

        //In random Order
        $productAll = Product::inRandomOrder()->where('status',1)->where('feature_item',1)->paginate(9);

        //get all categories and sub categories
        $categories = Category::with('cate')->where(['parent_id' => 0])->get();
        // $categories = json_decode(json_encode($categories));
        // echo"<pre>";print_r($categories);die;

        // $categories_menu = "";
        // foreach ($categories as $key => $cat) {
        // $categories_menu.= "<div class='panel-heading'>
        //         <h4 class='panel-title'>
        //             <a data-toggle='collapse' data-parent='#accordian' href='#".$cat->id."'>
        //                 <span class='badge pull-right'><i class='fa fa-plus'></i></span>
        //                 ".$cat->name."
        //             </a>
        //         </h4>
        //     </div>
        //     <div id='".$cat->id."' class='panel-collapse collapse'>
        //         <div class='panel-body'>
        //             <ul>";
        //             $sub_categories = Category::where(['parent_id' =>$cat->id])->get();

        //             foreach ($sub_categories as $sub_cat) {
        //                 $categories_menu.= "<li><a href='".$sub_cat->url."'>".$sub_cat->name." </a></li>";
        //             }
                       
        //             $categories_menu.= "</ul>
        //         </div>
        //     </div>";  
        // }

        //get all brands
        $brands = Brand::with('products')->get();

        //get all banners
        $banners = Banner::where('status',1)->get();
        
        //meta tag
        $meta_title = "E-shop Sample Website";
        $meta_description = "Online Shopping site for men and women and kids clothing";
        $meta_keyword = "eshop website,online shopping,men clothing";

        return view('index',
            compact('productAll','categories','brands',
                'banners','meta_title','meta_description','meta_keyword'));
    }
}
