<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function addCurrency(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
            
            $currency = new Currency();
            
            $currency->currency_code = $data['currency_code'];
            $currency->exchange_rate = $data['exchange_rate'];
            if (empty($data['status']))
            {
                $status = 0;
            }else{
                $status = 1;
            }
            $currency->status = $status;
            
            $currency->save();
            return redirect()->back()->with('flash_message_success','Your Currency Added Successfully');
        }
        return view('admin.currency.add_currency');
    }
    
    public function viewCurrency(Request $request)
    {
        $currencies = Currency::latest()->get();
        return view('admin.currency.view_currency',compact('currencies'));
    }
    
    public function editCurrency(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
    
            $currency = Currency::findOrFail($id);
    
            $currency->currency_code = $data['currency_code'];
            $currency->exchange_rate = $data['exchange_rate'];
            if (empty($data['status']))
            {
                $status = 0;
            }else{
                $status = 1;
            }
            $currency->status = $status;
    
            $currency->update();
            return redirect()->back()->with('flash_message_success','Your Currency Updated Successfully');
        }
        $currency = Currency::findOrFail($id);
        return view('admin.currency.edit_currency',compact('currency'));
    }
    
    public function deleteCurrency($id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();
        return redirect()->back()->with('flash_message_success','Your Currency Deleted Successfully');
    }
}
