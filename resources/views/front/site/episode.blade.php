@extends('layouts.play')

@section('content')
{{-- <episode-player episode="{{$episode->file}}"></episode-player> --}}
{{!! $episode->file !!}}
@endsection

@section('seo')
<title>{{ config('site-info.site_name') }} | برنامه {{$episode->name}}</title>
<meta name="description" content="مشاهده برنامه {{$episode->name}} تولید شده توسط رسانه اینترنتی کات مدیا" />
<meta name="keywords"
    content="cutmedia,Cut Media,کات مدیا,برنامه های کات مدیا,برنامه ها,شبکه های کات مدیا,شبکه ها,رسانه اینترنتی,رسانه نوآور,رسانه اینترنتی کرمان" />
<meta property="og:site_name" content="مشاهده برنامه {{$episode->name}} تولید شده توسط رسانه اینترنتی کات مدیا" />
<meta property="og:description" content="مشاهده تمام برنامه های تولید شده توسط رسانه اینترنتی کات مدیا" />
<meta property="og:title" content="{{ config('site-info.site_name') }} |  برنامه {{$episode->name}}" />
<meta property="og:locale" content="fa_IR" />
@endsection

@section('footer')
<script>
</script>
@endsection