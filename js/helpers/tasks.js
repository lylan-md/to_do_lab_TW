var cookieListName = "task_list";

function addTask(task, email)
{
    if (email)
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                showTasks(getTasksThisPage());
            }
        }
        
        var requestData = "email=" + email + "&task_data=" + JSON.stringify(task);
        xhttp.open("POST", "app/api.php", true);
        xhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        xhttp.send(requestData);
    }
    else
    {
        var taskList = getTasks();
        var lastId = taskList.length ? taskList[taskList.length - 1].task_id + 1 : 1;
        task.task_id = lastId;
        taskList.push(task);
        setCookie(cookieListName, JSON.stringify(taskList), 24);
    }
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

function getTask(category, email)
{
    if (email)
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                showTasks(JSON.parse(this.responseText));
            }
        }
        
        var requestData = "email=" + email + "&category=" + category;

        xhttp.open("GET", "app/api.php?" + requestData, true);
        xhttp.send();
        return [];
    }
    else
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
}

function getImportantTask(email)
{
    if (email)
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                showTasks(JSON.parse(this.responseText));
            }
        }
        
        var requestData = "email=" + email + "&important=1";

        xhttp.open("GET", "app/api.php?" + requestData, true);
        xhttp.send();
        return [];
    }
    else
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
}

function deleteTask(taskId, email)
{
    if (email)
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                showTasks(getTasksThisPage());
            }
        }
        
        var requestData = "email=" + email + "&task_id=" + taskId;

        xhttp.open("DELETE", "app/api.php", true);
        xhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        xhttp.send(requestData);
    }
    else
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
}

function updateTask(updatedTask, email)
{
    if (email)
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                showTasks(getTasksThisPage());
            }
        }
        
        var requestData = "email=" + email + "&task_data=" + JSON.stringify(updatedTask);
        xhttp.open("PUT", "app/api.php", true);
        xhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        xhttp.send(requestData);
    }
    else
    {
        var taskList = getTasks();
        var newTaskList = [];

        taskList.forEach((task) => {
            newTaskList.push(updatedTask.task_id == task.task_id ? updatedTask : task);
        });

        setCookie(cookieListName, JSON.stringify(newTaskList), 1);
    }
}