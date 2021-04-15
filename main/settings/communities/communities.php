<?php 
    session_start();

    require_once("../../../includes/db.php");
    require_once("../../../includes/auth-check.php");
    require_once("../../../includes/session-check.php");

    require_once("communities-select.php");

    $_SESSION['LAST_ACTIVITY'] = time();

?>


<html>

<head>
    <!-- link to stylesheet -->
    <title>Settings - Communities</title>
    <link href="../../../css/main-style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
</head>


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
                    <li><a href="../account/settings.php">Settings</a></li>
                    <li><a href="../../../logout.php">Logout</a></li>

                </ul>
            </nav>
        </header>

        <div class="content">
      
                <div class="container">
                    <div class="section section1">

                        <div class="title">Communities</div>
                                

                        <div class="links">
                            <a href="../account/settings.php" class="link">Account</a>
                            <div class="link" style="background-color: rgba(50, 231, 255, 0.7);">Communities</div>
                            <a href="../friends/friends.php" class="link">Friends</a>
                        </div>


                    </div>
                    
                    <div class="section section2">
                    
                        <div class="section-title">Communities</div>

                        <div class="content-box">
                            <div class="segment full-content">
                                <h1>Communities Joined:</h1>
                            </div>
                        </div>


                        <div class="content-box">
                            <div class="segment full-content">
                                <a href="edit-communities.php">Edit Communities</a>
                            </div>
                        </div>

                        <div class="content-box"> 
                            <div class="segment full-content">
                                <h4 style="padding: 0px;">To join a new community, use <a href="../../search/search.php">search</a> to find and join a class.</h4>
                            </div>
                        </div>

                        

                        <?php
                        
                            if($communities) {

                                while($output = $query->fetch(PDO::FETCH_ASSOC)) {    
                        ?>

                                <div class="content-box">
                                    <div class="segment1">
                                        <div class="result1">
                                            <h2>
                                                <!-- LINK TO VIEW PAGE -->
                                                <a href="../../search/communities/communities-view.php?id=<?php echo $output['id']; ?>">
                                                    View
                                                </a>
                                            </h2>
                                        </div>
                                    </div>

                                    <!-- ACCOUNT INFO -->

                                    <div class="segment2">
                                        <div class="result2">
                                            <h2><?php echo trim($output['class_name'])." with ".$output['class_proctor']; ?></h2>
                                            <h3>Date Joined: <?php echo date("F j, Y", strtotime($output['joined_at'])); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                
                        <?php } ?>

                        <?php } else { ?>

                                <div class="content-box"> 
                                    <div class="segment full-content">
                                        <h4 style="padding: 0px;">You have not joined any communities! To join a new community, use <a href="../../search/search.php">search</a> to find and join a class.</h4>
                                    </div>
                                </div>

                        <?php } ?>  
                           
                    </div>
                </div>
            </div>

         

                
         
        </div>

        <?php include("../../../includes/footer.html"); ?>

    </div>


   

</body>


</html>   
