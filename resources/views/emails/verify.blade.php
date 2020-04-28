<html>
<h3 style="text-align: center;"><strong>Hey {{ $user["name"] }}, leuk dat je een account hebt aangemaakt voor Rockstars events.</strong></h3>
<p style="text-align: center;">Alleen nog even je account verifi&euml;ren en dan ben je er helemaal klaar voor!</p>
<p style="text-align: center;"><img src="{{ $user['giflink'] }}" alt="" width="237" height="185" /></p>
<p style="text-align: center;">Je verificatiecode is:</p>
<h1 style="text-align: center;">{{ $user['verify_code'] }}</h1>
<small style="text-align: center;">Als je dit niet hebt gedaan kun je deze email negeren. We verwijderen je email uit onze database als deze niet op tijd wordt geverifieerd.</small>
</html>