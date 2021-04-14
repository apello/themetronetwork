<?php


if(isset($_POST['submit'])){

    //FUNCTION REQUIRE FROM FUNC
    require("../../includes/functions.php");

    //FILE PATHs
    $filepath = "../../includes/db.php";
    $bad_word_filepath = "../../includes/bad-words.php";

    //intializes variables
    $userID = $_POST["user-id"];
    $username = $_POST["username"];

    $title = $_POST["title"];
    $body = $_POST["body"]; 
    $community = $_POST["community"];
    

    //MAKE IT NULL
    if($community == "question"){ $community = NULL; }

    if(isEmpty($title, $body)) {
        header("Location: http://localhost:8888/themetronetwork/main/post/post.php?alert=missing-value");
        exit();
    }

    if(filterInputTwo($title, $body, $bad_word_filepath)) {
        header("Location: http://localhost:8888/themetronetwork/main/post/post.php?alert=inappropriate-value");
        exit();
    } 

     if(createPost($userID, $title, $body, $community, $username, $filepath)) {
        header("Location: http://localhost:8888/themetronetwork/main/feed.php?alert=successful-post");
        exit(); 
    } else {
        header("Location: http://localhost:8888/themetronetwork/main/feed.php?alert=unsuccessful-post");
        exit();
    }    
}


function createPost($userID, $title, $body, $community, $username, $filepath) {

    $result;

    require($filepath);

    $sql = "INSERT INTO posts 
            (creatorid, creator_username, title, body, classid, created_at) 
            VALUES 
            (:userID, :username, :title, :body, :classid, NOW());";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":userID", $userID);
    $stmt->bindParam(":username", $username);

    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":body", $body);
    $stmt->bindParam(":classid", $community);
  
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $result = TRUE;
    } else {
        $result = FALSE;
    }

    return $result;


}


