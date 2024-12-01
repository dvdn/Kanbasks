<?php

const BTN_CANCEL = '<span class="cancel"><a href="index.php#formarea">Cancel</a></span>';

function viewAddTask($group)
{
    $inputs = "";

    foreach ($group->taskattributes as $attribute => $type) {
        switch ($type) {
            case 'text':
                $inputs .=  "<label for=\"$attribute\">$attribute</label>";
                if ($attribute == 'color') {
                    $inputs .= '<a href="https://www.w3.org/TR/SVG11/types.html#ColorKeywords" target="_blank"> (hint)</a>';
                }
                $inputs .=  "<input type=\"text\" name=\"$attribute\"/>";
                break;
            case "textarea":
                $inputs .=  "<label for=\"$attribute\">$attribute</label>";
                $inputs .=  "<textarea name=\"$attribute\"/></textarea>";
                break;
        }
    }
    $viewSelect = viewSelect($group->taskattributes['status']);
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>New task</h3>
    <form action="index.php#formarea" method="POST">
        <input type="hidden" name="group" value="$group->name">
        $inputs
        $viewSelect
        <input type="hidden" name="action" value="addtask">
        <div class="row btn-form">
            <input type="submit" value="Add">
            $btn_cancel
        </div>
    </form>
EOT;
}

function viewDeleteTask($group, $id)
{
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>Delete a task</h3>
    <form action="index.php#formarea" method="POST">
        <input type="hidden" value="$id" name="id">
        <input type="hidden" name="group" value="$group->name"/>
        Are you sure ?
        <div class="row btn-form">
            <input type="hidden" name="action" value="deletetask">
            <input type="submit" value="Delete">
            $btn_cancel
        </div>
    </form>
EOT;
}

function viewEditTask($group, $id)
{
    $task = $group->tasks[$id];
    echo <<<EOT
    <h3>Edition</h3>
      <form action="index.php#formarea" method="POST">
            <input type="hidden" value="$id" name="id">
            <input type="hidden" name="group" value="$group->name">
EOT;
    foreach ($group->taskattributes as $attribute => $type) {
        switch ($type) {
            case 'text':
                $value = "";
                if (isset($task[$attribute])) {
                    $value = $task[$attribute];
                }
                echo "<label for=\"$attribute\">$attribute</label>";

                if ($attribute == 'color') {
                    echo '<a href="https://www.w3.org/TR/SVG11/types.html#ColorKeywords" target="_blank"> (hint)</a>';
                }

                echo "<input type=\"text\" value=\"$value\" name=\"$attribute\">";
                break;
            case "textarea":
                $value = "";
                $textarea_height = TEXTAREA_HEIGHT;
                if (isset($task[$attribute])) {
                    $value = $task[$attribute];
                }
                echo "<label for=\"$attribute\">$attribute</label>";
                echo "<textarea rows=\"$textarea_height\" value=\"$value\" name=\"$attribute\"/>$value</textarea>";
                break;
            default:
                if ($attribute == 'status') {
                    echo viewSelect($group->taskattributes[$attribute], $task[$attribute]);
                }
        }
    }
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
            <input type="hidden" name="action" value="edittask">
            <div class="row btn-form">
                <input type="submit" value="Edit">
                $btn_cancel
            </div>
        </form>
EOT;
}

function viewAddGroup()
{
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>New board</h3>
    <form action="index.php#formarea" method="POST">
        <input type="text" name="group" value="">
        <input type="hidden" name="action" value="addgroup">
        <div class="row btn-form">
            <input type="submit" value="Add">
            $btn_cancel
        </div>
    </form>
EOT;
}

function viewDeleteGroup($group)
{
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>Delete a board</h3>
    <form action="index.php#formarea" method="POST">
        <input type="hidden" name="group" value="$group->name">
        Are you sure you want to delete '$group->name' board and all its tasks ?
        <div class="row btn-form">
            <input type="hidden" name="action" value="deletegroup">
            <input type="submit" value="Delete">
            $btn_cancel
        </div>
    </form>
EOT;
}

function viewEditGroup($group)
{
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>Rename a board</h3>
    <form action="index.php#formarea" method="POST">
        <input type="text" name="group" value="$group->name">
        <input type="hidden" name="oldgroup" value="$group->name">
        <input type="hidden" name="action" value="editgroup">
        <div class="row btn-form">
            <input type="submit" value="Rename">
            $btn_cancel
        </div>
    </form>
EOT;
}

function viewMoveGroup($group)
{
    $btn_cancel = BTN_CANCEL;
    $selector = viewSelect(['left', 'right'], 'left', 'direction');
    echo <<<EOT
    <h3>Move a board</h3>
    <form action="index.php#formarea" method="POST">
        <input type="hidden" name="group" value="$group->name">
        Move '$group->name' in
        $selector
        <div class="row btn-form">
            <input type="hidden" name="action" value="movegroup">
            <input type="submit" value="Move">
            $btn_cancel
        </div>
    </form>
EOT;
}

function viewSelect($list, $selected = 'todo', $attribute = 'status')
{
    $select = "";
    foreach ($list as $item) {
        $select .= '<option value="' . $item . '"';
        if ($item == $selected) {
            $select .= 'selected = "selected"';
        }
        $select .= '>' . $item . '</option>';
    }
    return <<<EOT
            <label for="$attribute">$attribute :</label>
            <select name="$attribute">
                $select
            </select>
EOT;
}
