<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CartUser
 *
 * @property int $id
 * @property int $cart_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CartUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CartUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CartUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CartUser whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CartUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CartUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CartUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CartUser whereUserId($value)
 * @mixin \Eloquent
 */
class CartUser extends Model
{
    protected $table = 'cart_user';
}
