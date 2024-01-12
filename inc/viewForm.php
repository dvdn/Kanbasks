<?php

const TEXT_INPUTS = [
    'name',
    'description',
    'creation_date',
    'due_date',
    'color'
];
const VALID_STATUSES = ['todo', 'wip', 'done'];

function viewEdit($crud, $id, $anchorName)
{
    $data = $crud->data['tasks'];
    echo <<<EOT
    <h3>Edition</h3>
      <form action="index.php#$anchorName" method="POST">
            <input type="hidden" value="$id" name="id"/>
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


function viewAdd($anchorName)
{
    $inputs = "";
    foreach (TEXT_INPUTS as $attribute) {
        $inputs .= "<input type=\"text\" name=\"" . $attribute . "\" placeholder=\"" . $attribute . "\"/>";
    }
    $viewSelect = viewSelect(VALID_STATUSES);

    echo <<<EOT
    <h3>Addition</h3>
    <form action="index.php#$anchorName" method="POST">
        $inputs
        $viewSelect
        <input type="submit" name="add" value="Add"/>
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
    viewEdit($crud, $_GET["id"], $anchorName);
} else if ($_GET["action"] == "add") {
    viewAdd($anchorName);
}
