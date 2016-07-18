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
	    	<h2>#Users</h2>
	    	<p><strong>getUserById</strong>: Get user by ID, you only need to pass the ID<br></p>
	    	<p class="quote">
				var settings = {<br>
				&emsp;"async": true,<br>
				&emsp;"crossDomain": true,<br>
				&emsp;"url": "http://95.85.15.210/user/get/<strong>USER_ID</strong>",<br>
				&emsp;"method": "GET",<br>
				&emsp;"headers": {<br>
				&emsp;&emsp;"Authorization": "Bearer <strong>TOKEN</strong>",<br>
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

	    	<h2>#Places</h2>
	    	<p><strong>getPlaces</strong>: Get the places ordered by distance (in km) by passing latitude and longitude<br></p>
	    	<p class="quote">
				var settings = {<br>
				&emsp;"async": true,<br>
				&emsp;"crossDomain": true,<br>
				&emsp;"url": "http://95.85.15.210/places/<strong>LATITUDE</strong>/<strong>LONGITUDE</strong>",<br>
				&emsp;"method": "GET",<br>
				&emsp;"headers": {<br>
				&emsp;&emsp;"Authorization": "Bearer <strong>TOKEN</strong>",<br>
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

	    	<p><strong>getPlaceById</strong>: Get place by ID, you only need to pass the ID<br></p>
	    	<p class="quote">
				var settings = {<br>
				&emsp;"async": true,<br>
				&emsp;"crossDomain": true,<br>
				&emsp;"url": "http://95.85.15.210/places/1",<br>
				&emsp;"method": "GET",<br>
				&emsp;"headers": {<br>
				&emsp;&emsp;"Authorization": "Bearer ",<br>
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

	    	<p><strong>getPlacesByCategory</strong>: Same as <strong>getPlaces</strong>, but with  category ID</p>
	    	<p><strong>getPlaces</strong>: Get the places ordered by distance (in km) by passing latitude and longitude<br></p>
	    	<p class="quote">
				var settings = {<br>
				&emsp;"async": true,<br>
				&emsp;"crossDomain": true,<br>
				&emsp;"url": "http://95.85.15.210/places/getPlacesByCategory/<strong>CATEGORY_ID</strong>/<strong>LATITUDE</strong>/<strong>LONGITUDE</strong>",<br>
				&emsp;"method": "GET",<br>
				&emsp;"headers": {<br>
				&emsp;&emsp;"Authorization": "Bearer <strong>TOKEN</strong>",<br>
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
	    </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript">
    	var form = new FormData();
		form.append("name", "PlaceName");
		form.append("address", "Somewhere");
		form.append("description", "Idk");
		form.append("email", "yknow@me.me");
		form.append("categoryId", "1");
		form.append("site", "site.www");
		form.append("latitude", "50");
		form.append("longitude", "4");

		var settings = {
		  "async": true,
		  "crossDomain": true,
		  "url": "http://95.85.15.210/places/add",
		  "method": "PUT",
		  "headers": {
		    "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjQsImlzcyI6Imh0dHA6XC9cLzk1Ljg1LjE1LjIxMFwvYXV0aFwvbG9naW4iLCJpYXQiOjE0Njg4NDE0MTcsImV4cCI6MTQ2ODg0NTAxNywibmJmIjoxNDY4ODQxNDE3LCJqdGkiOiJiZTliNTRjYTRmNTA0NGM0NzdkYmJiMTQ1OTNlMzVjYiJ9.TIRRrMhn1c6emUc2oLNC_7ufC760gEDH0RDcHyRlBL0",
		    "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8"
		  },
		  "processData": false,
		  "contentType": false,
		  "mimeType": "multipart/form-data",
		  "data": form
		}

		$.ajax(settings).done(function (response) {
			console.log(JSON.parse(response));
		});
    </script>
</html>
