<p align="center">
    <a href="https://packagist.org/packages/devlop/honeypot"><img src="https://img.shields.io/packagist/v/devlop/honeypot" alt="Latest Stable Version"></a>
    <a href="https://github.com/devlop-ab/honeypot/blob/master/LICENSE.md"><img src="https://img.shields.io/packagist/l/devlop/honeypot" alt="License"></a>
</p>

# Honeypot

Simple honeypot made for Laravel FormRequest that detects spam bots via a hidden honeypot field.

# Installation

```
composer require devlop/honeypot
```

If you wish to change any of the honeypot configuration options (such as the component name) you can publish the config, but this is usually not needed.

```
php artisan vendor:publish --provider="Devlop\Honeypot\HoneypotServiceProvider"
```

# Usage

First, add the `WithHoneypot` trait to your FormRequest.

```php
namespace App\Http\Requests;

use Devlop\Honeypot\WithHoneypot;
use Illuminate\Foundation\Http\FormRequest;

class DemoRequest extends FormRequest
{
    use WithHoneypot;
```

Next you need to add the honeypot to your form.

```html
<form method="POST" action="/">
    <x-honeypot />

    ... all your other form contents
</form>
```

Optionally you can add a message to show when the honeypot was triggered, this only works when using automatic validation.

```html
<form method="POST" action="/">
    <x-honeypot>
        <p>Nice try! Go away!</p>
    </x-honeypot>

    ... all your other form contents
</form>
```

Lastly, you need to configure the validation, it can either be automatic or manual.

## Automatic validation

Add the honeypot rules to your rules configuration, this will make it redirect back to the form when triggered, as any other form validation error.

```php
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return $this->withHoneypotRules([
            // your normal rules goes here
        ]);
    }
```

Optionally you can also register the rules like this

```php
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            // your normal rules goes here,
            $this->getHoneypotInputName() => $this->honeypotRules(),
        ];
    }
```

## Manual validation

If you are doing the validation manually you have more control of how you handle spammers,
maybe you want to silently ignore it and give the spammer the impression of success? it's all up to you.

```php
namespace App\Http\Controllers;

use App\Requests\DemoRequest;
use Illuminate\Http\Request;

class DemoController
{
    public function store(DemoRequest $request)
    {
        // get the honeypot
        $honeypot = $request->honeypot();

        if ($honeypot->triggered()) {
            // do something when the honeypot was triggered
        }
    }
}
```
