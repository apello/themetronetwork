<?php


if(isset($_POST['submit'])){

    //intializes variables
    $old_pwd = $_POST["old-user-pwd"];
    $user_pwd = $_POST["user-pwd"]; 
    $user_rpt_pwd = $_POST["user-rpt-pwd"];

    
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

    if(checkOldPassword($old_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-password.php?alert=old-pwd-does-not-match");
        exit();
    }

    if(editPassword($user_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-password.php?alert=successful-edit");
        exit();
    } else {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-password.php?alert=unsuccessful-edit");
        exit();
    }

}

//function checks if passwords are the same
function isSamePassword($user_pwd, $user_rpt_pwd) {

    $result;

    if($user_pwd != $user_rpt_pwd) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function oldEqualNew($user_pwd, $old_pwd) {
    $result;

    if($user_pwd == $old_pwd) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

//checks if every input is empty
function isEmpty($old_pwd, $user_pwd, $user_rpt_pwd) {

    $result;

    if(empty($old_pwd) || empty($user_pwd) || empty($user_rpt_pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    
    return $result;
}


//function runs password thru checks to make sure it is correct
function checkPassword($user_pwd) {
    
    $result;

    //checks password length and whether it was written with ABC and 123
    if(strlen($user_pwd) < 6 || strlen($user_pwd) > 50 || !preg_match("/^[a-zA-Z0-9]*$/", $user_pwd)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
} 

//function checks if password matches pwd in db
function checkOldPassword($old_pwd) {

    //had an issue where the intial require did not work in functions
    require("../../../includes/db.php");

    $result;

    $user_id = $_POST['user-id'];

    $sql = "SELECT passwrd FROM users WHERE id = :id;";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":id", $user_id);

    $stmt->execute();

    if($stmt->rowCount() > 0) {
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(password_verify($old_pwd, $row['passwrd'])) {
                $result = FALSE;
            } else {
                $result = TRUE;
            }
        }
    } else {
        $result = TRUE;
    }

    return $result;

    $conn->close();

}




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