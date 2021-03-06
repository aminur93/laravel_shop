<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {
        if(Session::get('adminDetails')['category_edit_access'] == 0)
        {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
        }
        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['status'])){
                $status = 0;
            }else {
                $status = 1;
            }
            
            $category = new Category();

            $category->name = $data['category_name'];
            $category->parent_id = $data['parent_id'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->status = $status;

            $category->save();

            return redirect('/admin/view-category')->with('flash_message_success', 'Category Added SuccessFully');
        }

        $levels = Category::where(['parent_id' => 0])->get();
        return view('admin.categories.add_category')->with(compact('levels'));
    }

    public function view_category()
    {
        if(Session::get('adminDetails')['category_view_access'] == 0)
        {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
        }
        
        $categories = Category::orderBy('id','DESC')->get();
        return view('admin.categories.view_category')->with(compact('categories'));
    }

    public function edit_category(Request $request, $id)
    {
        if(Session::get('adminDetails')['category_edit_access'] == 0)
        {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
        }
        
        if($request->isMethod('post')){
            $data = $request->all();

            if (empty($data['status'])) {
                $status = 0;
            }else {
                $status = 1;
            }

            $category = Category::findOrFail($id);

            $category->name = $data['category_name'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->status = $status;

            $category->save();

            return redirect('/admin/view-category')->with('flash_message_success', 'Category Edit Successfully');
        }

        $categories = Category::where('id',$id)->first();
        $levels = Category::where(['parent_id' => 0])->get();
        return view('admin.categories.edit_category', compact('categories','levels'));
    }

    public function delete_category($id)
    {
        if(Session::get('adminDetails')['category_full_access'] == 0)
        {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access to this model');
        }
        $category = Category::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success', 'Category Deleted Successfully');
    }
}
