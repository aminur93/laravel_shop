<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {
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
        $categories = Category::orderBy('id','DESC')->get();
        return view('admin.categories.view_category')->with(compact('categories'));
    }

    public function edit_category(Request $request, $id)
    {
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
        $category = Category::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success', 'Category Deleted Successfully');
    }
}
