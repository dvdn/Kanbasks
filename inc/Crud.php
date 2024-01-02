<?php

class Crud
{
    private $filePath;
    private $fileContent;
    public $data;
    public $listName;
    public $attributesList;
    public $attributesListText;
    public $statusList;

    public function __construct($filePath = 'data/data.json')
    {
        if (file_exists($filePath)) {
            $this->filePath = $filePath;
            $this->fileContent = file_get_contents($filePath);
            $this->data = json_decode($this->fileContent, true);
            $this->listName = "tasks";
            $this->attributesList = ["title", "description", "created_at", "color", "status"];
            $this->attributesListText = ["title", "description", "created_at"];
            $this->statusList = ["todo", "wip", "done"];
        } else {
            throw new Exception("No file found", 1);
        }
    }

    public function actionAdd()
    {
        $listName = $this->listName;
        $data = $this->data;
        array_push($data[$listName], $_POST);
        file_put_contents($this->filePath, json_encode($data));
        $this->refreshBoard();
    }

    public function actionRead()
    {
        return $this->data;
    }

    public function actionEdit()
    {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $listName = $this->listName;
            $data = $this->data;
            $itemData = $data[$listName][$id];

            foreach ($this->attributesList as $value) {
                $post[$value] = isset($_POST[$value]) ? $_POST[$value] : "";
            }

            if ($itemData) {
                unset($data[$listName][$id]);
                $data[$listName][$id] = $post;
                file_put_contents($this->filePath, json_encode($data));
            }
            $this->refreshBoard();
        }
    }

    public function actionDelete($id=null)
    {
        if ($id!==null && is_numeric($id) && $this->data[$this->listName][$id]) {
            $listName = $this->listName;
            $data = $this->data;
            unset($data[$listName][$id]);
            file_put_contents($this->filePath, json_encode($data));
            $this->refreshBoard();
        } else {
            throw new Exception("Nothing to delete", 1);
        }
    }

    public function refreshBoard()
    {        
        if (headers_sent()) {
            echo('Roger that.<br>Please -> <a href="index.php">refresh the board</a>');
        }
        else {
            header("Location: ".$_SERVER['PHP_SELF']);
        }
    }
}
