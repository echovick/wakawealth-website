<?php

namespace Modules\Cms\Models;

use App\Models\PropertyVariation;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $post_type_id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string|null $image
 * @property array|null $content
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property bool $is_featured
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Modules\Cms\Models\PostType $postType
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Cms\Models\Category> $categories
 */
final class Post extends Model
{
    /** @var array<string, scalar|bool|null> Default values for Eloquent attributes */
    protected $attributes = [
        'content' => '{}',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'content' => 'array',
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }

    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'post_type_categories')
            ->withPivot('post_type_id')
            ->withTimestamps();
    }

    public function variations(): HasMany
    {
        return $this->hasMany(PropertyVariation::class)->orderBy('order');
    }
}
