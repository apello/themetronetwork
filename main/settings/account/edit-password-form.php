<?php


if(isset($_POST['submit'])){

    //FUNCTION REQUIRE FROM FUNC
    require("../../../includes/functions.php");

    //FILE PATHs
    $filepath = "../../../includes/db.php";
    $bad_word_filepath = "../../../includes/bad-words.php";

    //intializes variables
    $user_first_name = $_POST["user-first-name"];
    $user_last_name = $_POST["user-last-name"]; 
    $user_username = $_POST["user-name"];
    $user_email = $_POST["user-email"];

    //intializes variables
    $old_pwd = $_POST["old-user-pwd"];
    $user_pwd = $_POST["user-pwd"]; 
    $user_rpt_pwd = $_POST["user-rpt-pwd"];

    //FOR TRACKING
    $user_id = $_POST['user-id'];


    
    //if empty directs user back with all empty error
    if(isEmpty($old_pwd, $user_pwd, $user_rpt_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-password.php?alert=missing-value");
        exit();
    }

    if(checkPassword($user_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-password.php?alert=incorrect-password");
        exit();
    }

    if(isSamePassword($user_pwd, $user_rpt_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-password.php?alert=passwords-do-not-match");
        exit();
    }

    if(oldEqualNew($user_pwd, $old_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-password.php?alert=old-equal-new");
        exit();
    }

    if(checkPasswordDB($old_pwd, $filepath)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-password.php?alert=old-pwd-does-not-match");
        exit();
    }

    if(editPassword($user_pwd)) {

        trackUserActions($user_id, "EDITED PASSWORD", $filepath);

        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-password.php?alert=successful-edit");
        exit();
    } else {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-password.php?alert=unsuccessful-edit");
        exit();
    }

}



//ONLY IN EDIT PASSWORD
//checks if input is filled in, then updates it
function editPassword($user_pwd) {

    require("../../../includes/db.php");

    $result;

    //had an issue where the global $userid wasnt working
    $user_id = $_POST['user-id'];
    
    $sql = "UPDATE users SET passwrd = :passwrd WHERE id = :id;";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":passwrd", password_hash($user_pwd, PASSWORD_BCRYPT));
    $stmt->bindParam(":id", $user_id);

    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}