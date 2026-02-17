<?php

namespace Database\Seeders;

use App\Models\AgentApplication;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class DeveloperSubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic',
                'subtitle' => 'Mulai',
                'badge' => null,
                'price' => 1500000,
                'period_label' => 'per bulan',
                'is_highlight' => false,
                'features' => [
                    '1 proyek aktif',
                    'Listing properti unlimited',
                    'Dashboard analitik',
                    'Support via email',
                ],
                'access' => [
                    'max_projects' => 1,
                    'listings' => -1,
                    'analytics' => true,
                ],
                'sort_order' => 1,
            ],
            [
                'name' => 'Growth',
                'subtitle' => 'Populer',
                'badge' => 'Populer',
                'price' => 3500000,
                'period_label' => 'per bulan',
                'is_highlight' => true,
                'features' => [
                    '3 proyek aktif',
                    'Listing properti unlimited',
                    'Dashboard analitik lengkap',
                    'Priority support',
                    'Featured listings',
                ],
                'access' => [
                    'max_projects' => 3,
                    'listings' => -1,
                    'analytics' => true,
                    'priority_support' => true,
                    'featured_listings' => true,
                ],
                'sort_order' => 2,
            ],
            [
                'name' => 'Custom',
                'subtitle' => null,
                'badge' => 'Custom',
                'price' => null,
                'period_label' => null,
                'is_highlight' => false,
                'features' => [
                    'Multi proyek',
                    'Listing properti unlimited',
                    'Dashboard analitik premium',
                    'Dedicated account manager',
                    'Custom integrations',
                    'Priority support 24/7',
                ],
                'access' => [
                    'max_projects' => -1,
                    'listings' => -1,
                    'analytics' => true,
                    'priority_support' => true,
                    'featured_listings' => true,
                    'dedicated_manager' => true,
                ],
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                [
                    'agent_type' => AgentApplication::TYPE_DEVELOPER,
                    'name' => $plan['name'],
                ],
                array_merge($plan, [
                    'agent_type' => AgentApplication::TYPE_DEVELOPER,
                    'is_active' => true,
                ])
            );
        }

        $this->command->info('Developer subscription plans seeded successfully.');
    }
}
