<tr class="<?php echo ($policy->didPass() ? '' : 'error'); ?>">
    <td><?php echo $policy->date; // TODO: make this a sort link ?></td>
    <td><?php echo render('policy.partials.link', array('policy'=> $policy)); ?></td>
    <td><?php echo $policy->votes('for'); ?></td>
    <td><?php echo $policy->votes('against'); ?></td>
    <td><?php echo $policy->votes('abstain'); ?></td>
</tr>