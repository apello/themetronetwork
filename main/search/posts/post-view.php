<?php 
	session_start();

	require_once("../../../includes/db.php");
	require_once("../../../includes/auth-check.php");
	require_once("../../../includes/session-check.php");
	//QUERIES FOR THIS PAGE
	require_once("post-view-select.php");


	$_SESSION['LAST_ACTIVITY'] = time();

?>


<html>

<head>
	<!-- link to stylesheet -->
	<title>Post View</title>
	<link href="../../../css/main-style.css" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	  
</head>

<!-- JQUERY for the hiding/showing content -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


<!-- JQUERY CODE -->
<script type="text/javascript">
	$(document).ready(function() {

		//HIDE LIKE INFO AND CLOSE DROP DOWN BARS
		$("#like-user-hide").hide();
		$("#like-user-content").hide();
		$("#comment-hide").hide();
		$("#comment-content").hide();

		//SHOW LIKE DROPDOWN INFO
		$("#like-user-show").click(function() {
			$("#like-user-show").hide();

			$("#like-user-hide").show();
			$("#like-user-content").show();
		});

		//HIDE LIKE DROPDOWN INFO
		$("#like-user-hide").click(function() {
			$("#like-user-show").show();

			$("#like-user-hide").hide();
			$("#like-user-content").hide();
		});

		//SHOW COMMENT DROPDOWN INFO
		$("#comment-dropdown-show").click(function() {
			$("#comment-show").hide();

			$("#comment-hide").show();
			$("#comment-content").show();
		});

		//HIDE COMMENT DROPDOWN INFO
		$("#comment-dropdown-hide").click(function() {
			$("#comment-show").show();

			$("#comment-hide").hide();
			$("#comment-content").hide();
		});
	}); 

</script> 

<?php


	$alert;


	if($_GET['alert'] == 'error') {
		$alert = 'Something went wrong! Please return to search <a href="../search.php">here</a> or use the back button.';
	} else if ($_GET['alert'] == 'friended') {
		$alert = 'You have successfully friended '. $user_account_info['first_name'].'!';
	} else if ($_GET['alert'] == 'unfriended') {
		$alert = 'You have successfully unfriended '. $user_account_info['first_name'].'!';
	} else if ($_GET['id'] == '' OR $_GET['id'] == NULL) {
		$alert = 'Something went wrong! Please return to search <a href="../search.php">here</a> or use the back button.';
	} else if ($_GET == '' OR $_GET == NULL) {
		$alert = 'Something went wrong! Please return to search <a href="../search.php">here</a> or use the back button.';
	} else  {
		$alert = 'Search - Post View';
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
					<li><a href="../../feed.php">Home</a></li>
					<li><a href="../search.php">Search</a></li>
					<li><a href="../../settings/account/settings.php">Settings</a></li>
                    <li><a href="../../../logout.php?id=<?php echo $row['id'] ?>">Logout</a></li>
				</ul>
			</nav>
		</header>

		<div class="content">
				<div class="container">

					<!-- LEFT NAV BAR -->
					<div class="section section1">
						<div class="title">Post View</div>

						<?php if($_GET['header']) {  ?>

							<div class="links">
								<a href="../../feed.php" class="link">Back to Feed</a>
							</div>

						<?php } else { ?>

							<div class="links">
								<a href="../search.php" class="link">Back to Search</a>
							</div>

						<?php } ?>

					</div>

					<div class="section section2" style="padding-bottom: 20px;">

						<div class="section-title"><?php echo $alert ?></div>

						<!-- POST INFO -->


                        <div class="content-box">
                            <div class="segment1">
                                <div class="result1">
                                    <h2>
                                        <a href="../account/account-view.php?id=<?php echo $post_info['id']; ?>&header=postview&postid=<?php echo $select_post_id; ?>">
                                            View
                                        </a>
                                    </h2>
                                </div>
                            </div>

                            <div class="segment2">
                                <div class="result2">
                                    <h3>Post Creator</h3>
                                    <h2><?php echo $post_info['first_name'].' '.$post_info['last_name']?></h2>
                                </div>
                            </div>
                        </div>

						<div class="content-box">
							<div class="segment full-content">
                                <h4 style="margin-bottom: 10px;"><?php echo $post_info['community']; ?></h1>
                                <h1><?php echo $post_info['title']; ?></h1>
                                <h3><?php echo $post_info['body']; ?></h3>
							</div>
						</div> 


				
						<!-- END POST INFO SECTION -->


						<!--  COMMENT INFO -->
						<div class="content-box" id="comment-show">
							<div class="segment2" style="font-size: 1.30em">Comments:</div>
							<div class="segment1 dropdown" id="comment-dropdown-show">+</div>
						</div>

						<div class="content-box" id="comment-hide" style="margin-bottom: 5px;">
							<div class="segment2" style="font-size: 1.30em">Comments:</div>
							<div class="segment1 dropdown" id="comment-dropdown-hide">&#8212;</div>
						</div>

						<div id="comment-content" style="margin-bottom: 30px;">

                            
							<?php
							if($comment) {
								//ECHO NUMBER OF COMMUNITIES JOINED
								if($comment_count == 1) {
							?>				
									<div class="content-box">
										<div class="full-content">
											This post has one comment.
										</div>
									</div>

							<?php } else if($comment_count > 1) { ?>
									<div class="content-box">
										<div class="full-content">
                                            This post has <?php echo $comment_count; ?> comments.
										</div>
									</div>
							<?php } //IF END BRACKET ?>

                            <?php while($comment_info = $select_comments->fetch(PDO::FETCH_ASSOC)) { ?>
															
                                    <div class="content-box">
                                        <div class="full-content">
                                   
                                        <!-- COMMENT INFO -->

                                            <h2><?php echo $comment_info['username'];?></h2>
                                            <h3>Comment: <?php echo $comment_info['comment']; ?></h3>
                                        </div>        
                                    </div>

                                <?php } //WHILE LOOP END BRACKET ?>

                                <?php } else { ?>

                                    <div class="content-box">
                                        <div class="full-content">
                                            This post has no comments yet!
                                        </div>
                                    </div>
                                            
                                <?php } ?>
                            

						</div>

						<!-- END COMMENT INFO SECTION -->


                        	<!-- DUAL TITLE/DROPDOWN BAR - ONE FOR SHOW/ONE FOR HIDE -->
					<!-- 	<div class="content-box" id="like-user-show" style="margin-bottom: 5px;">
							<div class="segment2" style="font-size: 1.30em">All Likes:</div>
							<div class="segment1 dropdown" id="like-dropdown-show">+</div>
						</div>

						<div class="content-box" id="like-user-hide" style="margin-bottom: 5px;">
						<div class="segment2" style="font-size: 1.30em">All Likes:</div>
							<div class="segment1 dropdown" id="like-dropdown-hide">&#8212;</div>
						</div>

						<div id="like-user-content" style="margin-bottom: 30px;">

                            
							<?php
							/* if($likes) {
								//ECHO NUMBER OF COMMUNITIES JOINED
								if($like_count == 1) { */
							?>				
									<div class="content-box">
										<div class="full-content">
											This post has been liked by one person.
										</div>
									</div>

							<?php /* } else if($like_count > 1) { */ ?>
									<div class="content-box">
										<div class="full-content">
                                            This post has been liked by <?php /* echo $like_count; */ ?> people.
										</div>
									</div>
							<?php /* }  *///IF END BRACKET ?>

                            <?php/*  while($like_user_info = $select_likes->fetch(PDO::FETCH_ASSOC)) { */ ?>
                                                        
                                <div class="content-box">
                                    <div class="segment1">
                                        <div class="result1">
                                            <h2>
                                                <a href="../account/account-view.php?id=<?php /* echo $like_user_info['id']; */ ?>&header=postview&postid=<?php /* echo $select_post_id; */ ?>">
                                                    View
                                                </a>
                                            </h2>
                                        </div>
                                    </div>


                                    <div class="segment2">
                                        <div class="result2">
                                            <h2><?php /* echo $like_user_info['first_name'] .' '. $like_user_info['last_name']; */?></h2>
                                            <h3><?php /* echo $like_user_info['username']; */ ?></h3>
                                        </div>
                                    </div>
                                </div>

                            <?php/* } */ //WHILE LOOP END BRACKET ?>

                            <?php /* } else {  */?>

                                <div class="content-box">
                                    <div class="full-content">
                                        This post has no likes yet!
                                    </div>
                                </div>
                                        
                            <?php /* } */ ?>
                        



						</div>
 -->

						<!-- END  LIKE INFO SECTION -->


					</div>

				</div>	


	

		 
			</div>

		<?php include("../../../includes/footer.html"); ?>

	</div>


   

</body>


</html>   
