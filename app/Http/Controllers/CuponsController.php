<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cupon;

class CuponsController extends Controller
{
    public function add_coupons(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;

            if (empty($data['status'])) {
                $status = 0;
            }else {
                $status = 1;
            }

            $coupon = new Cupon();
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expire_date = $data['expire_date'];
            $coupon->status = $status;

            $coupon->save();

            return redirect('/admin/view-coupons')->with('flash_message_success','Coupon Code Added Successfully');

        }
        return view('admin.coupon.add_coupon');
    }

    public function view_coupons()
    {
        $coupons = Cupon::get();
        return view('admin.coupon.view_coupon',compact('coupons'));
    }

    public function edit_coupons(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo"<pre>";print_r($data);die;

            if (empty($data['status'])) {
                $status = 0;
            }else {
                $status = 1;
            }

            $coupon = Cupon::findOrFail($id);

            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expire_date = $data['expire_date'];
            $coupon->status = $status;

            $coupon->save();

            return redirect('/admin/view-coupons')->with('flash_message_success','Coupon Updated Successfully');
        }
        $coupons = Cupon::where('id',$id)->first();
       return view('admin.coupon.edit_coupon', compact('coupons'));
    }

    public function delete_coupons($id)
    {
        $coupons = Cupon::findOrFail($id);
        $coupons->delete();

        return redirect()->back()->with('flash_message_success','Coupon Deleted Successfully');
    }
}
