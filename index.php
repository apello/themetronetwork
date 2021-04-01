<html>


<head>
    <!-- link to stylesheet -->
    <title>Home</title>
    <link href="css/auth-form.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<?php
    $alert;

    
    if($_GET['alert'] == 'missingvalue') {
        $alert = 'There seems to be a missing value.';
    } else if ($_GET['alert'] == 'loggedin') {
        $alert = 'Welcome back to the Metro Network!';
    } else if ($_GET['alert'] == 'login-failed') {
        $alert = 'The entered username/password combination is incorrect.';
    } else if ($_GET['alert'] == 'failed-access') {
        $alert = 'Please log in to access that page.';
    } else if ($_GET['alert'] == 'logged-out') {
        $alert = 'You have been logged out. Thank you!';
    } else if ($_GET['alert'] == 'timed-out') {
        $alert = 'Your session has timed out. Please log in again.';
    } else if ($_GET['alert'] == 'account-deleted') {
        $alert = 'Your account has been successfully deleted. We are so sorry to see you go!';
    } else if ($_GET['alert'] == 'error') {
        $alert = 'Something went wrong. Please log in.';
    } else  {
        $alert = 'Welcome to the Metro Network.';
    }
    

?>

<body>

    <div class="flexbox-container">
        <header>
            <div class="title">
                <h1>TMN</h1>
            </div>

            <nav>
                <ul>
                    <li><a href="index.php">Login</a></li>
                    <li><a href="register.php">Sign Up</a></li>
                    <li><a href="about.html">About</a></li>
                </ul>
            </nav>
        </header>

        <form action="authentication-form.php" method="post">


            <div class="content">
        
            <div class="login-form">
                <?php echo '<div class="alert login">'.$alert.'</div>'; ?>
                <h1>Login:</h1>
                        <input type="text" name="user-auth-name" placeholder="Enter username here:">
                        <input type="password" name="user-auth-pwd" placeholder="Enter password here:">
                        <input type="submit" name="submit" value="Login" class="submit-btn">
                </div>
            </div>

        </form>     


        <?php include("includes/footer.html"); ?>

</div>




</body>


</html>



