<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class skill extends Model
{
    protected $fillable = [
        'categoria', 'skill'
    ];
    protected $table ="skills";
}
