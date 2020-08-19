@component('mail::message')
# Introduction

The body of your message - user registered.

<a href="{{ $actionUrl  }}">verification link</a>

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
