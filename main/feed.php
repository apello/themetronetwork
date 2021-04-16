<?php 
    //dont forget db is included auth-check
    session_start();

    require_once("../includes/db.php");
    require_once("../includes/auth-check.php");
    require_once("../includes/session-check.php");

    $_SESSION['LAST_ACTIVITY'] = time();
?>

<html>

<head>
    <!-- link to stylesheet -->
    <title>Home</title>
    <link href="../css/main-style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<script>


    $(document).ready(function() {

        /* this sends the postCount and loads the feed */

        var postCount = 4;

        $("#showmore").click(function() {
            postCount = postCount + 2;
            $("#posts").load("load-feed.php", {
                postNewCount: postCount
            });
        });

     
    });

</script>


<?php 

    /* this counts the posts so that loading does not stop */

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
?>

<body>

    <div class="flexbox-container">
        <header>
            <div class="logo">
                <h1>TMN</h1>
            </div>

            <nav>
                <ul>
                    <li>Home</li>
                    <li><a href="search/search.php">Search</a></li>
                    <li><a href="settings/account/settings.php">Settings</a></li>
                    <li><a href="../logout.php?id=<?php echo $row['id'] ?>">Logout</a></li>

                </ul>
            </nav>
        </header>

        <div class="content">




       <div class="container">

            <div class="section section1">

                <div class="title">Hi, <?php echo $row['first_name']; ?>!</div>

                <div class="links" id="hide">
                    <a href="search/search.php" class="link">Search For Friends</a>
                    <a href="settings/account/edit-account.php" class="link">Change Your Bio</a>
                    <a href="" class="link">Give Feedback</a>

                </div>

            </div>

            <!-- ALERT CODE -->


            <?php 
                $alert;


                if($_GET['alert'] == 'unsuccessful-post') {
                    $alert = 'Something went wrong! Please try again.';
                } else if ($_GET['alert'] == 'successful-post') {
                    $alert = 'You have successfully posted!';
                } else if($_GET['alert'] == 'unsuccessful-commment') {
                    $alert = 'Something went wrong! Please try again.';
                } else if ($_GET['alert'] == 'successful-comment') {
                    $alert = 'You have successfully commented!';
                } else  {
                    $alert = 'Home - Feed Scroll';
                }
            
            ?>

            <div class="section section2" style="padding-bottom: 20px;">

                <div class="section-title"><?php echo $alert ?></div>

                    <div id="posts">

                        <?php
                            //SELECT POSTS LIMIT 4
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
                            DESC LIMIT 4;";

                            //PREPARE QRYs
                            $select_post = $conn->prepare($select_post_qry);

                            //EXECUTE QRYs
                            $select_post->execute();

                            //CHECK IF ANY POSTS CAME BACK
                            
                            global $limit_post_count;
                            $limit_post_count = $select_post->rowCount();

                            //CHECK IF ANY POSTS CAME BACK
                            if($limit_post_count > 0) {
                                $post = TRUE;
                            }

                            if($post) { 
                                while($post_info = $select_post->fetch(PDO::FETCH_ASSOC)) {   
                        ?>

                            <div class="content-box">


                                <?php 
                                   /*  //checks if user liked post by selected value from table
                                    $user_liked_post_qry = "SELECT * FROM favorites WHERE userid = :userid AND postid = :postid";
                                    $user_liked_post = $conn->prepare($user_liked_post_qry);

                                    $user_liked_post->bindParam(":userid", $row['id']);
                                    $user_liked_post->bindParam(":postid", $post_info['id']);

                                    $user_liked_post->execute();

                                    if($user_liked_post->rowCount > 0) {
                                        $liked = TRUE;
                                    } */

                                ?>
                            
                                <div class="segment segment1">

                                  <!--   <div id="like-qry"></div>

                                    <?php if($liked) { ?>
                                        <button class="heart-filled" id="unlike"></button>
                                    <?php } else { ?>
                                        <button class="heart-outline" id="like"></button>
                                    <?php }  ?> -->

                                    <a href="post/comment/comment.php?title=<?php echo $post_info['title']; ?>&postid=<?php echo $post_info['id']; ?>">
                                        <button class="comment"></button>
                                    </a>

                                </div>

                                <div class="postbox">

                                    <div class="segment segment2">

                        

                                        <div><h4 style="float: right;"><?php echo date("F j, Y", strtotime($post_info['created_at'])) ?></h4></div>

                                        <h4><?php echo $post_info['community'];?></h4>

                                        <h2 style="color: white"><?php echo $post_info['title']; ?> - <?php echo $post_info['username']; ?></h2>
                                        <h3><?php echo $post_info['body']; ?></h3>


                                    </div>

                                    <a class="bottom-bar" style="color:white; text-decoration: none;" href="search/posts/post-view.php?id=<?php echo $post_info['id']; ?>&header=feed">View Comments And More</a>

                                </div>

                            </div> 



                        <?php /* WHiLE END BRACKET */ } ?>

                        <?php /*  END IF */ } ?>

                    </div>

                        <?php 

                        echo $count;

                            //CHECK COUNT VALUE
                            if($post_count > $limit_post_count) {
                                $showmore = TRUE;
                            }

                            if($showmore) {
                        ?>

                        <div id="hide-showmore">
                            <button class="content-box" id="showmore">
                                <div class="full-content">
                                    <h3 style="text-decoration:underline; cursor:pointer;">Show More Posts</h3>
                                    </div>
                            </button>
                        </div>

                        <?php } else if($post_count == 0) { ?>
                            <div class="content-box">
                                <div class="full-content">
                                    <h4>Where'd all the posts go...?</h4>
                                </div>
                            </div>
                        <?php } ?>

            </div>

        </div>  

        </div>

        <?php include("../includes/footer.html"); ?>

        <a href="post/post.php">
            <button class="outer-button add">
                <img id="add" src="../pictures/plus.png">      
            </button>
        </a>

    </div>


   

</body>


</html>   

