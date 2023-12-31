@component('vendor.mail.html.layout')
{{-- Header --}}
@slot('header')
@component('vendor.mail.html.header', ['url' => config('app.url')])
{{ config('app.name')}}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y')}} {{ GetSetting('site_name')}}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
