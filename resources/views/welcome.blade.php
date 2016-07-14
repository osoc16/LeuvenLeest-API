<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">LeuvenLeest</div>
                    @if (Auth::check()) 
                    Welcome back, {{ Auth::user()->name }} <a href="{{ url('auth/logout') }}"> logout</a>
                    @else
                    Hi guest 
                    <br/>
                    
                    <a href="auth/login/fb" ><img src="img/facebook-login-blue.png" alt="facebook login button" /></a>
                    <br/>
                    <a href="auth/login/google" ><img src="img/google-login.png" alt="google login button" /></a>
                    <br/>
                    <a href="auth/login"><img src="img/login-button.jpg" alt="login button"></a>
                    @endif
            </div>
        </div>
    </body>
</html>
