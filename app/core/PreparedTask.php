<?php
class PreparedTask 
{
    private $description;
    private $isDone;
    private $category;
    private $important;
    private $plannedOn;

    function __construct($description, $isDone = false, $category, $important = false, $plannedOn = null)
    {
        $this->description  = $description;
        $this->isDone       = $isDone;
        $this->category     = $category;
        $this->important    = $important;
        $this->plannedOn    = $plannedOn;
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