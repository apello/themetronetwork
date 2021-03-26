<?php 
    session_start();

    require_once("../../includes/db.php");
    require_once("../../includes/auth-check.php");
    require_once("../../includes/session-check.php");

    $_SESSION['LAST_ACTIVITY'] = time();



    //input checks
    //put them up here to give space to the search query


    $alert;
    $input_set;

    
    if($_GET['alert'] == 'missing-value') {
        $alert = 'There seems to be a missing value. Please try again.';
    } else if($_GET['alert'] == 'inappropriate-value') {
        $alert = 'The value entered is inappropriate. Please try again.';
    } else  {
        $alert = 'Search for users, communities, or posts here:';
    }

    if($_GET['alert'] == 'input-set') {
        $input_set = TRUE;
    }

?>


<html>

<head>
    <!-- link to stylesheet -->
    <title>Search</title>
    <link href="../../css/main-style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
</head>



<?php

    //i have to put this code in the page because its harder to send code across pages

    //intialize var
  


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
                    <li>Search</li>
                    <li>Communities</li>
                    <li><a href="../settings/account/settings.php">Settings</a></li>
                    <li><a href="../../logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <div class="content">
      
                <div class="container">
                    <div class="section section1">

                        <form class="search" action="search-form.php" method="post">
                                <div class="alert"><?php echo $alert; ?></div>
                                <input type="text" name="search" placeholder="Search here:"/>
                                <input type="submit" name="submit" class="submit-btn" value="Go">
                        </form>


                    </div>


                <div class="section section2">

                    <?php
                        if($input_set) {
                            if($user) {
                                while($row = $user->fetch(PDO::FETCH_ASSOC)) {
                                    echo ' 
                                    <div class="content-box">
                                        <div class="segment1">
                                            <div class="result1">
                                                <h2>View</h2>
                                            </div>
                                        </div>
            
                                        <div class="segment2">
                                            <div class="result2">
                                                <h1>Abdi</h1>
                                                <h3>Student</h3>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            }
                        } else {
                    
                            echo ' 
                            <div class="content-box" style="margin-top:30px;">
                                <div class="full-content">
                                    Use the search bar to discover users, posts and communities!
                                 </div>
                            </div>';
                        }

                    ?>

                </div>
            </div>

         

                
         
        </div>

        <footer>
            <h1>The Metro Network</h1>
            <h1>Created by Abdirahman Nur</h1>

        </footer>
    </div>


   

</body>


</html>   
