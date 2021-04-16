<!-- 
this page is the next step in registration, where users select a community or communities to join
the inputs have the same values of the class id's that are in the class table
when input is submitted, it is pushed to an array to select class id (id's if multiple)
array is there to allow multiple community selection
the array is cycled through and the class id is used in four queries
the first query checks if there are duplicate community selection to stop users from going back and choosing the same community multiple times
the second query inserts the classid, userid, and date joined into the community table
the third query selects the class size from the class table
the fourth query increments class size and then updates the class row
   -->


<?php 
    session_start();

    require_once("../includes/db.php");
    require_once("../includes/auth-check.php");
    require_once("../includes/session-check.php");

    
?>

<html>

<head>
    <!-- link to stylesheet -->
    <title>Community Selection</title>
    <link href="../css/main-style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php

//check isset
    if(isset($_POST['submit'])) {
        //puts input into an array
        $classid = array();

        //cycles through dictionary as isolates key and value
        foreach ($_POST as $name => $id) {
            //adds all values except submit to an array
            if($id != "Submit") {
                //pushes value to array as $classid
                //correlates to the value in the inputs
                array_push($classid, $id);
            }
        }


        //checks to see if input is greater than zero aka empty
      if(count($classid) > 0) {

            $all_qry_success;
            //intiliazes sql stmts
            $check_qry = "SELECT userid,classid FROM communities WHERE userid = :userid AND classid = :classid";
            $insert = "INSERT INTO communities (classid, userid, joined_at) VALUES (:classid, :userid, NOW());";
            $select = "SELECT class_size FROM class WHERE id = :id;";
            $update = "UPDATE class SET class_size = :size WHERE id = :id;";

            //iterates iterative 
            for ($iterative = 0; $iterative < count($classid); $iterative++) { 

                //checks to see if user is already in the community to prevent duplicates
                $check = $conn->prepare($check_qry);

                $check->bindParam(":userid", $row['id']);
                $check->bindParam(":classid", $classid[$iterative]);

                $check->execute();

                if($check->rowCount() > 0) {
                    while($check_row = $check->fetch(PDO::FETCH_ASSOC)){
                        //checks if userid and classid match
                        if($check_row['userid'] == $row['id'] AND $check_row['classid'] == $classid[$iterative]) {
                            //outputs error
                            $alert = "You are already apart of the community[ities] selected. Please choose another.";
                            //sets variable to true
                            $taken = true;
                        }
                    }
                }


                //if taken not true
                //taken refers to the duplicate check
                //so if there are no duplicates continue
                if(!$taken){
                    //insert community choice into db 
                    $inst_qry = $conn->prepare($insert);

                    //uses iterative to cycle through array values from zero
                    $inst_qry->bindParam(":classid", $classid[$iterative]);
                    //uses $row[] value established in auth-check to set up param
                    $inst_qry->bindParam(":userid", $row['id']);

                    $inst_qry->execute();
                    
                    if($inst_qry->rowCount() > 0) { 

                        //select class size from db
                        $slct_qry = $conn->prepare($select);
                        $slct_qry->bindParam(":id", $classid[$iterative]);

                        $slct_qry->execute();

                        if($slct_qry->rowCount() > 0) {
                    
                            //fetch the info
                            while($row_query = $slct_qry->fetch(PDO::FETCH_ASSOC)) {
                                //update the class size + 1
                                $class_size = $row_query['class_size'] + 1;
                            }  

                            //update the class size
                            $updt_qry = $conn->prepare($update);

                            $updt_qry->bindParam(":size", $class_size);
                            $updt_qry->bindParam(":id", $classid[$iterative]);

                            $updt_qry->execute();

                            if($updt_qry->rowCount() > 0) { 
                                //allows the for statement to iterate through every number before
                                $all_qry_success = true;
                            //error-catching
                            //not my first choice on how to do it but easiest way
                            } else {
                                $error = true;
                            }
                        } else {
                            $error = true;
                        }
                    } else {
                        $error = true;
                    }
                } 

                //checks if every query went through for each class by
                if($all_qry_success == TRUE && $iterative == (count($classid) - 1)) {
                    //sends user to feed page aka home
                    header("Location:http://localhost:8888/themetronetwork/main/feed.php?newuser");
                    exit();
                } else {
                    $error = true;
                }
            }

        //if input is empty
        } else {
            $alert = "There is a missing value. Please select a community or press skip.";
        }
    } else if(isset($_POST['skip'])) {
        //skip choice
        header("Location:http://localhost:8888/themetronetwork/main/feed.php?newuser");
        exit();
    //base alert
    } else {
        $alert = "Please select a community or press skip to move on.";
    }

    if($error) {
        $alert = "Something went wrong. Please try again.";
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
                <li><a href="../logout.php?id=<?php echo $row['id'] ?>">Logout</a></li>
                </ul>
            </nav>
        </header>


        <form action="community-selection.php" method="post">

            <div class="content">
        
                <div class="container">

                    <div class="section section1">
                        <div class="title title-top">
                            <h2>Welcome!</h2>
                        </div>
                    </div>

                    <div class="section section2">

                        <div class="section-title"><?php /*outputs alert */ echo $alert ?></div>

                        <!-- community options -->
                        <div class="content-box">     
                            <div class="segment segment1">
                                <input type="checkbox" name="precalculus" value="1">
                            </div>
                            <div class="segment segment2">
                                Pre-Calculus
                                <h5>Carol Van Fossen</h5>
                            </div>
                        </div>

                        <div class="content-box">     
                            <div class="segment segment1">
                                <input type="checkbox" name="english12" value="2">
                            </div>
                            <div class="segment segment2">
                                English 12
                                <h5>Carlee Beatty</h5>
                            </div>
                        </div>
                    

                            <input type="submit" name="submit" class="submit-btn long-submit-btn" style="margin-bottom: 5px;,">
                            <input type="submit" name="skip" value="Skip" class="submit-btn long-submit-btn">



                    </div>
                    
                </div>    
            </div>
        </form>
                    

      
    <?php include("../includes/footer.html"); ?>

</div>



</body>


</html>

<?php $conn->close() ?>