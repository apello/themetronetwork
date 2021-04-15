<?php
    //DB
    require_once("../includes/db.php");

    //newCount from JQuery
    $postNewCount = $_POST['postNewCount'];
    
    $select_post_qry = 
        "SELECT 
            u.first_name,
            u.username,
            p.id,
            p.community,
            p.title,
            p.body,
            p.created_at
        from posts p 
        inner join users u on p.userid = u.id
        ORDER BY created_at
        DESC LIMIT $postNewCount;";

    //PREPARE QRYs
    $select_post = $conn->prepare($select_post_qry);
    //EXECUTE QRYs
    $select_post->execute();

    $limit_post_count = $select_post->rowCount();

    //CHECK IF ANY POSTS CAME BACK
    if($limit_post_count > 0) {
        $post = TRUE;
    }

   
    if($post) { 
        while($post_info = $select_post->fetch(PDO::FETCH_ASSOC)) {   
    ?>

        <div class="content-box">
        
            <div class="segment segment1">
                <button class="heart-filled"></button>
                <button class="comment"></button>
            </div>

            <div class="segment segment2">

                <div><h4 style="float: right;"><?php echo date("F j, Y", strtotime($post_info['created_at'])) ?></h4></div>

                <h2><?php echo $post_info['title']; ?> - <?php echo $post_info['username']; ?></h2>
                <h3><?php echo $post_info['body']; ?></h3>

                <div class="bottom-bar">View Comments And More</div>

            </div>

        </div> 



    <?php /* WHiLE END BRACKET */ } ?>

    <?php /*  END IF */ } ?>
