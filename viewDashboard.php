 <?php
// tableHead
    $tHead = "<div class='row'><div class='head'> To Do </div><div class='head'> WIP </div><div class='head'> Done </div></div>";


echo $tHead;

foreach (reset($crud->data) as $idx => $item) {
    $status = $item['status'];
    $itemData = "<div class='row'><div class='item ".$status."'>";
    foreach ($crud->attributesList as $attribute){
        $itemData .= $item[$attribute]."</br>";
    }
    echo $itemData;
        echo <<<EOT
                <a href="?action=edit&id=$idx">Edit</a>
                <a href="?action=delete&id=$idx">Delete</a>
                </div></div>
EOT;
}

echo <<<EOT
<hr>
<a href="?action=add">Add</a>
<hr>
EOT;
?>
