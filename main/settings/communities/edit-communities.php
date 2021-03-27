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

        for ($iterative = 0; $iterative < count($classid); $iterative++) { 

            //checks to see if user is already in the community to prevent duplicates
            $delete_qry = "DELETE FROM communities where userid = :userid AND classid = :classid";

            $delete = $conn->prepare($delete_qry);

            $delete->bindParam(":userid", $row['id']);
            $delete->bindParam(":classid", $classid[$iterative]);

            $delete->execute();

            if($delete->rowCount() > 0) {
                $query_sucess = TRUE;
            } else {
                $error = TRUE;
            }

            echo $iterative;
            echo count($classid);

            if($query_sucess == TRUE && $iterative == (count($classid) - 1)) {
                header("Location: http://localhost:8888/themetronetwork/main/settings/communities/edit-communities.php");
                exit();
            }           
        }
    }

    if($error) {
        $alert = "Something went wrong! Please try again.";
    } else {
        $alert = "Select communit[ies] you want to leave below:";
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

            <?php include("../../includes/nav-folder-links.html"); ?>

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

                                echo '<div class="content-box error">
                                    <div class="full-content">
                                        '.$alert.'
                                    </div>
                                    </div>';

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

                                echo '<input type="submit" name="submit" value="Leave" class="submit-btn" style="margin-bottom: 5px;">';
                                

                            } else {
                                echo '<div class="content-box">
                                <div class="full-content">
                                   You have not joined any communities!
                                </div>
                                </div>';                   
                            }

                        ?>


        

                        </form>




                            

                    

                

                    </div>
                

                </div>
            </div>

         

                
         
        </div>

        <?php include("../../../includes/footer.html"); ?>

    </div>


   

</body>


</html>   
