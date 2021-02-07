<?php

declare(strict_types=1);

namespace Devlop\Honeypot;

final class HoneypotService implements HoneypotServiceInterface
{
    private string $inputName;

    /**
     * Instantiate the service
     *
     * @param  string  $inputName  The input name
     * @return void
     */
    public function __construct(string $inputName)
    {
        $this->inputName = $inputName;
    }

    /**
     * Get the input name
     */
    public function getInputName() : string
    {
        return $this->inputName;
    }
}
