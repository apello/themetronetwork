<?php


//REGISTRATION FUNCTIONS


//function checks if empty
function isEmpty($user_first_name, $user_last_name, $user_username, $user_email, $user_pwd, $user_rpt_pwd, $select) {

    $result;

    if(empty($user_first_name) || empty($user_last_name) || empty($user_username) || empty($user_email) || empty($user_pwd) || empty($user_rpt_pwd) || $select == "question") {
        $result = true;
    } else {
        $result = false;
    }
    
    return $result;
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

//function checks if the username or email are already taken
function takenUsernameEmail($user_username, $user_email) {

    //had an issue where the intial require did not work in functions
    require("includes/db.php");

    $result;

    $sql = "SELECT username, email FROM users WHERE username = :username OR email = :email;";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":username", $user_username);
    $stmt->bindParam(":email", $user_email);

    $stmt->execute();

    echo $stmt->rowCount();

    if($stmt->rowCount() > 0) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;

    $conn->close();

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
 

//creates the user
function createUser($user_first_name, $user_last_name, $user_username, $user_email, $user_pwd, $select) {

    $choice;
    
    
    //had an issue where the intial require did not work in functions
    require("includes/db.php");

    
    //decided to randomly choose picture for user 
    $profile_picture = rand(1,10);

    //checks what select is
    if($select == "student") {
        $choice = 1;
    } else if ($select == "teacher"){
        $choice = 0;
    }

    
    //sql statement
    $sql = "INSERT INTO users (first_name,last_name, username, email, passwrd, created_at, picture, position) VALUES (:first_name,:last_name,:username,:email,:passwrd, NOW(), :picture, :position)";
    $stmt = $conn->prepare($sql);

    
    //to prevent sql injection, paramters are binded here
    $stmt->bindParam(":first_name", $user_first_name);
    $stmt->bindParam(":last_name", $user_last_name);
    $stmt->bindParam(":username", $user_username);
    $stmt->bindParam(":email", $user_email);
    $stmt->bindParam(":picture", $profile_picture);
    $stmt->bindParam(":position", $choice);
    $stmt->bindParam(":passwrd", password_hash($user_pwd, PASSWORD_BCRYPT));


    if($stmt->execute()) {
        return true;
    }

    echo "Hello";

    $conn->close();
}
 
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////

// LOGIN FUNCTIONS


//function checks if empty
function authIsEmpty($auth_username, $auth_pwd) {

    $result;

    if(empty($auth_username) || empty($auth_pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    
    return $result;
}

//function logs user in
function logIn($auth_username, $auth_pwd) {

    session_start();
    
    //had an issue where the intial require did not work in functions
    require("includes/db.php");

    //sql statement - selects username from database 
    $sql = "SELECT id,username,passwrd FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);

    //to prevent sql injection, paramters are binded here
    $stmt->bindParam(":username", $auth_username);
    $stmt->execute();

    //if results are greater than 0
    if($stmt->rowCount() > 0) {
        //make $row = to whatever we requested
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //hashes entered password and checks against already hashed password
            //also checks if username = username
            if(password_verify($auth_pwd, $row['passwrd']) && $row['username'] == $auth_username) {
                //makes a session with the user id
                $_SESSION['USER_ID'] = $row['id'];
                //to help track activity
                $_SESSION['LAST_ACTIVITY'] = time();
                //used in if statements to easily call
                $result = true;
            }
        }
    } else {
        $result = false;
    }

    return $result;

    $conn->close();
}