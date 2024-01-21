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
        $newgroup = isset($_POST['newgroup']) ? $_POST['newgroup'] : "";
        $data = isset($this->data) ? $this->data : [];

        if ($newgroup && !array_key_exists($newgroup, $data)) {
            $data[$newgroup] = array();
            file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT)); // TMP nicer json for humans
            $_SESSION['group'] = $newgroup; // display created group at reload
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
