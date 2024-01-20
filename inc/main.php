<?php

require('Group.php');
require('utils.php');
require('viewDashboard.php');

$data = json_decode(file_get_contents($config['data_filepath']), true);
setGroupInSession($data);

$displayedGroup = new Group($_SESSION['group'], $data);

viewGroups($data);
viewHead();
viewTasks($displayedGroup);





