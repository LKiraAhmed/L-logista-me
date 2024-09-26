<?php

namespace App\Http\Controllers;

use App\Models\ShippingCompany;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    //
    public function index(){
        return view('api.index');
    }
    public function storeCompanyOrder(Request $request, $randomString)
    {
        $validator = Validator::make($request->all(),[
            'order_number' => 'required|string|unique:shipping_companies',
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
            'token' => 'required|string', 
        ]);
   
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $faker = Faker::create();
        $randomString = $faker->word(); 
        $url = url('/company/orders/' . $randomString);

    
        $tokenRecord = Token::where('token', hash('sha256', $request->token))->first();
    
        if (!$tokenRecord) {
            return response()->json(['error' => 'Invalid token Error'], 403);
        }
    
        $userId = $tokenRecord->user_id; 
 
        try {
            $orderData = $request->all();
            $orderData['user_id'] = $userId; 
 
            $order = ShippingCompany::create($orderData);
            $order->save();         
            return response()->json([
                'message' => 'Order created successfully for company',
                'order' => $order,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create order', 'message' => $e->getMessage()], 500);
        }
    }
    
    
    
    public function storeMerchantOrder(Request $request,$randomString)
    {
        $validator = Validator::make($request->all(),[
            'order_number' => 'required|string|unique:shipping_companies',
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
            'token' => 'required|string', 
        ]);
   
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $faker = Faker::create();
        $randomString = $faker->word(); 
        $url = url('/company/orders/' . $randomString);

    
        $tokenRecord = Token::where('token', hash('sha256', $request->token))->first();
    
        if (!$tokenRecord) {
            return response()->json(['error' => 'Invalid token Error'], 403);
        }
    
        $userId = $tokenRecord->user_id; 
 
        try {
            $orderData = $request->all();
            $orderData['user_id'] = $userId; 
 
            $order = ShippingCompany::create($orderData);
            $order->save();         
            return response()->json([
                'message' => 'Order created successfully for company',
                'order' => $order,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create order', 'message' => $e->getMessage()], 500);
        }
    }
        
}   

