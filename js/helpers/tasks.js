var cookieListName = "task_list";

function addTask(task)
{
    var taskList = getTasks();
    console.log(taskList);
    var lastId = taskList.length ? taskList[taskList.length - 1].task_id + 1 : 1;
    task.task_id = lastId;
    taskList.push(task);
    setCookie(cookieListName, JSON.stringify(taskList), 24);
}

function getLastTaskId()
{
    var taskList = getCookie(cookieListName);

    if (taskList)
    {
        taskList = JSON.parse($taskList);
        var task = taskList[taskList.length - 1];
        return task.task_id;
    }
    else
    {
        return 0;
    }
}

function getTasks()
{
    var taskList = getCookie(cookieListName);

    if (taskList)
    {
        return JSON.parse(taskList);
    }
    else
    {
        return [];
    }
}

function getTask(category)
{
    var jsonTaskList = getCookie(cookieListName);

    if (jsonTaskList)
    {
        let taskList = JSON.parse(jsonTaskList);
        let filtredTaskList = [];
    
        taskList.forEach((task) => {
            if (task.category == category)
            {
                filtredTaskList.push(task);            
            }
        });

        return filtredTaskList;
    }
    else
    {
        return [];
    }
}

function getImportantTask()
{
    var jsonTaskList = getCookie(cookieListName);

    if (jsonTaskList)
    {
        let taskList = JSON.parse(jsonTaskList);
        let filtredTaskList = [];
    
        taskList.forEach((task) => {
            if (task.category == 4 || task.important)
            {
                filtredTaskList.push(task);            
            }
        });

        return filtredTaskList;
    }
    else
    {
        return [];
    }
}

function deleteTask(taskId)
{
    var taskList = getTasks();
    var newTaskList = [];

    taskList.forEach((task) => {
        if (task.task_id != taskId)
        {
            newTaskList.push(task);
        }
    });

    setCookie(cookieListName, JSON.stringify(newTaskList), 1);
}

function updateTask(updatedTask)
{
    var taskList = getTasks();
    var newTaskList = [];

    taskList.forEach((task) => {
        newTaskList.push(updatedTask.task_id == task.task_id ? updatedTask : task);
    });

    setCookie(cookieListName, JSON.stringify(newTaskList), 1);
}