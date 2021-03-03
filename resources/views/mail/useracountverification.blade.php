@component('mail::message')
<h1 style="color: #4caf50;">Hello</h1>

Please click the button below to activate your account.

@component('mail::button', ['url' => $url, 'color' => 'green'])
Activate
@endcomponent

Thank you for signing-up! <br><br>
Thanks,<br>
{{ config('app.name') }}

<hr>
<small>
    If you’re having trouble clicking the "Activate" button, copy and paste the URL below into your web browser: {{$url}}</small>

@endcomponent
