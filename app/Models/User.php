<?php

namespace App\Models;

use App\Http\Controllers\UserController;
use App\Repositories\UserRepository;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Auth\Authorizable;

/**
 * @method static where(string $string, mixed $input)
 * @method static create()
 * @method static insertGetId(array $array)
 * @property string $api_token
 * @property string $name
 * @property string $email
 * @property string $description
 * @property Client $client
 * @property int $id
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
     * @param $email
     * @return User
     */
    public static function exists($email): ?User
    {
        return UserRepository::findOneBy('email', $email);
    }

    /**
     * @return bool
     */
    public static function canCreateProject(): bool
    {
        $projects = static::loggedInUser()->client->projects;
        if (count($projects) > 0) {
            return false;
        }
        return true;
    }


    /**
     * @return HasOne
     */
    public function client(): HasOne
    {
        return $this->hasOne('App\Models\Client','user_id');
    }

    /**
     * @return AuthenticatableContract|null
     */
    public static function loggedInUser(): ?AuthenticatableContract
    {
        return Auth::user();
    }

}
