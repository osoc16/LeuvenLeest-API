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
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v2.6&appId=1648199705507270";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <div class="container">
            <div class="content">
                <div class="title">LeuvenLeest</div>
                    @if (Auth::check()) 
                    Welcome back, {{ Auth::user()->name }} <a href="auth/logout"> logout</a>
                    @else
                    Hi guest 
                    
                    <a href="auth/login/fb" >
                        <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="false"></div>
                    </a>
                    <br/>
                    or <a href="auth/login/google" >login with google</a>
                    <br/>
                    or <a href="auth/login">Go to the login page</a>
                    @endif
            </div>
        </div>
    </body>
</html>
