<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
    </head>
    <body>
        <form action="/searching" method="get" accept-charset="UTF-8">
            <input name="lat" placeholder="Latitude" required>
            <input name="lng" placeholder="Longitude" required>
            <input type="submit">
        </form>

        <script type="text/javascript">
            navigator.geolocation.getCurrentPosition(function (pos) {
                var crd = pos.coords;
                document.querySelector('input[name=lat]').value = crd.latitude;
                document.querySelector('input[name=lng]').value = crd.longitude;
            });
        </script>
    </body>
</html>
