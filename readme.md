# Aviate WordPress

[Aviate](https://github.com/timneutkens/aviate) implementation for WordPress.

## Installation

```
composer require weprovide/aviate-wordpress
```

## Usage

```js
const path = require('path')
const env = process.env.NODE_ENV || 'development'
const isDev = env === 'development'

module.exports = {
    distLocations: [
        path.join(__dirname, 'web/app/themes/yourtheme/dist')
    ],
    decorateConfig(config) {
        config.output.publicPath = isDev ? host : './'

        config.entry = Object.assign({}, config.entry, {
            'styles': [
                path.join(__dirname, 'web/app/themes/yourtheme/assets/styles/main.scss')
            ],
            'javascript': [
                path.join(__dirname, 'web/app/themes/yourtheme/assets/javascript/main.js')
            ]
        })

        return config
    }
}
```

## Adding custom files

`aviate.config.js`:

```js
const path = require('path')
const env = process.env.NODE_ENV || 'development'
const isDev = env === 'development'

module.exports = {
    distLocations: [
        path.join(__dirname, 'web/app/themes/yourtheme/dist')
    ],
    decorateConfig(config) {
        config.output.publicPath = isDev ? host : './'

        config.entry = Object.assign({}, config.entry, {
            'styles': [
                path.join(__dirname, 'web/app/themes/yourtheme/assets/styles/main.scss')
            ],
            'javascript': [
                path.join(__dirname, 'web/app/themes/yourtheme/assets/javascript/main.js')
            ],
            'your-file': [
                path.join(__dirname, 'web/app/themes/yourtheme/assets/javascript/example.js')
            ]
        })

        return config
    }
}
```

`functions.php`:

```php
<?php
namespace YourVendor\YourTheme;

function aviateFiles($files, $aviate) {
	if($aviate->isDevelopment()) {
		$files['js'][] = $aviate->getDevServerUrl('your-file.js');
		return $files;
	}

	$files['js'][] = $aviate->getProductionUrl('your-file.js');

	return $files;
}

add_filter('aviate_files', __NAMESPACE__.'\\aviateFiles', 10, 2);
```
