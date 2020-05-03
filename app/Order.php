<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Order
 *
 * @property int $id
 * @property string $order_id
 * @property int $quantity
 * @property string $address
 * @property int $product_id
 * @property int $user_id
 * @property int $is_approved
 * @property int $is_premium
 * @property int $arrival_confirmed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereArrivalConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereIsPremium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    protected $fillable = ['is_approved'];

    public function product(){
        return $this->belongsTo(\App\Product::class, 'product_unique_id', 'unique_id');
    }


    public function getPriceAttribute(){
        return $this->quantity * $this->product->price;
    }

    public function users(){
        return $this->belongsToMany(\App\User::class);
    }

    public function buyer(){
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
