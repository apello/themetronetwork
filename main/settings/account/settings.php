<?php 
    session_start();

    require_once("../../../includes/db.php");
    require_once("../../../includes/auth-check.php");
    require_once("../../../includes/session-check.php");

    $_SESSION['LAST_ACTIVITY'] = time();

?>


<html>

<head>
    <!-- link to stylesheet -->
    <title>Settings</title>
    <link href="../../../css/main-style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
</head>

<script>

function deleteAlert() {
  if (confirm("If You Want to Delete Your Account, Press Ok. Otherwise, Press Cancel.")) {
      window.location.replace("http://localhost:8888/themetronetwork/main/settings/account/delete-account.php");
  } 
}
</script>


<body>
<div id="demo"></div>

    <div class="flexbox-container">
        <header>
            <div class="logo">
                <h1>TMN</h1>
            </div>

            <nav>
                <ul>
                    <li><a href="../../feed.php">Home</a></li>
                    <li><a href="../../search/search.php">Search</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    <li><a href="../../../logout.php">Logout</a></li>

                </ul>
            </nav>
        </header>

        <div class="content">
      
                <div class="container">
                    <div class="section section1">

                        <div class="title">Settings</div>

                        <div class="links">
                            <div class="link" style="background-color: rgba(50, 231, 255, 0.7);">Account</div>
                            <a href="../communities/communities.php" class="link">Communities</a>
                            <a href="../friends/friends.php" class="link">Friends</a>
                        </div>


                    </div>
                    
                    <div class="section section2">
                    
                        <div class="section-title">Account</div>

                        <div class="content-box">
                            <div class="segment full-content">
                                <h1><?php /* outputs name */echo trim($row['first_name']) . " " . trim($row['last_name']);?></h1>
                                <h3>Username: <?php echo trim($row['username']) ?></h3>
                                <h3>Email: <?php echo trim($row['email']) ?></h3>
                                <h3>Position: <?php echo ucwords($row['position']); ?></h3>
                                <h3>Account Creation Date: <?php echo date("F j, Y", strtotime($row['created_at'])) ?></h3>
                            </div>                    
                        </div> 

                        <?php if(!empty($row['bio'])){ ?>
                            <div class="content-box">
                                <div class="segment full-content">
                                    <h1>Bio</h1>
                                    <h3><?php echo trim($row['bio']) ?></h3>
                                </div>
                            </div> 
                        <?php } else { ?>
                            <div class="content-box">
                                <div class="segment full-content"><a href="edit-account.php">Add Bio</a></div>
                            </div> 
                        <?php }  ?>

                        
                        <div class="content-box">
                            <div class="segment full-content"><a href="edit-account.php">Edit Account</a></div>
                        </div>

                        <div class="content-box">
                            <div class="segment full-content"><a href="edit-password.php">Edit Password</a></div>
                        </div>

                        <div class="content-box">
                            <div class="segment full-content" onclick="deleteAlert()" style="cursor: pointer; text-decoration:underline;">Delete Account</div>
                        </div>   

                    </div>
                </div>
            </div>

         

                
         
        </div>

        <?php include("../../../includes/footer.html"); ?>

    </div>


   

</body>


</html>   
