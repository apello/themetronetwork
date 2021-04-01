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
    
    //pull search from get because it doesnt practically exist on this page
    $search = $_GET['search'];

    if($input_set) {
        //already know search isnt empty and its been filtered

        //USER
        $user_query = "SELECT id,first_name,last_name,username,position FROM users WHERE first_name LIKE :input OR last_name LIKE :input OR username LIKE :input LIMIT 3";
        $user_search = $conn->prepare($user_query);

        //to get around wildcard issue, have to declare var with wildcards
        $user_input = "$search%";

        $user_search->bindParam(":input", $user_input);
        $user_search->bindParam(":id", $row['id']);

        $user_search->execute();

        if($user_search->rowCount() > 0) {
            $user = TRUE;
        }

        //COMMUNITIES
        $comm_query = "SELECT id,class_name,class_size,class_proctor FROM class WHERE class_name LIKE :input OR class_proctor LIKE :input LIMIT 3";
        $comm_search = $conn->prepare($comm_query);

        //to get around wildcard issue, have to declare var with wildcards
        //idk if i should do it starts with or it has it inside
        $comm_input = "$search%";

        $comm_search->bindParam(":input", $comm_input);

        $comm_search->execute();

        if($comm_search->rowCount() > 0) {
            $communities = TRUE;
        }

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
                    <li>Search</li>
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
                            //RESULT COUNT
                            if($user || $communities || $posts) {
                                $count = $count + $user_search->rowCount();
                                $count = $count + $comm_search->rowCount();
                                //$count = $count + $posts;
                            }

                            //RESULT OUTPUT
                            if($count > 0) {
                                echo '<div class="content-box">
                                <div class="full-content">
                                    <h3 align="center">'.$count.' result[s] for: '.$search.'</h3>
                                </div>
                                </div>';
                            } else {
                                echo '<div class="content-box">
                                <div class="full-content">
                                    <h3 align="center">0 results for: '.$search.'</h3>
                                </div>
                                </div>';
                            }

                            //USERS SEARCH RESULTS

                            if($user) {

                                //TITLE
                                echo '<div class="content-box">
                                        <div class="full-content">
                                            <h1>Users</h1>
                                        </div>
                                    </div>';
        

                                while($row = $user_search->fetch(PDO::FETCH_ASSOC)) {

                                    global $userid;
                                    $userid = $row['id'];

                                    //CONTENT BOX  - RESULT OUTPUT
                                    echo ' 
                                    <div class="content-box">
                                        <div class="segment1">
                                            <div class="result1">
                                                <h2>';
                    ?>
                                                    <a href="account/account-view.php?id=<?php echo $userid; ?>">
                                                        View
                                                    </a>
                    <?php
                                    echo '      </h2>
                                            </div>
                                        </div>
            
                                        <div class="segment2">
                                            <div class="result2">
                                                <h1>'.$row['first_name'].' '.$row['last_name'] .'</h1>
                                                <h3>'.$row['username']. ' - ' .ucwords($row['position']).'</h3>
                                            </div>
                                        </div>
                                    </div>';
                                }

                                // SEE MORE
                                if($user_search->rowCount() >= 3) {
                    ?>
                                    <div class="content-box"  style="margin-bottom: 30px;">
                                        <div class="full-content">
                  
                                            <h3 align="center"><a href="account/user-see-all.php?search_query=<?php echo trim($search); ?>">See All Results</a></h3>

                                        </div>
                                    </div>
                    <?php

                                }
                                
                            }

                            //COMMUNITIES RESULTS

                            if($communities) {

                                //TITLE
                                echo '<div class="content-box">
                                        <div class="full-content">
                                            <h1>Communities</h1>
                                        </div>
                                    </div>';
        
                                //SELECT RESULTS FROM DB
                                while($row = $comm_search->fetch(PDO::FETCH_ASSOC)) {


                                    global $commid;
                                    $commid = $row['id'];

                                    //CONTENT BOX
                                    echo ' 
                                    <div class="content-box">
                                        <div class="segment1">
                                            <div class="result1">
                                                <h2>';
                    ?>
                                                    <a href="communities/communities-view.php?id=<?php echo $commid; ?>">
                                                        View
                                                    </a>
                    <?php  
                                            echo '</h2>
                                            </div>
                                        </div>
            
                                        <div class="segment2">
                                            <div class="result2">
                                                <h1>'.$row['class_name'] .'</h1>
                                                <h3>'.$row['class_proctor'].'</h3>
                                                <h3>'.$row['class_size']. ' student[s] are enrolled</h3>
                                            </div>
                                        </div>
                                    </div>';
                                }

                                 // SEE MORE
                                 if($comm_search->rowCount() >= 3) {
                                    echo '<div class="content-box">
                                        <div class="full-content">';
                    ?>
                                            <h3 align="center"><a href="communities/comm-see-all.php?search_query=<?php echo trim($search); ?>">See All Results</a></h3>

                    <?php
                                    echo '</div>
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

        <?php include("../../includes/footer.html"); ?>

    </div>


   

</body>


</html>   
