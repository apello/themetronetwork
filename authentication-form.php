<?php

//require db and for future uses function page

if(isset($_POST['submit'])){

    require_once("includes/functions.php");

    $auth_username = $_POST["user-auth-name"];
    $auth_pwd = $_POST["user-auth-pwd"];

    $filepath = "includes/db.php";

    if(isEmpty($auth_username, $auth_pwd)) {
        header("Location: http://localhost:8888/themetronetwork/index.php?alert=missingvalue");
        exit();
    }

    if(logIn($auth_username, $auth_pwd, $filepath)) {        
        header("Location: http://localhost:8888/themetronetwork/main/feed.php");
        exit();
    } else {
        header("Location: http://localhost:8888/themetronetwork/index.php?alert=login-failed");
        exit();
    }
}
