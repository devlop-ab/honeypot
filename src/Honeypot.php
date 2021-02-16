<?php

declare(strict_types=1);

namespace Devlop\Honeypot;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

final class Honeypot
{
    /**
     * @var array<string,mixed>
     */
    private array $request;

    private string $inputName;

    private MessageBag $errors;

    /**
     * Create a new Honeypot instance
     *
     * @param  FormRequest
     * @return void
     */
    public function __construct(FormRequest $request, string $inputName, Validator $validator)
    {
        $this->request = $request->input();

        $this->inputName = $inputName;

        $this->errors = $validator->errors();
    }

    /**
     * If the honeypot is triggered, the honeypot is
     * considered to be triggered if the value is
     * anything but an empty string (or null)
     */
    public function triggered() : bool
    {
        return $this->value() !== ''
            ? true
            : false;
    }

    /**
     * Get the honeypot value
     */
    public function value() : string
    {
        $value = Arr::get($this->request, $this->inputName) ?? '';

        return is_string($value)
            ? $value
            : 'invalid type: ' . get_debug_type($value);
    }

    /**
     * Get the request input
     *
     * @var array<string,mixed>
     */
    public function getRequest() : array
    {
        return $this->request;
    }

    /**
     * Get the request validation errors
     */
    public function getRequestValidationErrors() : MessageBag
    {
        return $this->errors;
    }
}
