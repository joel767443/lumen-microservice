<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $input)
 * @method static find(int $id)
 * @method static create()
 */
class Client extends Model
{
    protected $fillable = ['name','description', 'user_id'];
}
