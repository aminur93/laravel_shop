<?php

namespace App\Http\Controllers;

use App\CmsPage;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function addCms(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
//            echo "<pre>"; print_r($data);die;
            
            $cms = new CmsPage();
            $cms->title = $data['title'];
            $cms->url = $data['url'];
            $cms->description = $data['description'];
            
            if (empty($data['status']))
            {
                $status = 0;
            }else{
                $status = 1;
            }
            
            $cms->status = $data['status'];
            $cms->save();
            
            return redirect('/admin/view-cms-page')->with('flash_message_success','Your cms page added successfully!!');
        }
        return view('admin.cms.add_cms_page');
    }
    
    public function viewCms()
    {
        $cms = CmsPage::all();
        return view('admin.cms.view-cms-page',compact('cms'));
    }
    
    public function editCms(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
//            echo "<pre>"; print_r($data);die;
            
            $cms = CmsPage::findOrFail($id);
            
            $cms->title = $data['title'];
            $cms->url = $data['url'];
            $cms->description = $data['description'];
            if (empty($data['status']))
            {
                $status = 0;
            }else{
                $status = 1;
            }
            $cms->status = $data['status'];
            $cms->save();
            
            return redirect('/admin/view-cms-page')->with('flash_message_success','Your Cms page Updated successfully!!');
        }
        $cms = CmsPage::where('id',$id)->first();
        return view('admin.cms.edit_cms_page',compact('cms'));
    }
    
    public function deleteCms($id)
    {
        $cms = CmsPage::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Your cms page deleted successfully!!');
    }
    
}
