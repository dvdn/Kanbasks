 <?php
include_once('View.php');
$view = new View();

// tableHead
$tHead = "<div class='row'><div class='head'> To Do </div><div class='head'> WIP </div><div class='head'> Done </div></div>";

echo $tHead;

$data = reset($crud->data);
ksort($data);

foreach ($data as $idx => $item) {
    $status = $item['status'];
    $colorStyle = "";

    if (isset($item['color'])) {
        $colorStyle = "style='background-color: ".$item['color'].";'";
    }
    
    $itemData = "<div class='row'><div class='item ".$status."' ".$colorStyle.">";
    foreach ($crud->attributesListText as $attribute){
        if (isset($item[$attribute])) {
            $itemData .= $item[$attribute]."</br>";
        }
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
<a href="?action=add">+ Add a new task</a>
<hr>
EOT;
?>
