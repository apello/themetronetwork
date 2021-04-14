<?php

$select_post_qry = "SELECT * FROM posts p
                INNER JOIN friends f 
                on f.user_id1 = :userid AND p.creatorid = f.user_id2
                INNER JOIN communities co
                on co.userid = :userid AND p.classid = co.classid
                ORDER BY p.created_at";
$select_post = $conn->prepare($select_post_qry);

$select_post->bindParam(":userid", $row['id']);

$select_post->execute();



