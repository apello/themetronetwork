<?php 

    $token = $_SESSION['USER_ID'];

    if(isset($token)){

        $sql = "SELECT id,first_name,last_name,username,email,position,created_at FROM users WHERE id = :token";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":token", $token);

        $stmt->execute();


        if($stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $tokenisset = true;
        } else {
            header("Location:http://localhost:8888/themetronetwork/index.php?alert=failed-access");
            exit();
        }
    } else {
        header("Location:http://localhost:8888/themetronetwork/index.php?alert=failed-access");
        exit();
    }

    if(!$tokenisset){
        header("Location:http://localhost:8888/themetronetwork/index.php?alert=failed-access");
        exit();
    }
?>
