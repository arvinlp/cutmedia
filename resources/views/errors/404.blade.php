@extends('layouts.front2')

@section('content')
<div class="container e-404">
    <div class="row">
        <div class="col-12">
            <div class="title">خطا ۴۰۴</div>
            <div class="description">متاسفانه صفحه که به دنبال آن هستید یافت نشد!</div>
            <a href="{{route('homepage')}}" class="cutmedia">
                کات مدیا رسانه نوآور
            </a>
        </div>
    </div>
</div>
@endsection

@section('seo')
<title>{{ config('site-info.site_name') }} | خطا ۴۰۴</title>
<meta name="description" content="صفحه مدنظر یافت نشد"/>
<meta name="keywords" content="cutmedia,Cut Media,کات مدیا,برنامه های کات مدیا,برنامه ها,شبکه های کات مدیا,شبکه ها,رسانه اینترنتی,رسانه نوآور,رسانه اینترنتی کرمان"/>
<meta property="og:site_name" content="{{ config('site-info.site_name') }} | برنامه ها"/>
<meta property="og:locale" content="fa_IR"/>
@endsection