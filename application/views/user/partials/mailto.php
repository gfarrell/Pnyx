<?php 
    $email = $user->crsid.'@cam.ac.uk';
    if(!isset($label)) {
        $label = $email;
    }
    if(isset($icon) && $icon !== false) {
        if($icon === true) $icon = 'icon-envelope-alt';
        $label = '<i class="'.$icon.'"></i>';
    }

    echo '<a href="mailto:'.$email.'" title="'.$email.'">'.$label.'</a>';
?>