<?php

//require db and for future uses function page

if(isset($_POST['submit'])){

    session_start();

    require_once("includes/functions.php");

    $user_first_name = $_POST["user-first-name"];
    $user_last_name = $_POST["user-last-name"]; 
    $user_username = $_POST["user-name"];
    $user_email = $_POST["user-email"];
    $user_pwd = $_POST["user-pwd"];
    $user_rpt_pwd = $_POST["user-rpt-pwd"];
    $select = $_POST['select'];

    //FILE PATHS
    $bad_word_filepath = "includes/bad-words.php";
    $filepath = "includes/db.php";

    //calls isempty to check if empty and if return true rediret to homepage 
    if(isEmpty($user_first_name, $user_last_name, $user_username, $user_email, $user_pwd, $user_rpt_pwd, $select)){
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=missingvalue");
        exit();
    }

    if(filterInputFour($user_first_name, $user_last_name, $user_username, $user_email, $bad_word_filepath)){
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=inappropriate-value");
        exit();
    }

    //calls issamepassword to check if password are different and if return true rediret to homepage
    if(isSamePassword($user_pwd, $user_rpt_pwd)){
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=passwords-do-not-match");
        exit();
    }
    

    //checks db for matching username and email
    if(takenUsernameEmail($user_username, $user_email, $filepath)) {
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=taken-username-email");
        exit();
    }

    //makes sure first or last are letters
    if(checkName($user_first_name, $user_last_name)) {
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=name-incorrect-value");
        exit();
    }

    //makes sure username is letters and numbers
    if(checkUsername($user_username)) {
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=incorrect-username");
        exit();
    }

    //^
    if(checkPassword($user_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=incorrect-password");
        exit();
    }

    //checks to see if themetroschool is in email
    if(checkEmail($user_email)) {
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=incorrect-email");
        exit();
    }

    if(createUser($user_first_name, $user_last_name, $user_username, $user_email, $user_pwd, $select, $filepath)) {

        //REQUIRE IS DIFF THAN REQUIRE ONCE
        require("includes/db.php");

        $sql = "SELECT id,first_name FROM users WHERE username = :username;";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":username", $user_username);

        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['LAST_ACTIVITY'] = time();
            $_SESSION['USER_ID'] = $row['id'];

            header("Location: http://localhost:8888/themetronetwork/main/community-selection.php");
            exit();
        }

        $conn->close();

    } else {
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=registrationfailed");
        exit();
    }

}







