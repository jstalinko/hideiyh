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
                    'link_checkout' => $plan->link_checkout,
                    'is_popular' => $plan->is_popular,
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

    public function download(Request $request)
    {
        // download storage/app/_integration.php rename as index-$username.php
        $username = strtolower(str_replace(' ', '_', $request->user()->name));
        $filePath = storage_path('app/_integration.php');
        $newFilePath = storage_path("app/index-$username.php");
        copy($filePath, $newFilePath);
        return response()->download($newFilePath)->deleteFileAfterSend(true);
    }
}
