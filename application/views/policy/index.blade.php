@layout('layouts.master')

<?php 
    Section::append('page_title', 'All Policy');
    Section::start('content');
?>

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
    <?php echo render_each('policy.partials.row', $policies->results, 'policy'); ?>
    </tbody>
</table>

<?php echo $policies->links(); ?>

<?php Section::stop(); ?>