
<?php

//SAME ID; NEEDED FOR ISSET CHECKS
$friend_id = $_POST['friend'];
$unfriend_id = $_POST['unfriend'];

$userid = $_POST['userid'];


//IF USER ID SET
if(isset($userid)) {

    //IF FRIEND ID SET
    if(isset($unfriend_id)) {
        //IF USER ID DOES NOT MATCH FRIEND ID
        if($unfriend_id != $userid) {

            //IF QRY IS SUCCESSFULL, GO TO ACCOUNT-VIEW WITH ID & SUCCESS ALERT
            if(unFriendUser($userid, $unfriend_id)) {
                header("Location: http://localhost:8888/themetronetwork/main/search/account/account-view.php?id=".$unfriend_id."&alert=unfriended");
            } else {
                header("Location: http://localhost:8888/themetronetwork/main/search/account/account-view.php?id=".$unfriend_id."&alert=error");
            }
        } else {
            header("Location: http://localhost:8888/themetronetwork/main/search/search.php");
        }
    }  
    
    if(isset($friend_id)) {
        if($friend_id != $userid) {
            if(friendUser($userid, $friend_id)) {
                header("Location: http://localhost:8888/themetronetwork/main/search/account/account-view.php?id=".$friend_id."&alert=friended");
            } else {
                header("Location: http://localhost:8888/themetronetwork/main/search/account/account-view.php?id=".$friend_id."&alert=error");
            }
        } else {
            header("Location: http://localhost:8888/themetronetwork/main/search/search.php");
        } 
    }

//ELSE GO TO SEARCH PAGE
} else {
    header("Location: http://localhost:8888/themetronetwork/main/search/search.php");
}



/////////////////////////////////////////////
//FRIENDING FUNCTIONS


//FRIEND USER

function friendUser($userid, $friend_id) {

    require_once("../../../includes/db.php");

    $result;

    $friend_qry = "INSERT INTO friends (user_id1, user_id2) VALUES (:userid, :friend_id)";
    $friend = $conn->prepare($friend_qry);

    $friend->bindParam(":userid", $userid);
    $friend->bindParam(":friend_id", $friend_id);

    $friend->execute();

    if($friend->rowCount() > 0) {
        $result = TRUE;
    } else {
        $result = FALSE;
    }

    return $result;
}


//UNFRIEND USER

function unFriendUser($userid, $unfriend_id) {

    require_once("../../../includes/db.php");

    $result;

    $unfriend_qry = "DELETE FROM friends WHERE user_id1 = :userid AND user_id2 = :unfriend_id";
    $unfriend = $conn->prepare($unfriend_qry);

    $unfriend->bindParam(":userid", $userid);
    $unfriend->bindParam(":unfriend_id", $unfriend_id);

    $unfriend->execute();

    if($unfriend->rowCount() > 0) {
        $result = TRUE;
    } else {
        $result = FALSE;
    }

    return $result;
}


?>