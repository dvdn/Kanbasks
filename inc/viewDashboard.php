<?php
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
    $colorStyle = "style='background-color: $color;'";

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
                    $textareaContent = addLinksIfContainsHttp($item[$attribute]);
                    echo "<div class='textarea_box'>$textareaContent</div>";
                    break;
            }
        }
    }

    echo <<<EOT
            <div class='row'>
                <form class="move" action="index.php#formarea" method="POST">
                    <input type="hidden" name="id" value="$idx">
                    <input type="hidden" name="action" value="movetask">
                    <button name="direction" value="up" title="move up">&#x25B4;</button>
                    <button name="direction" value="down" title="move down">&#x25BE;</button>
                </form>
                <a href="?action=deletetask&id=$idx#formarea" class="delete action">Delete</a>
                <a href="?action=edittask&id=$idx#formarea" class="edit action">Edit</a>
            </div>
        </div>
    </div>
EOT;
}

function addLinksIfContainsHttp($text) {
    // Regular expression to find URLs starting with http or https
    $pattern = '/\b(http[s]?:\/\/[^\s]+)/i';

    // Replace matched URLs with a clickable link
    $replacement = '<a href="$1" target="_blank">$1</a>';

    // Use preg_replace to replace URLs with anchor tags
    return preg_replace($pattern, $replacement, $text);
}

function viewMenu($dataCount)
{
    $htmlMoveGroup = "";
    $htmlEditGroup = "";
    $htmlDeleteGroup = "";
    $htmlCreateTask = "";

    if ($dataCount) {
        $htmlMoveGroup = '<a href="?action=movegroup#formarea"><> Move board</a>';
        $htmlEditGroup = '<a href="?action=editgroup#formarea">* Rename board</a>';
        $htmlDeleteGroup = '<a href="?action=deletegroup#formarea">x Delete board</a>';
        $htmlCreateTask = '<a href="?action=addtask#formarea">+ Add a new task</a>';
    }

    $data_filepath = $GLOBALS['config']['data_filepath'];
    $data_filename = getCurrentDataFileName();

    echo <<<EOT
<div class="menu">
    <a href="$data_filepath" download="$data_filename">&raquo; Backup data</a>
    &emsp; &emsp;
    <a href="?action=addgroup#formarea">+ Add a new board</a>
    $htmlMoveGroup
    $htmlEditGroup
    $htmlDeleteGroup
    &emsp;
    $htmlCreateTask
</div>
<span id="formarea"></span>
EOT;
}

function getCurrentDataFileName(){
    $title = str_replace(' ', '-', strtolower($GLOBALS['config']['title']));
    $filename = gmdate("Ymd")."_".$title."_kanbasks_data.json";
    return $filename;
}
