<?php 
    session_start();

    require_once("../../../includes/db.php");
    require_once("../../../includes/auth-check.php");
    require_once("../../../includes/session-check.php");
    require_once("communities-select.php");

    $_SESSION['LAST_ACTIVITY'] = time();

    if(isset($_POST['submit'])) {
        //puts input into an array
        $classid = array();

        //cycles through dictionary as isolates key and value
        foreach ($_POST as $name => $id) {
            //adds all values except submit to an array
            if($id != "Leave") {
                //pushes value to array as $classid
                //correlates to the value in the inputs
                array_push($classid, $id);
            }
        }

        print_r($classid);
    }

?>


<html>

<head>
    <!-- link to stylesheet -->
    <title>Edit Communities</title>
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
                    <li>Communities</li>
                    <li>Settings</li>
                    <li><a href="../../../logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <div class="content">
      
                <div class="container">
                    <div class="section section1">


                        <div class="links">
                            <a href="communities.php" class="link">Back</a>
                        </div>


                    </div>
                    
                    <div class="section section2">
                    
                        <div class="section-title">Edit Communities</div>

                        <form action="edit-communities.php" method="post">

                        <?php

                            if($communities) {

                                while($output = $query->fetch(PDO::FETCH_ASSOC)) {    
                                    echo '
                                    <div class="content-box">     
                                        <div class="segment segment1">
                                            <input type="checkbox" name='.$output['class_name'].' value='.$output['id'].'>
                                        </div>
                                        
                                        <div class="segment segment2">
                                            '.$output['class_name'].'
                                            <h5>'.$output['class_proctor'].'</h5>
                                        </div>
                                    </div>
                                    
                                    ';
                                }
                                

                            } else {
                                echo '<div class="content-box">You have not joined any communities!</div>';                                
                            }

                        ?>


        
                        <input type="submit" name="submit" value="Leave" class="submit-btn" style="margin-bottom: 5px;">

                        </form>




                            

                    

                

                    </div>
                

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
