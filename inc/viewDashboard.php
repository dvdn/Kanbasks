<?php
const TEXTAREA_HEIGHT = 3;

// tableHead
function viewHead()
{
    echo <<<EOT
    <div class='row'>
        <div class='head'> To Do </div><div class='head'> WIP </div><div class='head'> Done </div>
    </div>
EOT;
}


function viewGroups($data)
{
    $btnsGroup = "";
    $currentGroup = isset($_SESSION['group']) ? $_SESSION['group'] : '';
    foreach (array_keys($data) as $group) {
        $styleCurrent = $group == $currentGroup ? 'style="border-color: black; color:black; font-weight:bold;"' : '';
        $btnsGroup .=  '<button class="group" name="group" value="' . $group . '" ' . $styleCurrent . '>' . $group . '</button>';
    }
    echo <<<EOT
    <div class='row group'>
        <form action='index.php#formarea' method='post'>
            $btnsGroup
        </form>
    </div>
EOT;
}


function viewTasks($group)
{
    $tasks = $group->tasks;
    if ($tasks) {
        //ksort($tasks);
        foreach ($tasks as $idx => $item) {
            viewTask($idx, $item, $group->taskattributes);
        }
    } else {
        echo "No task found.<br> You can create tasks or a new group from the menu.";
    }
}


function viewTask($idx, $item, $taskattributes)
{
    $status = $item['status'];
    $color = empty($item['color']) ? 'yellow' : $item['color'];
    $colorStyle = "style='background-color: " . $color . ";'";

    echo "<div class='row'><div id=" . $idx . " class='item " . $status . "' " . $colorStyle . ">";

    foreach ($taskattributes as $attribute => $type) {
        if (array_key_exists($attribute, $item)) {
            switch ($type) {
                case 'text':
                    if ($attribute!="color") {
                        echo "<span class=\"$attribute\" title=\"$attribute\">$item[$attribute]</span>";
                    }

                    break;
                case "textarea":
                    echo '<textarea rows="' . TEXTAREA_HEIGHT . '" readonly>' . $item[$attribute] . '</textarea>';
                    break;
            }
        }
    }

    echo <<<EOT
    <div class='row'>
            <a href="?action=delete&id=$idx#formarea" class="delete action">Delete</a>
            <a href="?action=edit&id=$idx#formarea" class="edit action">Edit</a>
            </div>
            </div>
        </div>
EOT;
}


function viewMenu($crud)
{
    $htmlCreateTask = "";
    $htmlDeleteGroup = "";

    if (count($crud->data)) {
        $htmlCreateTask = '<a href="?action=add#formarea">+ Add a new task</a>';
        $htmlEditGroup = '<a href="?action=editgroup#formarea">* Rename current group</a>';
        $htmlDeleteGroup = '<a href="?action=deletegroup#formarea">x Delete current group</a>';
    }

    echo <<<EOT
<div class="menu">
    <a href="?action=addgroup#formarea">+ Add a new group</a>
    $htmlEditGroup
    $htmlDeleteGroup
    $htmlCreateTask
</div>
<span id="formarea"></span>
EOT;
}


function viewActions($crud, $group)
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
    }
    if (isset($_GET["action"])) {
        include('viewForm.php'); // formarea used in this file
    }
}
