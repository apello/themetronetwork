<?php


if(isset($_POST['submit'])) {

    $user_pwd = $_POST["user-pwd"]; 

    if(emptyValue($user_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/delete-account.php?alert=missing-value");
        exit();
    }

    if(checkPassword($user_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/delete-account.php?alert=incorrect-password");
        exit();
    }

    if(deleteUser()) {
        header("Location: http://localhost:8888/themetronetwork/index.php?alert=account-deleted");
        exit(); 
    } else {
        header("Location: http://localhost:8888/themetronetwork/main/account/delete-account.php?alert=error");
        exit(); 
    }
}

function emptyValue($user_pwd) {
    $result;

    if(empty($user_pwd)) {
        $result = TRUE;
    } else {
        $result = FALSE;
    }

    return $result;
}

function checkPassword ($user_pwd) {

    $result;

    require("../../../includes/db.php");

    $userid = $_POST['user-id'];

    $sql = "SELECT passwrd FROM users WHERE id = :id;";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":id", $userid);

    $stmt->execute();

    if($stmt->rowCount() > 0) {
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(password_verify($user_pwd, $row['passwrd'])) {
                $result = FALSE;
            } else {
                $result = TRUE;
            }
        }
    } else {
        $result = TRUE;
    }

    return $result;
}

function deleteUser() {

    $result;

    $userid = $_POST['user-id'];

    require("../../../includes/db.php");

    //one SQL stmt still has problems but idc anymore took me two freaking weeks to figrue this out stupid ur stupid dummy
    $sql = 
    "DELETE FROM users WHERE id = :id;
    DELETE FROM posts WHERE creatorid = :id;
    DELETE FROM comments WHERE userid = :id;
    DELETE FROM friends WHERE user_id1 = :id OR user_id2 = :id;
    DELETE FROM favorites WHERE userid = :id;
    DELETE FROM communities WHERE userid = :id;
    ";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":id", $userid);

    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $return = TRUE;
    } else {
        $return = FALSE;
    }

    return $return;
}