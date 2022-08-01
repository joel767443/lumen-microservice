<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Project extends Model
{
    protected $fillable = ["name", "client_id"];
}
