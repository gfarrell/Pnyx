<?php
    $extras = Section::yield('navbar_extras');
?> 
<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="/">PNYX</a>
        <ul class="nav">
            <li><a href="/policy/index" title="All Policy">All Policies</a></li>
            <li><a href="/motion_creator" title="Create a motion">Create Motion</a></li>
            
            <?php if(Auth::check() && Auth::user()->isAdmin()): ?>
            <li><a href="/policy/add" title="Add a Policy">Add Policy</a></li>
            <li><a href="/admin" title="Administrative Controls">Administration</a></li>
            <?php endif; ?>

            <?php if(!is_null($extras)) { echo $extras; } ?>
        </ul>
        <form class="navbar-search pull-right">
            <input type="text" class="search-query" placeholder="search..." />
        </form>
    </div>
</div>