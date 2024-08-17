# PHP Validator

PHP Validator is a lightweight, modular validation library designed to help you validate your data effortlessly. Whether you're handling simple form submissions or complex data structures, this library provides a flexible and extensible framework to ensure your data is clean, safe, and ready for use.

## Features

-   **Easy to Use**: Define validation rules with minimal effort, and apply them across your data with a single method call.
-   **Modular Design**: Choose and use only the validators you need, making it easy to extend and customize the validation process.
-   **Extensible**: Easily create custom validation rules to handle your specific data requirements.
-   **Comprehensive Error Handling**: Automatically capture and handle validation errors, allowing you to provide clear feedback to users.
-   **Support for Complex Data Structures**: Validate arrays and nested data with specialized validators like `ArrayValidator`.

## Installation

### _!Coming soon!_

Install the library via Composer:

```bash
composer require openvoid/php-validator
```

## Usage

The PHP Validator library is designed to be extremely user-friendly and modular, allowing you to validate data in a way that suits your application's needs. Whether you're validating simple data fields or complex nested arrays, PHP Validator provides an intuitive API that makes data validation straightforward.

### Example 1: Simple Validator for Basic Data

In this example, we demonstrate how to set up a simple validator for basic data fields such as `age`, `website_ids`, and `email`. Each field has its own set of validation rules, ensuring that the data meets your application's requirements.

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use OpenVoid\Validator\Validator;
use OpenVoid\Validator\Validators\ArrayValidator;
use OpenVoid\Validator\Validators\EmailValidator;
use OpenVoid\Validator\Validators\Integer;
use OpenVoid\Validator\Validators\NotNull;

$validator = new Validator([
    "age"         => [(new Integer())->min(18)->max(99)],
    "website_ids" => [(new ArrayValidator([new Integer(), new NotNull()]))->not_empty()],
    "email"       => new EmailValidator(),
]);

$is_validated = $validator->validate([
    "age"         => 24,
    "website_ids" => [1, 2],
    "email"       => "antonio@obradovic.dev",
]);

if ($is_validated) {
    // * Process form
} else {
    // * Handle errors
    $errors = $validator->get_errors();
}
```

### Example 2: Validating your form data

In a real-world scenario, you often need to validate data submitted through forms. This example shows how to validate POST data by defining validation rules for each form field. Simply pass the entire `$_POST` object into the validate method and let the library handle the rest.

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use OpenVoid\Validator\Validator;
use OpenVoid\Validator\Validators\EmailValidator;
use OpenVoid\Validator\Validators\NotNull;

$validator = new Validator([
    "email" => [new EmailValidator(), new NotNull()],
]);

$is_validated = $validator->validate($_POST);

if ($is_validated) {
    // * Process form
} else {
    // * Handle errors
    $errors = $validator->get_errors();
}
```

## Licence

This project is licensed under the MIT License - see the [LICENSE](https://github.com/openvoid-dev/php-validator/blob/main/LICENSE) file for details.
