@layout('layouts.master')

<?php
    Section::append('page_title', 'Current Policy');
    Section::start('content');
?>
<?php echo render('policy.partials.list', array('policies'=>$policies)); ?>

<?php Section::stop(); ?>