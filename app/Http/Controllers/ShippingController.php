<?php

namespace App\Http\Controllers;

use App\ShippingCharge;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function viewShipping()
    {
        $shipping_charge = ShippingCharge::get();
        return view('admin.shipping.view_shipping',compact('shipping_charge'));
    }
    
    public function edit(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
            
            $shipping = ShippingCharge::findOrFail($id);
            
            $shipping->country = $data['country'];
            $shipping->shipping_charges = $data['shipping_charges'];
            $shipping->update();
            
            return redirect('/admin/view-shipping')->with('flash_message_success','Shipping Charges Added Successfully');
        }
        $shipping_charge = ShippingCharge::findOrFail($id);
        return view('admin.shipping.edit_shipping',compact('shipping_charge'));
    }
}
