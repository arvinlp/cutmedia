@extends('layouts.front')

@section('content')
<div class="homepage-slides">
    <homepage-slide></homepage-slide>
</div>
<div class="advertise">
    <advertise-boxs></advertise-boxs>
</div>
<div class="special-tvshows">
    <div class="homepage-title">
        <h2>ویژه برنامه</h2>
    </div>
    <special-tv-shows></special-tv-shows>
</div>
<div class="lastes-tvshows">
    <div class="homepage-title">
        <h2>جدیدترین ها</h2>
    </div>
    <lastes-tv-shows></lastes-tv-shows>
</div>
<homepage-tv-shows></homepage-tv-shows>
@endsection

@section('seo')
<title>{{ config('site-info.site_name') }}</title>
<meta name="description" content="{{ config('site-info.description') }}" />
<meta name="keywords" content="{{ config('site-info.keywords') }}" />
<meta property="og:site_name" content="{{ config('site-info.site_name') }}" />
<meta property="og:description" content="{{ config('site-info.description') }}" />
<meta property="og:title" content="{{ config('site-info.site_name') }}" />
<meta property="og:locale" content="fa_IR" />
@endsection

@section('footer')
@endsection