<?php

namespace App\Models\TV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

use Carbon\Carbon;

class Episode extends Model{
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
        $slug = str_replace(' ','-',$value);
        $slug = str_replace('---','-',$slug);
        $this->attributes['slug'] = $slug;
    }

    public function getThumbAttribute(){
        if(!$this->attributes['thumb']) return "assest/images/no-thumb.png";
        return $this->attributes['thumb'];
    }
    
    protected $appends = [
        'link'
    ];
    public function getLinkAttribute(){
        $tvShowSlug = Serie::find($this->attributes['serie_id']);
        return env('APP_URL','')."/shows/".$tvShowSlug->slug."/episodes/".$this->attributes['slug'];
    }
    /**
     * Get the user that owns the Episode
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tvShow(){
        return $this->belongsTo(Serie::class, 'serie_id', 'id')->where('is_published',true);
    }
}
