<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'niveau';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
