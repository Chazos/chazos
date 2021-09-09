<b>{{ ucfirst($contact->topic)  }}</b><br>
{{ $contact->name  }} said:<br>

{{ $contact->message  }}

{{ $contact->extras  }}
<br>
You can reply to this message by replying to this email:
{{ $contact->email  }}



