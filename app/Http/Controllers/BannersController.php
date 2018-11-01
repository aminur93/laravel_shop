<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use Image;
use Illuminate\Support\Facades\Input;

class BannersController extends Controller
{
    public function add_banners(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo"<pre>";print_r($data);die;

            $banner = new Banner();

            $banner->title = $data['title'];
            $banner->link = $data['link'];

            if($request->hasFile('image')){

                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extenson = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extenson;
                    $banner_image_path = 'user/images/banners/'.$filename;

                    //Resize Image
                    Image::make($image_tmp)->resize(1140,340)->save($banner_image_path);

                    //store product image in data table
                    $banner->image = $filename;
                }
            }

            if (empty($data['status'])) {
                $status = 0;
            }else {
                $status = 1;
            }

            $banner->status = $status;

            $banner->save();

            return redirect('/admin/add-banners')->with('flash_message_success','Banners Image Added Successfully');
        }
        return view('admin.banners.add_banners');
    }

    public function view_banners()
    {
        $banners = Banner::where('status',1)->get();
        return view('admin.banners.view_banners', compact('banners'));
    }

    public function edit_banners(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;

            $banner = Banner::findOrFail($id);

            $banner->title = $data['title'];
            $banner->link = $data['link'];

            if($request->hasFile('image')){

                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extenson = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extenson;
                    $banner_image_path = 'user/images/banners/'.$filename;

                    //Resize Image
                    Image::make($image_tmp)->resize(1140,340)->save($banner_image_path);

                    //store product image in data table
                    $banner->image = $filename;
                }
            }

            if (empty($data['status'])) {
                $status = 0;
            }else {
                $status = 1;
            }

            $banner->status = $status;

            $banner->save();

            return redirect('/admin/view-banners')->with('flash_message_success','Banners Image Added Successfully');
        }
        $banners = Banner::where(['id' => $id, 'status' => 1])->first();
        return view('admin.banners.edit_banners',compact('banners'));
    }

    public function delete_image_banners($id)
    {
        $banner = Banner::where(['id' => $id])->first();

        $image_path = public_path().'/user/images/banners/'.$banner->image;

        unlink($image_path);

        $banner = Banner::where(['id' => $id])->update(['image' => '']);
        return redirect()->back()->with('flash_message_success', 'Banners Image Deleted Successfully');
    }

    public function delete_banners($id)
    {
        $banner = Banner::findOrFail($id);

        $image_path = public_path().'/user/images/banners/'.$banner->image;
        unlink($image_path);

        $banner->delete();
        
        return redirect()->back()->with('flash_message_success','Banner Image Deleted Successfully');
    }
}
