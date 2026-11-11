<?php

namespace Database\Seeders;

use App\Models\Research;
use Illuminate\Database\Seeder;

class ResearchSeeder extends Seeder
{
    public function run(): void
    {
        $researches = [
            [
                'title' => 'Beyond Accuracy: Explainable and Actionable Machine Learning for Student Academic Performance Prediction',
                'category' => 'Machine Learning',
                'published_date' => 'June 21, 2026',
                'description' => 'This system presents an intelligent Student Performance Prediction System that combines Machine Learning (ML), Explainable Artificial Intelligence (XAI), Goal-Based Academic Planning, and Human-in-the-Loop (HITL) feedback mechanisms.',
                'research_url' => 'https://student-performance-checker.pages.dev',
                'thumbnail' => 'assets/images/spp2.png',
            ],
            [
                'title' => 'Failover Network Using Redundant Paths',
                'category' => 'Networking',
                'published_date' => 'June 03, 2025',
                'description' => 'A highly available and resilient network by implementing Spanning Tree Protocol (STP) and Hot Standby Router Protocol (HSRP).',
                'research_url' => 'assets/pdf/Report Book Main.pdf',
                'thumbnail' => 'assets/images/fail.png',
            ],
            [
                'title' => 'Dynamic NAT Configuration',
                'category' => 'Networking',
                'published_date' => 'May 07, 2025',
                'description' => 'Dynamic Network Address Translation (NAT) is a method used to map multiple private IP addresses to a pool of public IP addresses. This is particularly useful when you have a fixed number of public IP addresses.',
                'research_url' => 'assets/pdf/Istiak_ID-05_Computer_Networks_Lab_Report-01.pdf',
                'thumbnail' => 'assets/images/NAT.jpg',
            ],
            [
                'title' => 'Learn Shell Programming',
                'category' => 'Learn',
                'published_date' => 'Feb 27, 2025',
                'description' => 'An interactive Shell Scripting learning tool designed to help beginners understand the basics of Shell Programming. Just need a Linux-based system or a terminal with Bash installed.',
                'research_url' => null,
                'thumbnail' => 'assets/images/shellrep.png',
            ],
            [
                'title' => 'Invisible Security System',
                'category' => 'Microprocessor',
                'published_date' => 'Nov 19, 2024',
                'description' => 'The Invisible Security System project is designed to deliver a user-friendly solution for securing spaces by detecting unauthorized entry.',
                'research_url' => 'assets/pdf/Invisible_Security_System_Microprocessor_Project_Report Book.pdf',
                'thumbnail' => 'assets/images/ilss.png',
            ],
            [
                'title' => 'Matal Detector',
                'category' => 'Hardware',
                'published_date' => 'Jun 04, 2024',
                'description' => 'A low cost metal detector project that can detect the presence of metal objects. It is designed for educational purposes and can be used in various applications, such as security screening and treasure hunting.',
                'research_url' => 'assets/pdf/CSE-2106 Project Report.pdf',
                'thumbnail' => 'assets/images/md.png',
            ],
        ];

        foreach ($researches as $order => $research) {
            Research::updateOrCreate(
                ['title' => $research['title']],
                $research + ['sort_order' => $order]
            );
        }
    }
}
