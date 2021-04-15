<?php


if(isset($_POST['submit'])){

    //FUNCTION REQUIRE FROM FUNC
    require("../../includes/functions.php");

    //FILE PATHs
    $filepath = "../../includes/db.php";
    $bad_word_filepath = "../../includes/bad-words.php";

    //intializes variables
    $userid = $_POST["user-id"];

    $title = $_POST["title"];
    $body = $_POST["body"]; 
    $community = $_POST["community"];
    

    //MAKE IT NULL
    if($community == "question"){ $community = NULL; }


    echo $userid;
    echo $title;
    echo $body;
    echo $community;


    if(isEmpty($title, $body)) {
        header("Location: http://localhost:8888/themetronetwork/main/post/post.php?alert=missing-value");
        exit();
    }

    if(filterInputTwo($title, $body, $bad_word_filepath)) {
        header("Location: http://localhost:8888/themetronetwork/main/post/post.php?alert=inappropriate-value");
        exit();
    } 

    if(createPost($userid, $title, $body, $community, $filepath)) {
        header("Location: http://localhost:8888/themetronetwork/main/feed.php?alert=successful-post");
        exit(); 
    } else {
        header("Location: http://localhost:8888/themetronetwork/main/feed.php?alert=unsuccessful-post");
        exit();
    }     
}


function createPost($userid, $title, $body, $community, $filepath) {

    $result;

    require($filepath);

    $sql = "INSERT INTO posts 
            (userid, title, body, community) 
            VALUES 
            (:userid, :title, :body, :community);";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":userid", $userid);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":body", $body);
    $stmt->bindParam(":community", $community);
  
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $result = TRUE;
    } else {
        $result = FALSE;
    }

    return $result;


}


