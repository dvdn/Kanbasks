<?php
// Html Addition
// tableHead

$attributesList = $crud->attributesList;
$select ="";
if (in_array('status', $crud->attributesList)) {
    $select .= $view->SelectList($crud->statusList);
    $rmkey = array_search('status', $crud->attributesList);
    unset($attributesList[$rmkey]);
}

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
