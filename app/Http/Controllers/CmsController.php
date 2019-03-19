<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
    
    public function cmsPage($url)
    {
        //redirect page 404 if page is not found
         $cmsPageCount = CmsPage::where(['url'=>$url, 'status'=>1])->count();
         if ($cmsPageCount > 0)
         {
             //get cms page details
             $cmsPageDetails = CmsPage::where('url',$url)->first();
    
         }else{
             abort(404);
         }
    
    
        //categories details
        $categories = Category::with('cate')->where(['parent_id' => 0])->get();
        
        //brand details
        $brands = Brand::with('products')->get();
        return view('pages.cms_page',compact('cmsPageDetails','categories','brands'));
    }
    
    public function cmsContact(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
//            echo "<pre>"; print_r($data);die;
            
            //send email
            $email = "aminurrashid126@gmail.com";
            $messageData =[
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'body' => $data['body']
            ];
            Mail::send('email.enquery',$messageData,function ($message)use ($email){
                $message->to($email)->subject('Enquiry from E-com Website');
            });
            
            return redirect()->back()->with('flash_message_success','Thanks for enquiry. We will get back soon');
        }
        //categories details
        $categories = Category::with('cate')->where(['parent_id' => 0])->get();
    
        //brand details
        $brands = Brand::with('products')->get();
    
        //meta tag
        $meta_title = "Contact us - E-shop Sample Website";
        $meta_description = "Contact us for any queries related to our products";
        $meta_keyword = "contact us,exchange product";
        
        return view('pages.contact',compact('cmsPageDetails','categories',
            'brands','meta_title','meta_description','meta_keyword'));
    }
    
}
