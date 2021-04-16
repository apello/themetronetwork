<?php 
    session_start();

    require_once("../../../includes/db.php");
    require_once("../../../includes/auth-check.php");
    require_once("../../../includes/session-check.php");

    //FRIEND INFO SELECT QRY
    require("friends-select.php");

    $_SESSION['LAST_ACTIVITY'] = time();


?>

<!-- SEPARATIOn -->

<?php
  
    //COPY AND PASTED FROM COMMUNITY EDIT
    if(isset($_POST['submit'])) {

        //puts input into an array
        $friendID = array();

        //cycles through dictionary as isolates key and value
        foreach ($_POST as $name => $id) {
            if(count($_POST) == 1) {
                $empty = TRUE;
            }

            //adds all values except submit to an array
            if($id != "Unfriend") {
                //pushes value to array as $friendID
                //correlates to the value in the inputs
                array_push($friendID, $id);
            }
        }

        print_r($friendID);

       if(!$empty) {
            for ($iterative = 0; $iterative < count($friendID); $iterative++) { 
                //DELETE FRIEND 
                $delete_friend_qry = "DELETE FROM friends where user_id1 = :userid AND user_id2 = :friendid";

                $delete_friend = $conn->prepare($delete_friend_qry);

                $delete_friend->bindParam(":userid", $row['id']);
                $delete_friend->bindParam(":friendid", $friendID[$iterative]);

                $delete_friend->execute();

                if($delete_friend->rowCount() > 0) {
                    $all_query_success =  TRUE;
                } else {
                    $error = TRUE;
                }

                if($all_query_success == TRUE && $iterative == (count($friendID) - 1)) {

                    require("../../../includes/functions.php");

                    trackUserActions($row['id'], "EDITED FRIENDS", "../../../includes/db.php");
                    //RELOCATE PAGE BCUZ OF SOME WEIRD BUG - CHECK OUT LATER
                    header("Location: http://localhost:8888/themetronetwork/main/settings/friends/friends.php");
                    exit();
                }        
            } 
        } 
    }

    if($error) {
        $alert = "Something went wrong! Please try again.";
    } else if($empty) {
        $alert = "Please select a friend to continue:";
    } else {
        $alert = "Select users you want to unfriend below:";
    }

?>

<html>

<head>
    <!-- link to stylesheet -->
    <title>Edit Friends</title>
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
                            <a href="friends.php" class="link">Back to Settings</a>
                        </div>
                    </div>
                    
                    <div class="section section2">
                    
                        <div class="section-title">Edit Friends</div>

                        <form action="edit-friends.php" method="post">

                        <?php if($has_friends) { ?>

                            <div class="content-box error">
                                <div class="segment full-content">
                                       <?php echo $alert; ?>
                                </div>
                            </div>

							<?php while($friend_acccount_info = $select_friends->fetch(PDO::FETCH_ASSOC)) { ?>
                                 
                                    <div class="content-box">     
                                        <div class="segment segment1">
                                            <input type="checkbox" name="<?php echo $friend_acccount_info['id']; ?>" value="<?php echo $friend_acccount_info['id']; ?>">
                                        </div>
                                        
                                        <div class="segment segment2">
                                            <h2><?php echo $friend_acccount_info['first_name']; ?></h2>
                                            <h3><?php echo $friend_acccount_info['username']; ?></h3>
                                        </div>
                                    </div>
                                                               
                            <?php } ?>

                                <input type="submit" name="submit" value="Unfriend" class="submit-btn" style="margin-bottom: 25px;">

                            <?php } else { ?>

                                <div class="content-box">
                                    <div class="full-content">
                                    You do not have any friends!
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
