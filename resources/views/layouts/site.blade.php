<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<base href="https://dompapochki.by/" />--}}
    <meta name="author" content="1pxby">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    {{--<meta name="keywords" content="пицца, доставка, минск,осетинские пироги,">--}}
    <meta name="author" content="1px.by">
    <meta name="robots" content="index, follow">

    <meta property="og:site_name" content="dompapochki.by">

    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="/" />
    <meta property="og:image" content="https://dompapochki.by/images/previewsite.jpg">


    <meta name="google-site-verification" content="b-40QjMnW7qI9fjdSgjSfyXQNhlW0jXmegTVnklPvvk" />
    <meta name='yandex-verification' content='6703979e74b4d1a0' />

    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('/images/icon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('/images/icon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('/images/icon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/images/icon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('/images/icon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('/images/icon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('/images/icon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('/images/icon/apple-icon-144x144.png')}}" >
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('/images/icon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/images/icon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('/images/icon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/images/icon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('/images/icon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/images/icon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('/images/icon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('/images/icon/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">

    @yield('before-css')
    {{-- theme css --}}

     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
    <link href="{{asset('/themes/dpnew/css/style.css')}}" rel="stylesheet">

    {{-- page specific css --}}
    @yield('page-css')
    
    <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(62047174, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        ecommerce:"shopData"
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/62047174" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-163945386-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-163945386-1');
</script>


    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container">
        @php($messageShow = App\Http\Models\Settings::getValue('top_site_message_show'))
        @if(isset($messageShow) && !empty($messageShow) && $messageShow == 1)
            @php($message = App\Http\Models\Settings::getValue('top_site_message'))
            @if(isset($message) && !empty($message))
                <div class="text-center pt-4 pb-1">
                    <h4 class="text-uppercase">{{$message}}</h4>
                </div>
                <hr>
            @endif
        @endif
        @include('layouts.site-header-menu')
        {{-- end of header menu --}}

        @if(\Illuminate\Support\Facades\Route::currentRouteName() !== 'cart')
            @include('layouts.cart-modal')
        @endif

        @yield('main-content')

        @include('layouts.site-footer')
    </div>

    <?php $phone = \App\Http\Models\Settings::getValue('phone_delivery')?>
    <a href="tel:<?=$phone?>" class="phone-btn">
        <div class="call"></div>
    </a>

    {{-- page specific js --}}
    @yield('page-js')

    {{-- laravel js --}}
    {{-- <script src="{{mix('assets/js/laravel/app.js')}}"></script> --}}

    @yield('bottom-js')
</body>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script
  src="https://code.jquery.com/jquery-3.1.0.min.js"
  integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="{{asset('/themes/dpnew/js/jquery.mask.min.js')}}"></script>
    <script src="{{asset('/themes/dpnew/js/scripts.js')}}"></script>
</html>
