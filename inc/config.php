<?php

/*
* Configuration File
*/
$config = array(
    'title' => "Kanbasks",
    'data_filepath' => 'data/test.json',
    'debug' => 1
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