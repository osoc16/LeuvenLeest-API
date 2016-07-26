# Installation
## Prerequisites
* PHP >= 5.5.9: Can be downloaded from the [PHP website](http://php.net)
* Composer: Follow the instructions on the [Composer website](https://getcomposer.org/doc/00-intro.md)
* Any database system listed in the [Laravel documentation](https://laravel.com/docs/5.2/database)

## Clone the repository
```
git clone https://github.com/osoc16/LeuvenLeest-API.git
cd LeuvenLeest-API
```

## Getting things ready
Copy the .env.example to .env and fill in the environment variables
```
cp .env.example .env
```

To fill the database, calls are made to the Foursquare API, so make sure you fill in the id and key from [Foursquare](http://developer.foursquare.com)
```
FOURSQUARE_CLIENT_KEY=YOUR_FOURSQUARE_CLIENT_KEY
FOURSQUARE_CLIENT_ID=YOUR_FOURSQUARE_CLIENT_ID
```

If you want to use oAuth, fill in the correct values for [Facebook](http://developer.facebook.com) and [Google](https://console.developers.google.com)
```
FACEBOOK_CLIENT_ID=YOUR_FACEBOOK_CLIENT_ID
FACEBOOK_CLIENT_KEY=YOUR_FACEBOOK_CLIENT_KEY

GOOGLE_CLIENT_ID=YOUR_GOOGLE_CLIENT_ID
GOOGLE_CLIENT_SECRET=YOUR_GOOGLE_CLIENT_SECRET
```
For oAuth also change the redirect ip-addresses in config/services.php. For more information go to [Socialite](https://github.com/laravel/socialite).
```
'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_KEY'),
        'redirect' => 'http://95.85.15.210/auth/loginCallback/fb'
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => 'http://95.85.15.210/auth/loginCallback/google'
    ],
```

### Resolving dependencies
```
composer install
composer update
```

### Creating the database
```
php artisan migrate
```

### Seeding the database
```
php artisan db:seed
```

## Running the application
```
php artisan serve
```
The application should now be running on your local machine.
Look at localhost in a webbrowser to see which requests can be sent to the API.
