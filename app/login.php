<?php
require_once(__DIR__ . "/core/includes.php");

session_start();

try 
{   
    $db = new DBLayer();
}
catch (Exception $e)
{
    $_SESSION['login_error'] = "Internal error!";  
    exit();
}

$utility        = new Utility();
$userRepository = new UserRepository();

if (isset($_POST['action']))
{
    $action = $_POST['action'];

    switch ($action) 
    {
        case "SignIn": 
            if ($utility->validateEmail($_POST['email']))
            {
                if (strlen($_POST['password']))
                {
                    $email      = $_POST['email'];
                    $password   = $_POST['password'];

                    $user = $userRepository->getUser($email, $password);
                    
                    if (is_a($user, "User"))
                    {
                        $_SESSION['email'] = $user->getEmail();          
                    }
                    elseif (is_a($user, "UserNull"))
                    {
                        $_SESSION['login_error'] = "Password or Email incorrect!";                
                    }
                    else
                    {
                        $_SESSION['login_error'] = "Internal error!";      
                    }
                }
                else
                {
                    $_SESSION['login_error'] = "Empty password!";        
                }
            }
            else
            {
                $_SESSION['login_error'] = "Invalid email!";    
            }

            header("Location: /../index.php");
            break;
        case "Create":
            if ($utility->validateEmail($_POST['email']))
            {
                if (strlen($_POST['password']))
                {
                    $email      = $_POST['email'];
                    $password   = $_POST['password'];

                    $resultUserExists = $userRepository->checkUserExists($email);

                    if ($resultUserExists == -1)
                    {
                        $queryInsertUser = "INSERT INTO `users` (`email`, `password`) VALUES ('$email', '" . sha1($password) . "')";        
                        if ($db->query($queryInsertUser))
                        {
                            $_SESSION['email'] = $email;         
                        }
                        else
                        {
                            $_SESSION['login_error'] = "Internal error!";                
                        }
                    }
                    elseif ($resultUserExists === false)
                    {
                        $_SESSION['login_error'] = "Internal error!";                
                    }   
                    else
                    {
                        $_SESSION['login_error'] = "User exists!";            
                    }
                }
                else
                {
                    $_SESSION['login_error'] = "Empty password!";        
                }
            }
            else
            {
                $_SESSION['login_error'] = "Invalid email!";    
            }

            header("Location: /../index.php");
            break;
        default:
            $_SESSION['login_error'] = "Internal error!"; 
            exit();
    }
}