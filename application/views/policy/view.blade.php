@layout('layouts.master')

<?php Section::append('page_title', $policy->title); ?>

@if(Ravenly::user()->inGroup('admin'))
@section('navbar_extras')

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        Policy
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li>{{ HTML::link('policy/edit/'.$policy->id, 'edit') }}</li>
        <li>@render('partials.delete_button', array('location'=>'policy/delete', 'text'=>'delete', 'id'=>$policy->id, 'inline'=>true))</li>
    </ul>
</li>
@endsection
@endif

@section('content')
<?php Bundle::start('sparkdown'); ?>
<h1>
    {{ $policy->title }} <small class="labels">@render('policy.partials.labels', array('policy' => $policy))</small>
</h1>

<dl class="dl-horizontal">
    <dt>Proposed by</dt><dd>{{ $policy->proposed }}</dd>
    <dt>Seconded by</dt><dd>{{ $policy->seconded }}</dd>
    <dt>Motion brought</dt><dd>{{ date('jS F, Y', strtotime($policy->date)) }}</dd>
    @if($policy->didPass())
    <dt>Policy Expire{{ $policy->isCurrent() ? 's' : 'd' }}</dt><dd>{{ date('F, Y', $policy->expires()) }}</dd>
    @endif
    @if($policy->isRescinded())
    <dt class="text-warning">Rescinded on</dt><dd class="text-warning">{{ date('jS M Y', strtotime($policy->relatedTo()->where('rescinds', '=', 1)->first()->date)); }}
    @endif
    @if($policy->wasRenewed())
    <dt class="text-info">Renewed on</dt><dd class="text-info">{{ date('jS M Y', strtotime($policy->relatedTo()->where('rescinds', '=', 0)->first()->date)); }}
    @endif
</dl>

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

@if($policy->relatesTo()->count() > 0)
<h3>Related Policy</h3>
<ul>
@foreach($policy->relatesTo as $r)
    <li>
        (<span class="text-{{ ($r->pivot->rescinds ? 'warning">Rescinds' : 'success">Renews') }}</span>) 
        @render('policy.partials.link', array("policy" => $r))
    </li>
@endforeach
</ul>
@endif

@endsection