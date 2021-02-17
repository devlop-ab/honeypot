<?php

declare(strict_types=1);

namespace Devlop\Honeypot;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

final class Honeypot
{
    /**
     * @var array<string,mixed>
     */
    private array $request;

    private string $inputName;

    /**
     * Create a new Honeypot instance
     *
     * @param  FormRequest  $request
     * @param  string  $inputName
     * @return void
     */
    public function __construct(FormRequest $request, string $inputName)
    {
        $this->request = $request->input();

        $this->inputName = $inputName;
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
}
