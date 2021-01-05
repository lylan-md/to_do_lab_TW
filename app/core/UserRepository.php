<?php
class UserRepository
{
    private $db;

    function __construct()
    {
        $this->db = new DBLayer();
    }

    public function addUser($email, $password)
    {
        $queryInsertUser = "INSERT INTO `users` (`email`, `password`) VALUES ('$email', '" . sha1($password) . "')";

        if ($this->db->query($queryInsertUser))
        {
            return true;
        }
        else
        {
            Utility::loggerAll(array(__FUNCTION__, "Query error!", $queryInsertUser));
            return false;
        }
    }

    public function getUser($email, $password = null)
    {
        $queryGetUser = "SELECT `id`, `email` FROM `users` WHERE email = '$email'";

        if ($password)
        {
            $queryGetUser .= " AND `password` = '" . sha1($password) . "'";
        }

        $resultGetUser  = $this->db->query($queryGetUser);

        if ($resultGetUser === false)
        {
            Utility::loggerAll(array(__FUNCTION__, "Query error!", $queryGetUser));
            return false;
        }

        if ($resultGetUser->num_rows)
        {
            $row = mysqli_fetch_assoc($resultGetUser);
            return new User($row['id'], $row['email']);
        }
        else
        {
            return new UserNull();
        }
    }

    public function checkUserExists($email)
    {
        $queryCheckUserExists = "SELECT IFNULL((SELECT `id` FROM `users` WHERE `email` = '$email'), -1)";
        return $this->db->selectOneValue($queryCheckUserExists);
    }
}