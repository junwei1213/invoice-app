<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];
    // 自动加载 items 和 customer 关系
    protected $with = ['customer', 'items']; 

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
    public function items() {
        return $this->hasMany(InvoiceItem::class);
    }
}