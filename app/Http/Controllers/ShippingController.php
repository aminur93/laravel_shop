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
            $shipping->shipping_charges0_500g = $data['shipping_charges0_500g'];
            $shipping->shipping_charges501_1000g = $data['shipping_charges501_1000g'];
            $shipping->shipping_charges1001_2000g = $data['shipping_charges1001_2000g'];
            $shipping->shipping_charges2001_5000g = $data['shipping_charges2001_5000g'];
            $shipping->update();
            
            return redirect('/admin/view-shipping')->with('flash_message_success','Shipping Charges Added Successfully');
        }
        $shipping_charge = ShippingCharge::findOrFail($id);
        return view('admin.shipping.edit_shipping',compact('shipping_charge'));
    }
}
