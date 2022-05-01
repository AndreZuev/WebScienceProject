<?php
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_PASS = 'mysql';
    const DB_NAME = 'gravesidesdb';
    const HASH_ALGO = 'sha3-512';

    // Session variables constants.
    const USERNAME = "s_username";
    const LOGGED_IN = "s_logged_in";
    const IP_ADDRESS = "s_address";

    const PASSWORD_ALGORITHM = 'sha3-512';

    $dbs = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
    $db = new PDO($dbs, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function destroySession() {
        session_unset();
        if (ini_get('session.use_cookies')) {
            setcookie(session_name(), '', time() - 42000);
        }
        session_destroy();
    }

    function createSession($username) {
        $_SESSION[USERNAME] = $username;
        $_SESSION[LOGGED_IN] = true;
    }

    function isSessionVariableSet($key) {
        return array_key_exists($key, $_SESSION);
    }

    function getIPAddressOfUser() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }
        return $ipAddress;
    }

    function showInfo($text) {
        ?>
            <script>
                showInfo(<?php echo '"' . $text . '"' ?>);
            </script>
        <?php
    }

    function showWarning($text) {
        ?>
            <script>
                showAlert(<?php echo '"' . $text . '"' ?>);
            </script>
        <?php
    }

    if (!isset($_SESSION)) {
        session_start();
    }

    if (isSessionVariableSet(IP_ADDRESS) && $_SESSION[IP_ADDRESS] != getIPAddressOfUser()) {
        destroySession();
        session_start();
    }
?>