<!DOCTYPE html>
<html itemscope="" itemtype="http://schema.org/WebPage" lang="vi">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {%HEADER%}
    <link rel="stylesheet" href="{{ assetFile('theme/frontend/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ assetFile('theme/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ assetFile('theme/frontend/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ assetFile('theme/frontend/css/m-pagetransition-styles.css') }}">
    <link rel="stylesheet" href="{{ assetFile('theme/frontend/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ assetFile('theme/frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ assetFile('theme/frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ assetFile('theme/frontend/css/reset.css') }}">
    <link rel="stylesheet" href="{{ assetFile('theme/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ assetFile('theme/frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ assetFile('theme/frontend/css/upgrade.css') }}">
    <style type="text/css">
    .box-links__greens .intros-links__texts {
        background-color: #2BB18F;
        color: #000000;
    }

    .box-links__violet .intros-links__texts {
        background-color: #E0EA8F;
        color: #7F1ACB;
    }

    .box-links__blues .intros-links__texts {
        background-color: #2B298F;
        color: #FFFFFF;
    }
    a{
        color:{{$this->CI->Dindex->getSettings("COLOR_MAIN_HV")}};
    }
    a:hover,
    a:focus{
        color:{{$this->CI->Dindex->getSettings("COLOR_MAIN")}};
    }
    </style>
    <script type="text/javascript">
        var url = '{{$this->CI->session->flashdata('url')}}';
    </script>
    @yield('css')
    <script type="text/javascript">
      var currentLang = '{{pGetLanguage()}}';
      var defaultLang = '{{pgetDefaultLanguage()}}';
    </script>
</head>

<body class="scrollstyle1 {{ isset($isHome) ? 'home-page':'other-page' }}  @yield('css_popup')">
    @include('header')
    @yield('content')
    @section('popup')
        @include('section.popup')
    @show
    @section('footer')
        @include('footer')
    @show
    <div class="back-to-top smooth">
        <img src="theme/frontend/images/up-arrow.svg" class="img-fluid" alt="Backtotop">
    </div>
    <script src="{{ assetFile('theme/frontend/js/jquery-3.4.1.min.js') }}" defer></script>
    <script src="{{ assetFile('theme/frontend/js/bootstrap.min.js') }}" defer></script>
    <script src="{{ assetFile('theme/frontend/js/moment.min.js') }}" defer></script>
    <script src="{{ assetFile('theme/frontend/js/wow.min.js') }}" defer></script>
    <script src="{{ assetFile('theme/frontend/js/masonry.js') }}" defer></script>
    <script src="{{ assetFile('theme/frontend/js/toastr.min.js') }}" defer></script>
    <script src="{{ assetFile('theme/frontend/js/m-pagetransition.js') }}" defer></script>
    <script src="{{ assetFile('theme/frontend/js/valiForm.min.js') }}" defer></script>
    <script src="{{ assetFile('theme/frontend/js/swiper.min.js') }}" defer></script>
    <script src="{{ assetFile('theme/frontend/js/anime.js') }}" defer></script>
    <script src="{{ assetFile('theme/frontend/js/script.js') }}" defer></script>
    <script src="{{ assetFile('theme/frontend/js/script_th.js') }}" defer></script>
    <script src="{{ assetFile('theme/frontend/js/effect.js') }}" defer></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    @yield('js')
</body>

</html>