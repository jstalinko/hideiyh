<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
  
    protected $fillable = [
        'user_id',
        'shortlink',
        'domain',
        'clicks',
        'white_page_clicks',
        'bot_page_clicks',
        'offer_page_clicks',
        'bot_page_url',
        'white_page_url',
        'offer_page_url',
        'render_bot_page_method',
        'render_white_page_method',
        'render_offer_page_method',
        'allowed_country',
        'allowed_params',
        'block_no_referer',
        'block_vpn',
        'block_bot',
        'allowed_device',
        'allowed_platform',
        'anti_loop_max',
        'apikey',
        'active'
    ];

    protected $casts = [
        'allowed_country' => 'array',
        'allowed_params' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function integrations() {
        return $this->hasMany(Integration::class);
    }
}
