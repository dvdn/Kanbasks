<?php

/*
* Configuration File
*/
$config = array(
    'title' => "Kanbasks",
    'debug' => 0
);

if ($config['debug'] == 1) {
    // PHP debug
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $msgDebug = "DEBUG mode";
    // To debug possible files permissions issues, uncomment following line to display which user is running php
    // $msgDebug .= " (user : '".exec('whoami')."')";    
    echo $msgDebug;
  }

return $config;