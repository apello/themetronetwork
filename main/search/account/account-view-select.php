<?php

//DECLARE USER VAR FROM SEARCH USING GET VALUE
$search_user_id = $_GET['id'];


//SELECT QUERY
    $account_view_qry = "SELECT first_name,last_name,username,email,position,bio,created_at FROM users WHERE id = :id";
    $account_view = $conn->prepare($account_view_qry);

    $account_view->bindParam(":id", $search_user_id);

    $account_view->execute();

    //FETCH VAR
    if($account_view->rowCount() > 0){
        $user_account_info = $account_view->fetch(PDO::FETCH_ASSOC);
    }

//////////////////////////////////////////////////////

//CHECK IF FRIENDS OR IF USER THEMSELVES
    if($row['id'] != $search_user_id) {
        $friends;

        $friend_check_qry = "SELECT user_id1, user_id2 FROM friends WHERE user_id1 = :id1 AND user_id2 = :id2";
        $friend_check = $conn->prepare($friend_check_qry);

        $friend_check->bindParam(":id1", $row['id']);
        $friend_check->bindParam(":id2", $search_user_id);

        $friend_check->execute();

        if($friend_check->rowCount() > 0) {
            $friends = TRUE;
        }
    } else {
        $own_account = TRUE;
    }

//////////////////////

//WRITE FUNC FOR BOTH ON SETTINGS AND SEARCH

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



    $id = $search_user_id;
    require_once("../../settings/communities/communities-select.php");


/////////////////

//Copy and pasted directly from community-select.php
	$select = "SELECT 
					c.id,
					c.class_name,
					c.class_proctor,
					c.class_size,
					com.joined_at
				FROM class c
				INNER JOIN communities com 
				ON c.id = com.classid 
				AND :userid = com.userid";

	$query = $conn->prepare($select);

	$query->bindParam(":userid", $search_user_id);

	$query->execute();

	if($query->rowCount() > 0) {
		$communities = TRUE;

	} else {
		$communities = FALSE;
	} 

?>