Hello {{ $data['name'] }},<br><br>

Your Verification Link is- <br><br>

<a href="{{url('forget-password')}}/{{ $data['token'] }}">Click here for verify</a>
<br><br>
Thanks,<br>
{{ config('app.name') }}