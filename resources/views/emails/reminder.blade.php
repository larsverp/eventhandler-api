<html>
<h2 style="text-align: center;"><strong>Hey {{ $user->first_name }},</strong></h2><br>
<p style="text-align: center;"><img src="{{ $gif }}" alt="" width="237" height="185" /></p>
<h3 style="text-align: center;">In less than 48 hours you will be atending <b>"{{ $event->title }}"</b></h3>
<h3 style="text-align: center;">This event takes place on <b>{{explode(" ",$event->begin_date)[0]}} at {{substr(explode(" ",$event->begin_date)[1], 0,5)}}</h3>
<h3 style="text-align: center;">The event is held at {{ $event->street.' '.$event->hnum.', '.$event->postal_code.' '.$event->city }}</h3>
</html>