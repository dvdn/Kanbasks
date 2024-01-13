<?php
include('inc/Crud.php');
$crud = new Crud($config['data_filepath']);


if (isset($_POST['group'])) {
    $_SESSION['group'] = $_POST['group'];
}


$group = isset($_SESSION['group']) ? $_SESSION['group'] : 'tasks'; // default tasks group in data

echo "<hr>";
var_dump($_POST);
var_dump($_SESSION);
echo "<hr>";

const DISPLAY_ATTR_AS_TEXT = ["name", "description", "creation_date", "due_date"];
const ANCHOR_NAME = 'formarea';

// tableHead
function viewHead()
{

    echo <<<EOT
    <div class='row'>

    <form action='index.php' method='post'>
        <button name='group' value='tasks'>Tasks</button>
        <button name='group' value='group2'>Group2</button>
    </form>

    </div>
    <div class='row'>
        <div class='head'> To Do </div><div class='head'> WIP </div><div class='head'> Done </div>
    </div>
EOT;
}

function viewData($crud)
{
    $group = isset($_SESSION['group']) ? $_SESSION['group'] : 'tasks'; // default tasks group in data
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
    echo <<<EOT
<div class="menu">
    <a href="?action=add#$anchorName">+ Add a new task</a>
    <a href="?action=addgroup#$anchorName">+ Add a new group</a>
</div>
<span id="$anchorName"></span>
EOT;
}

function viewActions($crud, $group, $anchorName)
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
        unset($_POST["delete"]);
        $crud->actionDelete($group);
    }
    if (isset($_GET["action"])) {
        include('viewForm.php'); // $anchorName is usable in this file
    }
}

// Display page content
viewMenu();
viewActions($crud, $group, ANCHOR_NAME);
viewHead();
viewData($crud);
