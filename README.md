[![StyleCI](https://styleci.io/repos/72206912/shield)](https://styleci.io/repos/72206912)
[![Latest Stable Version](https://poser.pugx.org/lingxi/dotty/v/stable)](https://packagist.org/packages/lingxi/dotty)[![Total Downloads](https://poser.pugx.org/lingxi/dotty/downloads)](https://packagist.org/packages/lingxi/dotty)

# Dotty

Query 参数跟踪 

# Install

Laravel 大于 5.4，请使用 0.1.* 版本

```php
composer require lingxi/dotty

Lingxi\Context\ContextServiceProvider::class,

// Add Global Middleware
Lingxi\Dotty\DottyTracker::class,

// publish config. or use default.
php artisan vendor:publish --provider="Lingxi\Context\ContextServiceProvider"
```
