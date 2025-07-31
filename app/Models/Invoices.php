<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoices extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'invoice_number',
            'invoice_Date',
            'due_date' ,
            'section_id',
            'product',
            'amount_collection',
            'amount_Commission',
            'discount' ,
            'value_VAT' ,
            'rate_VAT' ,
            'total' ,
            'status',
            'value_Status' ,
            'note',
    ]; 

    public function section(){
        return $this->belongsTo(Sections::class);
    }
    public function product(){
        return $this->belongsTo(Products::class, 'product');
    }
}
