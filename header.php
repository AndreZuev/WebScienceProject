<?php
    require_once("global.php");
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
    <div id="alert-div" class="alert" style="display: none">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <p style="margin: 0;" id="alert-text"></p>
    </div> 
    <nav id="main-navbar">
        <div class="logo-container">
            <img src="" alt="GraveSides" />
        </div>
        <ul class="navbar-ul">
            <li class="navbar-item">
                <a class="navbar-link" href="index.php">Home</a>
            </li>
            <?php if (!isSessionVariableSet(LOGGED_IN) || $_SESSION[LOGGED_IN] == false) { ?>
                <li class="navbar-item">
                    <a class="navbar-link" href="login.php">Login</a>
                </li>
            <?php } else { ?>
                <li class="navbar-item">
                    <a class="navbar-link" href="logout.php">Logout</a>
                </li>
            <?php } ?>
        </ul>
    </nav>