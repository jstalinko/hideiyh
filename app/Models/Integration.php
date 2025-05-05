<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    protected $fillable = [
        'user_id',
        'link_id',
        'domain',
        'apikey',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    
}
