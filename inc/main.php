<?php

require('Group.php');
require('utils.php');
require('viewDashboard.php');
require('Crud.php');

$crud = new Crud($config['data_filepath']);
$data = $crud->data;
$dataCount = count($data);

if ($dataCount) {
    setGroupInSession($data);
    $displayedGroup = new Group($_SESSION['group'], $data);
}

// Display page content
viewMenu($dataCount);
if ($dataCount) {
    viewGroups($data);
}
require('routingForm.php'); // manages and calls form views
viewHead();
if ($dataCount) {
    viewTasks($displayedGroup);
}
