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
