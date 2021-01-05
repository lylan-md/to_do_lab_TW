<?php
require_once(__DIR__ . "/core/includes.php");

$taskRepository = new TaskRepository();
$userRepository = new UserRepository();

if (isset($_GET['task_data'], $_GET['email']))
{   
    $user = $userRepository->getUser($_GET['email']);

    if (is_a($user, "User"))
    {
        $taskData   = json_decode($_GET['task_data']);
        $task       = new Task($taskData->task_id, $taskData->task_desc, $taskData->is_done, $taskData->category, $taskData->important, $taskData->planned_on);
        var_dump($task);
        var_dump($taskRepository->updateTask($task, $user));
    }
}