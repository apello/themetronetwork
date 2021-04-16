<?php

//DECLARE USER VAR FROM SEARCH USING GET VALUE
$select_post_id = $_GET['id'];


//SELECT POST INFO

$select_post_info_qry = "SELECT 
                        u.first_name,
                        u.last_name,
                        u.username,
                        u.id,
                        p.community,
                        p.title,
                        p.body,
                        p.created_at
                    FROM posts p 
                    INNER JOIN users u on p.userid = u.id
                    WHERE p.id = :id";

$select_post_info = $conn->prepare($select_post_info_qry);

$select_post_info->bindParam(":id", $select_post_id);

$select_post_info->execute();

if($select_post_info->rowCount() > 0) {
    $post_info = $select_post_info->fetch(PDO::FETCH_ASSOC);
}

//SELECT COMMENTS

$select_comments_qry = "SELECT c.comment, 
                                u.first_name, 
                                u.username 
                        FROM comments c 
                        INNER JOIN users u ON c.userid = u.id 
                        WHERE c.post_id = :id";

$select_comments = $conn->prepare($select_comments_qry);

$select_comments->bindParam(":id", $select_post_id);

$select_comments->execute();

if($select_comments->rowCount() > 0) {
    $comment = TRUE;
    $comment_count = $select_comments->rowCount();
}
/* 

//SELECT LIKES

$select_likes_qry = "SELECT u.id,
                            u.first_name,
                            u.last_name,
                            u.username 
                    FROM users u 
                    INNER JOIN favorites f ON u.id = f.userid 
                    WHERE f.postid = :id";

$select_likes = $conn->prepare($select_likes_qry);

$select_likes->bindParam(":id", $select_post_id);

$select_likes->execute();

if($select_likes->rowCount() > 0) {
    $likes = TRUE;
    $like_count = $select_likes->rowCount();
}
 */
