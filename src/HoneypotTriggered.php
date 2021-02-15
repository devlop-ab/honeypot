<?php

declare(strict_types=1);

namespace Devlop\Honeypot;

// use Illuminate\Foundation\Events\Dispatchable;

final class HoneypotTriggered
{
    // use Dispatchable;

    /**
     * The value of the triggered honeypot
     */
    private string $value;

    /**
     * Create a new event instance.
     *
     * @param  string  $value
     * @return void
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Get the honeypot value
     */
    public function getValue() : string
    {
        return $this->value;
    }
}
