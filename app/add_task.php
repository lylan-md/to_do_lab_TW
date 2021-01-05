<?php
require_once(__DIR__ . "/core/includes.php");

$taskRepository = new TaskRepository();
$userRepository = new UserRepository();

if (isset($_GET['task_data'], $_GET['email']))
{   
    $user = $userRepository->getUser($_GET['email']);

    if (is_a($user, "User"))
    {
        $task = json_decode($_GET['task_data']);
        $preparedTask = new PreparedTask($task->task_desc, $task->is_done, $task->category, $task->important, $task->planned_on);
        $taskRepository->addTask($preparedTask, $user);
    }
}