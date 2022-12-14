<?php

// $dbEnv db.env.php file
include __DIR__ . '/db.env.php';
include __DIR__ . '/app.env.php';


$env = [
    'BASE_URL' => 'http://localhost:99/cms/',
    'DEVELOPMENT' => true,
    'SECRET_KEY' => '2C&I3AtF20',
    'LOCALE' => 'tr_TR',
    'MEDIA_LIBRARY_PATH' => 'uploads',
];

$env = array_merge($env, $dbENV);
$env = array_merge($env, $appENV);
return $env;

?>
