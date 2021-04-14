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
</head>

<?php 

    $select_post_qry = "SELECT * FROM posts p
    INNER JOIN friends f 
    on f.user_id1 = :userid AND p.creatorid = f.user_id2
    INNER JOIN communities co
    on co.userid = :userid AND p.classid = co.classid";
    $select_post = $conn->prepare($select_post_qry);

    $select_post->bindParam(":userid", $row['id']);

    $select_post->execute();

    if($select_post->rowCount() > 0) {
        $post = TRUE;
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

                <div class="section section2">

                    <div class="section-title">Posts - Scroll:</div>



                    <?php 
                        if($post) { 
                            while($post_info = $select_post->fetch(PDO::FETCH_ASSOC)) {   
                    ?>

                        <div class="content-box">
                        
                            <div class="segment segment1">
                                <button class="heart-outline"></button>
                                <button class="heart-filled"></button>
                                <button class="comment"></button>
                            </div>

                            <div class="segment segment2">

                                <h2><?php echo $post_info['title']; ?> - <?php echo $post_info['creator_username']; ?></h2>
                                <h3><?php echo $post_info['body']; ?></h3>

                            </div>

                        </div> 


                    
                    <?php  } /* WHiLE END BRACKET */ } else { ?>

                        <div class="content-box">
                            <div class="full-content">
                                Nobody has seemed to have posted... ever
                            </div>
                        </div>

                    <?php }  ?>

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

