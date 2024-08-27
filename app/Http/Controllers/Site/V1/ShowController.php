<?php
namespace App\Http\Controllers\Site\V1;

use App\Http\Controllers\PKSIController;

use Carbon\Carbon;
use App\Models\Core\ADS;
use App\Models\Core\Page;
use App\Models\Core\Slide;
use App\Models\Core\Setting;
use App\Models\TV\Serie as Series;
use App\Models\TV\Episode;
use App\Models\TV\Person;
use App\Models\User\Code;
use App\Models\User\Meta;
use App\Models\User;

class ShowController extends PKSIController{

    private $view = 'front.';
    private function view(){
        return $this->view;
    }

    public function tvShow($slug = null){
        if(!$slug) return abort(404);
        $tvShows = Series::with(['persons'])->where('slug',$slug);
        $tvShows = $tvShows->where('is_published',true);
        $tvShows = $tvShows->first();
        if(!$tvShows) return abort(404);
        $episodes = Episode::where('serie_id',$tvShows->id);
        $episodes = $episodes->where('is_published',true);
        $episodes = $episodes->get();
        return view(  self::view().'site.tvshow',[
            'show' => $tvShows,
            'episodes' => $episodes,
        ]);
    }
    
    public function play($slug = null,$slug2 = null){
        if(!$slug) return abort(404);
        if(!$slug2) return abort(404);
        $episode = Episode::with('tvShow')->where('slug','LIKE',"%{$slug2}%");
        $episode = $episode->where('is_published',true);
        $episode = $episode->first();
        if(!$episode) return abort(404);
        return view(  self::view().'site.episode',[
            'episode' => $episode,
        ]);
    }

}