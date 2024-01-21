<?php
require('viewForm.php');


// actions related to GET/POST vars available
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            viewAdd($crud, $group);
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
            unset($_POST["add"]);
            $crud->actionAddGroup();
            break;
    }
}




/* if (isset($_POST["add"])) {
    switch ($_POST["add"]) {
        case 'task':
            unset($_POST["add"]);
            $crud->actionAdd($group);
            break;
        case 'group':
            unset($_POST["add"]);
            $crud->actionAddGroup();
            break;
    }
}
elseif (isset($_POST["edit"])) {
    switch ($_POST["edit"]) {
        case 'task':
            unset($_POST["edit"]);
            $crud->actionEdit($group);
            break;
        case 'group':
            unset($_POST["edit"]);
            $crud->actionEditGroup();
            break;
    }
}
if (isset($_POST["delete"])) {
    switch ($_POST["delete"]) {
        case 'task':
            unset($_POST["delete"]);
            $crud->actionDelete($group);
            break;
        case 'group':
            unset($_POST["delete"]);
            $crud->actionDeleteGroup();
            break;
    }
} */
