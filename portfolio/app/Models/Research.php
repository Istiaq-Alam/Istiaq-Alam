<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Support\ImageUrl;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    protected $table = 'researches';

    protected $fillable = [
        'title',
        'category',
        'published_date',
        'description',
        'research_url',
        'thumbnail',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::get(fn () => ImageUrl::resolve($this->thumbnail));
    }
}
