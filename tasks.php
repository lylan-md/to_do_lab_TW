<?php 
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>To Do</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="img/favicon.png">
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="style/pure-min.css">
        <link rel="stylesheet" href="style/grids-responsive-min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script type="text/javascript" src="js/helpers/cookies.js"></script>
        <script type="text/javascript" src="js/helpers/tasks.js"></script>
        <script type="text/javascript" src="js/todo.js"></script>
    </head>
    <body>
        <?php require_once(__DIR__ . "/left_panel.php"); ?>
        <div class="pure-u-1 pure-u-sm-16-24 pure-u-md-18-24 pure-u-xl-20-24" id="content-wrapper">
            <?php require_once(__DIR__ . "/header.php"); ?>
            <div class="pure-u-1-1" id="content-block">
                <div class="content-block-header">
                    <h1><span class="material-icons">home</span>Tasks</h1>
                </div>
                <hr>
                <input type="text" id="content-block-add" class="pure-u-1-1" onchange="handleInputTask(this, this.value)" placeholder="Add task">
                <div class="content-block-list" id="task-list-block">
                </div>
                <template id="task-list-elem-template">
                    <div class="content-block-list-item pure-u-1-1" style="vertical-align: middle;">
                        <div class="pure-u-2-24 pure-u-md-1-24">
                            <input type="checkbox" id="checkbox-is-done-{TASK_ID}" {CHECKED} class="checkbox-is-done" onclick="handleIsDoneCheckBox(this)">
                        </div>
                        <div class="pure-u-18-24 pure-u-md-21-24">
                            <span id="task-desc-{TASK_ID}" style="text-decoration: {TEXT_DES_DECORATION}" data-category="{TASK_CATEGORY}">{TASK_DESCRIPTION}</span>
                        </div>
                        <div class="pure-u-3-24 pure-u-md-2-24" style="float: right;">
                            <span class="material-icons favorite-icon-{FAVORITE_STATUS}" id="fav-i-{TASK_ID}" onclick="favoriteClick(this)">{FAVORITE_STATUS_ICON}</span>
                            <span class="material-icons delete-task-icon" id="del-i-{TASK_ID}" onclick="handleDeleteIconPress(this.id)">delete_outline</span>
                        </div>
                        <div class="content-block-list-item-planned-date" style="display: {DISPLAY_PLANNED};">
                            <span style="font-size: 80%; color: #8c8c8c;">Planned on: </span>
                            <span style="font-size: 80%; color: #788cde;" id="planned-on-{TASK_ID}">{PLANNED_DATE}</span>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </body>
    <script>
        function handleInputTask(input, taskDescription)
        {
            if (taskDescription.length)
            {
                var task = {
                    task_desc: taskDescription,
                    is_done: false,
                    category: categoryPage,
                    important: false,
                    planned_on: null
                };

                var email = undefined;
                var emailSpan = document.getElementById("email-span");
                
                if (emailSpan)
                {
                    email = emailSpan.innerText;
                }

                addTask(task, email);
                showTasks(getTasksThisPage());
                input.value = "";
            }
        }

        function getTasksThisPage()
        {
            var email = undefined;
            var emailSpan = document.getElementById("email-span");
            
            if (emailSpan)
            {
                email = emailSpan.innerText;
            }
             
            return getTask(categoryPage, email); 
        }

        var categoryPage = 3;
        document.getElementById("menu-list-tasks").classList.add("selected");
        showTasks(getTasksThisPage());
    </script>
</html>