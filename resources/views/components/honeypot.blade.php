<div style="display: none;">
    <input type="text"
        name="{{ $inputName }}"
        value=""
        placeholder="Email"
    >
</div>

@if ($honeypotWasTriggered)
    {{ $slot }}
@endif
