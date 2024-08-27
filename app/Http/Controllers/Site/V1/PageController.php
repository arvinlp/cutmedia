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

class PageController extends PKSIController{

    private $view = 'front.';
    private function view(){
        return $this->view;
    }

    public function index($slug = null){
        if(!$slug) return abort(404);
        $page = Page::where('slug',$slug);
        $page = $page->where('is_published',true);
        $page = $page->first();
        if(!$page) return abort(404);
        return view(  self::view().'site.page',[
            'page' => $page,
        ]);
    }

}