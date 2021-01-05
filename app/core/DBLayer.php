<?php
require_once(__DIR__ . "/config.php");

class DBLayer 
{
    private $username;
    private $password;
    private $host;
    private $dbName;
    
    private $connectionError;

    private static $link;

    function __construct()
    {
        $this->username = DBLayerConfig::$username;
        $this->password = DBLayerConfig::$password;
        $this->host		= DBLayerConfig::$host;
        $this->dbName	= DBLayerConfig::$dbName;
                
        register_shutdown_function(array($this, "closeConnection"));

        if (!$this->checkConnection())
        {
            throw new Exception("Connection db error! error: " . $this->connectionError);
        }
    }

    public function checkConnection()
    {
        $connected = true;

        if (!is_object(self::$link))
        {
            $connected = $this->connect();
        }
        
        if ($connected)
        {
            if (!mysqli_ping(self::$link))
            {
                return $this->connect();
            }

            return true;
        }
        else
        {
            return false;
        }
    }

    public function connect()
    {
        self::$link = mysqli_connect($this->host, $this->username, $this->password, $this->dbName);

        if (!self::$link)
        {
            $this->connectionError = mysqli_connect_error();
            Utility::loggerAll(array(__FUNCTION__, "DB connection error!", $this->connectionError));
        }

        return self::$link ? true : false; 
    }

    public function selectOneValue($query)
    {
        if ($this->checkConnection())
        {
            $result = mysqli_query(self::$link, $query);
            return $result !== false ? mysqli_fetch_array($result, MYSQLI_NUM)[0] : false;
        }
        else
        {
            return false;
        }
    }

    public function query($query)
    {
        if ($this->checkConnection())
        {
            $result = mysqli_query(self::$link, $query);
            return $result;
        }
        else
        {
            return false;
        }
    }

    public function closeConnection()
    {
        if (self::$link)
        {
            mysqli_close(self::$link);
            self::$link = null;
        }
    }
}