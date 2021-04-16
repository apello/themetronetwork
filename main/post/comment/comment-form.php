<?php

if(isset($_POST['submit'])){

    //FUNCTION REQUIRE FROM FUNC
    require("../../../includes/functions.php");

    //FILE PATHs
    $filepath = "../../../includes/db.php";
    $bad_word_filepath = "../../../includes/bad-words.php";

    //intializes variables
    $userid = $_POST["user-id"];
    $title = $_POST["title"];
    $postid = $_POST['post-id'];
    $comment = $_POST["comment"]; 




   if(isEmpty($comment)) {
        header("Location: http://localhost:8888/themetronetwork/main/post/comment/comment.php?alert=missing-value&title=".$title."&postid=".$postid);
        exit();
    }

    if(filterInput($comment, $bad_word_filepath)) {
        header("Location: http://localhost:8888/themetronetwork/main/post/comment/comment.php?alert=inappropriate-value&title=".$title."&postid=".$postid);
        exit();
    }  

   if(createComment($userid, $postid, $comment, $filepath)) {
        trackUserActions($userid, "COMMENTED", $filepath);
        header("Location: http://localhost:8888/themetronetwork/main/feed.php?alert=successful-comment");
        exit(); 
    } else {
        header("Location: http://localhost:8888/themetronetwork/main/feed.php?alert=unsuccessful-comment");
        exit();
    }      
}


function createComment($userid, $postid, $comment, $filepath) {

    $result;

    require($filepath);

    $sql = "INSERT INTO comments 
            (post_id, comment, userid) 
            VALUES 
            (:postid, :comment, :userid);";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":userid", $userid);
    $stmt->bindParam(":postid", $postid);
    $stmt->bindParam(":comment", $comment);
  
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $result = TRUE;
    } else {
        $result = FALSE;
    }

    return $result;


}


