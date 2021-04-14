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