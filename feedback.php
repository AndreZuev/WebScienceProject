<?php 
    require_once("header.php");

    // Send already logged in users away.
    if (!isSessionVariableSet(LOGGED_IN) || $_SESSION[LOGGED_IN] == false) {
        header("Location: login.php");
        exit();
    }

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == "POST") {

        // Trick to stop bot spam.
        if (!empty($_POST['website'])) {
            die();
        }

        $feedback = trim($_POST['feedback']);

        if (!empty($feedback)) {
            $statement = $db->prepare("INSERT INTO feedback (UserForeignKey, Feedback) VALUES (?, ?)");
            $statement->bindParam(1, $_SESSION[USERNAME], PDO::PARAM_STR);
            $statement->bindParam(2, $feedback, PDO::PARAM_STR);
            $statement->execute();

            showInfo("Feedback submitted!");
            exit;
        } else {
            showWarning("Feedback cannot be empty.");
        }
    }

?>

<div class="container main-content">
    <form method='post' name='feedback' enctype='multipart/form-data'>
        <input style='display: none;' type='text' id='website' name='website'>
        <div class="container">
            <span class="nice-text">Provide your Feedback</span>
        </div>
        <span><textarea rows="8" cols="50" name='feedback' id='feedback' placeholder="Your feedback..." <?php if (isset($_POST['feedback'])) { echo "value='" . $_POST['feedback'] . "'"; } ?> ></textarea></span>
        <div class="container">
            <button class="button" id='submitFeedback'>Feedback</button>
        </div>
    </form>
</div>

<?php
    require_once("footer.php");
?>