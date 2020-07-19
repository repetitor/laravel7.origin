@component('mail::message')
# Introduction

The body of your message.

<br>

<p>{{ $order->name }}</p>

@if (count($arr))
@foreach ($arr as $key => $value)<p>
    {{ $key }}
    @if (is_array($value))
        @foreach ($value as $item)
            <br> - <b>{{ $item }}</b>
        @endforeach
    @else
        <b>{{ $value }}</b>
    @endif
</p>@endforeach
@endif

---

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
