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

class SiteController extends PKSIController{

    private $view = 'front.';
    private function view(){
        return $this->view;
    }

    public function index(){
        $slides = Slide::limit(10)->where('is_published',true);
        $slides = $slides->orderBy('created_at', 'desc');
        $slides = $slides->get();

        $ads = ADS::limit(10)->where('is_published',true);
        $ads = $ads->where('expire_date', '>=', Carbon::now());
        $ads = $ads->orderBy('created_at', 'desc');
        $ads = $ads->where('location', 'home');
        $ads = $ads->get();
        
        $lastTvShows = Episode::with(['tvShow']);
        $lastTvShows = $lastTvShows->limit(10);
        $lastTvShows = $lastTvShows->orderBy('created_at', 'desc');
        $lastTvShows = $lastTvShows->get();
        
        $specialTvShows = Episode::with(['tvShow']);
        $specialTvShows = $specialTvShows->where('is_special',true);
        $specialTvShows = $specialTvShows->where('is_published',true);
        $specialTvShows = $specialTvShows->limit(10);
        $specialTvShows = $specialTvShows->orderBy('id', 'desc');
        $specialTvShows = $specialTvShows->get();
        
        $tvShows = Series::with(['lastEpisodes']);
        $tvShows = $tvShows->orderBy('order', 'asc');
        $tvShows = $tvShows->get();
        $tvShows = $tvShows->map(function($serie) {
            $serie->setRelation('last_episodes', $serie->lastEpisodes->take(10));
            return $serie;
        });

        return view(  self::view().'site.home',[
            'slides'=>$slides,
            'ads'=>$ads,
            'lastTvShows'=>$lastTvShows,
            'specialTvShows'=>$specialTvShows,
            'tvShows'=>$tvShows
        ]);
    }
    public function tvShows(){
        $tvShows = Series::with(['lastEpisodes']);
        $tvShows = $tvShows->orderBy('order', 'asc');
        $tvShows = $tvShows->where('is_published',true);
        $tvShows = $tvShows->get();
        $tvShows = $tvShows->map(function($serie) {
            $serie->setRelation('last_episodes', $serie->lastEpisodes->take(10));
            return $serie;
        });
        
        return view(  self::view().'site.tvshows',[
            'tvShows'=>$tvShows
        ]);
    }
    
    public function sitemap(){
        $seriesCount=Serie::where('is_published',true)->count();
        return response()->view('sitemap',['show_count'=>$seriesCount])
            ->header('Content-Type','text/xml');
    }

}