<?php

$SERVER_NAME = "localhost";
$DB_NAME = "tmn";
$DB_USERNAME = "root2";
$DB_PASSWORD = "";


try {   

    $conn = new PDO("mysql:host=$SERVER_NAME; dbname=$DB_NAME", $DB_USERNAME, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Error has occured: " . $e->getMessage();
}

