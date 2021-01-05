<?php 
    session_start();
    if (isset($_SESSION['email']))
    {
        header("Location: /my_day.php");
    }
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
                <div class="content-block-header" id="header">
                    <h1 style="text-align: center;">Welcome to lylan To Do manager.</h1>
                </div>
                <hr>
                <div class="login-form">
                    <?php if(isset($_SESSION['login_error'])) : ?>
                        <span class="login-error-box pure-u-4-5 pure-u-md-2-5 pure-u-xl-1-5"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></span>
                    <?php endif; ?>
                    <form action="app/login.php" method="POST" onsubmit="return validateLogInForm(this)">
                        <input class="pure-u-4-5 pure-u-md-2-5 pure-u-xl-1-5" name="email" type="email" id="email-login" placeholder="Your email..">
                        <br>
                        <input class="pure-u-4-5 pure-u-md-2-5 pure-u-xl-1-5" name="password" type="password" id="password-login" placeholder="Your password..">
                        <br>
                        <button class="pure-u-10-24 pure-u-md-7-24 pure-u-xl-3-24" type="submit" name="action" value="SignIn">Sign In</button>
                        <button class="pure-u-10-24 pure-u-md-7-24 pure-u-xl-3-24" type="submit" name="action" value="Create">Create account</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>