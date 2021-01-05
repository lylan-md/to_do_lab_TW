<div class="header pure-u-1" id="header">
    <div class="pure-g">
        <div class="pure-u-1-3 pure-u-sm-1-3">
            <span class="material-icons" id="button-open-left-panel" onclick="openPanel(this)">menu</span>
        </div>
        <input type="search" class="header-search-input pure-u-sm-1-3" placeholder="Search"></input>
        <div class="logout-block pure-u-2-3 pure-u-sm-1-3">
            <?php if(isset($_SESSION['email'])) : ?>
                <form method="POST" action="app/logout.php">
                    <span style="color: #ffffff;" id="email-span"><?php echo $_SESSION['email'] ?></span>
                    <button id="button-logout"><span class="material-icons">exit_to_app</span></button>
                </form>
            <?php else : ?>
                <form method="POST" action="index.php">
                    <span style="color: #ffffff;">LogIn</span>
                    <button><span class="material-icons">how_to_reg</span></button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>