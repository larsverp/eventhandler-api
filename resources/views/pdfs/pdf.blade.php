<p style="float: right;"><img src="images/logo2.png" style="height:250px; width:250px;"></p>
<h2>Hey {{ $name }},</h2><br>
<p>We're exited to welcome you on our event!</b></p>
<h4>Event info:</h4>
<table>
    <tr><th style="text-align:left; padding-right: 8px; ">Title:</th><td >{{ $event->title }}</td></tr>
    <tr><th style="text-align:left; padding-right: 8px; ">Host:</th><td >{{ $host->first_name.' '.$host->last_name }}</td></tr>
    <tr><th style="text-align:left; padding-right: 8px; ">Start:</th><td >{{ $event->begin_date }}</td></tr>
    <tr><th style="text-align:left; padding-right: 8px; ">End:</th><td >{{ $event->end_date }}</td></tr>
    <tr><th style="text-align:left; padding-right: 8px; ">Address:</th><td >{{ $event->street.' '.$event->hnum.', '.$event->postal_code.' '.$event->city }}</td></tr>
</table>
<p style="text-align: center;"><img src="data:image/png;base64, {!! base64_encode($qr) !!} "></p>
<p style="text-align: center; ">Show this ticket at the start of this event.</p>
