<?php 
    session_start();

    require_once("../../../includes/db.php");
    require_once("../../../includes/auth-check.php");
    require_once("../../../includes/session-check.php");

    $_SESSION['LAST_ACTIVITY'] = time();

?>


<html>

<head>
    <!-- link to stylesheet -->
    <title>Comment</title>
    <link href="../../../css/main-style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
</head>

<?php 
    $alert;

    
    if($_GET['alert'] == 'missing-value') {
        $alert = 'There seems to be a missing value. Please try again.';
    } else if($_GET['alert'] == 'inappropriate-value') {
        $alert = 'The value entered is inappropriate. Please try again.';
    } else if ($_GET['postid'] == ' ' OR $_GET['postid'] == NULL) {
		$alert = 'Something went wrong! Please return to feed <a style="color:white" href="../../feed.php">here</a> or use the back button.';
	} else if ($_GET == '' OR $_GET == NULL) {
		$alert = 'Something went wrong! Please return to feed <a style="color:white" href="../../feed.php">here</a> or use the back button.';
    } else  {
        $alert = 'Compose Comment Here:';
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
                    <li><a href="../../feed.php">Home</a></li>
                    <li><a href="../../search/search.php">Search</a></li>
                    <li><a href="../../settings/account/settings.php">Settings</a></li>
                    <li><a href="../../../logout.php?id=<?php echo $row['id'] ?>">Logout</a></li>
                </ul>
            </nav>
        </header>

        <div class="content">

            <div class="container">
                
                <div class="section section1">

                    <div class="links">
                        <a href="../../feed.php" class="link">Back to Feed</a>
                    </div>
                </div>

                <div class="section2">

                    <div class="section-title">Comment</div>

                    <form action="comment-form.php" method="post">

                        <div class="input-form">

                            <div class="content-box error" style="margin-bottom: 0px;">
                                <div class="full-content"><?php echo $alert ?></div>
                            </div>


                            <div class="content-box" style="margin-bottom: 5px;">
                                <div class="full-content">Post Title: <?php echo $_GET['title']; ?></div>
                            </div>

                            <textarea placeholder="100 word limit:" name="comment" maxlength="300"></textarea>
                            

                            <input type="submit" name="submit" value="Post" class="submit-btn">
                            <input type="hidden" name="user-id" value="<?php echo $row['id'] ?>">
                            <input type="hidden" name="title" value="<?php echo $_GET['title'] ?>">
                            <input type="hidden" name="post-id" value="<?php echo $_GET['postid'] ?>">


                        </div>

                    </form>

                </div>

            </div>
                
        </div>

        <?php include("../../../includes/footer.html"); ?>

    </div>


   

</body>


</html>   
