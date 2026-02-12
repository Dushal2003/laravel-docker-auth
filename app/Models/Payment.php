<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id','txn_id','amount','status','response'];
    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
