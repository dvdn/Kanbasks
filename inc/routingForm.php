<?php
require('viewForm.php');


// actions related to GET/POST vars available
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            viewAddTask($crud, $group);
            break;
        case "edit":
            if (isset($_GET["id"])) {
                viewEdit($crud, $group, $_GET["id"]);
            }
            break;
        case "delete":
            if (isset($_GET["id"])) {
                viewDelete($group, $_GET["id"]);
            }
            break;
        case "addgroup":
            viewAddGroup();
            break;
        case "editgroup":
            if (isset($_SESSION["group"])) {
                viewEditGroup($crud);
            }
            break;
        case "deletegroup":
            viewDeleteGroup();
            break;
    }
}

if (isset($_POST["action"])) {
    switch ($_POST["action"]) {
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
    }
}
