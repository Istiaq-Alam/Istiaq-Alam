<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'istiak.apk@gmail.com'],
            [
                'name' => 'Istiaq Alam',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'hahahapasswordNai-vai khuija laav nai XD')),
            ]
        );

        $this->call([
            ProjectSeeder::class,
            ResearchSeeder::class,
            SkillSeeder::class,
            CertificateSeeder::class,
        ]);
    }
}
