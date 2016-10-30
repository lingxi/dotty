# Dotty

> query 跟踪 [![StyleCI](https://styleci.io/repos/72206912/shield)](https://styleci.io/repos/72206912)[![Latest Stable Version](https://poser.pugx.org/lingxi/dotty/v/stable)](https://packagist.org/packages/lingxi/dotty)[![Total Downloads](https://poser.pugx.org/lingxi/dotty/downloads)](https://packagist.org/packages/lingxi/dotty)[![License](https://poser.pugx.org/lingxi/dotty/license)](https://packagist.org/packages/lingxi/dotty)

# Install

    composer require lingxi/dotty

    Lingxi\Context\ContextServiceProvider::class,

    // Add Global Middleware
    Lingxi\Dotty\DottyTracker::class,

    // publish config. or use default.
    php artisan publish --Lingxi\Context\ContextServiceProvider
