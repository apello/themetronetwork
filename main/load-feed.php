<?php
    //DB
    require_once("../includes/db.php");

    //newCount from JQuery
    $postNewCount = $_POST['postNewCount'];

    //COUNT ALL POSTS
    $select_all_qry = "SELECT COUNT(*) FROM posts;";
    $select_all = $conn->prepare($select_all_qry);

    $select_all->execute();

    $select_all_array = $select_all->fetch(PDO::FETCH_ASSOC);

    //EXTRACT VALUE IN ARRAY
    foreach ($select_all_array as $key => $value) {
        global $post_count;
        $post_count = $value;
    }

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
                <button class="comment"></button>
            </div>

           <div class="postbox">
                <div class="segment segment2">

                    <h3><?php echo $post_info['community'];?></h3>

                    <div><h4 style="float: right;"><?php echo date("F j, Y", strtotime($post_info['created_at'])) ?></h4></div>

                    <h2 style="color: white"><?php echo $post_info['title']; ?> - <?php echo $post_info['username']; ?></h2>
                    <h3><?php echo $post_info['body']; ?></h3>

                </div>

                <div class="bottom-bar">View Comments And More</div>
            </div>

        </div> 

    <?php /* WHiLE END BRACKET */ } ?>

    <?php if($limit_post_count >= $post_count) { ?>          
        <script>
            //HIDES SHOW MORE BUTTON when posts all are shown
            $(document).ready(function() {
                $("#hide-showmore").hide();
            });

        </script>

    <?php /*  END IF */ } ?>

<?php /*  END IF */ } ?>
