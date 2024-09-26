<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingCompany;
class ShippingCompanyController extends Controller
{
    //
    public function index(){
        $orders = ShippingCompany::where('user_id', auth()->id())->get(); 
        return view('shippingcompany.index', compact('orders'));
    }
  
    public function edit($id){
        $order =ShippingCompany::find($id);
        return view('shippingcompany.edit',compact('order'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
            'total_amount' => 'required|numeric',
            'order_status' => 'required|string',
            'payment_method' => 'required|string',
            'shipping_method' => 'required|string',
            'shipping_cost' => 'required|numeric',
            'tax_amount' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'currency' => 'required|string|max:10',
            'notes' => 'nullable|string',
            'tracking_number' => 'nullable|string|max:255',
            'expected_delivery_date' => 'nullable|date',
        ]);
    
        $order = ShippingCompany::findOrFail($id);
        $order->update($request->all());
    
        return redirect()->route('orders.edit', $order->id)->with('success', 'Order updated successfully.');
    }
    
    public function delete($id){
        $shippingcompany=new ShippingCompany;
        if($id){
            $shippingcompany->find($id)->delete();
            return redirect()->route('shippingcompany.index');
        }else{
            return redirect()->route('login');
        }
    }
}
