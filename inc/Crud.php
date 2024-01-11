<?php

class Crud
{
    private $filePath;
    const TASK_ATTRIBUTES = [
        'name',
        'description',
        'creation_date',
        'due_date',
        'status',
        'color'
    ];

    public function __construct($filePath)
    {
        if (file_exists($filePath)) {
            $this->filePath = $filePath;
            $this->data = json_decode(file_get_contents($filePath), true);
        } else {
            throw new Exception("Data file not found", 1);
        }
    }

    public function actionAdd($group = 'tasks')
    {

        $data = $this->data;
        array_push($data[$group], $_POST);
        file_put_contents($this->filePath, json_encode($data));
        $this->refreshBoard();
    }

    public function actionEdit($group = 'tasks')
    {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];

            $data = $this->data;
            $itemData = $data[$group][$id];

            foreach (self::TASK_ATTRIBUTES as $idx => $value) {
                $post[$value] = isset($_POST[$value]) ? $_POST[$value] : "";
            }

            if ($itemData) {
                unset($data[$group][$id]);
                $data[$group][$id] = $post;
                file_put_contents($this->filePath, json_encode($data));
            }
            $this->refreshBoard();
        }
    }

    public function actionDelete($id, $group = 'tasks')
    {
        if ($id && is_numeric($id) && $this->data[$group][$id]) {
            unset($this->data[$group][$id]);
            file_put_contents($this->filePath, json_encode($this->data));
            $this->refreshBoard();
        } else {
            throw new Exception("Nothing to delete", 1);
        }
    }

    public function refreshBoard()
    {
        if (headers_sent()) {
            echo ('Roger that.<br>Please -> <a href="index.php"><strong>refresh the board</strong></a>');
        } else {
            header("Location: " . $_SERVER['PHP_SELF']);
        }
    }
}
