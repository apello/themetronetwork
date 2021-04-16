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
    <title>Delete Account</title>
    <link href="../../../css/main-style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
</head>


<?php
     if($_GET['alert'] == 'missing-value') {
        $alert = 'There seems to be a missing value.';
    } else if ($_GET['alert'] == 'incorrect-password') {
        $alert = 'The password entered does not match our records. Please re-enter and try again.';
    } else if ($_GET['alert'] == 'error') {
        $alert = 'Something went wrong! Please try again.';
    } else  {
        $alert = 'If You Delete Your Account, All Your Data Will Be Lost. If You Understand, Enter Your Password to Continue:';
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
                    <li><a href="settings.php">Settings</a></li>
                    <li><a href="../../../logout.php?id=<?php echo $row['id'] ?>">Logout</a></li>

                </ul>
            </nav>
            
        </header>

        <div class="content">
      
                <div class="container">
                    <div class="section section1">


                        <div class="links">
                            <a href="settings.php" class="link">Back to Settings</a>
                        </div>


                    </div>
                    
                    <div class="section section2">
                    
                        <div class="section-title">Delete Account</div>

                       
                        <?php 
                            echo '<div class="content-box error" style="margin-bottom: 5px;">
                                <div class="full-content">
                                    '.$alert.'
                                </div>
                            </div>'; 
                        ?>

                        <form action="delete-account-form.php" method="post">

                            <div class="input-form">

                                <input type="password" name="user-pwd" placeholder="Enter password here to continue:">
                                <?php  echo "<input type='hidden' name='user-id' value=".$row['id'].">";  ?>   

                                <input type="submit" name="submit" class="submit-btn">
                            

                            </div>

                        </form>
                    

                    

                

                    </div>
                

                </div>
            </div>

         

                
         
        </div>

        <?php include("../../../includes/footer.html"); ?>

    </div>


   

</body>


</html>   
