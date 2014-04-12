<?php
require(dirname(__FILE__).'/../../../../../config/pnyx.php');
return array(
    'connections' => array(
        'mysql' => array(
            'driver'   => 'mysql',
            'host'     => 'localhost',
            'database' => $PNYX_DB_DB,
            'username' => $PNYX_DB_USER,
            'password' => $PNYX_DB_PASS,
            'charset'  => 'utf8',
            'prefix'   => '',
        )
    )
);
?>