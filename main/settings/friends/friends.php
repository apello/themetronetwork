<?php 
    session_start();

    require_once("../../../includes/db.php");
    require_once("../../../includes/auth-check.php");
    require_once("../../../includes/session-check.php");

    require("friends-select.php");

    $_SESSION['LAST_ACTIVITY'] = time();

?>


<html>

<head>
    <!-- link to stylesheet -->
    <title>Settings - Friends</title>
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

                        <div class="title">Friends</div>

                        <div class="links">
                            <a href="../account/settings.php" class="link">Account</a>
                            <a href="../communities/communities.php" class="link">Communities</a>
                            <div class="link" style="background-color: rgba(50, 231, 255, 0.7);">Friends</div>
                        </div>


                    </div>
                    
                    <div class="section section2">
                    
                        <div class="section-title">Settings - Friends</div>

                        <div class="content-box">
                            <div class="segment full-content">
                                <h1>Friends:</h1>
                            </div>
                        </div>

                        <?php
							if($has_friends) {
								//ECHO NUMBER OF COMMUNITIES JOINED
                        ?>

                                <div class="content-box" style="margin-bottom: 30px;">
                                    <div class="full-content" align="center">
                                        <a href="edit-friends.php">Edit Friends</a>
                                    </div>
                                </div>

                            <?php
								if($select_friends->rowCount() == 1) {
							?>				

									<div class="content-box">
										<div class="full-content">
											You have friended one user.
										</div>
									</div>

							<?php } else if ($select_friends->rowCount() > 1) { ?>

									<div class="content-box">
										<div class="full-content">
											You have friended <?php echo $select_friends->rowCount(); ?> users.
										</div>
									</div>

                            
							<?php } while($friend_acccount_info = $select_friends->fetch(PDO::FETCH_ASSOC)) { ?>
															
                                <div class="content-box">
                                    <div class="segment1">
                                        <div class="result1">
                                            <h2>
                                                <!-- LINK TO VIEW PAGE -->
                                                <a href="../../search/account/account-view.php?id=<?php echo $friend_acccount_info['id']; ?>&header=friends">
                                                    View
                                                </a>
                                            </h2>
                                        </div>
                                    </div>

                                    <!-- ACCOUNT INFO -->

                                    <div class="segment2">
                                        <div class="result2">
                                            <h2><?php echo $friend_acccount_info['first_name'] .' '. $friend_acccount_info['last_name'];?></h2>
                                            <h3><?php echo $friend_acccount_info['username']; ?></h3>
                                        </div>
                                    </div>
                                </div>

							<?php } //WHILE LOOP END BRACKET ?>

                                <div class="content-box">
                                    <div class="full-content">
                                        <h4 style="padding: 0px;">To find a new friend, use <a href="../../search/search.php">search</a> to look up users.</h4>
                                    </div>
                                </div>
										

                            <?php } else { ?>

								<div class="content-box">
                                    <div class="full-content">
                                        <h4 style="padding: 0px;">You have not friended anyone yet! To find a new friend, use <a href="../../search/search.php">search</a> to look up users.</h4>
                                    </div>
                                </div>
										
							<?php } ?>
						
						</div>


						<!-- END USER FRIEND INFO SECTION -->



                    
                        
                        
                      
                

                    </div>
                

                </div>
            </div>

         

                
         
        </div>

        <?php include("../../../includes/footer.html"); ?>

    </div>


   

</body>


</html>   
