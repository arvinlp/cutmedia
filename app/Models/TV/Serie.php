<?php

namespace App\Models\TV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

use Carbon\Carbon;
class Serie extends Model
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
    
    public function getThumbAttribute(){
        if(!$this->attributes['thumb']) return "assest/images/no-thumb-2.png";
        return $this->attributes['thumb'];
    }
    
    public function getCoverAttribute(){
        if(!$this->attributes['cover']) return "assest/images/no-cover.png";
        return $this->attributes['cover'];
    }
    
    public function getHeaderAttribute(){
        if(!$this->attributes['header']) return "assest/images/no-header.png";
        return $this->attributes['header'];
    }
    
    protected $appends = [
        'link'
    ];
    public function getLinkAttribute(){
        return env('APP_URL','')."/shows/".$this->attributes['slug'];
    }

    /**
     * Get all of the comments for the Series
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function episodes(){
        return $this->hasMany(Episode::class, 'id', 'serie_id')->where('is_published',true);
    }
    public function lastEpisodes(){
        return self::hasMany(Episode::class, 'serie_id')->orderBy('created_at','desc');
    }
    public function persons(){
        return $this->belongsToMany(Person::class, 'serie_people', 'serie_id', 'person_id')->where('is_published',true);
    }
}
