@extends('layouts.front2')

@section('content')
<div class="page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">{{$page->name}}</h2>
            </div>
            <div class="col-12">
                <div class="page-content">{!! $page->description !!}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('seo')
<title>{{ config('site-info.site_name') }} | {{$page->name}}</title>
<meta name="description" content="{{$page->excerpt}}" />
<meta name="keywords"
    content="cutmedia,Cut Media,کات مدیا,برنامه های کات مدیا,برنامه ها,شبکه های کات مدیا,شبکه ها,رسانه اینترنتی,رسانه نوآور,رسانه اینترنتی کرمان" />
<meta property="og:site_name" content="{{ config('site-info.site_name') }} | {{$page->name}}" />
<meta property="og:description" content="{{$page->excerpt}}" />
<meta property="og:title" content="{{ config('site-info.site_name') }} | {{$page->name}}" />
<meta property="og:locale" content="fa_IR" />
@endsection