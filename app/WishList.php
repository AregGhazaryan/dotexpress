<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\WishList
 *
 * @property int $id
 * @property string $product_unique_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\WishList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\WishList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\WishList query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\WishList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\WishList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\WishList whereProductUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\WishList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\WishList whereUserId($value)
 * @mixin \Eloquent
 */
class WishList extends Model
{
    public function product(){
        return $this->belongsTo(\App\Product::class,'product_unique_id', 'unique_id');
    }
}
