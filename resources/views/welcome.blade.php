<!DOCTYPE html>
<html>
    <head>
        <title>LeuvenLeest API</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{!! asset('css/app.css') !!}">
    </head>
    <body>
    	<div id="content">
	    	<h1>LeuvenLeest - API</h1>
	    	<h2>Login and registration</h2>
	    	<hr>

	    	<h2>Basic usage - GET</h2>
	    	<p class="quote">
				var settings = {<br>
				&emsp;"async": true,<br>
				&emsp;"crossDomain": true,<br>
				&emsp;"url": <strong>URL</strong>,<br>
				&emsp;"method": "GET",<br>
				&emsp;"headers": {<br>
				&emsp;&emsp;"Authorization": "Bearer <strong>USER_TOKEN</strong>",<br>
				&emsp;&emsp;"Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8"<br>
				&emsp;},<br>
				&emsp;"processData": false,<br>
				&emsp;"contentType": false,<br>
				&emsp;"mimeType": "multipart/form-data"<br>
				}<br>
				<br>
				$.ajax(settings).done(function (response) {<br>
				&emsp;console.log(JSON.parse(response));<br>
				});
	    	</p>
	    	<hr>

	    	<h2>#Users</h2>

	    	<p>
	    		<strong>getUserById</strong><br>
	    		Get user by ID, you only need to pass the ID<br>
	    		Returns users:<br>
	    		<i>id</i>, <i>name</i>, <i>email</i>, <i>password</i>, <i>remember_token</i>, <i>created_at</i> and <i>updated_at</i>.
	    	</p>
	    	<p class="quote">"url": "http://95.85.15.210/user/get/<strong>USER_ID</strong>",</p>
	    	
	    	<hr>

	    	<h2>#Places</h2>

	    	<p>
	    		<strong>getPlaces</strong><br>
	    		Get the places ordered by distance (in km) by passing latitude and longitude<br>
	    		Returns all places:<br>
	    		<i>id</i>, <i>foursquareId</i>, <i>geoId</i>, <i>name</i>, <i>address</i>, <i>description</i>, <i>userId</i>, <i>email</i>, <i>categoryId</i>, <i>site</i>, <i>created_at</i>, <i>updated_at</i>, <i>longitude</i> and <i>distance</i>.
	    	</p>
	    	<p class="quote">"url": "http://95.85.15.210/places/<strong>LATITUDE</strong>/<strong>LONGITUDE</strong>",</p>

	    	<p>
	    		<strong>getPlaceById</strong><br>
	    		Get place by ID, you only need to pass the ID<br>
	    		Returns place:<br>
	    		<i>id</i>, <i>foursquareId</i>, <i>geoId</i>, <i>name</i>, <i>address</i>, <i>description</i>, <i>userId</i>, <i>email</i>, <i>categoryId</i>, <i>site</i>, <i>created_at</i>, <i>updated_at</i>, <i>longitude</i> and <i>distance</i>.
	    	</p>
	    	<p class="quote">"url": "http://95.85.15.210/places/<strong>PLACE_ID</strong>",</p>

	    	<p>
	    		<strong>getPlacesByCategory</strong><br>
	    		Same as <strong>getPlaces</strong>, but with category ID<br>
	    		Returns all places with category ID:<br>
	    		<i>id</i>, <i>foursquareId</i>, <i>geoId</i>, <i>name</i>, <i>address</i>, <i>description</i>, <i>userId</i>, <i>email</i>, <i>categoryId</i>, <i>site</i>, <i>created_at</i>, <i>updated_at</i>, <i>longitude</i> and <i>distance</i>.
	    	</p>
	    	<p class="quote">"url": "http://95.85.15.210/places/getPlacesByCategory/<strong>CATEGORY_ID</strong>/<strong>LATITUDE</strong>/<strong>LONGITUDE</strong>",</p>
	    	
	    	<hr>

	    	<h2>Check-in</h2>

	    	<p>
	    		<strong>getLatestCheckin</strong><br>
	    		get the latest created checkins
	    	</p>
	    	<p class="quote">"url": "http://95.85.15.210/checkin/latest/<strong>USER_ID</strong>",</p>

	    	<p>
	    		<strong>getRecentCheckins</strong><br>
	    		get the latest updated checkins
	    	</p>
	    	<p class="quote">"url": "http://95.85.15.210/checkin/recent/<strong>USER_ID</strong>",</p>

	    	<hr>

	    	<h2>Basic usage - PUT</h2>
	    	<p class="quote">
		    	var form = new FormData();<br>
				form.append(<strong>FORM_KEY</strong>, <strong>FORM_VALUE</strong>);<br>
				<br>
				var settings = {<br>
				&emsp;"async": true,<br>
				&emsp;"crossDomain": true,<br>
				&emsp;"url": <strong>URL</strong>,<br>
				&emsp;"method": "PUT",<br>
				&emsp;"headers": {<br>
				&emsp;&emsp;"Authorization": "Bearer <strong>USER_TOKEN</strong>",<br>
				&emsp;&emsp;"Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8"<br>
				&emsp;},<br>
				&emsp;"processData": false,<br>
				&emsp;"contentType": false,<br>
				&emsp;"mimeType": "multipart/form-data",<br>
				&emsp;"data": form<br>
				}
	    	</p>
	    	<hr>
	    </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript">
    	
    </script>
</html>
