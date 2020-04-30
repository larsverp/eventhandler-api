<html>
<h3 style="text-align: center;"><strong>Hey {{ $user["name"] }}, It's great to have you aboard.</strong></h3>
<p style="text-align: center;">There's only one thing left to do, please verify your email.</p>
<p style="text-align: center;"><img src="{{ $user['giflink'] }}" alt="" width="237" height="185" /></p>
<p style="text-align: center;">Your verification code is:</p>
<h1 style="text-align: center;">{{ substr($user['verify_code'], 0, 3)." ".substr($user['verify_code'], 3) }}</h1>
<small style="text-align: center;">If you didn't create a new account, you can ignore this email.</small>
</html>