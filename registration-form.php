<?php

//require db and for future uses function page
require_once("includes/db.php");
require_once("includes/auth-functions.php");

if(isset($_POST['submit'])){

    session_start();

    $user_first_name = $_POST["user-first-name"];
    $user_last_name = $_POST["user-last-name"]; 
    $user_username = $_POST["user-name"];
    $user_email = $_POST["user-email"];
    $user_pwd = $_POST["user-pwd"];
    $user_rpt_pwd = $_POST["user-rpt-pwd"];
    $select = $_POST['select'];

    //calls isempty to check if empty and if return true rediret to homepage

    if(isEmpty($user_first_name, $user_last_name, $user_username, $user_email, $user_pwd, $user_rpt_pwd, $select)){
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=missingvalue");
        exit();
    }

    //calls issamepassword to check if password are different and if return true rediret to homepage

    if(isSamePassword($user_pwd, $user_rpt_pwd)){
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=passwords-do-not-match");
        exit();
    }

    if(takenUsernameEmail($user_username, $user_email)) {
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=taken-username-email");
        exit();
    }

    if(checkUsername($user_username)) {
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=incorrect-username");
        exit();
    }

    if(checkPassword($user_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=incorrect-password");
        exit();
    }

    if(checkEmail($user_email)) {
        header("Location: http://localhost:8888/themetronetwork/register.php?alert=incorrect-email");
        exit();
    }



    if(createUser($user_first_name, $user_last_name, $user_username, $user_email, $user_pwd, $select)) {

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







