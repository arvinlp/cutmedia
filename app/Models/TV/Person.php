<?php

namespace App\Models\TV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

use Carbon\Carbon;

class Person extends Model
{
    use HasFactory;
    use SoftDeletes;
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

    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_replace(' ','-',$value);
    }

    public function getImageAttribute(){
        if(!$this->attributes['image']) return "assest/images/no-person.png";
        return $this->attributes['image'];
    }
    
    protected $appends = [
        'link'
    ];
    public function getLinkAttribute(){
        return env('APP_URL','')."/people/".$this->attributes['slug'];
    }
    
    /**
     * The roles that belong to the Person
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shows(){
        return $this->belongsToMany(Serie::class, 'serie_people', 'person_id', 'serie_id')->where('is_published',true);
    }
}
