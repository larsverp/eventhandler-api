<html>
<h2 style="text-align: center;"><strong>Hey {{ $name }},</strong></h2><br>
<h3 style="text-align: center;">This is your ticket for <b>"{{ $event->title }}"</b></h3>
<h3 style="text-align: center;">This event takes place on <b>{{explode(" ",$event->begin_date)[0]}} at {{substr(explode(" ",$event->begin_date)[1], 0,5)}}</h3>
<p style="text-align: center;"><img src="{!!$message->embedData($qr, 'rockstars_event_ticket.png', 'image/png')!!}"></p>
<h3 style="text-align: center;"><strong>Show this ticket at the start of this event.</strong></h3>
</html>