<?php
include('inc/Crud.php');
$crud = new Crud($config['data_filepath']);

const DISPLAY_ATTR_AS_TEXT = ["name", "description", "creation_date", "due_date"];
const ANCHOR_FORM = 'formarea';

// tableHead
function viewHead()
{
    $tHead = "<div class='row'><div class='head'> To Do </div><div class='head'> WIP </div><div class='head'> Done </div></div>";
    echo $tHead;
}

function viewData($crud)
{
    $data = $crud->data;
    $groupData = $data['tasks'];
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
    $anchorForm = ANCHOR_FORM;

    $itemData = "<div class='row'><div class='item " . $status . "' " . $colorStyle . ">";
    foreach (DISPLAY_ATTR_AS_TEXT as $attribute) {
        if (isset($item[$attribute])) {
            $itemData .= $item[$attribute] . "</br>";
        }
    }

    echo $itemData;
    echo <<<EOT
                <a href="?action=delete&id=$idx#$anchorForm" class="delete action">Delete</a>
                <a href="?action=edit&id=$idx#$anchorForm" class="edit action">Edit</a>
                </div></div>
EOT;
}

function viewFoot()
{
    $anchorForm = ANCHOR_FORM;
    echo <<<EOT
<div class="menu">
    <a href="?action=add#$anchorForm">+ Add a new task</a>
</div>
<span id="$anchorForm"></span>
EOT;
}

function viewActions($crud)
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


viewHead();
viewData($crud);
viewFoot();
viewActions($crud);
