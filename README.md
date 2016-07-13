# boekdelen
Cultuurconnect boekdelen project


#Debugbar
```
https://github.com/barryvdh/laravel-debugbar
```

##Install
Add on top of file
```
 use Debugbar;
```

##How to use
Example
```
Debugbar::info('Test');
```

Other options
```
Debugbar::info($object);
Debugbar::error('Error!');
Debugbar::warning('Watch out…');
Debugbar::addMessage('Another message', 'mylabel');
```


#API

##Example
```
$.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                    }
                });

                $.ajax({
                    type: "POST",
                    url: '/checkin/54750454498ed14f0c7d12a6/12345/12345',
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
```

##Routes
###Places
Create a new place. You need to send the name, latitude and longitude.
```
Route::post('/places/add/{name}/{latitude}/{longitude}','PlaceController@addPlace');
```
```
Route::get('places/{id}','PlaceController@getPlaceById');
```
```
Route::get('/places/{lat}/{lng}','PlaceController@getPlaces');
```
###Checkins
```
Route::post('/checkin/{foursquareId}/{latitude}/{longitude}','CheckinController@checkin');
```
```
Route::get('/getLatestCheckin','CheckinController@getLatestCheckin');
```
