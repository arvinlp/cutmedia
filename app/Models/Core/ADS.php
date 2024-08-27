<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Ads extends Model{

    use HasFactory;
    use SoftDeletes;

    protected $table = "a_d_s";
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getImageAttribute(){
        if(!$this->attributes['image']) return "assest/images/no-ads.png";
        return $this->attributes['image'];
    }
}
