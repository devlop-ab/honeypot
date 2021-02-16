<?php

declare(strict_types=1);

namespace Devlop\Honeypot;

use Devlop\Honeypot\Honeypot;
use Devlop\Honeypot\HoneypotNotTriggeredRule;
use Devlop\Honeypot\HoneypotServiceInterface;
use Illuminate\Contracts\Validation\Rule;

trait WithHoneypot
{
    /**
     * Add the honeytrap rules with the existing ruleset
     *
     * @return array<string,string|array<string|Rule>>
     */
    private function withHoneypot(array $rules) : array
    {
        return $rules + [
            $this->getHoneypotInputName() => $this->honeypotRules(),
        ];
    }

    /**
     * Get the honeytrap rules
     *
     * @return array<Rule>
     */
    private function honeypotRules() : array
    {
        return [
            new HoneypotNotTriggeredRule($this),
        ];
    }

    /**
     * Get the input name
     */
    private function getHoneypotInputName() : string
    {
        return $this->container->make(HoneypotServiceInterface::class)->getInputName();
    }

    /**
     * Get the honeypot
     */
    public function honeypot() : Honeypot
    {
        return new Honeypot($this, $this->getHoneypotInputName(), $this->getValidatorInstance());
    }
}
