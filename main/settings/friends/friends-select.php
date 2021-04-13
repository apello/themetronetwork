<?php


//WRITE FUNC FOR BOTH ON SETTINGS AND SEARCH
    //CODE REPURPOSED FROM SEARCH
    $select_friends_qry = "SELECT u.id,
                                u.first_name,
                                u.last_name,
                                u.username,
                                u.position 
                            FROM users u 
                            INNER JOIN friends f 
                            ON f.user_id1 = :id AND f.user_id2 = u.id";
    $select_friends = $conn->prepare($select_friends_qry);

    $select_friends->bindParam(":id", $row['id']);

    $select_friends->execute();

    if($select_friends->rowCount() > 0) {
        $has_friends = TRUE;
    } else {
        $has_friends = FALSE;
    }
