<?php 
    require_once("header.php");

    // Send already logged in users away.
    if (isSessionVariableSet(LOGGED_IN) && $_SESSION[LOGGED_IN]) {
        header("Location: index.php");
        exit();
    }

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == "POST") {

        // Trick to stop bot spam.
        if (!empty($_POST['website'])) {
            die();
        }

        $username = trim($_POST['username']);
        $username = strip_tags($username);
        $password = $_POST['password'];

        $hashword = hash(PASSWORD_ALGORITHM, $password);

        $statement = $db->prepare("SELECT * FROM user WHERE UserName = ?;");
        $statement->bindParam(1, $username, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($results)) {
            showWarning("Username is already taken.");
            goto escape;
        }

        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter a password."; 
            showWarning($password_err);
            goto escape;
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Password must have atleast 6 characters.";
            showWarning($password_err);
            goto escape;
        }

        if(empty($username)){
            $username_err = "Please enter a username";
            showWarning($username_err);
            goto escape;
        }elseif(!preg_match('/^[a-zA-Z0-9_]+$/', $username)){
            $username_err = "Username can only contain letters, numbers, and underscores."; 
            showWarning($username_err);
            goto escape;
        }else{ 
            $statement = $db->prepare("INSERT INTO user (UserName, Password) VALUES (?, ?)");
            $statement -> bindParam(1, $username, PDO::PARAM_STR);
            $statement -> bindParam(2, $hashword, PDO::PARAM_STR);
            $statement -> execute();
            createSession($username);
            header("Location: index.php");
        }
    }

    escape:
?>

<div class="container main-content">
    <form method='post' name='login' enctype='multipart/form-data'>
        
        <input style='display: none;' type='text' id='website' name='website'>

        <div class="container">
            <span class="nice-text">Register</span>
        </div>
        <div class="container">
            <input type='text' name='username' id='username' maxlength='36' placeholder="Username" <?php if (isset($_POST['username'])) { echo "value='" . $_POST['username'] . "'"; } ?> ></input>
        </div>
        <div class="container">
            <input type='password' name='password' id='password' maxlength='36' placeholder="Password"></input>
        </div>
        <div class="container">
            <p class="text-small">Register an account with us :)</p>
        </div>
        <div class="container">
            <button class="button" id='submitRegister'>Register</button>
        </div>
        
    </form>
</div>

<?php
    require_once("footer.php");
?>