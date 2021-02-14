<style>
    input[name="{{ $inputName }}"] {
        display: none;
    }
</style>

<input type="text"
    name="{{ $inputName }}"
    value=""
    placeholder="Email"
>

@if ($honeypotWasTriggered)
    {{ $slot }}
@endif
