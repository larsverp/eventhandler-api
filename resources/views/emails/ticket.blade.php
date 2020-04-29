<html>
<h3 style="text-align: center;"><strong>Hey {{ $name }},</strong></h3>
<h3 style="text-align: center;">Leuk dat je je hebt aangemeld voor {{ $event->title }} Dit event vind plaats op {{ $event->begin_date }}</h3>
<h4 style="text-align: center;"> In deze mail staat je ticket, bewaar deze mail daarom goed.</h4>
<p style="text-align: center;"><img src="{!!$message->embedData($qr, 'Rockstar-ticket.png', 'image/png')!!}"></p>
<h3 style="text-align: center;"><strong>Laat dit ticket scannen om toegang te krijgen tot het event.</strong></h3>
</html>