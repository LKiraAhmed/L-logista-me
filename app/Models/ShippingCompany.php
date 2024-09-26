<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'billing_address',
        'total_amount',
        'order_status',
        'payment_method',
        'shipping_method',
        'shipping_cost',
        'tax_amount',
        'discount',
        'currency',
        'notes',
        'tracking_number',
        'expected_delivery_date',
    ];
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
