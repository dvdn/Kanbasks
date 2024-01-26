<?php
require('viewForm.php');

// actions related to GET/POST vars available
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {

        case "addtask":
            viewAddTask($displayedGroup);
            break;
        case "edittask":
            if ($displayedGroup && isset($_GET["id"])) {
                viewEditTask($displayedGroup, $_GET["id"]);
            }
            break;
        case "deletetask":
            if ($displayedGroup && isset($_GET["id"])) {
                viewDeleteTask($displayedGroup, $_GET["id"]);
            }
            break;
        case "addgroup":
            viewAddGroup();
            break;
        case "editgroup":
            if ($displayedGroup) {
                viewEditGroup($displayedGroup);
            }
            break;
        case "deletegroup":
            if ($displayedGroup) {
                viewDeleteGroup($displayedGroup);
            }
            break;
        case "movegroup":
            if ($displayedGroup) {
                viewMoveGroup($displayedGroup);
            }
            break;
    }
}

if (isset($_POST["action"])) {
    switch ($_POST["action"]) {
        case "addtask":
            unset($_POST["addtask"]);
            $crud->actionAddTask($displayedGroup);
            break;
        case "deletetask":
            unset($_POST["deletetask"]);
            $crud->actionDeleteTask($displayedGroup);
            break;
        case "edittask":
            unset($_POST["edittask"]);
            $crud->actionEditTask($displayedGroup);
            break;
        case "movetask":
            unset($_POST["movetask"]);
            $crud->actionMovetask($displayedGroup);
            break;
        case "addgroup":
            unset($_POST["addgroup"]);
            $crud->actionAddGroup();
            break;
        case "deletegroup":
            unset($_POST["deletegroup"]);
            $crud->actionDeleteGroup();
            break;
        case "editgroup":
            unset($_POST["editgroup"]);
            $crud->actionEditGroup();
            break;
        case "movegroup":
            unset($_POST["movegroup"]);
            $crud->actionMoveGroup();
            break;
    }
}
