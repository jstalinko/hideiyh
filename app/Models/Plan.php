<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 
        'duration_in_days', 'link_limit', 'traffic_limit_per_day', 'is_active'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
