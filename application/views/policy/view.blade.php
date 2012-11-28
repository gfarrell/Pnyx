<?php
    Section::append('page_title', $policy->title);
?>

@section('content')
<h1>$policy->title</h1>

<p>Proposed by: {{ $policy->proposed }}<br/>
Seconded by: {{ $policy->seconded }}</p>

<h3>KCSU Notes</h3>

{{ Markdown($policy->notes) }}


<h3>KCSU Believes</h3>

{{ Markdown($policy->believes) }}


<h3>KCSU Resolves</h3>

{{ Markdown($policy->resolves) }}

@endsection