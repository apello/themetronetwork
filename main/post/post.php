<?php 
    session_start();

    require_once("../../includes/db.php");
    require_once("../../includes/auth-check.php");
    require_once("../../includes/session-check.php");

    $_SESSION['LAST_ACTIVITY'] = time();

?>


<html>

<head>
    <!-- link to stylesheet -->
    <title>Post</title>
    <link href="../../css/main-style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
</head>

<?php 
    $alert;

    
    if($_GET['alert'] == 'missing-value') {
        $alert = 'There seems to be a missing value. Please try again.';
    } else if($_GET['alert'] == 'inappropriate-value') {
        $alert = 'The value entered is inappropriate. Please try again.';
    } else  {
        $alert = 'Compose Post Here:';
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
                    <li><a href="../feed.php">Home</a></li>
                    <li><a href="../search/search.php">Search</a></li>
                    <li><a href="../settings/account/settings.php">Settings</a></li>
                    <li><a href="../../logout.php?id=<?php echo $row['id'] ?>">Logout</a></li>
                </ul>
            </nav>
        </header>

        <div class="content">

            <div class="container">
                
                <div class="section section1">

                    <div class="links">
                        <a href="../feed.php" class="link">Back to Feed</a>
                    </div>
                </div>

                <div class="section2">

                    <form action="post-form.php" method="post">

                        <div class="input-form">

                            <div class="content-box error" style="margin-bottom: 10px;">
                                <div class="full-content"><?php echo $alert ?></div>
                            </div>

                            <input type="text" name="title" placeholder="Enter post title here:">

                            <textarea placeholder="250 word limit:" name="body" maxlength="600"></textarea>
                            
                            <select name="community">
                                <option value="question">--Add a community tag?--</option>
                                <option value="For Everybody">Everybody</option>
                                <option value="Pre-Calculus">Pre-Calculus w/ Carol Van Fossen</option>
                                <option value="English 12">English 12 w/ Carlee Beatty</option>
                                <option value="Algebra 2">Algebra 2 w/ Robert</option>
                            </select> 

                            <input type="submit" name="submit" value="Post" class="submit-btn">
                            <input type="hidden" name="user-id" value="<?php echo $row['id'] ?>">


                        </div>

                    </form>

                </div>

            </div>
                
        </div>

        <?php include("../../includes/footer.html"); ?>

    </div>


   

</body>


</html>   
