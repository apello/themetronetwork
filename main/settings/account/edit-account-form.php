<?php


if(isset($_POST['submit'])){

    //intializes variables
    $user_first_name = $_POST["user-first-name"];
    $user_last_name = $_POST["user-last-name"]; 
    $user_username = $_POST["user-name"];
    $user_email = $_POST["user-email"];

    
    //if empty directs user back with all empty error
    if(isEmpty($user_first_name, $user_last_name, $user_username, $user_email)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=all-empty");
        exit();
    }

    //if name is incorrect directs user back with incorrect name error
    if(!empty($user_first_name) || !empty($user_last_name)) {
        if(checkName($user_first_name, $user_last_name)) {
            header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=name-incorrect-value");
            exit();
        }
    }

    //if username or email is taken directs user back with taken username/email error
    if(!empty($user_username) || !empty($user_email)) {
        if(takenUsernameEmail($user_username, $user_email)) {
            header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=taken-username-email");
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

    //if input passes all functions, account is edited and the user is directed back
    //if something goes wrong, user is sent back with error
    if(editUser($user_first_name, $user_last_name, $user_username, $user_email)) {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=successful-edit");
        exit(); 
    } else {
        header("Location: http://localhost:8888/themetronetwork/main/settings/account/edit-account.php?alert=unsuccessful-edit");
        exit();
    }




}

//checks if every input is empty
function isEmpty($user_first_name, $user_last_name, $user_username, $user_email) {

    $result;

    if(empty($user_first_name) && empty($user_last_name) && empty($user_username) && empty($user_email)) {
        $result = true;
    } else {
        $result = false;
    }
    
    return $result;
}


//function checks if the username or email are already taken
function takenUsernameEmail($user_username, $user_email) {

    //had an issue where the intial require did not work in functions


    require("../../../includes/db.php");

    $result;

    $sql = "SELECT username, email FROM users WHERE username = :username OR email = :email;";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":username", $user_username);
    $stmt->bindParam(":email", $user_email);

    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;

    $conn->close();
    

}

//function runs name thru checks to make sure it is correct
function checkName($user_first_name, $user_last_name) {
    
    $result;

    //checks name was written with ABC 
    if(!preg_match("/^[a-zA-Z]*$/", $user_first_name) || !preg_match("/^[a-zA-Z]*$/", $user_last_name)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
    
} 


//function runs usernames thru checks to make sure it is correct
function checkUsername($user_username) {
    
    $result;

    //checks username length and whether it was written with ABC and 123
    if(strlen($user_username) < 5 || strlen($user_username) > 50 || !preg_match("/^[a-zA-Z0-9]*$/", $user_username)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
    
} 


//function checks email to see if it ends in the 'metroschool'
//will eventually edit to add the '.org' part
function checkEmail($user_email) {
    
    $result;


    if(!preg_match("/themetroschool/i", $user_email)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
    
} 


//checks if input is filled in, then updates it
function editUser($user_first_name, $user_last_name, $user_username, $user_email) {

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

    return $result;

    $conn->close();

}