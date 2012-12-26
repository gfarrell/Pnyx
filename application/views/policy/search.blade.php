@layout('layouts.master')

<?php 
    Section::append('page_title', 'Search');
    Section::start('content');
?>

<div class="search">
<?php
    $form = Formly::make();
    echo $form->open('policy/search', 'GET', array('class'=>'form-search'));
?>
<div class="input-append">
    <input type="text" name="query" class="input-xlarge search-query" value="{{ $query }}" placeholder="search..." /><!--
 --><button type="submit" class="btn icon-search"></button>

</div>
<?php
    echo $form->close();
?>
</div>
<?php if(!is_null($query)): ?>
<?php if(count($policies) > 0): ?>
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
<?php else: ?>
    @render('partials.alert', array('type'=>'info', 'message'=>'No results'))
<?php endif; ?>
<?php endif; ?>

<?php Section::stop(); ?>