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
    <title>Edit Account</title>
    <link href="../../../css/main-style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
</head>


<?php


    $alert;

    if($_GET['alert'] == 'all-empty') {
        $alert = 'All values seem to be empty. Please try again.';
    } else if($_GET['alert'] == 'inappropriate-value') {
        $alert = 'The value entered is inappropriate. Please try again.';
    } else if ($_GET['alert'] == 'name-incorrect-value') {
            $alert = 'The entered first/last name is incorrect. Please try again.';
    } else if ($_GET['alert'] == 'taken-username-email') {
        $alert = 'The username/email entered seems to be taken. Please try another.';
    } else if ($_GET['alert'] == 'incorrect-username') {
        $alert = 'The username entered seems to be:<br/>
            <ul>
                <br/>
                <li>Less than 6 characters</li><br/>
                <li>Greater than 50 characters</li><br/>
                <li>Written with non-alphabetical -numerical characters.
            <ul/>';
    } else if ($_GET['alert'] == 'incorrect-email') {
        $alert = 'Email entered does not seem to be registered @themetroschool.org. Please try again.';
    } else if ($_GET['alert'] == 'bio-too-long') {
        $alert = 'The bio entered is too long. Please re-type it and submit again.';
    } else if ($_GET['alert'] == 'successful-edit') {
        $alert = 'Your information has been successfully edited!';
    } else if ($_GET['alert'] == 'unsuccessful-edit') {
        $alert = 'Something went wrong! Please try again.';
    } else  {
        $alert = 'Edit Your Account Information Here:';
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
                    <li><a href="../../../logout.php">Logout</a></li>

                </ul>
            </nav>
            
        </header>

        <div class="content">
      
                <div class="container">
                    <div class="section section1">


                        <div class="links">
                            <a href="settings.php" class="link">Back to Settings</a>
                            <a href="edit-password.php" class="link">Edit Password</a>
                        </div>


                    </div>
                    
                    <div class="section section2">
                    
                        <div class="section-title">Edit Account</div>

                        <?php 

                            echo '<div class="content-box error">
                                <div class="full-content">
                                    '.$alert.'
                                </div>
                            </div>'; 
                        ?>

                        
                       
                        <div class="content-box">
                            <div class="full-content">
                                You can leave input boxes empty if you do not want to edit them.
                            </div>
                        </div>

                        <form action="edit-account-form.php" method="post">

                            <div class="input-form">
                                <h1>Edit Account</h1>

                                <div class="content-box"><div class="full-content"><?php echo "First Name: ".$row['first_name']; ?></div></div>
                                <input type="text" name="user-first-name" placeholder="Enter new first name here:">

                                <div class="content-box"><div class="full-content"><?php echo "Last Name: ".$row['last_name']; ?></div></div>
                                <input type="text" name="user-last-name" placeholder="Enter new last name here:">

                                <div class="content-box"><div class="full-content"><?php echo "Username: ".$row['username']; ?></div></div>
                                <input type="text" name="user-name" placeholder="Enter new username here:">

                                <div class="content-box"><div class="full-content"><?php echo "Email: ".$row['email']; ?></div></div>
                                <input type="email" name="user-email" placeholder="Enter new email here:">

                                <div class="content-box" style="margin-bottom: 5px;"><div class="full-content">Edit Bio Here:</div></div>
                                <textarea placeholder="50 word limit:" name="user-bio" maxlength="250"></textarea>
                                
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
