<?php 
	session_start();

	require_once("../../../includes/db.php");
	require_once("../../../includes/auth-check.php");
	require_once("../../../includes/session-check.php");
	//QUERIES FOR THIS PAGE
	require_once("account-view-form.php");


	$_SESSION['LAST_ACTIVITY'] = time();

?>


<html>

<head>
	<!-- link to stylesheet -->
	<title>Account View</title>
	<link href="../../../css/main-style.css" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	  
</head>

<!-- JQUERY for the hiding/showing content -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


<!-- JQUERY CODE -->
<script type="text/javascript">
	$(document).ready(function() {

		//USER ACCOUNT 

		//HIDE USER INFO AND CLOSE DROP DOWN BARS
		$("#user-friend-hide").hide();
		$("#user-friend-content").hide();
		$("#comm-hide").hide();
		$("#communities-content").hide();

		//SHOW FRIEND DROPDOWN INFO
		$("#friend-dropdown-show").click(function() {
			$("#user-friend-show").hide();

			$("#user-friend-hide").show();
			$("#user-friend-content").show();
		});

		//HIDE FRIEND DROPDOWN INFO
		$("#friend-dropdown-hide").click(function() {
			$("#user-friend-show").show();

			$("#user-friend-hide").hide();
			$("#user-friend-content").hide();
		});

		//SHOW COMMUNITIES DROPDOWN INFO
		$("#comm-dropdown-show").click(function() {
			$("#comm-show").hide();

			$("#comm-hide").show();
			$("#communities-content").show();
		});

		//HIDE COMMUNITIES DROPDOWN INFO
		$("#comm-dropdown-hide").click(function() {
			$("#comm-show").show();

			$("#comm-hide").hide();
			$("#communities-content").hide();
		});
	}); 

</script> 



<body>

	<div class="flexbox-container">
		<header>
			<div class="logo">
				<h1>TMN</h1>
			</div>

			<nav>
				<ul>
					<li><a href="../../feed.php">Home</a></li>
					<li><a href="../search.php">Search</a></li>
					<li>Communities</li>
					<li><a href="../../settings/account/settings.php">Settings</a></li>
					<li><a href="../../../logout.php">Logout</a></li>
				</ul>
			</nav>
		</header>

		<div class="content">
				<div class="container">

					<!-- LEFT NAV BAR -->
					<div class="section section1">
						<div class="title">Account View</div>

						<div class="links">
							<a href="../search.php" class="link">Back to Search</a>
						</div>
					</div>

					<div class="section section2" style="padding-bottom: 20px;">

						<div class="section-title">User Account View</div>

						<!-- USER INFO -->
						<div class="content-box">
							<div class="segment full-content">
								<h1><?php echo $user_account_info['first_name'] . ' ' . $user_account_info['last_name']; ?></h1>
								<h3>Username: <?php echo $user_account_info['username']; ?></h3>
								<h3>Email: <?php echo $user_account_info['email']; ?></h3>
								<h3>Position: <?php echo ucwords($user_account_info['position']); ?></h3>
                                <h3>Account Creation Date: <?php echo date("F j, Y", strtotime($user_account_info['created_at'])) ?></h3>
							</div>
						</div> 

						<!-- FRIEND BTN -->

						<?php 
						
							//IF USER HAS FRIENDS
							if($friends) {

						?>

						<form action="account-view.php" method="get">
				

							<button class="content-box friend">
									<div class="full-content">
										Unfriend <?php echo $user_account_info["first_name"];?>
									</div>                   
							</button>
							
							<input type="hidden" name="unfriend" value="<?php echo $_GET['id']; ?>">

						</form>

						<?php
							//IF USER'S OWN ACCOUNT
							} else if($own_account) {

								echo'<div class="content-box" align="center">
									<div class="full-content"><a href="../../settings/account/settings.php">Edit Account</a></div>
								</div>';
							//IF NONE OF THE ABOVE
							} else {
						?>
							<form action="account-view.php" method="post">

								<button class="content-box friend">
										<div class="full-content">
											Friend <?php echo $user_account_info["first_name"];?>
										</div>                   
								</button>
								
								<input type="hidden" name="friend" value="<?php echo $_GET['id']; ?>">

							</form>
						<?php
							}

						?>

						

						<!-- DUAL TITLE/DROPDOWN BAR - ONE FOR SHOW/ONE FOR HIDE -->
						<div class="content-box" id="user-friend-show" style="margin-bottom: 5px;">
							<div class="segment2" style="font-size: 1.30em">Users Friended:</div>
							<div class="segment1 dropdown" id="friend-dropdown-show">+</div>
						</div>

						<div class="content-box" id="user-friend-hide" style="margin-bottom: 5px;">
						<div class="segment2" style="font-size: 1.30em">Users Friended:</div>
							<div class="segment1 dropdown" id="friend-dropdown-hide">&#8212;</div>
						</div>

						<!-- CONTENT USER SEES WHEN DROPDOWN -->
						<div id="user-friend-content" style="margin-bottom: 30px;">

						<?php

							//PRACTIALLY THE SAME JOB AS $FRIENDS
							if($has_friends) {
								//ECHO AMOUNT OF FRIENDS 
								if($select_friends->rowCount() == 1) {
									echo '<div class="content-box">
											<div class="full-content">
													They have 1 friend.
											</div>
										</div>';
								} else if ($select_friends->rowCount() > 1) {
									echo '<div class="content-box">
											<div class="full-content">
												They have '.$select_friends->rowCount().' friends.
											</div>
										</div>';
								}

								while($friends_acccount_info = $select_friends->fetch(PDO::FETCH_ASSOC)) {
                                    //CONTENT BOX
                                    echo ' 
                                    <div class="content-box">
                                        <div class="segment1">
                                            <div class="result1">
                                                <h2>';
                    ?>

													<!-- LINK TO VIEW PAGE -->
                                                    <a href="../account/account-view.php?id=<?php echo $friends_acccount_info['id']; ?>">
                                                        View
                                                    </a>
                    <?php  

										//ACCOUNT INFO

                                            echo '</h2>
                                            </div>
                                        </div>

	

                                        <div class="segment2">
                                            <div class="result2">
                                                <h1>'.$friends_acccount_info['first_name'] .' ' . $friends_acccount_info['last_name'] .'</h1>
                                                <h3>'.$friends_acccount_info['username'].'</h3>
                                            </div>
                                        </div>
                                    </div>';
                                }

							} else {

								echo '<div class="content-box">
										<div class="full-content">
											They have not friended anyone yet!
										</div>
									</div>';                   
							}

					?>
						
						</div>

						<!-- REPEAT OF FRIEND WITH COMMUNITIES INFO -->
						<div class="content-box" id="comm-show">
							<div class="segment2" style="font-size: 1.30em">Communities Joined:</div>
							<div class="segment1 dropdown" id="comm-dropdown-show">+</div>
						</div>

						<div class="content-box" id="comm-hide" style="margin-bottom: 5px;">
							<div class="segment2" style="font-size: 1.30em">Communities Joined:</div>
							<div class="segment1 dropdown" id="comm-dropdown-hide">&#8212;</div>
						</div>

						<div id="communities-content" style="margin-bottom: 30px;">


					<?php
							if($communities) {


								//ECHO NUMBER OF COMMUNITIES JOINED
								
								if($query->rowCount() == 1) {
									echo '<div class="content-box">
											<div class="full-content">
												They have joined 1 community.
											</div>
										</div>';
								} else if ($query->rowCount() > 1) {
									echo '<div class="content-box">
											<div class="full-content">
												They have joined '.$query->rowCount().' communities.
											</div>
										</div>';
								}

								while($output = $query->fetch(PDO::FETCH_ASSOC)) {

                                    //CONTENT BOX
                                    echo ' 
                                    <div class="content-box">
                                        <div class="segment1">
                                            <div class="result1">
                                                <h2>';
                    ?>
                                                    <a href="../communities/communities-view.php?id=<?php echo $output['id']; ?>">
                                                        View
                                                    </a>
                    <?php  
                                            echo '</h2>
                                            </div>
                                        </div>
            
                                        <div class="segment2">
                                            <div class="result2">
                                                <h1>'.$output['class_name'] .'</h1>
                                                <h3>'.$output['class_proctor'].'</h3>
                                            </div>
                                        </div>
                                    </div>';
                                }

							} else {

								echo '<div class="content-box">
										<div class="full-content">
											They have not joined any communities yet!
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
