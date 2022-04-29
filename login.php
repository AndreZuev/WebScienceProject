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

        $username = $_POST['username'];
        $password = $_POST['password'];

        $hashword = hash(PASSWORD_ALGORITHM, $password);

        $statement = $db->prepare("SELECT Password FROM user WHERE UserName = ?;");
        $statement->bindParam(1, $username, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($results)) {
            $actual_hashword = $results[0]['Password'];

            if ($actual_hashword === $hashword) {
                // User is logged in.
                createSession($username);
                header('location: index.php');
            }
        }

        showWarning("Invalid username or password!");
    }

?>

<form method='post' name='login' enctype='multipart/form-data'>
    <input style='display: none;' type='text' id='website' name='website'>
    <span><input type='text' name='username' id='username' maxlength='36' placeholder="Username" <?php if (isset($_POST['username'])) { echo "value='" . $_POST['username'] . "'"; } ?> ></input></span>
    <span><input type='password' name='password' id='password' maxlength='36' placeholder="Password"></input></span>
    <button id='submitLogin'>Login</button>
</form>

<?php
    require_once("footer.php");
?>