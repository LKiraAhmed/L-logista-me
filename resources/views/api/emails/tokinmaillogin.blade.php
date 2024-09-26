<p>Hello {{ $user->name }},</p>

<p>Here is your API token:</p>

<pre>{{ $token }}</pre>

<p>This token will expire on {{ \Carbon\Carbon::parse($user->token_generated_at)->addDays(30)->toDateTimeString() }}.</p>

<p>Use this token to authenticate your API requests before it expires.</p>

<p>Thank you!</p>
