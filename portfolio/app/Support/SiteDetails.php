<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SiteDetails
{
    public const KEY = 'details';

    public const OG_IMAGE_KEY = 'og_image';

    /**
     * Current page text, used when nothing has been saved yet.
     */
    public static function defaults(): array
    {
        return [
            'name' => 'Istiaq Alam',
            'job_title' => "Web Development Intern,\nVariation Communications Ltd",
            'about_1' => "🔐 I'm a Computer Science & Engineering student with a deep interest in Cyber Security and Ethical Hacking. I enjoy discovering system vulnerabilities, understanding digital threats, and crafting defenses that make the web a safer place. Currently engaged in hands-on learning through CTFs, simulation environments, and open-source security projects.",
            'about_2' => "I build secure and user-friendly websites that are functional and visually striking. My approach integrates clean coding practices with a strong focus on digital safety. I aim to make every site not only eye-catching but also aligned with cybersecurity best practices.",
            'education' => [
                ['title' => 'Notre Dame University Bangladesh', 'period' => '2022 — Present', 'text' => 'I am currently pursuing a Bachelor of Science in Computer Science and Engineering at Notre Dame University Bangladesh, where I\'m developing a strong foundation in programming, system design, and technology.'],
                ['title' => 'Government Laboratory High School & Collage', 'period' => '2019 — 2021', 'text' => 'I have completed my Higher Secondary Certificate (H.S.C) in 2021 from Government Laboratory High School & College with GPA-5'],
                ['title' => 'Motijheel Govt. Boys High School', 'period' => '2009 — 2019', 'text' => 'I have completed my Secondary School Certificate (S.S.C) in 2019 from Motijheel Govt. Boys High School with GPA-4.78'],
            ],
            'experience' => [
                ['title' => 'Graphics Designer', 'period' => "Notre Dame University Bangladesh Computer Club\n2024 — Present", 'text' => 'Since 2023, I have been working as a Graphics Designer at the Notre Dame University Bangladesh Computer Club, where I design digital visuals for events, social media, and official branding. I have a passion for digital graphics art, with experience in both vector and raster-based design tools'],
                ['title' => 'Bash Terminal System', 'period' => '2019 — Present', 'text' => 'I have over five years of experience using Kali Linux and other Bash-based terminal systems, which has given me strong command-line and security knowledge.'],
                ['title' => 'Web designer', 'period' => '2022 — Present', 'text' => 'I also bring two years of hands-on experience in web design, specializing in creating responsive and user-friendly interfaces using HTML and CSS.'],
            ],
        ];
    }

    /**
     * Saved values merged over the defaults.
     */
    public static function current(): array
    {
        $saved = SiteSetting::valueFor(self::KEY);

        if (! is_array($saved)) {
            return self::defaults();
        }

        // Timeline lists are replaced whole, so removed entries stay removed.
        $timelines = ['education', 'experience'];
        $merged = array_replace(self::defaults(), $saved);
        foreach ($timelines as $key) {
            $merged[$key] = array_values($saved[$key] ?? []);
        }

        return $merged;
    }

    /**
     * Absolute URL of the generated social card, or null when none was generated yet.
     */
    public static function ogImageUrl(): ?string
    {
        $saved = SiteSetting::valueFor(self::OG_IMAGE_KEY);
        $url = is_array($saved) ? ($saved['url'] ?? null) : null;

        return is_string($url) && $url !== '' ? ImageUrl::resolve($url) : null;
    }

    /**
     * Store a freshly rendered card and return its absolute URL.
     */
    public static function storeOgImage(UploadedFile $file): string
    {
        $stored = ImageUrl::storeUpload($file);

        SiteSetting::store(self::OG_IMAGE_KEY, ['url' => $stored]);

        return (string) ImageUrl::resolve($stored);
    }

    /**
     * Job title on one line, e.g. "Web Development Intern at Variation Communications Ltd".
     */
    public static function headline(array $details): string
    {
        $lines = preg_split('/\R/', (string) ($details['job_title'] ?? '')) ?: [];

        $lines = array_filter(array_map(
            fn (string $line) => trim(rtrim(trim($line), ',')),
            $lines
        ));

        return implode(' at ', $lines);
    }

    /**
     * First about paragraph on one line, shortened for social cards and search results.
     */
    public static function summary(array $details, int $limit = 160): string
    {
        return Str::limit(Str::squish(strip_tags((string) ($details['about_1'] ?? ''))), $limit);
    }
}
