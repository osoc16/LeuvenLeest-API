<!DOCTYPE html>
<html>
    <head>
        <title>Search Results</title>
    </head>
    <body>
        <pre>
<?php
    $json = file_get_contents("https://api.foursquare.com/v2/venues/search?ll=" . $_GET['lat'] . "," . $_GET['lng'] . "&client_id=GYRQTW0RT5Y1XJRSQOQDGXULAAMGSYGOAUWRITPHBKK0SJUR&client_secret=L1PSCN4KMV2ER0F44ETG4ZHM1UPHBKXJWHB0VG3T0A3CXJVF&v=20160711");
    $data = json_decode($json);
    
    foreach ($data->response->venues as $item)
    {
        echo ("Name: " . $item->name . "<br>");
        echo ("Lat: " . $item->location->lat . "<br>");
        echo ("Long: " . $item->location->lng . "<br>");
        echo ("Long: " . $item->categories[0]->name . "<br>");
        echo ("<br>");
    }

?>
        </pre>
    </body>
</html>
