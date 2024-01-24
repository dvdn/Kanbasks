<?php
const TEXTAREA_HEIGHT = 3;

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
                    if ($attribute != "color") {
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
            <a href="?action=deletetask&id=$idx#formarea" class="delete action">Delete</a>
            <a href="?action=movetask&id=$idx#formarea" class="move action">Move</a>
            <a href="?action=edittask&id=$idx#formarea" class="edit action">Edit</a>
            </div>
            </div>
        </div>
EOT;
}

function viewMenu($data)
{
    $htmlCreateTask = "";
    $htmlEditGroup = "";
    $htmlDeleteGroup = "";

    if (count($data)) {
        $htmlMoveGroup = '<a href="?action=movegroup#formarea"><> Move board</a>';
        $htmlEditGroup = '<a href="?action=editgroup#formarea">* Rename board</a>';
        $htmlDeleteGroup = '<a href="?action=deletegroup#formarea">x Delete board</a>';
        $htmlCreateTask = '<a href="?action=addtask#formarea">+ Add a new task</a>';
    }

    echo <<<EOT
<div class="menu">
    <a href="?action=addgroup#formarea">+ Add a new board</a>
    $htmlMoveGroup
    $htmlEditGroup
    $htmlDeleteGroup
    $htmlCreateTask
</div>
<span id="formarea"></span>
EOT;
}
