@props(['label'])

<label style="font-weight: 500; color: rgb(55 65 81);" {{ $attributes->merge(['class' => 'form-label']) }}>
    {{ $label }} <span style="color: red;">*</span>
</label>
