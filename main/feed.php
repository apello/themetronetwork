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

    /* this qry sends the postCount and loads the feed */

    $(document).ready(function() {
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
                    <li><a href="../logout.php">Logout</a></li>

                </ul>
            </nav>
        </header>

        <div class="content">




       <div class="container">

            <div class="section section1">

                <div class="title">Hi, <?php echo $row['first_name']; ?>!</div>

                <div class="links" id="hide">
                    <div class="link" style="background-color: rgba(50, 231, 255, 0.7);">Things To Do:</div>
                    <a href="search/search.php" class="link">Search For Friends</a>
                    <a href="settings/account/edit-account.php" class="link">Change Your Bio</a>
                </div>

            </div>

            <!-- ALERT CODE -->


            <?php 
                $alert;


                if($_GET['alert'] == 'unsuccessful-post') {
                    $alert = 'Something went wrong! Please try again.';
                } else if ($_GET['alert'] == 'successful-post') {
                    $alert = 'You have successfully posted!';
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

                    </div>

                        <?php 

                            //CHECK COUNT VALUE
                            if($post_count > $limit_post_count) {
                                $showmore = TRUE;
                            }

                            if($showmore) {
                        ?>

                            <button class="content-box" id="showmore">
                                <div class="full-content">
                                    <h3 style="text-decoration:underline;">Show More Posts</h3>
                                    </div>
                            </button>

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

