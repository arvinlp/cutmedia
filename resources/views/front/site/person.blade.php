@extends('layouts.front2')

@section('content')
<div class="person-page">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-2">
                <img src="{{asset($person->image)}}" class="img-circle" title="{{$person->name}}">
            </div>
            <div class="col-12 col-md-10">
                <h2 class="show-title">{{$person->name}}</h2>
                <div class="show-description">{{$person->description}}</div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 class="shows title">برنامه های که حظور داشته است</h4>
            </div>
            @foreach ($person->shows as $show)
            <div class="col-6 col-md-4 shows">
                <a href="{{$show->link}}" title="{{$show->name}}">
                    <div class="tv-shows item">
                        <img src="{{asset($show->thumb)}}" class="img-circle" title="{{$show->name}}">
                        <div class="info">
                            <i class="fas fa-play-circle" aria-hidden="true"></i>
                        </div>
                    </div>
                    <h6 class="show-title">{{$show->name}}</h6>
                    <p class="show-description">{{$show->excerpt}}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('seo')
<title>{{ config('site-info.site_name') }} | {{$person->name}}</title>
<meta name="description" content="صفحه {{$person->name}} در رسانه اینترنتی کات مدیا" />
<meta name="keywords"
    content="cutmedia,Cut Media,کات مدیا,برنامه های کات مدیا,برنامه ها,شبکه های کات مدیا,شبکه ها,رسانه اینترنتی,رسانه نوآور,رسانه اینترنتی کرمان" />
<meta property="og:site_name" content="{{ config('site-info.site_name') }} | برنامه ها" />
<meta property="og:description" content="صفحه {{$person->name}} در رسانه اینترنتی کات مدیا" />
<meta property="og:title" content="{{ config('site-info.site_name') }} | {{$person->name}}" />
<meta property="og:locale" content="fa_IR" />
@endsection