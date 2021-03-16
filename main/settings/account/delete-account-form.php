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

  /*   header("Location: http://localhost:8888/themetronetwork/index.php?account-deleted");
    exit(); */

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
    $user_id = $_POST['user-id'];

    $sql = "SELECT passwrd FROM users WHERE id = :id;";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":id", $user_id);

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

    $conn->close();
}

function deleteUser() {
    $result 
}

function deleteAccount() {
    $result;

    $user_id = $_POST['user-id'];

    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":id", $user_id);

    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $result = TRUE;
    } else {
        $result = FALSE;
    }

    $conn->close();
}

function deleteCommunities() {
    $result;

    $user_id = $_POST['user-id'];


    $sql = "DELETE FROM communities WHERE userid = :id";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":id", $user_id);

    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $result = TRUE;
    } else {
        $result = FALSE;
    }

    $conn->close();
}



