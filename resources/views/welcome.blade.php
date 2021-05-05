<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>My Hobbies | Find people who share the same hobbies with you!</title>
        <meta name="description" content="Share your hobbies with people who have the same passion as yours.">
        <meta name="keywords" content="music, movie, reading, gaming, travel, share my passion, entertainment, spare time hobby">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(7,97,145,1) 52%, rgba(0,212,255,1) 100%);
                color: #F5F5F5;
                font-family: 'Nunito', sans-serif;
                font-weight: 300;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 40px;
            }

            .subtitle {
                font-size: 23px;
            }

            .links > a {
                color: #F5F5F5;
                padding: 0 25px;
                font-size: 23px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                text-shadow: 2px 2px 4px #042D57;
            }
        </style>

        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-175585308-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-175585308-1');
        </script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>

            <div class="content">
                <div class="title m-b-md">
                    <img src="images/logo.png" width="100"><br>
                    My hobbies<br>
                    <p class="subtitle">Find people who share the same hobbies with you!</p>
                </div>
            </div>
        </div>
    </body>
</html>
