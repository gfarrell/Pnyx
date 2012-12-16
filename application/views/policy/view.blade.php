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

<h3>Vote Breakdown</h3>

<?php
    $vote_map = array('votes_for'=>'for the motion', 'votes_against'=>'against the motion', 'votes_abstain'=>'abstained');
    $vote = '';

    foreach($vote_map as $key => $text) {
        if(strtolower($policy->$key) == 'm') {
            $vote .= ' a majority ' . $text . ', ';
            $vote_int = 0;
            $majority = $key;
        } elseif($policy->$key != '') {
            $vote .= ' ' . $policy->$key . ' ' . $text . ', ';
            $vote_int = intval($policy->$key);
        } else {
            $vote_int = 0;
        }
    }
    $vote = substr_replace($vote, '', -2); // Remove the final commas
?>

The vote, taken on {{ date('l, jS F, Y', strtotime($policy->date)) }}, was: {{ $vote }}. <strong>The motion {{ $policy->didPass() ? 'passed' : 'failed' }}</strong>.

<?php Section::stop(); ?>