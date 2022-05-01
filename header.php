<?php
    require_once("global.php");
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrNabs7Uu1HHH7PVvgaYuYczjTOGPM6V8"></script>
    <script src="main.js"></script>
</head>
<body>
    <div id="info-div" class="info" style="display: none">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <p style="margin: 0;" id="info-text"></p>
    </div> 
    <div id="alert-div" class="alert" style="display: none">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <p style="margin: 0;" id="alert-text"></p>
    </div> 
    <nav id="main-navbar">
        <div style="display: flex; align-items: center; height: 100%;">
            <h1 class="nice-text inline" style="margin: 0; color: white; padding-left: 1rem;">PROJECT GRAVESIDES</h1>
            <ul class="navbar-ul">
                <li class="navbar-item">
                    <a class="navbar-link" href="index.php">Home</a>
                </li>
                <li class="navbar-item">
                    <a class="navbar-link" href="map.php">Map</a>
                </li>
                <?php if (!isSessionVariableSet(LOGGED_IN) || $_SESSION[LOGGED_IN] == false) { ?>
                    <li class="navbar-item">
                        <a class="navbar-link" href="login.php">Login</a>
                    </li>
                    <li class="navbar-item">
                        <a class="navbar-link" href="register.php">Register</a>
                    </li>
                <?php } else { ?>
                    <li class="navbar-item">
                        <a class="navbar-link" href="feedback.php">Feedback</a>
                    </li>
                    <li class="navbar-item">
                        <a class="navbar-link" href="logout.php">Logout</a>
                    </li>
                <?php } ?>
            </ul>
            <?php if (isSessionVariableSet(LOGGED_IN) && $_SESSION[LOGGED_IN]) { ?>
                <div class="inline" style="margin-left: auto; padding-right: 2rem;">
                    <p class="nice-text" style="color: white;">Welcome <?php echo $_SESSION[USERNAME]; ?></p>
                </div>
            <?php } ?>
        </div>
    </nav>