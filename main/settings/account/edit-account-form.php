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
    $user_bio = $_POST["user-bio"];

    
    //if empty directs user back with all empty error
    if(allEmpty($user_first_name, $user_last_name, $user_username, $user_email, $user_bio)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=all-empty");
        exit();
    }

    //Checks if any of these values have curse words in them
    if(!empty($user_first_name) || !empty($user_last_name) || !empty($user_username) || !empty($user_email) || !empty($user_bio) ) {
        if(filterInputFive($user_first_name, $user_last_name, $user_username, $user_email, $user_bio, $bad_word_filepath)){
            header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=inappropriate-value");
            exit();
        }
    }

    //if name is incorrect directs user back with incorrect name error
    if(!empty($user_first_name) || !empty($user_last_name)) {
        if(checkName($user_first_name, $user_last_name)) {
            header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=name-incorrect-value");
            exit();
        }
    }

    //if username is incorrect directs user back with incorrect username error
    if(!empty($user_username)) {
        if(checkUsername($user_username)) {
            header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=incorrect-username");
            exit();
        } 
    }

    //if email is incorrect directs user back with incorrect email error
    if(!empty($user_email)) {
        if(checkEmail($user_email)) {
            header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=incorrect-email");
            exit();
        } 
    }

    //if username or email is taken directs user back with taken username/email error
    if(!empty($user_username) || !empty($user_email)) {
        if(takenUsernameEmail($user_username, $user_email, $filepath)) {
            header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=taken-username-email");
            exit();
        }
    }

    if(!empty($user_bio)) {
        if(wordCount($user_bio)) {
            header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=bio-too-long");
            exit();
        }
    }

    //if input passes all functions, account is edited and the user is directed back
    //if something goes wrong, user is sent back with error
    if(editUser($user_first_name, $user_last_name, $user_username, $user_email, $user_bio)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=successful-edit");
        exit(); 
    } else {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=unsuccessful-edit");
        exit();
    }
  
}


//ONLY IN USE FOR EDIT ACCOUNT
function editUser($user_first_name, $user_last_name, $user_username, $user_email, $user_bio) {

    require("../../../includes/db.php");

    $result;

    //had an issue where the global $userid wasnt working
    $user_id = $_POST['user-id'];

    if(!empty($user_first_name)) {

        $sql = "UPDATE users SET first_name = :first_name WHERE id = :id;";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":first_name", $user_first_name);
        $stmt->bindParam(":id", $user_id);


        $stmt->execute();


        if($stmt->rowCount() > 0) {
            $result = true;
        } else {
            $result = false;
        }
    }

    if(!empty($user_last_name)) {

        $sql = "UPDATE users SET last_name = :last_name WHERE id = :id;";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":last_name", $user_last_name);
        $stmt->bindParam(":id", $user_id);


        $stmt->execute();


        if($stmt->rowCount() > 0) {
            $result = true;
        } else {
            $result = false;
        }
    }


    if(!empty($user_username)) {

        $sql = "UPDATE users SET username = :username WHERE id = :id;";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":username", $user_username);
        $stmt->bindParam(":id", $user_id);


        $stmt->execute();


        if($stmt->rowCount() > 0) {
            $result = true;
        } else {
            $result = false;
        }
    }

    if(!empty($user_email)) {

        $sql = "UPDATE users SET email = :email WHERE id = :id;";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":email", $user_email);
        $stmt->bindParam(":id", $user_id);


        $stmt->execute();


        if($stmt->rowCount() > 0) {
            $result = true;
        } else {
            $result = false;
        }
    }

    if(!empty($user_bio)) {

        $sql = "UPDATE users SET bio = :bio WHERE id = :id;";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":bio", $user_bio);
        $stmt->bindParam(":id", $user_id);


        $stmt->execute();


        if($stmt->rowCount() > 0) {
            $result = true;
        } else {
            $result = false;
        }
    }


    return $result;

    $conn->close();

}