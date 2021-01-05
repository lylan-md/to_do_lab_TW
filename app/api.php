<?php
require_once(__DIR__ . "/core/includes.php");

$taskRepository = new TaskRepository();
$userRepository = new UserRepository();

$httpCodeResponse       = 200;
$httpMessageResponse    = "OK"; 

switch ($_SERVER['REQUEST_METHOD'])
{
    case "GET":
        $response = array();

        $email      = isset($_GET['email']) ? $_GET['email'] : null;
        $category   = isset($_GET['category']) ? $_GET['category'] : null;
        $important  = isset($_GET['important']) ? $_GET['important'] : null;

        if ($email)
        {   
            $user = $userRepository->getUser($email);

            if (is_a($user, "User"))
            {
                $filters = array();
                if ($category)
                {
                    $filters['category_id'] = $category;
                }

                if ($important)
                {
                    $filters['important'] = (int) $important;
                }

                $taskList = $taskRepository->getTasks($user, $filters);

                foreach ($taskList as $task)
                {
                    $response[] = array(
                        "task_id"       => $task->getId(),
                        "task_desc"     => $task->getDescription(),
                        "is_done"       => $task->getIsDone(),
                        "category"      => $task->getCategory(),
                        "important"     => $task->getImportant(),
                        "planned_on"    => $task->getPlannedOn(),
                    );
                }
            }
            else
            {
                $httpCodeResponse       = 401;
                $httpMessageResponse    = "Unauthorized";    
            }
        }
        else
        {
            $httpCodeResponse       = 400;
            $httpMessageResponse    = "Bad Request";
        }
        echo json_encode($response);
        break;
    case "POST":
        $input = file_get_contents("php://input");
        parse_str($input, $vars);

        if (isset($vars['task_data'], $vars['email']))
        {   
            $user = $userRepository->getUser($vars['email']);

            if (is_a($user, "User"))
            {
                $task = json_decode($vars['task_data']);
                $preparedTask = new PreparedTask($task->task_desc, $task->is_done, $task->category, $task->important, $task->planned_on);
                if (!$taskRepository->addTask($preparedTask, $user))
                {
                    $httpCodeResponse       = 500;
                    $httpMessageResponse    = "Internal Server Error";
                }
            }
            else
            {
                $httpCodeResponse       = 401;
                $httpMessageResponse    = "Unauthorized";    
            }
        }
        else
        {
            $httpCodeResponse       = 400;
            $httpMessageResponse    = "Bad Request";
        }
        break;
    case "PUT":
        $input = file_get_contents("php://input");
        parse_str($input, $vars);

        if (isset($vars['task_data'], $vars['email']))
        {   
            $user = $userRepository->getUser($vars['email']);

            if (is_a($user, "User"))
            {
                $taskData   = json_decode($vars['task_data']);
                $task       = new Task($taskData->task_id, $taskData->task_desc, $taskData->is_done, $taskData->category, $taskData->important, $taskData->planned_on);
                if (!$taskRepository->updateTask($task, $user))
                {
                    $httpCodeResponse       = 500;
                    $httpMessageResponse    = "Internal Server Error";    
                }
            }
            else
            {
                $httpCodeResponse       = 401;
                $httpMessageResponse    = "Unauthorized";    
            }
        }
        else
        {
            $httpCodeResponse       = 400;
            $httpMessageResponse    = "Bad Request";
        }
        break;
    case "DELETE":
        $input = file_get_contents("php://input");
        parse_str($input, $vars);

        if (isset($vars['email'], $vars['task_id']))
        {
            $user = $userRepository->getUser($vars['email']);

            if (is_a($user, "User"))
            {
                $tasks = $taskRepository->getTasks($user, array("id" => $vars['task_id']));
                if (!$taskRepository->deleteTask($tasks[0], $user))
                {
                    $httpCodeResponse       = 500;
                    $httpMessageResponse    = "Internal Server Error";    
                }
            }
            else
            {
                $httpCodeResponse       = 401;
                $httpMessageResponse    = "Unauthorized";    
            }
        }
        else
        {
            $httpCodeResponse       = 400;
            $httpMessageResponse    = "Bad Request";
        }
        break;
    default:
        $httpCodeResponse       = 501;
        $httpMessageResponse    = "Not Implemented";
        break;
}

header("HTTP/1.1 $httpCodeResponse $httpMessageResponse");
