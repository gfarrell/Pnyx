<?php
/*
    Echoes appropriate labels:
        pass/fail
        current/expired
 */
$passed = $policy->didPass();
$current = $policy->isCurrent();
$rescinded = $policy->isRescinded();

$labels = array(
    'passed'    =>  array(
            'test'  => $policy->didPass(),
            'label' => array(true => 'passed', false => 'failed'), 
    ),
    'current'   =>  array(
            'test'  => $current && !$rescinded,
            'label' => array(true => 'current', false => 'expired')
    )
);

foreach($labels as $t => $label) {
    echo render('partials.label', array(
            'type'    => $label['test'] ? 'success' : 'important',
            'content' => $label['label'][$label['test']]
        ));
}
?>
