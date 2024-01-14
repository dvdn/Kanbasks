<?php

class Crud
{
    private $filePath;

    public function __construct($filePath)
    {
        if (file_exists($filePath)) {
            $this->filePath = $filePath;
            $this->data = json_decode(file_get_contents($filePath), true);
            $this->taskattributes = [
                'name' => 'text',
                'description' => 'textarea',
                'creation_date' => 'text',
                'due_date' => 'text',
                'color' => 'text',
                'status' => ['todo', 'wip', 'done'],
              ];
        } else {
            throw new Exception("Data file not found", 1);
        }
    }

    public function get_datagroup($group)
    {
        return $this->data[$group];
    }

    public function actionAddGroup()
    {
        $newgroup = isset($_POST['newgroup']) ? $_POST['newgroup'] : "";
        $data = isset($this->data) ? $this->data : [];

        if ($newgroup && !array_key_exists($newgroup, $data)) {
            $data[$newgroup] = array();
            file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT)); // TMP nicer json for humans
            $this->refreshBoard();
        }
    }

    public function actionEditGroup()
    {
        $newgroup = isset($_POST['newgroup']) ? $_POST['newgroup'] : "";
        $data = $this->data;

        if ($newgroup && !array_key_exists($newgroup, $data)) {
            $data[$newgroup] = $data[$_SESSION['group']];
            unset($data[$_SESSION['group']]);
            file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT)); // TMP nicer json for humans
            $this->refreshBoard();
        }
    }

    public function actionAdd($group)
    {
        $data = $this->data;

        foreach (array_keys($this->taskattributes) as $idx => $value) {
            if (isset($_POST[$value]) && $_POST[$value]) { // persist only non empty values
                $posted[$value] = $_POST[$value];
            }
        }

        array_push($data[$group], $posted);

        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT)); // TMP nicer json for humans
        $this->refreshBoard();
    }

    public function actionEdit($group)
    {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $data = $this->data;
            $itemData = $data[$group][$id];

            foreach (array_keys($this->taskattributes) as $idx => $value) {
                if (isset($_POST[$value]) && $_POST[$value]) { // persist only non empty values
                    $posted[$value] = $_POST[$value];
                }
            }

            if ($itemData) {
                unset($data[$group][$id]);
                $data[$group][$id] = $posted;
                file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT)); // TMP nicer json for humans
            }

            $this->refreshBoard($id);
        }
    }

    public function actionDelete($group)
    {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            unset($this->data[$group][$id]);
            file_put_contents($this->filePath, json_encode($this->data, JSON_PRETTY_PRINT)); // TMP nicer json for humans
        } else {
            echo "Nothing to delete";
            $this->refreshBoard();
        }
    }

    public function actionDeleteGroup()
    {
        $deletegroup = isset($_POST['grouptodelete']) ? $_POST['grouptodelete'] : "";
        if ($deletegroup) {
            unset($this->data[$deletegroup]);
            file_put_contents($this->filePath, json_encode($this->data, JSON_PRETTY_PRINT)); // TMP nicer json for humans
            $this->refreshBoard();
        } else {
            echo "Nothing to delete.";
            $this->refreshBoard();
        }
    }

    public function refreshBoard($anchor = '')
    {
        if (headers_sent()) {
            $fullAnchor = $anchor ?  '#' . $anchor : '';
            echo <<<EOT
             <form id="refresh" action="$fullAnchor">
                <p><img width="10%" src="inc/checkmark.png" alt="logo OK" /></p>
                Please ->
                <button type="submit">refresh the board</button>
             </form>
EOT;
        } else {
            header("Location: " . $_SERVER['PHP_SELF']);
        }
    }
}
