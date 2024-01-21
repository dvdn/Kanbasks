<?php

/**
 * Group and its tasks
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

    function set_task($id, $data)
    {
        $this->tasks[$id] = $data;
    }

    function remove_task($id)
    {
        unset($this->tasks[$id]);
    }

    /**
     * reset_tasks
     *
     * removes keys as : ["0":{"name":"A"},"1":{"name":"B"}]
     * is equivalent to : [{"name":"A"},{"name":"B"}]
     * (less chars, only uselful data)
     *
     * @return array tasks values
     */
    function reset_tasks()
    {
        return array_values($this->tasks);
    }
}
