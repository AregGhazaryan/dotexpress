<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string $unique_id
 * @property int $stock
 * @property int|null $category_id
 * @property int $user_id
 * @property int $is_approved
 * @property int $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $primary_image
 * @property-read mixed $secondary_images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Image[] $images
 * @property-read int|null $images_count
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUserId($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    public function images()
    {
        return $this->belongsToMany(\App\Image::class);
    }

    public function getSecondaryImagesAttribute()
    {
        return $this->images()->where('is_primary', false)->get();
    }


    public function getPrimaryImageAttribute()
    {
        return $this->images()->where('is_primary', true)->first();
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function order(){
        return $this->hasMany(\App\Order::class, 'product_unique_id', 'unique_id');
    }
}
