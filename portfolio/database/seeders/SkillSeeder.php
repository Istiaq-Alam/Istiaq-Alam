<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            'Graphics designing' => 85,
            'Web designing' => 70,
            'Mobile App development' => 30,
            'Shell' => 80,
            'Ethical Hacking' => 60,
            'Burp Suite' => 40,
            'Metasploit' => 25,
            'Nmap' => 50,
            'Wireshark' => 25,
        ];

        $order = 0;
        foreach ($skills as $name => $percentage) {
            Skill::updateOrCreate(
                ['name' => $name],
                ['percentage' => $percentage, 'sort_order' => $order++]
            );
        }
    }
}
