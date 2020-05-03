<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ImageProduct
 *
 * @property int $id
 * @property int $product_id
 * @property int $image_id
 * @property int $is_primary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageProduct whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageProduct whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ImageProduct extends Model
{
    protected $table = 'image_product';
}
