<?php
// App Fog
$AF_SERVICES = json_decode(getenv('VCAP_SERVICES'),true);
$AF_MYSQL = $AF_SERVICES['mysql-5.1'][0]['credentials'];
// Adapt for Laravel
$AF_MYSQL = array_merge($AF_MYSQL, array(
    'database'  =>  $AF_MYSQL['name'],
    'charset'   =>  'utf8',
    'prefix'    =>  '',
    'driver'    =>  'mysql'
));

return array(
    'profile' => true,
    'fetch' => PDO::FETCH_CLASS,
    'default' => 'mysql',
    'connections' => array(
        'mysql' => $AF_MYSQL
    )
);
?>