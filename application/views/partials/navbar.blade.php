<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="/">PNYX</a>
        <ul class="nav">
            <li>{{ HTML::link('policy/index', 'Policy') }}</li>
            <!-- NOT IMPLEMENTED <li>{{ HTML::link('minutes/index', 'Minutes') }}</li> -->
            <!-- NOT IMPLEMENTED <li>{{ HTML::link('docs/index', 'Documents') }}</li> -->

            @if(Ravenly::loggedIn() && Ravenly::user()->inGroup('admin'))
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Add <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>{{ HTML::link('policy/add', 'Policy') }}</li>
                    <li>{{ HTML::link('minutes/add', 'Minutes') }}</li>
                    <li>{{ HTML::link('docs/add', 'Documents') }}</li>
                </ul>
            </li>
            <li>{{ HTML::link('admin', 'Administration') }}</li>
            @endif

            @yield('navbar_extras')
        </ul>
        <form action="/policy/search" method="get" class="navbar-search pull-right">
            <input name="query" type="text" class="search-query" placeholder="search..." />
        </form>
    </div>
</div>