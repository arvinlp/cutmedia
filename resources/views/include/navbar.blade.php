<a class="navbar-brand" href="{{route('homepage')}}">{{ config('site-info.site_name_menu') }}</a>
<button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId"
    aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="collapsibleNavId">
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        <li class="nav-item active">
            <a class="nav-link" href="{{route('homepage')}}">صفحه نخست <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('tvshows')}}">برنامه ها</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('people')}}">کاتی ها</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('homepage')}}/درباره-ما">درباره ما</a>
        </li>
    </ul>
</div>