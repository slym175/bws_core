# Assets Packages 
This package for manager assets files
##Install
In your project base directory run
```bash
-composer require bws/assets
```
- Add to section providers of config/app.php:
// config/app.php
```
'providers' => [
    ...
    Bws\Assets\Providers\AssetsServiceProvider::class,
];
```

- And add to aliases section:
  
// config/app.php
```
 'aliases' => [
      ...
      'Assets' => Bws\Assets\Facades\AssetsFacade::class,
  ];
```
 
  
## Publish config and views
    ```bash
    - php artisan vendor:publish --tag=assets-config
    - php artisan vendor:publish --tag=assets-views
    ```
##Configs
- Edit `config/assets.php`
## Usage
In your views/layouts:
- To generate the CSS `<link rel="stylesheet">` tags and `<script>` configured in head
```bash
 {!! Assets::renderHeader() !!}
```

- To generate the JavaScript `<script>` tags
```bash
 {!! Assets::renderFooter() !!}
```

##Methods
####Add scripts
```
Assets::addScripts(['key-of-assets-in-config-file']);
```
Example
```
Assets::addScripts(['bootstrap', 'jquery']);
```

####Add styles
```
Assets::addStyles(['key-of-assets-in-config-file']);
```
Example
```
Assets::addStyles(['bootstrap', 'font-awesome']);
```


####Remove scripts
```
Assets::removeScripts(['key-of-assets-in-config-file']);
```
Example
```
Assets::removeScripts(['bootstrap']);
```


####Remove styles
```
Assets::removeStyles(['key-of-assets-in-config-file']);
```
Example
```
Assets::removeStyles(['font-awesome']);
```

###Settings  (Add to .env)
- Set version for assets. 

 Then all assets will be added ?v=1.0
```
ASSETS_VERSION=1.0
```
- To disable version:
```
ASSETS_ENABLE_VERSION=false
```

- Change to online mode (asset will be loaded from CDN if it's defined in config file)
```
ASSETS_OFFLINE=false
```
