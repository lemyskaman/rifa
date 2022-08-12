@component('mail::message')
# Introduction

This is a test mail

@component('mail::button', ['url' => config('APP_URL')])
Open application
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
