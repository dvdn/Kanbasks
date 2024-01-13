<?php

const TEXT_INPUTS = [
    'name',
    'description',
    'creation_date',
    'due_date',
    'color'
];
const VALID_STATUSES = ['todo', 'wip', 'done'];

function viewDelete($group, $id, $anchorName)
{
    echo <<<EOT
    <h3>Deletion</h3>
        <form action="index.php#$anchorName" method="POST">
            <input type="hidden" value="$id" name="id"/>
            <input type="hidden" name="group" value="$group"/>
            Are you sure ?
            <input type="submit" name="delete" value="Delete"/>
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
    foreach (TEXT_INPUTS as $attribute) {
        $value = "";
        if (isset($data[$id][$attribute])) {
            $value = $data[$id][$attribute];
        }
        echo "<label for=\"$attribute\">$attribute</label>";
        echo "<input type=\"text\" value=\"$value\" name=\"$attribute\"/>";
    }

    echo viewSelect(VALID_STATUSES, $data[$id]['status']);

    echo <<<EOT
            <input type="submit" name="edit" value="Edit"/>
        </form>
EOT;
}

function viewAdd($group, $anchorName)
{
    $inputs = "";
    foreach (TEXT_INPUTS as $attribute) {
        $inputs .= "<input type=\"text\" name=\"" . $attribute . "\" placeholder=\"" . $attribute . "\"/>";
    }
    $viewSelect = viewSelect(VALID_STATUSES);

    echo <<<EOT
    <h3>New task</h3>
    <form action="index.php#$anchorName" method="POST">
        <input type="hidden" name="group" value="$group"/>
        $inputs
        $viewSelect
        <input type="submit" name="add" value="task"/>
    </form>
EOT;
}

function viewAddGroup($anchorName)
{
    $inputs = "";
    foreach (TEXT_INPUTS as $attribute) {
        $inputs .= "<input type=\"text\" name=\"" . $attribute . "\" placeholder=\"" . $attribute . "\"/>";
    }

    echo <<<EOT
    <h3>New group</h3>
    <form action="index.php#$anchorName" method="POST">
        <input type="text" name="newgroup" value=""/>
        <input type="submit" name="add" value="group"/>
    </form>
EOT;
}

function viewSelect($list, $selected = 'todo', $attribute = 'status')
{
    $select = "";
    foreach ($list as $state) {
        $select .= '<option value="' . $state . '"';
        if ($state == $selected) {
            $select .= 'selected = "selected"';
        }
        $select .= '>' . $state . '</option>';
    }
    return <<<EOT
            <label for="$attribute">$attribute</label>
            <select name="$attribute">
                $select
            </select>
EOT;
}


if ($_GET["action"] == "edit" && isset($_GET["id"])) {
    viewEdit($crud, $group, $_GET["id"], $anchorName);
} else if ($_GET["action"] == "add") {
    viewAdd($group, $anchorName);
} else if ($_GET["action"] == "delete" && isset($_GET["id"])) {
    viewDelete($group, $_GET["id"], $anchorName);
} else if ($_GET["action"] == "addgroup") {
    viewAddGroup($group, $anchorName);
}
