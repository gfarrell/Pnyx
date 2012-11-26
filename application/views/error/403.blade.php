@layout('layouts.master')

@section('content')
<?php $messages = array('No entry.', 'Do not disturb.', 'Can\'t come in here, I\'m afraid.'); ?>

<h1><?php echo $messages[mt_rand(0, 2)]; ?></h1>

<h2>Server Error: 403 (Forbidden)</h2>

<hr>

<h3>What does this mean?</h3>

<p>
    We're afraid you don't have permission to access this page. If you aren't logged in, then please {{ HTML::link('/login', 'do so'); }}. If you are already logged in, then you simply don't have access to this location, sorry about that.
</p>
<p>
    If you really think you should have access, then please do {{ HTML::link('/contact', 'send us a message'); }}.
</p>

<p>
    Perhaps you would like to go to our <?php echo HTML::link('/', 'home page'); ?>?
</p>
@endsection