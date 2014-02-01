@layout('layouts.master')

<?php
    Section::append('page_title', 'Current Policy');
    Section::start('content');
?>
<h1>Current Policy {{ HTML::link('policy/index', 'see all policy', array('class'=>'btn btn-small')); }}</h1>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Date</th>
            <th>Title</th>
            <th>FOR</th>
            <th>AGAINST</th>
            <th>ABSTAIN</th>
        </tr>
    </thead>
    <tbody>
    <?php echo render_each('policy.partials.row', $policies, 'policy'); ?>
    </tbody>
</table>

<?php Section::stop(); ?>