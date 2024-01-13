<?php
const DISPLAY_ATTR_AS_TEXT = ["name", "description", "creation_date", "due_date"];
const ANCHOR_NAME = 'formarea';

// tableHead
function viewHead()
{
    echo <<<EOT
    <div class='row'>
        <div class='head'> To Do </div><div class='head'> WIP </div><div class='head'> Done </div>
    </div>
EOT;
}

function viewGroups($crud)
{
    $btnsGroup = "";
    foreach (array_keys($crud->data) as $group) {
        $btnsGroup .=  '<button name="group" value="' . $group . '">' . $group . '</button>';
    }
    echo <<<EOT
    <div class='row'>
        <form action='index.php' method='post'>
            $btnsGroup
        </form>
    </div>
EOT;
}


function viewData($crud)
{
    $group = isset($_SESSION['group']) ? $_SESSION['group'] : DEFAULT_GROUP;
    if (isset($_POST["add"])) {
        unset($_POST["add"]);
        $crud->actionAdd($group);
    }
    viewDataGroup($crud, $group);
}

function viewDataGroup($crud, $group)
{
    $groupData = $crud->get_datagroup($group);
    ksort($groupData);

    foreach ($groupData as $idx => $item) {
        viewTask($idx, $item);
    }
}

function viewTask($idx, $item)
{
    $status = $item['status'];
    $color = empty($item['color']) ? 'yellow' : $item['color'];
    $colorStyle = "style='background-color: " . $color . ";'";
    $anchorName = ANCHOR_NAME;

    $itemData = "<div class='row'><div id=" . $idx . " class='item " . $status . "' " . $colorStyle . ">";
    foreach (DISPLAY_ATTR_AS_TEXT as $attribute) {
        if (isset($item[$attribute])) {
            $itemData .= $item[$attribute] . "</br>";
        }
    }

    echo $itemData;
    echo <<<EOT
                <a href="?action=delete&id=$idx#$anchorName" class="delete action">Delete</a>
                <a href="?action=edit&id=$idx#$anchorName" class="edit action">Edit</a>
                </div></div>
EOT;
}

function viewMenu()
{
    $anchorName = ANCHOR_NAME;
    $htmlDeleteGroup = "";

    if (isset($_SESSION['group']) && ($_SESSION['group'] != DEFAULT_GROUP)) {
        $htmlDeleteGroup = '<a href="?action=deletegroup#' . $anchorName . '">+ Delete current group</a>';
    }

    echo <<<EOT
<div class="menu">
    <a href="?action=add#$anchorName">+ Add a new task</a>
    <a href="?action=addgroup#$anchorName">+ Add a new group</a>
    $htmlDeleteGroup
</div>
<span id="$anchorName"></span>
EOT;
}

function viewActions($crud, $group, $anchorName, $defaultGroup)
{
    // actions related to GET/POST vars available
    if (isset($_POST["add"])) {
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
    if (isset($_POST["edit"])) {
        unset($_POST["edit"]);
        $crud->actionEdit($group);
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
    }
    if (isset($_GET["action"])) {
        include('viewForm.php'); // $anchorName & $defaultGroup used in this file
    }
}
