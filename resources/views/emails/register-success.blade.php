<h2>Welcome to ConstructKaro, {{ $data['name'] }} 👋</h2>

<p>Your {{ ucfirst($data['role']) }} registration is completed successfully.</p>

@if(!empty($data['uid']))
<p><b>Your ID:</b> {{ $data['uid'] }}</p>
@endif

<p>Status: <b>{{ ucfirst($data['status']) }}</b></p>

<p>You can login anytime and start using ConstructKaro.</p>

<p>Thanks,<br>Team ConstructKaro</p>
