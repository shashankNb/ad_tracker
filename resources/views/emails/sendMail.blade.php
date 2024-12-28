@component('mail::message')
# {{ $mailData['title'] }}

{{ $mailData['password'] ?? '' }}

You may go to <a href="{{ route('login') }}">website</a> and login.
<p>Please use your login details for your account to login.</p>

{{ $mailData['message'] ?? '' }}

Thanks,<br>
TrackMagic Team
@endcomponent
