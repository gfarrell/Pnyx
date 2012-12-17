<?php
    $_defaults = array(
        'location'  =>  'delete',
        'text'      =>  'delete',
        'inline'    =>  false
    );
    foreach($_defaults as $vv => $df_val) {
        if(!isset($$vv)) {
            $$vv = $df_val;
        }
    }

    $form_id = 'delete_'.uniqid();

    $form = Formly::make()->set_options(array('form_class'=>'hidden form-inline delete-form'));
    echo $form->open($location, "DELETE", array('id'=>$form_id));
    echo $form->hidden('id', $id);
    if(!$inline) {
        echo $form->submit($text, array('class'=>'btn btn-small btn-danger'));
    }
    echo $form->close();
    if($inline) {
        echo HTML::link('#', $text, array('data-submit'=>'#'.$form_id));
    }
?>