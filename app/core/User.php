<?php
class User 
{
    private $id;
    private $email;

    function __construct($id, $email)
    {
        $this->id       = $id;
        $this->email    = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }
}