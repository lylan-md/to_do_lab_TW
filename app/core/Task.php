<?php
class Task 
{
    public $id;
    public $description;
    public $isDone;
    public $category;
    public $important;
    public $plannedOn;

    function __construct($id, $description, $isDone = false, $category, $important = false, $plannedOn = null)
    {
        $this->id           = $id;
        $this->description  = $description;
        $this->isDone       = $isDone;
        $this->category     = $category;
        $this->important    = $important;
        $this->plannedOn    = $plannedOn ? $plannedOn : null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getIsDone()
    {
        return $this->isDone;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getImportant()
    {
        return $this->important;
    }

    public function getPlannedOn()
    {
        return $this->plannedOn;
    }
}