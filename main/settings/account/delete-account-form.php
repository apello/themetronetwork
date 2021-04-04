<?php


if(isset($_POST['submit'])) {

    //FUNCTION REQUIRE FROM AUTH-FUNC
    require("../../../includes/functions.php");

    $filepath = "../../../includes/db.php";
    $user_pwd = $_POST["user-pwd"]; 

    if(isEmpty($user_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/delete-account.php?alert=missing-value");
        exit();
    }

   if(checkPasswordDB($user_pwd, $filepath)) {
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



//this is propreitary to delete-account
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