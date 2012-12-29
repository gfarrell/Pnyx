<li>
<span class="date"><?php echo date('d/m/Y', strtotime($policy->date)); ?></span>
<?php 
echo render('policy.partials.link', array('policy'=>$policy));

if(!$policy->didPass()) {
    echo render('partials.label', array('type'=>'important', 'content'=>'failed'));
}

if(!$policy->isCurrent()) {
    echo render('partials.label', array('type'=>'important', 'content'=>'expired'));
}
?> 
</li>