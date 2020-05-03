<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @property int $id
 * @property string $name
 * @property string $machine_name
 * @property int $is_published
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $product
 * @property-read int|null $product_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereMachineName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereName($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    public $timestamps = false;

    public function product(){
        return $this->hasMany(\App\Product::class);
    }
}
