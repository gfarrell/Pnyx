<?php
    $class = 'label';
    if(isset($type)) {
        $class .= ' label-' . $type;
    }
?>

<span class="<?php echo $class; ?>"><?php echo $content; ?></span>