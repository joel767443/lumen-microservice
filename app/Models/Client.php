<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, mixed $input)
 * @method static find(int $id)
 * @method static create(array $array)
 * @property string $description
 * @property string $name
 */
class Client extends Model
{
    protected $fillable = ['name','description', 'user_id'];

    /**
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany('App\Models\Project','client_id');
    }
}
