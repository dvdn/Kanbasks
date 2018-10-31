<?php
// Html Addition
$attributesDisplay = $view->manageAttributesDisplay($crud);
$attributesList = $attributesDisplay["stdAttributes"];
$select = $attributesDisplay["select"];

$inputs = "";
foreach ($attributesList as $attribute) {
    $inputs .= "<input type=\"text\" name=\"".$attribute."\" placeholder=\"".$attribute."\"/>";
}

echo <<<EOT
<h3>Addition</h3>
<form action="index.php" method="POST">
    $inputs
    $select
    <input type="submit" name="add" value="Add"/>
</form>
EOT;
