<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Support\ImageUrl;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'category',
        'sub_category',
        'description',
        'project_url',
        'thumbnail',
        'is_github_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_github_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::get(fn () => ImageUrl::resolve($this->thumbnail));
    }
}
