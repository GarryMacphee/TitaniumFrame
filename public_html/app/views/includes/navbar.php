<?php $query_string = explode('=', basename($_SERVER['QUERY_STRING'])); $name = strtolower(end($query_string)); $current_page = $name;?>
<nav class="navbar navbar-expand-lg navbar-light material-white text-dark nav-style">
    <div class="container-fluid">
        <a class="navbar-brand title-spacing" href="<?php echo URLROOT ?>"><?php echo SITENAME ?></a>
        <button class="navbar-toggler text-white" type="button" data-toggle="collapse" 
                data-target="#navbarsExampleDefault" 
                aria-controls="navbarsExampleDefault" 
                aria-expanded="false" 
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto px-2">
                <li class="nav-item px-2">
                    <a <?php if($current_page == ''){ echo 'id="here"';}?> class="nav-link text-dark" href="<?php echo URLROOT ?>">Home</a>
                </li>
                <li class="nav-item px-2">
                    <a <?php if($current_page == 'about'){ echo 'id="here"';}?> class="nav-link text-dark" href="<?php echo URLROOT ?>/pages/about">About</a>
                </li>
                <?php if(isset($_SESSION['user_id'])) :?>
                        
                <li class="nav-item px-2">
                    <a <?php if($current_page == 'dashboards'){ echo 'id="here"';}?> class="nav-link text-dark" href="<?php echo URLROOT ?>/dashboards/">Dashboard</a>
                </li>
                
                <li class="nav-item px-2">
                    <a <?php if($current_page == 'posts'){ echo 'id="here"';}?> class="nav-link text-dark" href="<?php echo URLROOT ?>/posts/">Posts</a>
                </li>
                
                <li class="nav-item px-2">
                    <a <?php if($current_page == 'chats'){ echo 'id="here"';}?> class="nav-link text-dark" href="<?php echo URLROOT ?>/chats/">Chat</a>
                </li>
                
                <li class="nav-item px-2">
                    <a <?php if($current_page == 'uploads'){ echo 'id="here"';}?> class="nav-link text-dark" href="<?php echo URLROOT ?>/uploads/">Uploads</a>
                </li>
                <?php endif ?>
            </ul>

            <ul class="navbar-nav ml-auto">
                <?php if(isset($_SESSION['user_id'])) :?>
                     <li class="nav-item px-2">
                        <a <?php if($current_page == 'users/logout/index.php'){ echo 'id="here"';}?> class="nav-link" href="<?php echo URLROOT ?>/users/logout">Logout</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item px-2">
                        <a <?php if($current_page == 'users/register/index.php'){ echo 'id="here"';}?> class="nav-link text-dark" href="<?php echo URLROOT ?>/users/register">Register</a>
                    </li>
                    <li class="nav-item px-2">
                        <a <?php if($current_page == 'login'){ echo 'id="here"';}?> class="nav-link text-dark" href="<?php echo URLROOT ?>/users/login">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>