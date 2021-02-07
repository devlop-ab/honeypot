<?php

declare(strict_types=1);

namespace Devlop\Honeypot;

use Devlop\Honeypot\HoneypotServiceInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;

final class HoneypotComponent extends Component
{
    private string $inputName;

    private bool $honeypotWasTriggered;

    /**
     * Create a new component instance.
     *
     * @param  HoneypotServiceInterface  $service
     * @param  Request  $request
     * @return void
     */
    public function __construct(HoneypotServiceInterface $service, Request $request)
    {
        $this->inputName = $service->getInputName();

        $this->honeypotWasTriggered = ($request->session()->get('errors') ?: new ViewErrorBag)->has($this->inputName);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View
    {
        return view('honeypot::components.honeypot', [
            'inputName' => $this->inputName,
            'honeypotWasTriggered' => $this->honeypotWasTriggered,
        ]);
    }

    /**
     * Determine if the component should be rendered.
     */
    public function shouldRender() : bool
    {
        return true;
    }
}
