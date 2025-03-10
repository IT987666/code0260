<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingDetail extends Model
{
    protected $table = 'shipping_details';

    protected $fillable = ['order_id', 'shipping_type', 'quantity', 'unit_price', 'shipping_cost', 'total_cost'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
