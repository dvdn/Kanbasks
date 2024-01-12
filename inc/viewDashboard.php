<?php
include('inc/Crud.php');
$crud = new Crud($config['data_filepath']);

const DISPLAY_ATTR_AS_TEXT = ["name", "description", "creation_date", "due_date"];
const ANCHOR_NAME = 'formarea';

// tableHead
function viewHead()
{
    echo "<div class='row'><div class='head'> To Do </div><div class='head'> WIP </div><div class='head'> Done </div></div>";
}

function viewData($crud)
{
    viewDataGroup($crud);
}

function viewDataGroup($crud, $group = 'tasks')
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
</div>
<span id="$anchorName"></span>
EOT;
}

function viewActions($crud, $anchorName)
{
    // actions related to GET/POST vars available
    if (isset($_POST["add"])) {
        unset($_POST["add"]);
        $crud->actionAdd();
    }
    if (isset($_POST["edit"])) {
        unset($_POST["edit"]);
        $crud->actionEdit();
    }
    if (isset($_GET["action"])) {
        if ($_GET["action"] == "delete" && isset($_GET["id"])) {
            $crud->actionDelete($_GET["id"]);
        }
        if ($_GET["action"] == "edit" || $_GET["action"] == "add") {
            include('viewForm.php');
        }
    }
}

// Display page content
viewMenu();
viewActions($crud, ANCHOR_NAME);
viewHead();
viewData($crud);
