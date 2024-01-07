<?php

class Crud
{
    private $filePath;
    public $data;

    public function __construct($filePath = 'data/data.json')
    {
        if (file_exists($filePath)) {
            $this->filePath = $filePath;
            $this->data = json_decode(file_get_contents($filePath);, true);
        } else {
            throw new Exception("Data file not found", 1);
        }


    }

    function get_data()
    {
        return $this->data;
    }
}