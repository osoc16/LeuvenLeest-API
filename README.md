# LeuvenLeest API
The backend API for the LeuvenLeest project of Cultuurconnect. It is about discovering nice reading locations in Louvain and the API provides the endpoints for places, users, photos.

##Documentation
The documentation can be found on [api.leuvenleestapp.be](http://api.leuvenleestapp.be "LeuvenLeest API site") or in the [welcome view](resources/views/welcome.blade.php)

##Example
```
$.ajaxSetup({
    headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
		 }
});

$.ajax({
    type: "PUT",
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
```

##Contributing
The best ways to contribute are
* Open [issues/tickets](../../issues)
* Submit fixes and/or improvements with [Pull Requests](../../pulls)

##License
See [LICENSE](LICENSE)
