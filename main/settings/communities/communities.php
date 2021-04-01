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

            <?php include("../../includes/nav-folder-links.html"); ?>

        </header>

        <div class="content">
      
                <div class="container">
                    <div class="section section1">

                        <div class="title">Communities</div>

                        <div class="links">
                            <a href="../account/settings.php" class="link">Account</a>
                            <div class="link" style="background-color: rgba(50, 231, 255, 0.7);">Communities</div>
                            <div class="link">Friends</div>
                        </div>


                    </div>
                    
                    <div class="section section2">
                    
                        <div class="section-title">Communities</div>

                        <div class="content-box">
                            <div class="segment full-content">
                                <h1>Communities Joined:</h1>
                            </div>
                        </div>

                        <?php
                        
                        if($communities) {

                            while($output = $query->fetch(PDO::FETCH_ASSOC)) {    

                                echo '<div class="content-box">'; 
                                echo '<div class="segment full-content">';
    
                                echo "<h3>".trim($output['class_name'])." with ".$output['class_proctor']."</h3>";
                                echo "<h3>Date Joined: ".date("F j, Y", strtotime($output['joined_at']))."</h3>";
    
                                echo "</div></div>";
                                
                              
                    
                            }

                            echo '<div class="content-box">';
                            echo '<div class="segment full-content">';
                            echo '<a href="edit-communities.php">Edit Communities</a>';
                            echo '</div></div>';

                            
                        } else {
                            echo '<div class="content-box"> 
                                    <div class="segment full-content">
                                        You have not joined any communities!
                                    </div>
                                </div>'; 
                        }


                        ?>  
                           
                    
                        
                        
                      
                

                    </div>
                

                </div>
            </div>

         

                
         
        </div>

        <?php include("../../../includes/footer.html"); ?>

    </div>


   

</body>


</html>   
