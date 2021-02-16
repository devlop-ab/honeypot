<?php

declare(strict_types=1);

namespace Devlop\Honeypot;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

final class HoneypotNotTriggeredRule implements Rule
{
    private FormRequest $request;

    /**
     * Initialize a new rule instance
     *
     * @param  FormRequest  $request
     * @return void
     */
    public function __construct(FormRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) : bool
    {
        $honeypot = $this->request->honeypot();

        return $honeypot->triggered()
            ? false
            : true;
    }

    /**
     * Get the validation error message.
     */
    public function message() : string
    {
        return 'The honeypot was triggered.'; // this error is not meant to be displayed to the user
    }
}
