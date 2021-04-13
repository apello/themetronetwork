<?php

    $classid = $_GET['id'];

    //SELECT CLASS INFO USING GET ID
    $select_class_qry = 
        "SELECT 
            id,
            class_name,
            class_proctor,
            class_size,
            contact_information
        FROM class 
        WHERE id = :classid";

    $select_class = $conn->prepare($select_class_qry);

    $select_class->bindParam(":classid", $classid);

    $select_class->execute();

    if($select_class->rowCount() > 0) {
        $communities = TRUE;
    } else {
        $communities = FALSE;
    }

    //FETCH DATA
    if($communities) {    
        $community_info = $select_class->fetch(PDO::FETCH_ASSOC);
    }

    //FIND OUT WHETHER USER IS IN COMMUNITY ALREADY


    $community_member_qry = "SELECT * FROM community WHERE userid = :userid AND classid = :classid";
    $community_member = $conn->prepare($community_member_qry);

    $community_member->bindParam(":userid", $row['id']);
    $community_member->bindParam(":classid", $classid);

    $community_member->execute();

