<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'starts_at', 'ends_at', 
        'status', 'payment_method', 'payment_id',
        'cancelled_at', 'cancellation_reason', 'auto_renew'
    ];

    protected $dates = [
        'starts_at', 'ends_at', 'cancelled_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function isActive()
    {
        return $this->status === 'active' && $this->ends_at > now();
    }
}
