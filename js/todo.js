function openPanel()
{
    var leftPanel = document.getElementById("left-panel");

    if (window.matchMedia("(max-width: 35.5em)").matches)
    {
        leftPanel.classList.remove("pure-u-sm-8-24");
        leftPanel.classList.remove("pure-u-md-6-24");
        leftPanel.classList.remove("pure-u-xl-4-24"); 
        leftPanel.classList.add("pure-u-1");
    }
    else
    {
        leftPanel.classList.add("pure-u-sm-8-24");
        leftPanel.classList.add("pure-u-md-6-24");
        leftPanel.classList.add("pure-u-xl-4-24");
    }

    document.getElementById("button-open-left-panel").style.display = null;
    
    var contentWrapper = document.getElementById("content-wrapper");
    contentWrapper.classList.add("pure-u-sm-16-24");
    contentWrapper.classList.add("pure-u-md-18-24");
    contentWrapper.classList.add("pure-u-xl-20-24");
}

function closePanel() 
{
    document.getElementById("button-open-left-panel").style.display = "block";
    
    var leftPanel = document.getElementById("left-panel");
    leftPanel.classList.remove("pure-u-1");
    leftPanel.classList.remove("pure-u-sm-8-24");
    leftPanel.classList.remove("pure-u-md-6-24");
    leftPanel.classList.remove("pure-u-xl-4-24");

    var contentWrapper = document.getElementById("content-wrapper");
    contentWrapper.classList.remove("pure-u-sm-16-24");
    contentWrapper.classList.remove("pure-u-md-18-24");
    contentWrapper.classList.remove("pure-u-xl-20-24");
}

function showTasks(taskList)
{
    var taskListBlock = document.getElementById("task-list-block");
    document.getElementById("task-list-block").innerHTML = "";

    var nodeDoneList = [];
    var nodeNotDoneList = [];

    taskList.forEach(task => {
        let htmlElemTemplate = document.getElementById("task-list-elem-template").innerHTML;
        htmlElemTemplate = htmlElemTemplate.replace(/{TASK_ID}/g, task.task_id);
        htmlElemTemplate = htmlElemTemplate.replace(/{CHECKED}/gi, task.is_done ? "checked" : "");
        htmlElemTemplate = htmlElemTemplate.replace(/{TASK_CATEGORY}/g, task.category);
        htmlElemTemplate = htmlElemTemplate.replace(/{TASK_DESCRIPTION}/g, task.task_desc);
        htmlElemTemplate = htmlElemTemplate.replace(/{TEXT_DES_DECORATION}/g, task.is_done ? "line-through" : "none");
        htmlElemTemplate = htmlElemTemplate.replace(/{FAVORITE_STATUS}/g, task.important ? "checked" : "unchecked");
        htmlElemTemplate = htmlElemTemplate.replace(/{FAVORITE_STATUS_ICON}/g, task.important ? "star" : "star_border");
        htmlElemTemplate = htmlElemTemplate.replace(/{DISPLAY_PLANNED}/g, task.planned_on ? "block" : "none");
        htmlElemTemplate = htmlElemTemplate.replace(/{PLANNED_DATE}/g, task.planned_on ? task.planned_on : "");

        if (task.is_done)
        {
            nodeDoneList.push(htmlElemTemplate);
        }
        else
        {
            nodeNotDoneList.push(htmlElemTemplate);
        }
    });

    nodeNotDoneList.forEach(htmlElemCode => {
        let elem = document.createElement('div');
        elem.innerHTML = htmlElemCode.trim()
        taskListBlock.appendChild(elem);
    });

    if (nodeNotDoneList.length && nodeDoneList.length)
    {
        taskListBlock.appendChild(document.createElement('hr'));
    }

    nodeDoneList.forEach(htmlElemCode => {
        let elem = document.createElement('div');
        elem.innerHTML = htmlElemCode.trim()
        taskListBlock.appendChild(elem);
    });

    document.getElementById("left-panel").style.height = (document.getElementById("content-block").offsetHeight + document.getElementById("header").offsetHeight) + "px";
}

function handleIsDoneCheckBox(checkBox)
{
    var taskId = checkBox.id.replace("checkbox-is-done-", "");
    var plannedElem = document.getElementById("planned-on-" + taskId);
    var plannedOn = plannedElem ? plannedElem.innerText : null;

    var task = {
            task_id: taskId,
            task_desc: document.getElementById("task-desc-" + taskId).innerText,
            is_done: checkBox.checked ? true : false,
            category: document.getElementById("task-desc-" + taskId).getAttribute("data-category"),
            important: document.getElementById("fav-i-" + taskId).classList.contains("favorite-icon-checked"),
            planned_on: plannedOn
        };
    updateTask(task);
    showTasks(getTasksThisPage());
}

function handleDeleteIconPress(id)
{
    var taskId = id.replace("del-i-", "");
    deleteTask(taskId);
    showTasks(getTasksThisPage());
}

function favoriteClick(elem)
{
    var favoriteChecked;

    if (elem.classList.contains("favorite-icon-checked"))
    {
        elem.classList.replace("favorite-icon-checked", "favorite-icon-unchecked");
        elem.innerHTML = "star_border";
        favoriteChecked = false;
    }
    else if (elem.classList.contains("favorite-icon-unchecked"))
    {
        elem.classList.replace("favorite-icon-unchecked", "favorite-icon-checked");
        elem.innerHTML = "star";
        favoriteChecked = true;
    }
    
    var taskId = elem.id.replace("fav-i-", "");
    var plannedElem = document.getElementById("planned-on-" + taskId);
    var plannedOn = plannedElem ? plannedElem.innerText : null;

    var task = {
            task_id: taskId,
            task_desc: document.getElementById("task-desc-" + taskId).innerText,
            is_done: document.getElementById("checkbox-is-done-" + taskId).checked ? true : false,
            category: document.getElementById("task-desc-" + taskId).getAttribute("data-category"),
            important: favoriteChecked,
            planned_on: plannedOn
        };
    updateTask(task);
    showTasks(getTasksThisPage());
}