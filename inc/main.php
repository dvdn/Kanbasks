<?php

require('Group.php');
require('utils.php');
require('viewDashboard.php');
require('Crud.php');

$crud = new Crud($config['data_filepath']);
$data = $crud->data;
setGroupInSession($data);

$displayedGroup = new Group($_SESSION['group'], $data);

// Display page content
viewMenu($data);
if (count($data)) {
    viewGroups($data);
}
require('routingForm.php');
viewHead();
viewTasks($displayedGroup);





