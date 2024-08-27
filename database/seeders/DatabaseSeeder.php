<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Core\Setting;
use App\Models\TV\Serie as Series;
use App\Models\TV\Episode;
use App\Models\TV\Person;
use App\Models\TV\SeriePerson;
use App\Models\Core\ADS;
use App\Models\Core\Slide;
use App\Models\Core\Page;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        $User = new User;
        $User->id = 13990002;
        $User->nickname = "کاربر سیستم";
        $User->first_name = "کاربر";
        $User->last_name = "سیستم";
        $User->mobile = (float) 9981078851;
        $User->password = Hash::make("12345678");
        $User->type = "user";
        $User->province = 21;
        $User->county = 296;
        $User->city = 902;
        $User->save();

        //Setting
        $setting = new Setting;
        $setting->meta_key = "sms_apikey";
        $setting->meta_value = "CeoBE4PkU7YrqVisCBBNlVhseOnmi1g4EmJpaw8sz_U=";
        $setting->save();
        $setting = new Setting;
        $setting->meta_key = "sms_number";
        $setting->meta_value = "+98100020400";
        $setting->save();
        
        self::Series();
        self::Episodes();
        self::Persions();
        self::SeriePersions();

        self::ADS();
        self::Slider();
        self::Page();
    }
    private function Series(){
        //Series
        $serie = new Series;
        $serie->name = "تک چرخ";
        $serie->is_published = 1;
        $serie->description = "CutMedia";
        $serie->order = 2;
        $serie->save();
        $serie = new Series;
        $serie->name = "سوبژه";
        $serie->is_published = 1;
        $serie->description = "CutMedia";
        $serie->order = 3;
        $serie->save();
        $serie = new Series;
        $serie->name = "کات فود";
        $serie->is_published = 1;
        $serie->description = "CutMedia";
        $serie->order = 3;
        $serie->save();
        $serie = new Series;
        $serie->name = "کات استایل";
        $serie->is_published = 1;
        $serie->description = "CutMedia";
        $serie->order = 5;
        $serie->save();
        $serie = new Series;
        $serie->name = "سایکوکات";
        $serie->is_published = 1;
        $serie->description = "CutMedia";
        $serie->order = 6;
        $serie->save();
        $serie = new Series;
        $serie->name = "سایکوکات";
        $serie->is_published = 1;
        $serie->description = "CutMedia";
        $serie->order = 7;
        $serie->save();
        $serie = new Series;
        $serie->name = "کاتالوگ";
        $serie->is_published = 1;
        $serie->description = "CutMedia";
        $serie->order = 8;
        $serie->save();
        $serie = new Series;
        $serie->name = "تک استارت";
        $serie->is_published = 1;
        $serie->description = "CutMedia";
        $serie->order = 9;
        $serie->save();
        $serie = new Series;
        $serie->name = "کات آرت";
        $serie->is_published = 1;
        $serie->description = "CutMedia";
        $serie->order = 10;
        $serie->save();
        $serie = new Series;
        $serie->name = "ورزشکات";
        $serie->is_published = 1;
        $serie->description = "CutMedia";
        $serie->order = 11;
        $serie->save();
        $serie = new Series;
        $serie->name = "تقصیرچی";
        $serie->is_published = 1;
        $serie->description = "CutMedia";
        $serie->order = 12;
        $serie->save();
        $serie = new Series;
        $serie->name = "ویژه کات";
        $serie->is_published = 1;
        $serie->description = "CutMedia";
        $serie->order = 1;
        $serie->save();
    }
    private function Episodes(){
        //Episode
        $episode = new Episode;
        $episode->serie_id = 1;
        $episode->name = "تک چرخ قسمت ۱۱";
        $episode->thumb = "https://arvinlp.arvanvod.com/z1GX7Rj5ZM/z8DA1MA9rv/thumbnail.png";
        $episode->file = "https://arvinlp.arvanvod.com/z1GX7Rj5ZM/z8DA1MA9rv/h_,144_200,240_400,360_800,480_1439,k.mp4.list/master.m3u8";
        $episode->is_published = 1;
        $episode->description = "CutMedia";
        $episode->save();
        $episode = new Episode;
        $episode->serie_id = 2;
        $episode->name = "سوبژه - قسمت ۱۰";
        $episode->thumb = "https://arvinlp.arvanvod.com/z1GX7Rj5ZM/z8DA1MA9rv/thumbnail.png";
        $episode->file = "https://arvinlp.arvanvod.com/z1GX7Rj5ZM/z8DA1MA9rv/h_,144_200,240_400,360_800,480_1439,k.mp4.list/master.m3u8";
        $episode->is_published = 1;
        $episode->description = "CutMedia";
        $episode->save();
        $episode = new Episode;
        $episode->serie_id = 3;
        $episode->name = "کات فود - تولیدی سوسیس و کالباس چه خبر؟";
        $episode->thumb = "https://arvinlp.arvanvod.com/z1GX7Rj5ZM/z8DA1MA9rv/thumbnail.png";
        $episode->file = "https://arvinlp.arvanvod.com/z1GX7Rj5ZM/z8DA1MA9rv/h_,144_200,240_400,360_800,480_1439,k.mp4.list/master.m3u8";
        $episode->is_published = 1;
        $episode->description = "CutMedia";
        $episode->save();
        $episode = new Episode;
        $episode->serie_id = 3;
        $episode->name = "کات فود - کاپ کیک یلدایی";
        $episode->thumb = "https://arvinlp.arvanvod.com/z1GX7Rj5ZM/z8DA1MA9rv/thumbnail.png";
        $episode->file = "https://arvinlp.arvanvod.com/z1GX7Rj5ZM/z8DA1MA9rv/h_,144_200,240_400,360_800,480_1439,k.mp4.list/master.m3u8";
        $episode->is_published = 1;
        $episode->description = "CutMedia";
        $episode->save();
    }
    private function Persions(){
        $person = new Person;
        $person->name = "اشکان اسکندرزاده";
        $person->description = "-";
        $person->is_published = 1;
        $person->save();
        $person = new Person;
        $person->name = "آروین لری پور";
        $person->description = "-";
        $person->is_published = 1;
        $person->save();
        $person = new Person;
        $person->name = "محمد مهدی درتاج";
        $person->description = "-";
        $person->is_published = 1;
        $person->save();
    }
    private function SeriePersions(){
        $seriePerson = new SeriePerson;
        $seriePerson->serie_id = 1;
        $seriePerson->person_id = 1;
        $seriePerson->content = "تهیه کننده";
        $seriePerson->save();
        $seriePerson = new SeriePerson;
        $seriePerson->serie_id = 2;
        $seriePerson->person_id = 1;
        $seriePerson->content = "تهیه کننده";
        $seriePerson->save();
        $seriePerson = new SeriePerson;
        $seriePerson->serie_id = 3;
        $seriePerson->person_id = 1;
        $seriePerson->content = "تهیه کننده";
        $seriePerson->save();
        $seriePerson = new SeriePerson;
        $seriePerson->serie_id = 1;
        $seriePerson->person_id = 2;
        $seriePerson->content = "پخش و نشر";
        $seriePerson->save();
        $seriePerson = new SeriePerson;
        $seriePerson->serie_id = 2;
        $seriePerson->person_id = 2;
        $seriePerson->content = "پخش و نشر";
        $seriePerson->save();
        $seriePerson = new SeriePerson;
        $seriePerson->serie_id = 3;
        $seriePerson->person_id = 2;
        $seriePerson->content = "پخش و نشر";
        $seriePerson->save();
        $seriePerson = new SeriePerson;
        $seriePerson->serie_id = 1;
        $seriePerson->person_id = 3;
        $seriePerson->content = "مجری";
        $seriePerson->save();
        $seriePerson = new SeriePerson;
        $seriePerson->serie_id = 2;
        $seriePerson->person_id = 3;
        $seriePerson->content = "مجری";
        $seriePerson->save();
        $seriePerson = new SeriePerson;
        $seriePerson->serie_id = 3;
        $seriePerson->person_id = 3;
        $seriePerson->content = "مجری";
        $seriePerson->save();
    }
    private function ADS(){
        $data = new ADS;
        $data->name = "ایده های هوشمند پارت کویر";
        $data->link = "https://www.pksi.ir";
        $data->location = "home";
        $data->is_published = 1;
        $data->expire_date = Carbon::now()->add(1, 'day');
        $data->save();
        $data = new ADS;
        $data->name = "آروین لری پور";
        $data->link = "https://www.pksi.ir";
        $data->location = "home";
        $data->is_published = 1;
        $data->expire_date = Carbon::now()->add(1, 'week');
        $data->save();
        $data = new ADS;
        $data->name = "گوگل";
        $data->link = "https://www.pksi.ir";
        $data->location = "home";
        $data->is_published = 1;
        $data->expire_date = Carbon::now()->add(1, 'day');
        $data->save();
        $data = new ADS;
        $data->name = "استانداری";
        $data->link = "https://www.pksi.ir";
        $data->location = "home";
        $data->is_published = 1;
        $data->expire_date = Carbon::now()->add(-1, 'day');
        $data->save();
    }
    private function Slider(){
        $data = new Slide;
        $data->name = "اسلاید اول";
        $data->link = "https://cut-media.ir";
        $data->expire_date = Carbon::now()->add(1, 'day');
        $data->is_published = 1;
        $data->save();
        $data = new Slide;
        $data->name = "اسلاید اول";
        $data->link = "https://cut-media.ir";
        $data->expire_date = Carbon::now()->add(1, 'day');
        $data->is_published = 1;
        $data->save();
        $data = new Slide;
        $data->name = "اسلاید اول";
        $data->link = "https://cut-media.ir";
        $data->expire_date = Carbon::now()->add(1, 'day');
        $data->is_published = 1;
        $data->save();
        $data = new Slide;
        $data->name = "اسلاید اول";
        $data->link = "https://cut-media.ir";
        $data->expire_date = Carbon::now()->add(1, 'day');
        $data->is_published = 1;
        $data->save();
    }
    private function Page(){
        $data = new Page;
        $data->name = "درباره ما";
        $data->slug = "درباره-ما";
        $data->description = "متن";
        $data->is_published = 1;
        $data->save();
        $data = new Page;
        $data->name = "درباره ما";
        $data->slug = "شما-ما";
        $data->description = "متن";
        $data->is_published = 1;
        $data->save();
        $data = new Page;
        $data->name = "درباره ما";
        $data->slug = "ما-ما";
        $data->description = "متن";
        $data->is_published = 1;
        $data->save();
        $data = new Page;
        $data->name = "درباره ما";
        $data->slug = "همینا-ما";
        $data->description = "متن";
        $data->is_published = 1;
        $data->save();
    }
}
