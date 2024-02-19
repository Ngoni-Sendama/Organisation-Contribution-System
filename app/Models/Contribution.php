<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id',
        'amount',
        'method',
        'verification_code',
    ];

    // Contribution model
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
