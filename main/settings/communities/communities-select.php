<?php
    $select = 
    "SELECT 
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

    $query->bindParam(":userid", $row['id']);

    $query->execute();

    if($query->rowCount() > 0) {
        $communities = TRUE;
    } else {
        $communities = FALSE;
    }