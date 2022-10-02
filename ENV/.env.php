<?php

// $dbEnv db.env.php file
include __DIR__ . '/db.env.php';


$env = [
    'BASE_URL' => 'http://localhost:99/cms/',
    'DEVELOPMENT' => true,
    'SECRET_KEY' => '2C&I3AtF20',
    'LOCALE' => 'tr_TR'
];

$env = array_merge($env, $dbENV);
return $env;

?>
