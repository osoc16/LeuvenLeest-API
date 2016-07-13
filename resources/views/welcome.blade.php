<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <script src='https://code.jquery.com/jquery-3.0.0.min.js'></script>

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
<meta content="{{ csrf_token() }}" name="_token">

        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
            </div>
        </div>
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: '/checkin/1/123/123',
                    dataType : "json",
                    processData:false,
                    contentType:false,
                    data: {
                         '_token':$('meta[name="_token"]').attr('content')
                    },
                    success: function(response){
                        console.log(response);
                    },
                    error: function(response) {
                    }
                })
             });



        </script>
    </body>
</html>
