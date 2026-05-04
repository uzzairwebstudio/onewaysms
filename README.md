# OneWaySMS PHP

A framework-agnostic PHP wrapper for One Way SMS API. Zero dependencies.

## System Requirements

- PHP 8.0 or higher
- `allow_url_fopen` enabled in php.ini (uses `file_get_contents`)

## Installation

Install via Composer:

```bash
composer require uzzairwebstudio/onewaysms
```

## Usage

```php
use Uzzairwebstudio\Onewaysms\OneWaySMSManager;

$sms = new OneWaySMSManager(
    'API_USERNAME',
    'API_PASSWORD',
    'MT_URL',
    'CHECK_STATUS_URL',
    'CHECK_CREDIT_URL'
);

// Send SMS (MobileNo, Message, SenderID = 'INFO', LanguageType = 1)
$response = $sms->send('60121234567', 'Test message');

// Check transaction status
$status = $sms->checkStatus('MT_ID_HERE');

// Check credit balance
$credit = $sms->checkCredit();
```

## Laravel Integration

In Laravel, add variables to your `.env` file:

```env
ONEWAYSMS_API_USERNAME=your_username
ONEWAYSMS_API_PASSWORD=your_password
ONEWAYSMS_MT_URL=your_mt_url
ONEWAYSMS_CHECK_STATUS_URL=your_status_url
ONEWAYSMS_CHECK_CREDIT_URL=your_credit_url
```

Register singleton in `App\Providers\AppServiceProvider`:

```php
use Uzzairwebstudio\Onewaysms\OneWaySMSManager;

public function register(): void
{
    $this->app->singleton(OneWaySMSManager::class, function ($app) {
        return new OneWaySMSManager(
            env('ONEWAYSMS_API_USERNAME'),
            env('ONEWAYSMS_API_PASSWORD'),
            env('ONEWAYSMS_MT_URL'),
            env('ONEWAYSMS_CHECK_STATUS_URL'),
            env('ONEWAYSMS_CHECK_CREDIT_URL')
        );
    });
}
```

Use via Dependency Injection in Controllers or Jobs:

```php
use Uzzairwebstudio\Onewaysms\OneWaySMSManager;

public function __invoke(OneWaySMSManager $sms)
{
    return $sms->send('60121234567', 'Hello from Laravel');
}
```

## Licensing

This package is open-source software licensed under the [MIT license](LICENSE.md).
