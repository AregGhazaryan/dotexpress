<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Cart
 *
 * @property int $id
 * @property int $product_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cart extends Model
{
    public function users(){
        return $this->belongsToMany(\App\User::class);
    }

    public function product(){
        return $this->belongsTo(\App\Product::class, 'product_id');
    }
}
