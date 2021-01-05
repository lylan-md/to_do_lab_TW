<?php
require_once(__DIR__ . "/core/includes.php");

$taskRepository = new TaskRepository();
$userRepository = new UserRepository();

if (isset($_GET['email'], $_GET['task_id']))
{
    $user = $userRepository->getUser($_GET['email']);

    if (is_a($user, "User"))
    {
        $tasks = $taskRepository->getTasks($user, array("id" => $_GET['task_id']));
        $taskRepository->deleteTask($tasks[0], $user);
    }
}