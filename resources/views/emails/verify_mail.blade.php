Hello {{ $data['name'] }},<br><br>

Your Verification Link is- <br><br>

<a href="{{url('verify-email')}}/{{ $data['remember_token'] }}">Click here for verify</a>
<br><br>
Thanks,<br>
{{ config('app.name') }}