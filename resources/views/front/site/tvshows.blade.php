@extends('layouts.front2')

@section('content')
<div class="tvShows-list">
    <div class="container-fluid">
        <div class="row">
            @foreach ($tvShows as $tvShow)
            <div class="col-12 col-md-3">
                <a href="{{$tvShow->link}}" class="tv-show" title="{{$tvShow->name}}">
                    <span>{{$tvShow->name}}</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
<tv-shows :class="mt-md-5"></tv-shows>
@endsection

@section('seo')
<title>{{ config('site-info.site_name') }} | برنامه ها</title>
<meta name="description" content="مشاهده تمام برنامه های تولید شده توسط رسانه اینترنتی کات مدیا"/>
<meta name="keywords" content="cutmedia,Cut Media,کات مدیا,برنامه های کات مدیا,برنامه ها,شبکه های کات مدیا,شبکه ها,رسانه اینترنتی,رسانه نوآور,رسانه اینترنتی کرمان"/>
<meta property="og:site_name" content="{{ config('site-info.site_name') }} | برنامه ها"/>
<meta property="og:description" content="مشاهده تمام برنامه های تولید شده توسط رسانه اینترنتی کات مدیا"/>
<meta property="og:title" content="{{ config('site-info.site_name') }} | برنامه ها"/>
<meta property="og:locale" content="fa_IR"/>
@endsection