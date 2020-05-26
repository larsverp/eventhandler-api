<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

<p style="float: right;"><img src="images/logo2.png" style="height:250px; width:250px;"></p>
<h2 style="font-family: 'Open Sans', sans-serif;">Hey {{ $name }},</h2><br>
<p style="font-family: 'Open Sans', sans-serif;">We're exited to welcome you on our event!</b></p>
<h4 style="font-family: 'Open Sans', sans-serif;">Event info:</h4>
<table>
    <tr><th style="text-align:left; padding-right: 8px; font-family: 'Open Sans', sans-serif;">Title:</th><td style="font-family: 'Open Sans', sans-serif;">{{ $event->title }}</td></tr>
    <tr><th style="text-align:left; padding-right: 8px; font-family: 'Open Sans', sans-serif;">Host:</th><td style="font-family: 'Open Sans', sans-serif;">{{ $host->first_name.' '.$host->last_name }}</td></tr>
    <tr><th style="text-align:left; padding-right: 8px; font-family: 'Open Sans', sans-serif;">Start:</th><td style="font-family: 'Open Sans', sans-serif;">{{ $event->begin_date }}</td></tr>
    <tr><th style="text-align:left; padding-right: 8px; font-family: 'Open Sans', sans-serif;">End:</th><td style="font-family: 'Open Sans', sans-serif;">{{ $event->end_date }}</td></tr>
    <tr><th style="text-align:left; padding-right: 8px; font-family: 'Open Sans', sans-serif;">Address:</th><td style="font-family: 'Open Sans', sans-serif;">{{ $event->street.' '.$event->hnum.', '.$event->postal_code.' '.$event->city }}</td></tr>
</table>
<p style="text-align: center;"><img src="data:image/png;base64, {!! base64_encode($qr) !!} "></p>
<p style="text-align: center; font-family: 'Open Sans', sans-serif;">Show this ticket at the start of this event.</p>
