<!DOCTYPE html>
<html>
    <head>
        <title>LeuvenLeest API</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{!! asset('css/app.css') !!}">
    </head>
    <body>
    	<div id="all">
	    	<nav>
	    		<h2>Navigation</h2>
	    		<ul>
	    			<li class="hover"><a href="#User">User</a></li>
	    			<ul class="close">
		    			<li>- <a href="#register">register</a></li>
	    				<li>- <a href="#login">login</a></li>
	    				<li>- <a href="#logout">logout</a></li>
	    			</ul>
	    			<li class="hover"><a href="#GET">GET</a></li>
	    			<ul class="close">
		    			<li>- <a href="#GETUser">User</a></li>
		    			<ul>
			    			<li><a href="#getUserById">getUserById</a></li>
		    			</ul>
		    			<li>- <a href="#GETPlaces">Places</a></li>
		    			<ul>
			    			<li><a href="#getPlaces">getPlaces</a></li>
			    			<li><a href="#getPlacesPictures">getPlacesPictures</a></li>
			    			<li><a href="#getPlaceById">getPlaceById</a></li>
			    			<li><a href="#getPlacesByCategory">getPlacesByCategory</a></li>
			    			<li><a href="#getTrendingPlaces">getTrendingPlaces</a></li>
			    			<li><a href="#getFavouritePlaces">getFavouritePlaces</a></li>
		    			</ul>
		    			<li>- <a href="#GETCheckin">Checkin</a></li>
		    			<ul>
			    			<li><a href="#getLatestCheckin">getLatestCheckin</a></li>
			    			<li><a href="#getRecentCheckins">getRecentCheckins</a></li>
		    			</ul>
		    			<li>- <a href="#GETQuestions">Questions</a></li>
		    			<ul>
			    			<li><a href="#getRandomQuestion">getRandomQuestion</a></li>
			    			<li><a href="#getQuestions">getQuestions</a></li>
			    			<li><a href="#getRating">getRating</a></li>
			    			<li><a href="#getEvaluations">getEvaluations</a></li>
			    			<li><a href="#evaluate">evaluate</a></li>
		    			</ul>
	    			</ul>
	    			<li class="hover"><a href="#POST">POST / PUT</a></li>
	    			<ul class="close">
		    			<li>- <a href="#POSTPlaces">Places</a></li>
		    			<ul>
		    				<li><a href="#addPlace">addPlace</a></li>
		    				<li><a href="#addToFavourites">addToFavourites</a></li>
		    				<li><a href="#removeFromFavourites">removeFromFavourites</a></li>
		    				<li><a href="#uploadPhoto">uploadPhoto</a></li>
		    				<li><a href="#addOpeningHours">addOpeningHours</a></li>
		    				<li><a href="#updateOpeningHours">updateOpeningHours</a></li>
		    			</ul>
		    			<li>- <a href="#POSTCheckin">Checkin</a></li>
		    			<ul>
		    				<li><a href="#checkin">checkin</a></li>
		    			</ul>
	    			</ul>
	    		</ul>
	    	</nav>
	    	<div id="content">
		    	<h1>LeuvenLeest - API</h1>
		    	<h2><a name="User">Login and registration</a></h2>
		    	<p>Whenever a user logs-in/registers, they recieve a <strong>USER_TOKEN</strong>, use this when making calls to the database.</p>
		    	<p>
		    		<strong><a name="register">register</a></strong><br>
		    		Register the user into the database.<br>
		    		Returns the USER_TOKEN.
		    	</p>
		    	<p class="quote">
		    		&emsp;var settings = {<br>
					&emsp;&emsp;"async": true,<br>
					&emsp;&emsp;"crossDomain": true,<br>
					&emsp;&emsp;"url": "http://95.85.15.210/auth/register",<br>
					&emsp;&emsp;"method": "PUT",<br>
					&emsp;&emsp;"headers": {<br>
					&emsp;&emsp;&emsp;"content-type": "application/x-www-form-urlencoded"<br>
					&emsp;&emsp;},<br>
					&emsp;&emsp;"data": {<br>
					&emsp;&emsp;&emsp;"name": "<strong>NAME</strong>",<br>
					&emsp;&emsp;&emsp;"email": "<strong>EMAIL</strong>",<br>
					&emsp;&emsp;&emsp;"password": "<strong>PASSWORD</strong>",<br>
					&emsp;&emsp;&emsp;"password_confirmation": "<strong>PASSWORD_CONFIRM</strong>"<br>
					&emsp;&emsp;}<br>
					&emsp;}<br>
					<br>
					&emsp;$.ajax(settings).done(function (response) {<br>
					&emsp;&emsp;console.log(JSON.parse(response)); // This will be the token<br>
					&emsp;});
		    	</p>

		    	<p>
		    		<strong><a name="login">login</a></strong><br>
		    		Log-in a user.<br>
		    		Returns the USER_TOKEN.
		    	</p>
		    	<p class="quote">
					&emsp;var settings = {<br>
					&emsp;&emsp;"async": true,<br>
					&emsp;&emsp;"crossDomain": true,<br>
					&emsp;&emsp;"url": "http://95.85.15.210/auth/login",<br>
					&emsp;&emsp;"method": "POST",<br>
					&emsp;&emsp;"processData": false,<br>
					&emsp;&emsp;"contentType": false,<br>
					&emsp;&emsp;"mimeType": "multipart/form-data",<br>
					&emsp;&emsp;"data": {<br>
					&emsp;&emsp;&emsp;"email": "<strong>EMAIL</strong>",<br>
					&emsp;&emsp;&emsp;"password": "<strong>PASSWORD</strong>"<br>
					&emsp;&emsp;}<br>
					&emsp;}<br>
					<br>
					&emsp;$.ajax(settings).done(function (response) {<br>
					&emsp;&emsp;console.log(JSON.parse(response)); // This will be the token<br>
					&emsp;});
		    	</p>

		    	<p>
		    		<strong><a name="logout">logout</a></strong><br>
		    		Logs-out a user.<br>
		    		Return nothing.
		    	</p>
		    	<p class="quote">
					&emsp;var settings = {<br>
					&emsp;&emsp;"async": true,<br>
					&emsp;&emsp;"crossDomain": true,<br>
					&emsp;&emsp;"url": "http://95.85.15.210/auth/logout",<br>
					&emsp;&emsp;"method": "POST"<br>
					&emsp;}<br>
					<br>
					&emsp;$.ajax(settings).done(function (response) {<br>
					&emsp;&emsp;console.log(response);<br>
					&emsp;});
		    	</p>

		    	<hr>
		    	<hr>
		    	<hr>

		    	<h2><a name="GET">Basic usage - GET</a></h2>
		    	<p>GET is used to get information from the database.</p>
		    	<p class="quote">
					var settings = {<br>
					&emsp;"async": true,<br>
					&emsp;"crossDomain": true,<br>
					&emsp;"url": "<strong>URL</strong>",<br>
					&emsp;"method": "<strong>METHOD</strong>",<br>
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

		    	<h2><a name="GETUser">Users</a></h2>

		    	<p>
		    		<strong><a name="getUserById">getUserById</a></strong><br>
		    		Get user by ID, you only need to pass the ID<br>
		    		Returns users:<br>
		    		<i>id</i>, <i>name</i>, <i>email</i>, <i>password</i>, <i>remember_token</i>, <i>created_at</i> and <i>updated_at</i>.
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/user/get/<strong>USER_ID</strong>",<br>
		    		"method": "GET"
		    	</p>
		    	
		    	<hr>

		    	<h2><a name="GETPlaces">Places</a></h2>

		    	<p>
		    		<strong><a name="getPlaces">getPlaces</a></strong><br>
		    		Get the places ordered by distance (in km) by passing latitude and longitude<br>
		    		Returns all places:<br>
		    		<i>id</i>, <i>foursquareId</i>, <i>geoId</i>, <i>name</i>, <i>address</i>, <i>description</i>, <i>userId</i>, <i>email</i>, <i>categoryId</i>, <i>site</i>, <i>created_at</i>, <i>updated_at</i>, <i>openingHours</i>, <i>longitude</i> and <i>distance</i>.<br>
		    		<span style="color: red;">WARNING</span> The openingHours returns an array with 7 arrays, one for each day of the week.<br>
		    		Sunday is 0, Monday is 1, Tuesday is 2, Wednesday is 3, Thursday is 4, Friday is 5 and Saturday is 6.
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/places/<strong>LATITUDE</strong>/<strong>LONGITUDE</strong>",<br>
		    		"method": "GET"
		    	</p>

		    	<p>
		    		<strong><a name="getPlacesPictures">getPlacesPictures</a></strong><br>
		    		Get the pictures of a place<br>
		    		Returns all pictures:<br>
		    		<i>id</i>, <i>userId</i>, <i>placeId</i>, <i>name</i> (link to the image), <i>created_at</i>, <i>updated_at</i>
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/places/<strong>PLACE_ID</strong>/photos",<br>
		    		"method": "GET"
		    	</p>

		    	<p>
		    		<strong><a name="getPlaceById">getPlaceById</a></strong><br>
		    		Get place by ID, you only need to pass the ID<br>
		    		Returns place:<br>
		    		<i>id</i>, <i>foursquareId</i>, <i>geoId</i>, <i>name</i>, <i>address</i>, <i>description</i>, <i>userId</i>, <i>email</i>, <i>categoryId</i>, <i>site</i>, <i>created_at</i>, <i>updated_at</i>, <i>openingHours</i>, <i>longitude</i> and <i>distance</i>.<br>
		    		<span style="color: red;">WARNING</span> The openingHours returns an array with 7 arrays, one for each day of the week.<br>
		    		Sunday is 0, Monday is 1, Tuesday is 2, Wednesday is 3, Thursday is 4, Friday is 5 and Saturday is 6.
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/places/<strong>PLACE_ID</strong>",<br>
		    		"method": "GET"
		    	</p>

		    	<p>
		    		<strong><a name="getPlacesByCategory">getPlacesByCategory</a></strong><br>
		    		Same as <strong>getPlaces</strong>, but with category ID<br>
		    		Returns all places with category ID:<br>
		    		<i>id</i>, <i>foursquareId</i>, <i>geoId</i>, <i>name</i>, <i>address</i>, <i>description</i>, <i>userId</i>, <i>email</i>, <i>categoryId</i>, <i>site</i>, <i>created_at</i>, <i>updated_at</i>, <i>openingHours</i>, <i>longitude</i> and <i>distance</i>.<br>
		    		<span style="color: red;">WARNING</span> The openingHours returns an array with 7 arrays, one for each day of the week.<br>
		    		Sunday is 0, Monday is 1, Tuesday is 2, Wednesday is 3, Thursday is 4, Friday is 5 and Saturday is 6.
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/places/getPlacesByCategory/<strong>CATEGORY_ID</strong>/<strong>LATITUDE</strong>/<strong>LONGITUDE</strong>",<br>
		    		"method": "GET"
		    	</p>

		    	<p>
		    		<strong><a name="getTrendingPlaces">getTrendingPlaces</a></strong><br>
		    		Get the trending places.<br>
		    		Returns: <br>
		    		<i>id</i>, <i>foursquareId</i>, <i>geoId</i>, <i>name</i>, <i>address</i>, <i>description</i>, <i>userId</i>, <i>email</i>, <i>categoryId</i>, <i>site</i>, <i>created_at</i>, <i>updated_at</i>, <i>openingHours</i>, <i>longitude</i> and <i>distance</i>.<br>
		    		<span style="color: red;">WARNING</span> The openingHours returns an array with 7 arrays, one for each day of the week.<br>
		    		Sunday is 0, Monday is 1, Tuesday is 2, Wednesday is 3, Thursday is 4, Friday is 5 and Saturday is 6.
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/places/trending",<br>
		    		"method": "GET"
		    	</p>

		    	<p>
		    		<strong><a name="getFavouritePlaces">getFavouritePlaces</a></strong><br>
		    		Get the users favourite places.<br>
		    		Returns: <br>
		    		<i>id</i>, <i>foursquareId</i>, <i>geoId</i>, <i>name</i>, <i>address</i>, <i>description</i>, <i>userId</i>, <i>email</i>, <i>categoryId</i>, <i>site</i>, <i>created_at</i>, <i>updated_at</i>, <i>openingHours</i>, <i>longitude</i> and <i>distance</i>.<br>
		    		<span style="color: red;">WARNING</span> The openingHours returns an array with 7 arrays, one for each day of the week.<br>
		    		Sunday is 0, Monday is 1, Tuesday is 2, Wednesday is 3, Thursday is 4, Friday is 5 and Saturday is 6.
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/places/favourite",<br>
		    		"method": "GET"
		    	</p>
		    	
		    	<hr>

		    	<h2><a name="GETCheckin">Checkin</a></h2>

		    	<p>
		    		<strong><a name="getLatestCheckin">getLatestCheckin</a></strong><br>
		    		get the latest created checkins
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/checkin/latest/<strong>USER_ID</strong>",<br>
		    		"method": "GET"
		    	</p>

		    	<p>
		    		<strong><a name="getRecentCheckins">getRecentCheckins</a></strong><br>
		    		get the latest updated checkins
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/checkin/recent/<strong>USER_ID</strong>",<br>
		    		"method": "GET"
		    	</p>

		    	<h2><a name="GETQuestions">Questions</a></h2>

		    	<p>
		    		<strong><a name="getRandomQuestion">getRandomQuestion</a></strong><br>
		    		Get a random question to ask the user<br>
		    		Returns a question:<br>
		    		<i>id</i>, <i>question</i>
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/questions/get",<br>
		    		"method": "GET"
		    	</p>

		    	<p>
		    		<strong><a name="getQuestions">getQuestions</a></strong><br>
		    		Gets all the questions<br>
		    		Returns:<br>
		    		<i>id</i>, <i>question</i>
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/questions",<br>
		    		"method": "GET"
		    	</p>

		    	<p>
		    		<strong><a name="getRating">getRating</a></strong><br>
		    		Gets the rating of a place<br>
		    		Returns:<br>
		    		<i>EXAMPLE</i> ["Afgelegen","Stil","Groen","Rustig"]
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/evaluations/rating/<strong>PLACE_ID</strong>",<br>
		    		"method": "GET"
		    	</p>

		    	<p>
		    		<strong><a name="getEvaluations">getEvaluations</a></strong><br>
		    		Gets all the ratings of a place<br>
		    		Returns:<br>
		    		<i>id</i>, <i>placeId</i>, <i>questionId</i>, <i>ratingGood</i>, <i>ratingBad</i>, <i>votes</i>, <i>question</i>
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/evaluations/<strong>PLACE_ID</strong>",<br>
		    		"method": "GET"
		    	</p>

		    	<p>
		    		<strong><a name="evaluate">evaluate</a></strong><br>
		    		Gets all the ratings of a place<br>
		    		Returns getEvaluations:<br>
		    		<i>id</i>, <i>placeId</i>, <i>questionId</i>, <i>ratingGood</i>, <i>ratingBad</i>, <i>votes</i>, <i>question</i>
		    	</p>
		    	<p class="quote">
		    		"url": "http://95.85.15.210/evaluate/<STRONG>PLACE_ID</STRONG>/<STRONG>QUESTION_ID</STRONG>/<STRONG>VOTE (1 = good; 0 = bad)</STRONG>",<br>
		    		"method": "GET"
		    	</p>

		    	<hr>
		    	<hr>
		    	<hr>

		    	<h2><a name="POST">Basic usage - PUT / POST</a></h2>
		    	<p>PUT and POST are used to store information into the database.</p>
		    	<p class="quote">
					var settings = {<br>
					&emsp;"async": true,<br>
					&emsp;"crossDomain": true,<br>
					&emsp;"url": "<strong>URL</strong>",<br>
					&emsp;"method": "<strong>METHOD</strong>",<br>
					&emsp;"headers": {<br>
					&emsp;&emsp;"Authorization": "Bearer <strong>USER_TOKEN</strong>",<br>
					&emsp;&emsp;"Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8"<br>
					&emsp;},<br>
					&emsp;"processData": false,<br>
					&emsp;"contentType": false,<br>
					&emsp;"mimeType": "multipart/form-data",<br>
					&emsp;"data": { <strong>DATA</strong> }<br>
					}
		    	</p>
		    	<hr>

		    	<h2><a name="POSTPlaces">Places</a></h2>
		    	<p>
		    		<strong><a name="addPlace">addPlace</a></strong>: adds a place to the database<br>
		    		Returns the made place:<br>
		    		<i>foursquareId</i>, <i>name</i>, <i>address</i>, <i>description</i>, <i>email</i>, <i>categoryId</i>, <i>site</i>, <i>geoId</i>, <i>updated_at</i>, <i>created_at</i> and <i>id</i>.
		    	</p>
		    	<p class="quote">
			    	"url": "http://95.85.15.210/places/add",<br>
			    	"method": "PUT"
		    	</p>
		    	<p>Required data:</p>
		    	<p class="quote">
			    	"data": {<br>
					&emsp;"name": "<strong>PLACE_NAME</strong>",<br>
					&emsp;"categoryId": "<strong>CATEGORY_ID</strong>",<br>
					&emsp;"latitude": "<strong>LATITUDE</strong>",<br>
					&emsp;"longitude": "<strong>LONGITUDE</strong>",<br>
					&emsp;"email": "<strong>EMAIL</strong>"<br>
					}
				</p>
				<p>Optional data:</p>
		    	<p class="quote">
			    	"data": {<br> 
					&emsp;"address": "<strong>ADDRESS</strong>",<br>
					&emsp;"description": "<strong>DESCRIPTION</strong>",<br>
					&emsp;"site": "<strong>WEBSITE</strong>"<br>
					}
				</p>

				<p>
		    		<strong><a name="addToFavourites">addToFavourites</a></strong><br>
		    		Add a favorite place.<br>

		    	</p>
		    	<p class="quote">
					&emsp;"url": "http://95.85.15.210/places/<strong>PLACE_ID</strong>/addToFavourites",<br>
					&emsp;"method": "POST",
				</p>

				<p>
		    		<strong><a name="removeFromFavourites">removeFromFavourites</a></strong><br>
		    		Removes a favorite place.<br>

		    	</p>
		    	<p class="quote">
					&emsp;"url": "http://95.85.15.210/places/<strong>PLACE_ID</strong>/addToFavourites",<br>
					&emsp;"method": "POST",
				</p>

				<p>
		    		<strong><a name="uploadPhoto">uploadPhoto</a></strong><br>
		    		Upload a picture.<br>
		    	</p>
		    	<p class="quote">
					&emsp;"url": "http://95.85.15.210/places/<strong>PLACE_ID</strong>/uploadPhoto",<br>
					&emsp;"method": "POST",
				</p>
				<p>Required data:</p>
		    	<p class="quote">
					&emsp;"data": {<br>
					&emsp;&emsp;"photo": "<strong>PHOTO_FILE</strong>"<br>
					&emsp;}
		    	</p>

		    	<p>
		    		<strong><a name="addOpeningHours">addOpeningHours</a></strong><br>
		    		Add the openingshours of a place.<br>
		    	</p>
		    	<p class="quote">
		    		&emsp;"url": "http://95.85.15.210/places/<strong>PLACE_ID</strong>/addOpeningHours",<br>
					&emsp;"method": "POST",
				</p>
				<p>Required data:</p>
				<p class="quote">
					"data":<br>
					{<br>
					&emsp;"timeframes": <strong><- you can have multiple timeframes if needed (<a href="#updateOpeningHours">example</a>)</strong><br>
					&emsp;[<br>
					&emsp;&emsp;{<br>
					&emsp;&emsp;"days": <strong><- these are the days, you can leave out some if needed</strong><br>
					&emsp;&emsp;[<br>
					&emsp;&emsp;&emsp;1, <strong><- 1 is sunday, 2 is monday, etc.</strong><br>
					&emsp;&emsp;&emsp;2,<br>
					&emsp;&emsp;&emsp;3,<br>
					&emsp;&emsp;&emsp;4,<br>
					&emsp;&emsp;&emsp;5,<br>
					&emsp;&emsp;&emsp;6,<br>
					&emsp;&emsp;&emsp;7<br>
					&emsp;&emsp;],<br>
					&emsp;&emsp;"open": <strong><- these are the hours, you can have multiple "open" if needed</strong><br>
					&emsp;&emsp;&emsp;[<br>
					&emsp;&emsp;&emsp;&emsp;{<br>
					&emsp;&emsp;&emsp;&emsp;&emsp;"start": "0800",<br>
					&emsp;&emsp;&emsp;&emsp;&emsp;"end": "0000"<br>
					&emsp;&emsp;&emsp;&emsp;}<br>
					&emsp;&emsp;&emsp;]<br>
					&emsp;&emsp;}<br>
					&emsp;]<br>
					}
				</p>

				<p>
		    		<strong><a name="updateOpeningHours">updateOpeningHours</a></strong><br>
		    		Update the openingsHours of a place.<br>
		    	</p>
		    	<p class="quote">
		    		&emsp;"url": "http://95.85.15.210/places/<strong>PLACE_ID</strong>/updateOpeningHours",<br>
					&emsp;"method": "POST",
		    	</p>
		    	<p>Required data:</p>
		    	<p class="quote">
					"data":<br>
					{<br>
					&emsp;"timeframes":[<br>
					&emsp;&emsp;{<br>
					&emsp;&emsp;&emsp;"days": [<br>
					&emsp;&emsp;&emsp;&emsp;1,<br>
					&emsp;&emsp;&emsp;&emsp;2,<br>
					&emsp;&emsp;&emsp;&emsp;3<br>
					&emsp;&emsp;&emsp;],<br>
					&emsp;&emsp;&emsp;"open": [<br>
					&emsp;&emsp;&emsp;&emsp;{<br>
					&emsp;&emsp;&emsp;&emsp;&emsp;"start": "0800",<br>
					&emsp;&emsp;&emsp;&emsp;&emsp;"end": "0000"<br>
					&emsp;&emsp;&emsp;&emsp;}<br>
					&emsp;&emsp;&emsp;]<br>
					&emsp;&emsp;},<br>
					&emsp;&emsp;{<br>
					&emsp;&emsp;&emsp;"days": [<br>
					&emsp;&emsp;&emsp;&emsp;5,<br>
					&emsp;&emsp;&emsp;&emsp;6,<br>
					&emsp;&emsp;&emsp;&emsp;7<br>
					&emsp;&emsp;&emsp;],<br>
					&emsp;&emsp;&emsp;"open": [<br>
					&emsp;&emsp;&emsp;&emsp;{<br>
					&emsp;&emsp;&emsp;&emsp;&emsp;"start": "0900",<br>
					&emsp;&emsp;&emsp;&emsp;&emsp;"end": "0000"<br>
					&emsp;&emsp;&emsp;&emsp;}<br>
					&emsp;&emsp;&emsp;]<br>
					&emsp;&emsp;}<br>
					&emsp;]<br>
					}
				</p>

		    	<hr>

		    	<h2><a name="POSTCheckin">Checkin</a></h2>

		    	<p>
		    		<strong><a name="checkin">checkin</a></strong><br>
		    		Adding a checkin into the database.<br>
		    		Returns the checkin details:<br>

		    	</p>
		    	<p class="quote">
					&emsp;"url": "http://95.85.15.210/checkin",<br>
					&emsp;"method": "PUT",
				</p>
				<p>Required data:</p>
		    	<p class="quote">
					&emsp;"data": {<br>
					&emsp;&emsp;"latitude": "<strong>LATITUDE</strong>",<br>
					&emsp;&emsp;"longitude": "<strong>LONGITUDE</strong>"<br>
					&emsp;}
		    	</p>
		    </div>
	    </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript">
    	(function($) {
    		var hovers = $(".hover");
    		$(".hover").on("click", function(){
    			$(".close").css("height", "0");
    			$(this).next(".close").css("height", "auto");
    		});
    	})(jQuery);
    </script>
</html>
