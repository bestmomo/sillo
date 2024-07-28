<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Styles -->
        <style>
            body {
                background: url({{ asset('storage/hero.jpg') }}) no-repeat center center fixed;
                background-size: cover;
                color: #ffffff;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                font-family: 'Arial', sans-serif;
                margin: 0;
                overflow: hidden;
            }
            .container {
                text-align: center;
                background: rgba(0, 0, 0, 0.6);
                padding: 20px;
                border-radius: 10px;
            }
            .glitch {
                font-size: 4em;
                position: relative;
                animation: glitch 1.5s infinite;
            }
            .glitch:before, .glitch:after {
                content: '404';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                color: #ff3e3e;
                background: rgba(0, 0, 0, 0.6);
                overflow: hidden;
                clip: rect(0, 900px, 0, 0);
            }
            .glitch:after {
                color: #3eff3e;
                animation: glitch 1.5s infinite reverse;
            }
            p {
                font-size: 1.2em;
                margin-top: 20px;
            }
            a {
                color: #61dafb;
                text-decoration: none;
                border-bottom: 2px solid #61dafb;
                transition: color 0.3s, border-bottom-color 0.3s;
            }
            a:hover {
                color: #ff3e3e;
                border-bottom: 2px solid #ff3e3e;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="glitch">@yield('code')</div>
            @yield('message')
        </div>
    </body>
</html>
