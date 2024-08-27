@extends('layouts.front')

@section('content')
<div class="tv-show">
    <img src="{{asset($show->header)}}" alt="{{$show->name}}" class="single-cover">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="show-title">{{$show->name}}</h2>
            </div>
            <div class="col-12">
                <div class="show-description">{{$show->description}}</div>
            </div>
        </div>
    </div>
    <div class="container-fluid show-people">
        <div class="row">
            <div class="col-12">
                <h2 class="show-episodes title">تیم تولید برنامه</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach ($show->persons as $person)
            <div class="col-6 col-md-2">
                <a href="{{$person->link}}" title="{{$person->name}}">
                    <img src="{{asset($person->image)}}" class="img-circle" title="{{$person->name}}">
                    <h5>{{$person->name}}</h5>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="show-episodes title">قسمت های پخش شده</h2>
            </div>
            @foreach ($episodes as $episode)
            <div class="col-6 col-md-2 show-episodes">
                <a href="{{$episode->link}}" title="{{$episode->name}}">
                    <div class="tv-shows item">
                        <img src="{{asset($episode->thumb)}}" class="img-circle" title="{{$episode->name}}">
                        <div class="info">
                            <i class="fas fa-play-circle" aria-hidden="true"></i>
                        </div>
                    </div>
                    <h6 class="episode-title">{{$episode->name}}</h6>
                    <p class="episode-description">{{$episode->excerpt}}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('seo')
<title>{{ config('site-info.site_name') }} | برنامه {{$show->name}}</title>
<meta name="description" content="مشاهده برنامه {{$show->name}} تولید شده توسط رسانه اینترنتی کات مدیا" />
<meta name="keywords"
    content="cutmedia,Cut Media,کات مدیا,برنامه های کات مدیا,برنامه ها,شبکه های کات مدیا,شبکه ها,رسانه اینترنتی,رسانه نوآور,رسانه اینترنتی کرمان" />
<meta property="og:site_name" content="مشاهده برنامه {{$show->name}} تولید شده توسط رسانه اینترنتی کات مدیا" />
<meta property="og:description" content="مشاهده تمام برنامه های تولید شده توسط رسانه اینترنتی کات مدیا" />
<meta property="og:title" content="{{ config('site-info.site_name') }} |  برنامه {{$show->name}}" />
<meta property="og:locale" content="fa_IR" />
@endsection