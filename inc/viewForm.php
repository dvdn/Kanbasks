<?php

const BTN_CANCEL = '<span class="cancel"><a href="index.php#' . ANCHOR_NAME . '">Cancel</a></span>';

function viewDelete($group, $id, $anchorName)
{
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>Delete a task</h3>
    <form action="index.php#$anchorName" method="POST">
        <input type="hidden" value="$id" name="id"/>
        <input type="hidden" name="group" value="$group"/>
        Are you sure ?
        <div class="row btn-form">
            <input type="hidden" name="delete" value="task"/>
            <input type="submit" value="Delete"/>
            $btn_cancel
        </div>
    </form>
EOT;
}

function viewDeleteGroup($anchorName)
{
    $grouptodelete = isset($_SESSION['group']) ? $_SESSION['group'] : '';
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>Delete a group</h3>
    <form action="index.php#$anchorName" method="POST">
        <input type="hidden" value="$grouptodelete" name="grouptodelete"/>
        Are you sure you want to delete '$grouptodelete' group and all its tasks ?
        <div class="row btn-form">
            <input type="hidden" name="delete" value="group"/>
            <input type="submit" value="Delete"/>
            $btn_cancel
        </div>
    </form>
EOT;
}

function viewEdit($crud, $group, $id, $anchorName)
{
    $data = $crud->get_datagroup($group);
    echo <<<EOT
    <h3>Edition</h3>
      <form action="index.php#$anchorName" method="POST">
            <input type="hidden" value="$id" name="id"/>
            <input type="hidden" name="group" value="$group"/>
EOT;
    foreach ($crud->taskattributes as $attribute => $type) {
        switch ($type) {
            case 'text':
                $value = "";
                if (isset($data[$id][$attribute])) {
                    $value = $data[$id][$attribute];
                }
                echo "<label for=\"$attribute\">$attribute</label>";

                if ($attribute == 'color') {
                    echo '<a href="https://www.w3.org/TR/SVG11/types.html#ColorKeywords" target="_blank"> (hint)</a>';
                }

                echo "<input type=\"text\" value=\"$value\" name=\"$attribute\"/>";
                break;
            case "textarea":
                $value = "";
                $textarea_height = TEXTAREA_HEIGHT;
                if (isset($data[$id][$attribute])) {
                    $value = $data[$id][$attribute];
                }
                echo "<label for=\"$attribute\">$attribute</label>";
                echo "<textarea rows=\"$textarea_height\" value=\"$value\" name=\"$attribute\"/>$value</textarea>";
                break;
            default:
                if ($attribute == 'status') {
                    echo viewSelect($crud->taskattributes[$attribute], $data[$id][$attribute]);
                }
        }
    }
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
            <input type="hidden" name="edit" value="task"/>
            <div class="row btn-form">
                <input type="submit" value="Edit"/>
                $btn_cancel
            </div>
        </form>
EOT;
}

function viewAdd($crud, $group, $anchorName)
{
    $inputs = "";
    foreach ($crud->taskattributes as $attribute => $type) {
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
    $viewSelect = viewSelect($crud->taskattributes['status']);
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>New task</h3>
    <form action="index.php#$anchorName" method="POST">
        <input type="hidden" name="group" value="$group"/>
        $inputs
        $viewSelect
        <input type="hidden" name="add" value="task"/>
        <div class="row btn-form">
            <input type="submit" value="Add"/>
            $btn_cancel
        </div>
    </form>
EOT;
}

function viewAddGroup($anchorName)
{
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>New group</h3>
    <form action="index.php#$anchorName" method="POST">
        <input type="text" name="newgroup" value=""/>
        <input type="hidden" name="add" value="group"/>
        <div class="row btn-form">
            <input type="submit" value="Add"/>
            $btn_cancel
        </div>
    </form>
EOT;
}

function viewEditGroup($crud, $anchorName)
{
    $group = $_SESSION['group'];
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>Rename a group</h3>
    <form action="index.php#$anchorName" method="POST">
        <input type="text" name="newgroup" value="$group"/>
        <input type="hidden" name="edit" value="group"/>
        <div class="row btn-form">
            <input type="submit" value="Rename"/>
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
            <label for="$attribute">$attribute</label>
            <select name="$attribute">
                $select
            </select>
EOT;
}

// Manage action
switch ($_GET["action"]) {
    case "add":
        viewAdd($crud, $group, $anchorName);
        break;
    case "edit":
        if (isset($_GET["id"])) {
            viewEdit($crud, $group, $_GET["id"], $anchorName);
        }
        break;
    case "delete":
        if (isset($_GET["id"])) {
            viewDelete($group, $_GET["id"], $anchorName);
        }
        break;
    case "addgroup":
        viewAddGroup($group, $anchorName);
        break;
    case "editgroup":
        if (isset($_SESSION["group"])) {
            viewEditGroup($crud, $anchorName);
        }
        break;
    case "deletegroup":
        viewDeleteGroup($anchorName);
        break;
}
