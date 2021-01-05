<?php
require_once(__DIR__ . "/core/includes.php");

$taskRepository = new TaskRepository();
$userRepository = new UserRepository();

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
}

echo json_encode($response);