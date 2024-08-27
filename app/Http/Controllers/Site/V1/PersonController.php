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

class PersonController extends PKSIController{

    private $view = 'front.';
    private function view(){
        return $this->view;
    }

    public function people(){
        $people = Person::where('is_published',true);
        $people = $people->get();
        return view(  self::view().'site.people',[
            'people' => $people,
        ]);
    }
    public function person($slug = null){
        if(!$slug) return abort(404);
        $person = Person::with(['shows'])->where('slug',$slug);
        $person = $person->where('is_published',true);
        $person = $person->first();
        if(!$person) return abort(404);
        return view(  self::view().'site.person',[
            'person' => $person,
        ]);
    }
    

}