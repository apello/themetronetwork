<?php 
    session_start();

    require_once("../../../includes/db.php");
    require_once("../../../includes/auth-check.php");
    require_once("../../../includes/session-check.php");
    //FOR INFO SELECTION
    require_once("communities-select.php");

    //FOR TRACKING

    $_SESSION['LAST_ACTIVITY'] = time();
  
    if(isset($_POST['submit'])) {

        //puts input into an array
        $classid = array();

        //cycles through dictionary as isolates key and value
        foreach ($_POST as $name => $id) {

            if(count($_POST) == 1) {
                $empty = TRUE;
            }

            //adds all values except submit to an array
            if($id != "Leave Class") {
                //pushes value to array as $classid
                //correlates to the value in the inputs
                array_push($classid, $id);
            }
        }


        if(!$empty) {
            for ($iterative = 0; $iterative < count($classid); $iterative++) { 

                //DELETE USER FROM COMMUNITIES
                $delete_qry = "DELETE FROM communities where userid = :userid AND classid = :classid";

                $delete = $conn->prepare($delete_qry);

                $delete->bindParam(":userid", $row['id']);
                $delete->bindParam(":classid", $classid[$iterative]);

                $delete->execute();

                if($delete->rowCount() > 0) {
                    //SET CLASS SIZE to CLASS SIZE - 1 (MINUS ONE STUDENT)
                    $update_qry = "UPDATE class SET class_size = (class_size - 1) WHERE id = :classid";
                    $update = $conn->prepare($update_qry);
        
                    $update->bindParam(":classid", $classid[$iterative]);
        
                    $update->execute();
        
                    if($update->rowCount() > 0) {
                        $all_query_success = TRUE;
                    } else {
                        $error = TRUE;
                    }
                } else {
                    $error = TRUE;
                }

                if($all_query_success == TRUE && $iterative == (count($classid) - 1)) {

                    require("../../../includes/functions.php");

                    trackUserActions($row['id'], "EDITED COMMUNITIES", "../../../includes/db.php");

                    //RELOCATE PAGE BCUZ OF SOME WEIRD BUG - CHECK OUT LATER
                    header("Location: http://localhost:8888/themetronetwork/main/settings/communities/communities.php");
                    exit();
                }           
            }  
        }
    }

    if($error) {
        $alert = "Something went wrong! Please try again.";
    } else if($empty) {
        $alert = "Please select a class to continue:";
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

            <nav>
                <ul>
                    <li><a href="../../feed.php">Home</a></li>
                    <li><a href="../../search/search.php">Search</a></li>
                    <li><a href="../account/settings.php">Settings</a></li>
                    <li><a href="../../../logout.php?id=<?php echo $row['id'] ?>">Logout</a></li>

                </ul>
            </nav>
            
        </header>

        <div class="content">
      
                <div class="container">
                    <div class="section section1">
                        <div class="links">
                            <a href="communities.php" class="link">Back to Settings</a>
                        </div>
                    </div>
                    
                    <div class="section section2">
                    
                        <div class="section-title">Edit Communities</div>

                        <form action="edit-communities.php" method="post">

                        <?php if($communities) { ?>

                            <div class="content-box error">
                                <div class="full-content">
                                       <?php echo $alert; ?>
                                </div>
                            </div>

                            <?php while($output = $query->fetch(PDO::FETCH_ASSOC)){ ?>
                                 
                                    <div class="content-box">     
                                        <div class="segment segment1">
                                            <input type="checkbox" name="<?php echo $output['class_name']; ?>" value="<?php echo $output['id']; ?>">
                                        </div>
                                        
                                        <div class="segment segment2">
                                            <?php echo $output['class_name']; ?>
                                            <h5>
                                                <?php echo $output['class_proctor']; ?>
                                            </h5>
                                        </div>
                                    </div>
                                                               
                            <?php } ?>

                                <input type="submit" name="submit" value="Leave Class" class="submit-btn" style="margin-bottom: 25px;">

                            <?php } else { ?>

                                <div class="content-box">
                                    <div class="full-content">
                                    You have not joined any communities!
                                    </div>
                                </div>    

                            <?php } ?>
    
                        </form>
                    </div>
                </div>
            </div>        
        </div>

        <?php include("../../../includes/footer.html"); ?>

    </div>


   

</body>


</html>   
