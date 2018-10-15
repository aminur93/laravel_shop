<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;

class BrandController extends Controller
{
    public function add_brand(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            
            $brand = new Brand();

            $brand->name = $data['brand_name'];
            $brand->description = $data['description'];
            $brand->url = $data['url'];

            $brand->save();

            return redirect('/admin/view-brand')->with('flash_message_success', 'Brand Added Successfully');
        }
        return view('admin.brand.add_brand');
    }

    public function view_brand()
    {
        $brands = Brand::get();
        return view('admin.brand.view_brand')->with(compact('brands'));
    }

    public function edit_brand(Request $request, $id)
    {
        if($request->isMethod('post')){

            $data = $request->all();

            $brand = Brand::findOrFail($id);

            $brand->name = $data['brand_name'];
            $brand->description = $data['description'];
            $brand->url = $data['url'];

            $brand->save();

            return redirect('/admin/view-brand')->with('flash_message_success', 'Brand Updated Successfully');
        }
        $brand = Brand::where('id',$id)->first();
        return view('admin.brand.edit_brand', compact('brand'));
    }

    public function delete_brand($id)
    {
        $brand = Brand::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success', 'Brand Deleted Successfully');
    }
}
