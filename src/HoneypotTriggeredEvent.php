<?php

declare(strict_types=1);

namespace Devlop\Honeypot;

use Devlop\Honeypot\Honeypot;

final class HoneypotTriggeredEvent
{
    private Honeypot $honeypot;

    /**
     * Create a new event instance.
     *
     * @param  Honeypot  $honeypot
     * @return void
     */
    public function __construct(Honeypot $honeypot)
    {
        $this->honeypot = $honeypot;
    }

    /**
     * Get the honeypot
     */
    public function getHoneypot() : Honeypot
    {
        return $this->honeypot;
    }
}
