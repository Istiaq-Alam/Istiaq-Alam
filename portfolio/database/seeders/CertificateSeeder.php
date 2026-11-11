<?php

namespace Database\Seeders;

use App\Models\Certificate;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        $certificates = [
            ['title' => 'NDUB CSE Fest 2026 Lead Organizer', 'image' => 'assets/images/Lead_Organizer_NDUB_CSE_FEST_2026.png'],
            ['title' => 'Edge Certificate', 'image' => 'assets/images/edgeCer.jpg'],
            ['title' => 'EWE Certificate', 'image' => 'assets/images/eweCer.jpg'],
            ['title' => 'Certificate 3', 'image' => 'assets/images/logo-1-color.png'],
            ['title' => 'Certificate 4', 'image' => 'assets/images/logo-2-color.png'],
        ];

        foreach ($certificates as $order => $certificate) {
            Certificate::updateOrCreate(
                ['title' => $certificate['title']],
                ['image' => $certificate['image'], 'sort_order' => $order]
            );
        }
    }
}
