<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Cms\Models\Post;

/**
 * @property int $id
 * @property int $post_id
 * @property string $name
 * @property string|null $size
 * @property string|null $property_type
 * @property int|null $bedrooms
 * @property string|null $description
 * @property float $price
 * @property array|null $payment_plan
 * @property int $order
 * @property bool $is_featured
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Modules\Cms\Models\Post $post
 */
final class PropertyVariation extends Model
{
    protected $fillable = [
        'post_id',
        'name',
        'size',
        'property_type',
        'bedrooms',
        'description',
        'price',
        'payment_plan',
        'order',
        'is_featured',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'payment_plan' => 'array',
            'bedrooms' => 'integer',
            'order' => 'integer',
            'is_featured' => 'boolean',
        ];
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
