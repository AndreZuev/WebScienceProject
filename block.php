<?php

    require_once('global.php');

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == "POST") {

    } else if ($method == "GET") {

        if (key_exists("blockid", $_GET)) {
            $statement = $db->prepare("SELECT * FROM block WHERE idBlock = ?;");
            $statement->bindParam(1, $_GET["blockid"], PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                http_response_code(404);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($result[0]);
                http_response_code(200);
            }
            exit;
        } else {
            $statement = $db->prepare("SELECT * FROM block");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($result);
            http_response_code(200);
            exit;
        }
    }

?>