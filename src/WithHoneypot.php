<?php

declare(strict_types=1);

namespace Devlop\Honeypot;

use Devlop\Honeypot\HoneypotServiceInterface;

trait WithHoneypot
{
    public function withHoneypotRules(array $rules) : array
    {
        return array_merge($rules, [
            $this->getHoneypotInputName() => [
                'sometimes', // only check when present
                'size:0', // must be empty
            ],
        ]);
    }

    /**
     * Get the input name
     */
    private function getHoneypotInputName() : string
    {
        return $this->container->make(HoneypotServiceInterface::class)->getInputName();
    }

    /**
     * If the honeypot was triggered
     */
    public function triggeredHoneypot() : bool
    {
        return $this->honeypotValue() !== null;
    }

    /**
     * Get the honeypot input value
     */
    public function honeypotValue() : ?string
    {
        return $this->input($this->getHoneypotInputName()) ?: null;
    }
}
