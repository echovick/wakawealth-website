<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cms\Models\PostType;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postTypes = [
            [
                'title' => 'Blog Post',
                'slug' => 'blog',
                'description' => 'Standard blog posts',
                'active' => true,
            ],
            [
                'title' => 'News',
                'slug' => 'news',
                'description' => 'News articles and updates',
                'active' => true,
            ],
            [
                'title' => 'Investment Insight',
                'slug' => 'investment-insight',
                'description' => 'Investment insights and analysis',
                'active' => true,
            ],
        ];

        foreach ($postTypes as $postTypeData) {
            $postType = new PostType();
            $postType->title = $postTypeData['title'];
            $postType->slug = $postTypeData['slug'];
            $postType->description = $postTypeData['description'];
            $postType->active = $postTypeData['active'];
            $postType->save();
        }
    }
}
