@component('mail::message')
# Introduction

The body of your message.
<h3>{{ $details['title'] }}</h3>
<h3>{{ $details['body'] }}</h3>

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent