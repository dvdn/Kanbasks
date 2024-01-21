<?php

class Crud
{
    private $filePath;
    public $data;


    public function __construct($filePath)
    {
        if (file_exists($filePath)) {
            $this->filePath = $filePath;
            $this->data = json_decode(file_get_contents($filePath), true);
        } else {
            throw new Exception("Data file not found", 1);
        }
    }


    public function actionAddGroup()
    {
        $group = isset($_POST['group']) ? $_POST['group'] : "";
        $data = isset($this->data) ? $this->data : [];

        if ($group && !array_key_exists($group, $data)) {
            $data[$group] = array();
            file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT)); // TMP nicer json for humans
            $_SESSION['group'] = $group; // display created group at reload
            $this->refreshBoard();
        }
    }


    public function actionDeleteGroup()
    {
        $group = isset($_POST['group']) ? $_POST['group'] : "";
        if ($group) {
            unset($this->data[$group]);
            file_put_contents($this->filePath, json_encode($this->data, JSON_PRETTY_PRINT)); // TMP nicer json for humans
        } else {
            echo "Nothing to delete.";
        }
        $this->refreshBoard();
    }


    public function actionEditGroup()
    {
        $group = isset($_POST['group']) ? $_POST['group'] : "";
        $oldGroup = isset($_POST['oldgroup']) ? $_POST['oldgroup'] : "";
        $data = $this->data;

        if ($group && !array_key_exists($group, $data)) {
            $data[$group] = $data[$oldGroup];
            unset($data[$oldGroup]); //TODO keep groups order
            file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT)); // TMP nicer json for humans
            $_SESSION['group'] = $group; // display group at reload
            $this->refreshBoard();
        }
    }


    public function refreshBoard($anchor = '')
    {
        $fullAnchor = $anchor ?  '#' . $anchor : '';
        echo '<meta http-equiv="refresh" content="0; url=index.php' . $fullAnchor . '">';
    }
}
