<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Auth\Authorizable;

/**
 * @method static where(string $string, mixed $input)
 * @method static create()
 * @method static insertGetId(array $array)
 * @property string $api_token
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var $fillable array
     */
    protected $fillable = ['name','email','password', 'api_token'];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    /**
     * @return HasOne
     */
    public function client(): HasOne
    {
        return $this->hasOne('App\Models\Client','user_id');
    }
}
