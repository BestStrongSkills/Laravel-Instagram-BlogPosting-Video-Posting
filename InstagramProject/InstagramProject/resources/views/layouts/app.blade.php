<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>Instgram SlideShow</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href={{asset("css/bootstrap.min.css")}} rel="stylesheet">
        <link href={{asset("css/main.css")}} rel="stylesheet">
        <link rel="stylesheet" href="{{ asset("css/style.css") }}" />
        <link rel="stylesheet" href="{{ asset("css/image-picker.css") }}" />
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <script type="text/javascript" src="{{asset("js/jquery-3.2.1.min.js")}}"></script>
    </head>
    <body>
        <div class="site-wrapper">
            <div class="site-wrapper-inner">
                <div class="cover-container">

                    <main role="main" class="inner cover">
                        @yield('content')
                    </main>
                    <footer class="mastfoot">
                        <div class="inner">
                          <p style="color:white;">Thanks for your attention!!!</p>
                        </div>
                    </footer>
                  
                </div>
            </div>
        </div>
        <script type="text/javascript" src="{{asset("js/popper.min.js")}}"></script>
        <script type="text/javascript" src="{{asset("js/bootstrap.min.js")}}"></script>
        <script type="text/javascript" src="{{asset("js/image-picker.min.js")}}"></script>
        @yield('footer_script')
    </body>
</html>
