<?php

/**
 * Group
 */
class Group
{
    public $name;
    public $tasks;
    public $taskattributes;

    function __construct($name, $data)
    {
        $this->name = $name;
        $this->tasks = $data[$this->name];
        $this->taskattributes = [
            'name' => 'text',
            'description' => 'textarea',
            'creation_info' => 'text',
            'due_info' => 'text',
            'color' => 'text',
            'status' => ['todo', 'wip', 'done'],
          ];
    }

    function set_name($name)
    {
        $this->name = $name;
    }
    function get_name()
    {
        return $this->name;
    }

    function get_tasks()
    {
        return $this->tasks;
    }

    /*     function set_tasks()
    {
        return $this->tasks;
    } */
}
