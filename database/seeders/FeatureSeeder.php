<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['name' => 'Kolam Renang', 'icon' => 'fa fa-person-swimming'],
            ['name' => 'Taman', 'icon' => 'fa fa-tree'],
            ['name' => 'Keamanan 24 Jam', 'icon' => 'fa fa-shield-halved'],
            ['name' => 'CCTV', 'icon' => 'fa fa-video'],
            ['name' => 'Akses Jalan', 'icon' => 'fa fa-road'],
            ['name' => 'Parkir', 'icon' => 'fa fa-square-parking'],
            ['name' => 'Gym', 'icon' => 'fa fa-dumbbell'],
            ['name' => 'Lift', 'icon' => 'fa fa-elevator'],
            ['name' => 'Area Bermain Anak', 'icon' => 'fa fa-person-running'],
            ['name' => 'Tempat Ibadah', 'icon' => 'fa fa-mosque'],
            ['name' => 'Dekat Sekolah', 'icon' => 'fa fa-school'],
            ['name' => 'Dekat Rumah Sakit', 'icon' => 'fa fa-hospital'],
            ['name' => 'Dekat Transportasi', 'icon' => 'fa fa-train-subway'],
            ['name' => 'Air PDAM', 'icon' => 'fa fa-droplet'],
            ['name' => 'Internet', 'icon' => 'fa fa-wifi'],
        ];

        foreach ($features as $f) {
            Feature::query()->firstOrCreate(
                ['name' => $f['name']],
                ['icon' => $f['icon']]
            );
        }
    }
}

