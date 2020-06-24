<html>
<h2 style="text-align: center;"><strong>Hey {{ $user->first_name }},</strong></h2><br>
<p style="text-align: center;"><img src="{{ $event->thumbnail }}" alt="" width="237" height="185" /></p>
<h3 style="text-align: center;">Yesterday you visited <b>"{{ $event->title }}"</b></h3>
<p style="text-align: center;">We would like to get a review from you. You can do this via the link:</p>
<p style="text-align: center;"><a href="https://teameventhandler.azurewebsites.net/review/event/{{$event->id}}">Click me :)</a></p>
</html>