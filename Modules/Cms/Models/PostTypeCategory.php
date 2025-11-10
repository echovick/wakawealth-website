<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $post_type_id
 * @property int $post_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Modules\Cms\Models\PostType $postType
 * @property-read \Modules\Cms\Models\Post $post
 * @property-read \Modules\Cms\Models\Category $category
 */
final class PostTypeCategory extends Model
{
    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
