<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $order = 0;

        foreach ($this->githubProjects() as $project) {
            Project::updateOrCreate(
                ['title' => $project['title'], 'is_github_featured' => true],
                $project + ['is_github_featured' => true, 'category' => 'Github', 'sort_order' => $order++]
            );
        }

        $order = 0;

        foreach ($this->gridProjects() as $project) {
            Project::updateOrCreate(
                ['title' => $project['title'], 'is_github_featured' => false],
                $project + ['is_github_featured' => false, 'sort_order' => $order++]
            );
        }
    }

    private function githubProjects(): array
    {
        return [
            [
                'title' => 'Student Academic Performance Prediction',
                'thumbnail' => 'assets/images/spp.png',
                'description' => 'AI-powered Student Performance Prediction System using Machine Learning, Explainable AI (SHAP/LIME), Risk Detection, and Human-in-the-Loop Feedback.',
            ],
            [
                'title' => 'Egg Drop Saga Game',
                'thumbnail' => 'assets/images/eds.png',
                'description' => 'Interactive OpenGL Game. A fun and dynamic 2D egg catching game built with C++ and OpenGL (GLUT). Control the bucket, catch falling eggs, and survive as long as possible while managing lives',
            ],
            [
                'title' => 'Flappy Bird Game',
                'thumbnail' => 'assets/images/flpy.png',
                'description' => 'Flappy Bird game is made with Java. In this project, I added an interface that will show the GUI game named Flappy Bird. Users can click on the Play button to play the game. Then a new window will open for the Flappy Bird game. It is not my first Java Project on games.',
            ],
            [
                'title' => 'NDUB student Management System',
                'thumbnail' => 'assets/images/logo.png',
                'description' => 'NDUB Student Management System is a comprehensive web application designed specifically for students of Notre Dame University Bangladesh to manage their academic information efficiently. It provides a user-friendly interface for students to access their results and percentages, while administrators can easily handle student data, course management, and result updates 📆📡',
            ],
            [
                'title' => 'Ethical Hacking Demonstration',
                'thumbnail' => 'assets/images/def.webp',
                'description' => 'This project contains an HTML file for a "deface page," often used in ethical hacking demonstrations or cybersecurity training to simulate website security breaches. The page mimics the appearance of a defaced website and serves as a tool for awareness and education about web application security.',
            ],
            [
                'title' => '2D Snake Game',
                'thumbnail' => 'assets/images/snk.png',
                'description' => 'A simple 2D snake game implemented in Java. This classic game allows players to control a snake with the objective of eating the red dot while avoiding collisions with the snake\'s own body and the game boundaries.',
            ],
        ];
    }

    private function gridProjects(): array
    {
        return [
            ['title' => 'Student Performance Prediction & Academic Advisory', 'category' => 'Web development', 'sub_category' => 'Web Applications', 'thumbnail' => 'assets/images/spp2.png', 'project_url' => 'https://student-performance-checker.pages.dev/'],
            ['title' => 'Egg Drop Saga Game', 'category' => 'Applications', 'thumbnail' => 'assets/images/eggdropsaga.png', 'project_url' => 'https://egg-drop-saga.vercel.app/'],
            ['title' => 'Computer Club Website', 'category' => 'Web development', 'thumbnail' => 'assets/images/project-9.png', 'project_url' => 'https://ndubcc.pages.dev/'],
            ['title' => 'Academic Notes Manager', 'category' => 'Web development', 'thumbnail' => 'assets/images/acadm-web.jpeg', 'project_url' => 'https://academic-note.vercel.app/'],
            ['title' => 'Failover Networks', 'category' => 'CyberSecurity', 'thumbnail' => 'assets/images/fail.png', 'project_url' => 'https://github.com/Istiaq-Alam/Failover-Network-Using-Redundant-Paths'],
            ['title' => 'Shell Programming', 'category' => 'Learn', 'thumbnail' => 'assets/images/shell.png', 'project_url' => 'https://github.com/Istiaq-Alam/Shell-Programming.git'],
            ['title' => 'NDUB Student Management System', 'category' => 'Web development', 'thumbnail' => 'assets/images/ndubsms.png', 'project_url' => 'https://github.com/Istiaq-Alam/NDUB-Student-Management-System2.0.git'],
            ['title' => 'Deface Page Demonstration', 'category' => 'CyberSecurity', 'thumbnail' => 'assets/images/deface.jpg', 'project_url' => 'https://spyder-deface-page.vercel.app/'],
            ['title' => 'Flappy Bird Game', 'category' => 'Applications', 'thumbnail' => 'assets/images/flppy.png', 'project_url' => 'https://github.com/Istiaq-Alam/Flappy-Birds-Game.git'],
            ['title' => 'Ethical Hacking', 'category' => 'CyberSecurity', 'thumbnail' => 'assets/images/ethical-hacking.webp', 'project_url' => 'https://spydercehub.vercel.app'],
            ['title' => 'Money Management System', 'category' => 'Web development', 'thumbnail' => 'assets/images/mms.jpg', 'project_url' => 'https://istiaq-alam.github.io/Money-Management-System/'],
            ['title' => 'Snake Game', 'category' => 'Applications', 'thumbnail' => 'assets/images/snk.jpg', 'project_url' => 'https://github.com/Istiaq-Alam/Snake-game-2D-.git'],
        ];
    }
}
