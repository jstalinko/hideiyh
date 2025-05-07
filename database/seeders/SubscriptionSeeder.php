<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, make sure we have users and plans
        if (User::count() == 0) {
            $this->command->info('No users found. Creating users...');
            User::factory(10)->create();
        }

        if (Plan::count() == 0) {
            $this->command->info('No plans found. Creating plans...');
            $this->createPlans();
        }

        $users = User::all();
        $plans = Plan::all();
        
        $statusOptions = ['active', 'cancelled', 'expired'];
        $paymentMethods = ['credit_card', 'paypal', 'bank_transfer', 'crypto', 'invoice'];
        
        $this->command->info('Creating subscriptions...');
        
        // Create different types of subscriptions for different users
        foreach ($users as $user) {
            // Determine how many subscriptions to create for this user (0-3)
            $subscriptionCount = rand(0, 3);
            
            for ($i = 0; $i < $subscriptionCount; $i++) {
                $plan = $plans->random();
                $status = $statusOptions[array_rand($statusOptions)];
                $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
                
                // Generate realistic dates
                $startsAt = Carbon::now()->subDays(rand(1, 365));
                
                // Determine end date based on plan duration and status
                $endsAt = null;
                if ($plan->duration) {
                    $endsAt = clone $startsAt;
                    $endsAt->addDays($plan->duration);
                }
                
                // For expired subscriptions, make sure end date is in the past
                if ($status === 'expired') {
                    $endsAt = Carbon::now()->subDays(rand(1, 30));
                }
                
                // For active subscriptions, make sure end date is in the future if specified
                if ($status === 'active' && $endsAt !== null) {
                    // If computed end date is in the past, shift to future
                    if ($endsAt->isPast()) {
                        $endsAt = Carbon::now()->addDays(rand(1, 180));
                    }
                }
                
                // For cancelled subscriptions, add cancelled_at date
                $cancelledAt = null;
                $cancellationReason = null;
                if ($status === 'cancelled') {
                    $cancelledAt = clone $startsAt;
                    $cancelledAt->addDays(rand(1, min(30, $plan->duration ?? 30)));
                    
                    $cancellationReasons = [
                        'Found a better alternative',
                        'Too expensive',
                        'Features did not meet expectations',
                        'Switching to a different plan',
                        'Technical issues',
                    ];
                    
                    $cancellationReason = $cancellationReasons[array_rand($cancellationReasons)];
                }
                
                // Auto-renew is true for some active subscriptions
                $autoRenew = ($status === 'active') ? (bool)rand(0, 1) : false;
                
                // Create invoice code for subscriptions that use invoice payment method
                $invoice = ($paymentMethod === 'invoice') ? 'INV-' . Str::upper(Str::random(8)) : null;
                
                Subscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'starts_at' => $startsAt,
                    'ends_at' => $endsAt,
                    'status' => $status,
                    'payment_method' => $paymentMethod,
                    'invoice' => $invoice,
                    'cancelled_at' => $cancelledAt,
                    'cancellation_reason' => $cancellationReason,
                    'auto_renew' => $autoRenew,
                ]);
            }
        }
        
        $this->command->info('Created ' . Subscription::count() . ' subscriptions');
    }
    
    /**
     * Create default plans if they don't exist.
     */
    private function createPlans(): void
    {
        $plans = [
            [
                'name' => 'Basic',
                'description' => 'Basic features for individuals',
                'price' => 9.99,
                'duration' => 30, // 1 month in days
                'features' => json_encode(['Feature 1', 'Feature 2']),
            ],
            [
                'name' => 'Professional',
                'description' => 'Advanced features for professionals',
                'price' => 19.99,
                'duration' => 30,
                'features' => json_encode(['Feature 1', 'Feature 2', 'Feature 3', 'Feature 4']),
            ],
            [
                'name' => 'Enterprise',
                'description' => 'Complete solution for businesses',
                'price' => 49.99,
                'duration' => 30,
                'features' => json_encode(['All Features', 'Priority Support', 'Custom Integration']),
            ],
            [
                'name' => 'Basic Annual',
                'description' => 'Basic features for individuals (annual billing)',
                'price' => 99.99,
                'duration' => 365, // 1 year in days
                'features' => json_encode(['Feature 1', 'Feature 2', '15% Discount']),
            ],
            [
                'name' => 'Professional Annual',
                'description' => 'Advanced features for professionals (annual billing)',
                'price' => 199.99,
                'duration' => 365,
                'features' => json_encode(['Feature 1', 'Feature 2', 'Feature 3', 'Feature 4', '15% Discount']),
            ],
        ];
        
        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}