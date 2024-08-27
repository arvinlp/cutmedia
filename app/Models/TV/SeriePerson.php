<?php

namespace App\Models\TV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SeriePerson extends Pivot{

    public $timestamps = false;
    protected $table = "serie_people";
    
}
