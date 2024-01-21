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

    public function actionAddTask($group)
    {
        $data = $this->data;

        foreach (array_keys($group->taskattributes) as $idx => $value) {
            if (isset($_POST[$value]) && $_POST[$value]) { // persist only non empty values
                $posted[$value] = $_POST[$value];
            }
        }

        array_push($data[$group->name], $posted);

        $this->saveData($data);
        $this->refreshBoard();
    }

    public function actionDeleteTask($group)
    {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $group->remove_task($id);
            $this->data[$group->name] = $group->reset_tasks();

            $this->saveData($this->data);
        } else {
            echo "Nothing to delete";
        }
        $this->refreshBoard();
    }

    public function actionEditTask($group)
    {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $itemData = $group->tasks[$id];

            foreach (array_keys($group->taskattributes) as $idx => $value) {
                if (isset($_POST[$value]) && $_POST[$value]) { // persist only non empty values
                    $posted[$value] = $_POST[$value];
                }
            }

            if ($itemData) {
                $group->set_task($id, $posted);
                $this->data[$group->name] = $group->reset_tasks();
                $this->saveData($this->data);
            }

            $this->refreshBoard($id);
        }
    }

    public function actionAddGroup()
    {
        $group = isset($_POST['group']) ? $_POST['group'] : "";
        $data = isset($this->data) ? $this->data : [];

        if ($group && !array_key_exists($group, $data)) {
            $data[$group] = array();
            $this->saveData($data);
            $_SESSION['group'] = $group; // display created group at reload
            $this->refreshBoard();
        }
    }

    public function actionDeleteGroup()
    {
        $group = isset($_POST['group']) ? $_POST['group'] : "";
        if ($group) {
            unset($this->data[$group]);
            $this->saveData($this->data);
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
            unset($data[$oldGroup]); // TODO keep groups order
            $this->saveData($data);
            $_SESSION['group'] = $group; // display group at reload
            $this->refreshBoard();
        }
    }

    private function refreshBoard($anchor = '')
    {
        $fullAnchor = $anchor ?  '#' . $anchor : '';
        echo '<meta http-equiv="refresh" content="0; url=index.php' . $fullAnchor . '">';
    }

    private function saveData($data)
    {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT)); // TMP nicer json for humans
    }
}
