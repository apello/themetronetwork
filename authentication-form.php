<?php

//require db and for future uses function page
require_once("includes/db.php");
require_once("includes/auth-functions.php");

if(isset($_POST['submit'])){

    $auth_username = $_POST["user-auth-name"];
    $auth_pwd = $_POST["user-auth-pwd"];

    if(authIsEmpty($auth_username, $auth_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/index.php?alert=missingvalue");
        exit();
    }

    if(logIn($auth_username, $auth_pwd)) {        
        header("Location: http://localhost:8888/themetronetwork/main/feed.php");
        exit();
    } else {
        header("Location: http://localhost:8888/themetronetwork/index.php?alert=login-failed");
        exit();
    }
}
