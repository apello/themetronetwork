<html>


<head>
    <!-- link to stylesheet -->
    <title>Sign Up</title>
    <link href="css/auth-form.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<?php


    $alert;

    
    if($_GET['alert'] == 'missingvalue') {
        $alert = 'There seems to be a missing value.';
    } else if ($_GET['alert'] == 'passwords-do-not-match') {
        $alert = 'The passwords entered do not match. Please try again.';
    } else if ($_GET['alert'] == 'taken-username-email') {
        $alert = 'The username/email entered seems to be taken. Please enter another value.';
    } else if ($_GET['alert'] == 'incorrect-username') {
        $alert = 'The username entered seems to be:<br/>
            <ul>
                <br/>
                <li>Less than 6 characters</li><br/>
                <li>Greater than 50 characters</li><br/>
                <li>Written with non-alphabetical -numerical characters.
            <ul/>';
    } else if ($_GET['alert'] == 'incorrect-password') {
        $alert = 'The password entered seems to be:<br/>
            <ul>
                <br/>
                <li>Less than 6 characters</li><br/>
                <li>Greater than 50 characters</li><br/>
                <li>Written with non-alphabetical -numerical characters.
            <ul/>';
    } else if ($_GET['alert'] == 'incorrect-email') {
        $alert = 'Email entered does not seem to be registered at -themetroschool.org. Please try again.';
    } else if ($_GET['alert'] == 'registered') {
        $alert = 'Welcome to the Metro Network!';
    } else if ($_GET['alert'] == 'registrationfailed') {
        $alert = 'Something went wrong. Please try again.';
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



        <form action="registration-form.php" method="post">


            <div class="content">
            
                <div class="register-form">
                <?php echo '<div class="alert register">'.$alert.'</div>'; ?>

                    <div class="register-section1">
                        <h1>Register:</h1>
                        <br/>

                        <input type="text" name="user-first-name" placeholder="[Required] Enter first name here:">
                        <input type="text" name="user-last-name" placeholder="[Required] Enter last name here:">
                        <input type="text" name="user-name" placeholder="[Required] Enter username here:">
                        <input type="email" name="user-email" placeholder="[Required] Enter email here:">

                    </div>

                    <div class="register-section2">
                        <input type="password" name="user-pwd" placeholder="[Required] Enter password here:">

                        <input type="password" name="user-rpt-pwd" placeholder="[Required] Re-enter password here:">

                        <select name="select">
                            <option value="question">[Required] -- Student or Teacher? --</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                        </select>

                        <input type="submit" name="submit" value="Sign Up" class="submit-btn">
                    </div>
                 </div>
            </div>
        </form>     


        <?php include("../../../includes/footer.html"); ?>

</div>




</body>


</html>



