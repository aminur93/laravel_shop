<?php

namespace App\Http\Controllers;

use App\NewsLetterSubscriber;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class NewsLetterSubscriberController extends Controller
{
    public function checkSubscribe(Request $request)
    {
        if ($request->ajax())
        {
            $data = $request->all();
            
            $subscriber_email = NewsLetterSubscriber::where('email',$data['subscriber_email'])->count();
            
            if ($subscriber_email > 0)
            {
                echo "exists";
            }
        }
    }
    
    public function addSubscribe(Request $request)
    {
        if ($request->ajax())
        {
            $data = $request->all();
        
            $subscriber_email = NewsLetterSubscriber::where('email',$data['subscriber_email'])->count();
        
            if ($subscriber_email > 0)
            {
                echo "exists";
            }else{
                // Add News Letter Subscriber in table
                $newsletter = new NewsLetterSubscriber();
                $newsletter->email = $data['subscriber_email'];
                $newsletter->status = 1;
                
                $newsletter->save();
                
                echo "saved";
            }
        }
    }
    
    public function viewSubscriber()
    {
        $newsLetter = NewsLetterSubscriber::get();
        return view('admin.subscriber.view_subscriber',compact('newsLetter'));
    }
    
    public function updateStatus($id,$status)
    {
        NewsLetterSubscriber::where('id',$id)->update(['status'=>$status]);
        
        return redirect()->back()->with('flash_message_success','NewsLetter has been update ');
    }
    
    public function exportNewsletter()
    {
        $subscriberData = NewsLetterSubscriber::select('id','email','created_at')
                          ->where('status',1)
                          ->orderBy('id','desc')
                          ->get();
        $subscriberData = json_decode(json_encode($subscriberData),true);
        
        return Excel::create('subscribers'.rand(),function ($excel) use($subscriberData){
            $excel->sheet('mySheet',function ($sheet) use ($subscriberData){
                $sheet->fromArray($subscriberData);
            });
        })->download('xlsx');
    }
    
    public function destroy($id)
    {
        $newsLetter = NewsLetterSubscriber::findOrFail($id);
        
        $newsLetter->delete();
        
        return redirect()->back()->with('flash_message_success','NewsLetter has been deleted');
    }
}
