@layout('layouts.master');

<?php
    Section::append('page_title', $policy->title);
?>

<?php Section::start('content'); Bundle::start('sparkdown'); ?>
<h1>{{ $policy->title }}</h1>

<p>Proposed by: {{ $policy->proposed }}<br/>
Seconded by: {{ $policy->seconded }}</p>

<h3>KCSU Notes</h3>

{{ Sparkdown\Markdown($policy->notes) }}

<h3>KCSU Believes</h3>

{{ Sparkdown\Markdown($policy->believes) }}

<h3>KCSU Resolves</h3>

{{ Sparkdown\Markdown($policy->resolves) }}

<?php Section::stop(); ?>