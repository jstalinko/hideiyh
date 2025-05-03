<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Inertia\Inertia;
use Illuminate\Http\Request;

class HiController extends Controller
{
    public function home(Request $request)
    {
        $props['plans'] = Plan::where('is_active', true)
            ->orderBy('price', 'asc')
            ->get()
            ->map(function ($plan) {
                return [
                    'name' => $plan->name,
                    'slug' => $plan->slug,
                    'description' => $plan->description,
                    'price' => $plan->price,
                    'duration_in_days' => $plan->duration_in_days,
                    'link_limit' => $plan->link_limit,
                    'traffic_limit_per_day' => $plan->traffic_limit_per_day,
                ];
            });
        $data['props'] = $props;
        return Inertia::render('Welcome' , $data);
    }
}
