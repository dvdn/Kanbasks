<?php
// Html Edition
$id = $_GET["id"];
$data = $crud->data[$crud->listName];

$attributesList = $crud->attributesList;
$select ="";
 if (in_array('status', $crud->attributesList)) {
     $select .= <<<EOT
            <select name="status">
              <option value="todo">todo</option>
              <option value="wip">wip</option>
              <option value="done">done</option>
            </select>
EOT;
    $rmkey = array_search('status', $crud->attributesList);
    unset($attributesList[$rmkey]);
 }

echo <<<EOT
<h3>Edition</h3>
  <form action="index.php" method="POST">
        <input type="hidden" value="$id" name="id"/>
EOT;
    foreach ($attributesList as $attribute) {
        $value = $data[$id][$attribute];
        echo "<label for=\"$value\">$attribute</label>";
        echo "<input type=\"text\" value=\"$value\" name=\"$attribute\"/>";
    }

    echo $data[$id]['status'];
    echo $select;

echo <<<EOT
        <input type="submit" name="edit" value="Edit"/>
    </form>
EOT;
