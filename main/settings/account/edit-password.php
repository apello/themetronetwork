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
    <title>Edit Password</title>
    <link href="../../../css/main-style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
</head>


<?php


    $alert;

    
    if($_GET['alert'] == 'missing-value') {
        $alert = 'There seems to be a missing value.';
    } else if ($_GET['alert'] == 'old-pwd-does-not-match') {
        $alert = 'The old password entered does not match our records. Please re-enter and try again.';
    } else if ($_GET['alert'] == 'passwords-do-not-match') {
        $alert = 'The new passwords entered do not match. Please try again.';
    } else if ($_GET['alert'] == 'old-equal-new') {
        $alert = 'Your new password cannot match your previous password. Please try again.';
    } else if ($_GET['alert'] == 'incorrect-password') {
        $alert = 'The password entered seems to be:<br/>
            <ul>
                <br/>
                <li>Less than 6 characters</li><br/>
                <li>Greater than 50 characters</li><br/>
                <li>Written with non-alphabetical -numerical characters.
            <ul/>';
    } else if ($_GET['alert'] == 'successful-edit') {
        $alert = 'Your password has been successfully edited!';
    } else if ($_GET['alert'] == 'unsuccessful-edit') {
        $alert = 'Something went wrong! Please try again';
    } else  {
        $alert = 'Edit Password Information Here:';
    }


?>


<body>

    <div class="flexbox-container">
        <header>
            <div class="logo">
                <h1>TMN</h1>
            </div>

            <?php include("../../includes/nav-folder-links.html"); ?>

        </header>

        <div class="content">
      
                <div class="container">
                    <div class="section section1">


                        <div class="links">
                            <a href="settings.php" class="link">Back</a>
                            <a href="edit-account.php" class="link">Edit Account</a>
                        </div>


                    </div>
                    
                    <div class="section section2">
                    
                        <div class="section-title">Edit Password</div>

                        <?php 

                            echo '<div class="content-box error">
                                <div class="full-content">
                                    '.$alert.'
                                </div>
                            </div>'; 
                        ?>

                        <form action="edit-password-form.php" method="post">

                            <div class="input-form">
                                <h1>Edit Password:</h1><br/>

                                <input type="password" name="old-user-pwd" placeholder="Enter old password here:">
                                <input type="password" name="user-pwd" placeholder="Enter new password here:">
                                <input type="password" name="user-rpt-pwd" placeholder="Re-enter new password here:">

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
