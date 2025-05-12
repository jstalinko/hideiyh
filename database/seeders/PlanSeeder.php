<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     *    $table->string('name');
            $table->string('link_checkout')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('duration_in_days');
            $table->integer('link_limit');
            $table->integer('traffic_limit_per_day')->nullable(); // null means unlimited
            $table->boolean('is_active')->default(true);
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free Trial',
                'link_checkout' => 'free-trial',
                'description' => 'Perfect for getting started with our service.',
                'price' => 0.00,
                'duration_in_days' => 2,
                'link_limit' => 2,
                'traffic_limit_per_day' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Basic Plan',
                'link_checkout' => 'basic-plan',
                'description' => 'Ideal for individuals and small teams.',
                'price' => 190000.00,
                'duration_in_days' => 30,
                'link_limit' => 10,
                'traffic_limit_per_day' => 10000,
                'is_active' => true,
            ],
            [
                'name' => 'Pro Plan',
                'link_checkout' => 'pro-plan',
                'description' => 'Best for growing businesses and teams.',
                'price' => 250000.00,
                'duration_in_days' => 30,
                'link_limit' => null,
                'traffic_limit_per_day' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise Plan',
                'link_checkout' => 'enterprise-plan',
                'description' => 'Custom solutions for large organizations.',
                'price' => 500000.00,
                'duration_in_days' => 30,
                'link_limit' => null,
                'traffic_limit_per_day' => null, // Unlimited
                'is_active' => true,
            ]
            ];
        foreach ($plans as $plan) {
            \App\Models\Plan::create([
                'name' => $plan['name'],
                'link_checkout' => $plan['link_checkout'],
                'description' => $plan['description'],
                'price' => $plan['price'],
                'duration_in_days' => $plan['duration_in_days'],
                'link_limit' => $plan['link_limit'],
                'traffic_limit_per_day' => $plan['traffic_limit_per_day'],
                'is_active' => $plan['is_active'],
            ]);
        }

    }
}
