@extends('layouts.front2')

@section('content')
<div class="people-page">
    <div class="container-fluid show-people">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="people-title">کاتی ها</h2>
            </div>
            @foreach ($people as $person)
            <div class="col-6 col-md-2">
                <a href="{{$person->link}}" title="{{$person->name}}">
                    <img src="{{asset($person->image)}}" class="img-circle" title="{{$person->name}}">
                    <h5>{{$person->name}}</h5>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('seo')
<title>{{ config('site-info.site_name') }} | اعضا رسانه</title>
<meta name="description" content="اعضا و افراد شرکت کننده در برنامه های تولید شده توسط رسانه اینترنتی کات مدیا" />
<meta name="keywords"
    content="cutmedia,Cut Media,کات مدیا,برنامه های کات مدیا,برنامه ها,شبکه های کات مدیا,شبکه ها,رسانه اینترنتی,رسانه نوآور,رسانه اینترنتی کرمان" />
<meta property="og:site_name" content="{{ config('site-info.site_name') }} | برنامه ها" />
<meta property="og:description" content="اعضا و افراد شرکت کننده در برنامه های تولید شده توسط رسانه اینترنتی کات مدیا" />
<meta property="og:title" content="{{ config('site-info.site_name') }} | اعضا رسانه" />
<meta property="og:locale" content="fa_IR" />
@endsection