<?php


//REGISTRATION FUNCTIONS


//MULTIPLE EMPTY
function isEmpty() {

    $result;

    $args = func_get_args();

    for ($i = 0; $i < count($args); $i++) { 
        if(trim($args[$i]) == NULL) {
            $result = TRUE;
        }
    }
    
    return $result;
}

//ALL EMPTY - EDIT ACCOUNT
function allEmpty($user_first_name, $user_last_name, $user_username, $user_email, $user_bio) {

    $result;

    if(empty($user_first_name) && empty($user_last_name) && empty($user_username) && empty($user_email) && empty($user_bio)) {
        $result = true;
    } else {
        $result = false;
    }
    
    return $result;
}


//filters input for bad words

/* USED IN:
- REGISTRATION

*/

function filterInputFour($a, $b, $c, $d, $bad_word_filepath) {

    include($bad_word_filepath);

    $result = FALSE;

    //str pos works very well
    for ($iterative = 0; $iterative < count($bad_words); $iterative++) { 
        if(strpos($a, $bad_words[$iterative]) !== FALSE OR strpos($b, $bad_words[$iterative]) !== FALSE OR strpos($c, $bad_words[$iterative]) !== FALSE OR strpos($d, $bad_words[$iterative]) !== FALSE) {
            $result = TRUE;
        }
    }

    return $result;
}

/* USED IN:
- EDIT ACCOUNT

*/

function filterInputFive($a, $b, $c, $d, $e, $bad_word_filepath) {

    include($bad_word_filepath);

    $result = FALSE;

    //str pos works very well
    for ($iterative = 0; $iterative < count($bad_words); $iterative++) { 
        if(strpos($a, $bad_words[$iterative]) !== FALSE OR strpos($b, $bad_words[$iterative]) !== FALSE OR strpos($c, $bad_words[$iterative]) !== FALSE OR strpos($d, $bad_words[$iterative]) !== FALSE OR strpos($e, $bad_words[$iterative]) !== FALSE) {
            $result = TRUE;
        }
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
function takenUsernameEmail($user_username, $user_email, $filepath) {

    //had an issue where the intial require did not work in functions
    require($filepath);

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
function createUser($user_first_name, $user_last_name, $user_username, $user_email, $user_pwd, $select, $filepath) {
    
    //had an issue where the intial require did not work in functions
    require($filepath);
    
    //decided to randomly choose picture for user 
    $profile_picture = rand(1,10);
    
    //sql statement
    $sql = "INSERT INTO users (first_name,last_name, username, email, passwrd, created_at, picture, position) VALUES (:first_name,:last_name,:username,:email,:passwrd, NOW(), :picture, :position)";
    $stmt = $conn->prepare($sql);
    
    //to prevent sql injection, paramters are binded here
    $stmt->bindParam(":first_name", $user_first_name);
    $stmt->bindParam(":last_name", $user_last_name);
    $stmt->bindParam(":username", $user_username);
    $stmt->bindParam(":email", $user_email);
    $stmt->bindParam(":picture", $profile_picture);
    $stmt->bindParam(":position", ucwords($select));
    $stmt->bindParam(":passwrd", password_hash($user_pwd, PASSWORD_BCRYPT));


    if($stmt->execute()) {
        return true;
    }

    $conn->close();
}
 
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////

// LOGIN FUNCTIONS


//function logs user in
function logIn($auth_username, $auth_pwd, $filepath) {

    session_start();
    
    //had an issue where the intial require did not work in functions
    require($filepath);

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



//////////////////////////////////


//OTHER FUNCTIONS


//CHECK DB PASSWORD

/* USES: 
- DELETE ACCOUNT
- EDIT PASSWORD
*/

function checkPasswordDB($user_pwd, $filepath) {

    $result;

    require_once($filepath);

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

    $conn->close();
}

//function checks if passwords are the same

/* USES: 
- SEARCH
- EDIT ACCOUNT
*/


function filterInput($search_query, $bad_word_filepath) {

    include($bad_word_filepath);

    $result = false;

    //STRPOS returns POS of string
    //Double negative for desired result

    for ($iterative = 0; $iterative < count($bad_words); $iterative++) { 
        if(strpos($search_query, $bad_words[$iterative]) !== FALSE) {
            $result = TRUE;
        }
    }

    return $result;
}

//function checks if old password and new password are the same

/* USES: 
- EDIT PASSWORD
*/

function oldEqualNew($user_pwd, $old_pwd) {
    $result;

    if($user_pwd == $old_pwd) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

//counts words in text

/* USES: 
- EDIT ACCOUNT for BIO
*/

function wordCount($a) {
    $result;

    if(count($a) > 250) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}