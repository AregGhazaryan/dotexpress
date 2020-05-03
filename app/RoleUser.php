<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RoleUser
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Role|null $role
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleUser whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RoleUser whereUserId($value)
 * @mixin \Eloquent
 */
class RoleUser extends Model
{
    protected $table = 'role_user';

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function role()
    {
        return $this->belongsTo(\App\Role::class, 'role_id');
    }
}
