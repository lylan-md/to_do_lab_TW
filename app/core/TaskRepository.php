<?php
class TaskRepository 
{
    private $db;

    function __construct()
    {
        $this->db = new DBLayer();
    }    

    public function addTask(PreparedTask $task, User $user)
    {
        $queryAddTask = "INSERT INTO `tasks` (`user_id`, `description`, `is_done`, `category_id`, `important`, `planned_on`) 
                        VALUES (" . $user->getId() . ", '" . $task->getDescription() . "', " . (int) $task->getIsDone() . ", " . $task->getCategory() . ", " . (int) $task->getImportant() . ", " . var_export($task->getPlannedOn(), true) . ")";

        if ($this->db->query($queryAddTask))
        {
            return true;
        }
        else
        {
            Utility::loggerAll(array(__FUNCTION__, "Query error!", $queryAddTask));
            return false;
        }
    }

    public function getTasks(User $user, $filters = array())
    {
        $queryGetTasks = "SELECT `id`, `description`, `is_done`, `category_id`, `important`, `planned_on` FROM `tasks` WHERE `user_id` = '" . $user->getId() . "'";

        foreach ($filters as $key => $value)
        {
            $queryGetTasks .= " AND `" . $key . "` = " . var_export($value, true);
        }

        $resultGetTasks = $this->db->query($queryGetTasks);

        if ($resultGetTasks === false)
        {
            Utility::loggerAll(array(__FUNCTION__, "Query error!", $queryGetTasks));
            return [];
        }

        $tasks = array();

        while ($row = mysqli_fetch_assoc($resultGetTasks))
        {
            $task       = new Task($row['id'], $row['description'], (bool) $row['is_done'], $row['category_id'], (bool) $row['important'], $row['planned_on']);
            $tasks[]    = $task;
        }

        return $tasks;
    }

    public function deleteTask(Task $task, User $user)
    {
        $queryDeleteTask = "DELETE FROM `tasks` WHERE `user_id` = " . $user->getId() . " AND `id` = " . $task->getId();
        return $this->db->query($queryDeleteTask);
    }

    public function updateTask(Task $task, User $user)
    {
        $queryUpdateTask = "UPDATE `tasks` SET 
                                `description`   = " . var_export($task->getDescription(), true) . ",
                                `is_done`       = " . (int) $task->getIsDone() . ",
                                `category_id`   = " . $task->getCategory() . ",
                                `important`     = " . (int) $task->getImportant() . ",
                                `planned_on`    = " . var_export($task->getPlannedOn(), true) . "
                            WHERE `user_id` = " . $user->getId() . " AND `id` = " . $task->getId();

        return $this->db->query($queryUpdateTask);
    }
}