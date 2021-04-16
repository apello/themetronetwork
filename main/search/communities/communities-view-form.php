
<?php

//SAME ID; NEEDED FOR ISSET CHECKS
$add_id = $_POST['add'];
$unadd_id = $_POST['unadd'];

$userid = $_POST['userid'];

$header = $_POST['header'];

include("../../../includes/functions.php");



//IF USER ID SET
if(isset($userid)) {

    //IF CLASS ID SET
    if(isset($unadd_id)) {
        //IF QRY IS SUCCESSFULL, GO TO ACCOUNT-VIEW WITH ID & SUCCESS ALERT
        if(unAddComm($userid, $unadd_id)) {

            trackUserActions($userid, "LEFT COMMUNITY", "../../../includes/db.php");

            if(isset($header)) {
                header("Location: http://localhost:8888/themetronetwork/main/search/communities/communities-view.php?id=".$unadd_id."&alert=left&header=communities");
                exit();
            } else {
                header("Location: http://localhost:8888/themetronetwork/main/search/communities/communities-view.php?id=".$unadd_id."&alert=left");
                exit();
            }
        } else {
            header("Location: http://localhost:8888/themetronetwork/main/search/communities/communities-view.php?id=".$unadd_id."&alert=error");
            exit(); 
        }
    }
    
    if(isset($add_id)) {
        if(addComm($userid, $add_id)) {

            trackUserActions($userid, "JOINED COMMUNITY", "../../../includes/db.php");

            if(isset($header)) {
                header("Location: http://localhost:8888/themetronetwork/main/search/communities/communities-view.php?id=".$add_id."&alert=joined&header=communities");
                exit();
            } else {
                header("Location: http://localhost:8888/themetronetwork/main/search/communities/communities-view.php?id=".$add_id."&alert=joined");
                exit();
            }
        } else {
            header("Location: http://localhost:8888/themetronetwork/main/search/communities/communities-view.php?id=".$add_id."&alert=error");
            exit();
        }
    } 

//ELSE GO TO SEARCH PAGE
} else {

    echo "friend id doesnt work";

   /*  header("Location: http://localhost:8888/themetronetwork/main/search/search.php");
    exit(); */
}



/////////////////////////////////////////////
//ADDING FUNCTIONS


//ADD COMM

function addComm($userid, $add_id) {

    require_once("../../../includes/db.php");

    $result;

    $add_qry = "INSERT INTO communities (userid, joined_at, classid) VALUES (:userid, NOW(), :classid)";
    $add = $conn->prepare($add_qry);

    $add->bindParam(":userid", $userid);
    $add->bindParam(":classid", $add_id);

    $add->execute();

    if($add->rowCount() > 0) {
        $result = TRUE;
    } else {
        $result = FALSE;
    }

    return $result;
}


//ADD COMM

function unAddComm($userid, $unadd_id) {

    require_once("../../../includes/db.php");

    $result;

    $unadd_qry = "DELETE FROM communities WHERE userid = :userid AND classid = :classid";
    $unadd = $conn->prepare($unadd_qry);

    $unadd->bindParam(":userid", $userid);
    $unadd->bindParam(":classid", $unadd_id);

    $unadd->execute();

    if($unadd->rowCount() > 0) {
        $result = TRUE;
    } else {
        $result = FALSE;
    }

    return $result;
}


?>