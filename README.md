# FAQ Exceptions Laravel Package

This packages lets you map exception with error code to a FAQ page. This will give users a better understanding of your system errors.

## Requirements

This package is compatible with Laravel 5.3

## Installation

Require the package in your project using Composer:

```bash
composer require whyounes/laravel-faq-exceptions
```

We also register the package service provider:

```php
// config/app.php

// ...
"providers" => [
    // ...
    Whyounes\FaqException\Providers\FaqProvider::class,
],
// ...
```

Next, we publish our assets:

```bash
php artisan vendor:publish --provider="Whyounes\FaqException\Providers\FaqProvider"
```

## Usage

The package provides two class to handle error handling:

- `WebRenderer`: Handle web application errors. It uses the `faq.blade.php` template to display them.
- `ApiRenderer`: Handle API application errors. It returns the response as JSON containing the exception message and FAQ url for the error.

You can combine both inside the Laravel error handler.

```php
// app/Exceptions/Handler.php

// ...
public function render($request, Exception $exception)
{
    if ($request->expectsJson()) {
        $renderer = App::make(ApiRenderer::class);
    } else {
        $renderer = App::make(WebRenderer::class);
    }

    return $renderer->render($exception);
}

// ...
```

To add exceptions and FAQ pages URL, you can use the `Whyounes\FaqException\Models\Faq::createFromException($exception, 'app.url/faq-page')` method.
