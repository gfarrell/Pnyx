@layout('layouts.master')

@section('content')
	<div class="hero-unit">
		<h1>Pnyx <small>the KCSU policy database</small></h1>
		<p>
			Welcome to Pnyx, the home of KCSU Policy. Below is a list of the latest Policy, as well as the Policies which are about to expire (this academic year).
		</p>
	</div>
	<div class="row">
		<div class="span6">
			<h2>Latest Policy</h2>
			@render('policy.partials.list', array('policies'=>$latest_policies))
		</div>
		<div class="span6">
			<h2>Expiring Policy</h2>
			@render('policy.partials.list', array('policies'=>$expiring_policies))
		</div>
	</div>
@endsection