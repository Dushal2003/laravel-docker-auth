<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtpCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'code_hash', 'type', 'expires_at',
    ];

    public $timestamps = true;

    protected $dates = ['expires_at'];

    /* Scope for still-valid codes */
    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now());
    }
}
