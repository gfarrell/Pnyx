@layout('layouts.master')

@section('content')
	<div class="hero-unit">
		<h1>Pnyx <small>the KCSU policy database</small></h1>
		<p>
			Welcome to Pnyx, the home of KCSU Policy. Below is a list of the latest Policy, as well as the Policies which are about to expire (this academic year).
		</p>
		
		<p>
			To find out more about the relationship between KCSU and Policy, please click {{ HTML::link('/help/policy', 'here') }}.
		</p>
		
		<p>
			To find out more about Pnyx (including why it's called &ldquo;Pnyx&rdquo;), please click {{HTML::link('/help/pnyx', 'here') }}.
	</div>
	
	<div class="row">
		<div class="span6">
			<h2>Expiring Policy</h2>
		</div>
		<div class="span6">
			<h2>Latest Policy</h2>
		</div>
	</div>
@endsection