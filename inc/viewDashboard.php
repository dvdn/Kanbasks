 <?php
include_once('View.php');
$view = new View();
$formAnchor = "#".$view->formAnchor;


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
                <a href="?action=delete&id=$idx$formAnchor" class="delete action">Delete</a>
                <a href="?action=edit&id=$idx$formAnchor" class="edit action">Edit</a>
                </div></div>
EOT;
}

echo <<<EOT
<div class="menu">
    <a href="?action=add$formAnchor">+ Add a new task</a>
</div>
<span id="$view->formAnchor"></span>
EOT;
?>
