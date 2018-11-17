<?php
// Html Edition
$attributesDisplay = $view->manageAttributesDisplay($crud);
$attributesList = $attributesDisplay["stdAttributes"];
$select = $attributesDisplay["select"];

$id = $_GET["id"];
$data = $crud->data[$crud->listName];

echo <<<EOT
<h3>Edition</h3>
  <form action="index.php" method="POST">
        <input type="hidden" value="$id" name="id"/>
EOT;
    foreach ($attributesList as $attribute) {
        $value = "";
        if (isset($data[$id][$attribute])) {
            $value = $data[$id][$attribute];       
        }
        echo "<label for=\"$attribute\">$attribute</label>";
        echo "<input type=\"text\" value=\"$value\" name=\"$attribute\"/>";
    }
    echo $select;

echo <<<EOT
        <input type="submit" name="edit" value="Edit"/>
    </form>
EOT;
