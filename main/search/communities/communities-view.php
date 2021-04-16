<?php 
	session_start();

	require_once("../../../includes/db.php");
	require_once("../../../includes/auth-check.php");
	require_once("../../../includes/session-check.php");

	require_once("community-view-select.php");

    $_SESSION['LAST_ACTIVITY'] = time();

?>


<html>

<head>
	<!-- link to stylesheet -->
	<title>Communities View</title>
	<link href="../../../css/main-style.css" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	  
</head>

<?php
	$alert;

	if($_GET['alert'] == 'error') {
		$alert = 'Something went wrong! Please return to search <a href="../search.php">here</a> or use the back button.';
    } else if(!$communities) {
		$alert = 'Something went wrong! Please return to search <a href="../search.php">here</a> or use the back button.';
	} else if ($_GET['alert'] == 'joined') {
		$alert = 'You have successfully joined '. $community_info['class_name'].'!';
	} else if ($_GET['alert'] == 'left') {
		$alert = 'You have successfully left '. $community_info['class_name'].'!';
	} else if ($_GET['id'] == '' OR $_GET['id'] == NULL) {
		$alert = 'Something went wrong! Please return to search <a href="../search.php">here</a> or use the back button.';
	} else if ($_GET == '' OR $_GET == NULL) {
		$alert = 'Something went wrong! Please return to search <a href="../search.php">here</a> or use the back button.';
	} else  {
		$alert = 'Communities View';
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
						<div class="title">Communities</div>

						<?php if($_GET['header']) {  ?>
							
							<div class="links">
								<a href="../../settings/communities/communities.php" class="link">Back to Settings</a>
							</div>

						<?php } else { ?>

							<div class="links">
								<a href="../search.php" class="link">Back to Search</a>
							</div>

						<?php } ?>

					</div>

					<div class="section section2" style="padding-bottom: 20px;">

						<div class="section-title"><?php echo $alert ?></div>
                        
                        <?php if($communities) { ?>

                            <!-- USER INFO -->
                            <div class="content-box">
                                <div class="full-content">
                                    <h1 align="center"><?php echo $community_info['class_name']; ?></h1>
                                </div>
                            </div> 

                            <div class="content-box">
                                <div class="full-content">
                                    <h3>Teacher: <?php echo $community_info['class_proctor']; ?></h3>
                                </div>
                            </div>


                            <div class="content-box">
                                <div class="full-content">
                                    <h3>Contact Info: <a href="mailto:<?php echo $community_info['contact_information']; ?>"><?php echo $community_info['contact_information']; ?></a></h3>
                                </div>
                            </div>
                        <?php } ?>    

						<!-- END COMM INFO SECTION -->

					</div>

				</div>	


                        <!-- ADD BTN -->

						
						<?php if($comm_member) { ?>

                        <form action="communities-view-form.php" method="post">


                            <button class="outer-button unfriend">
                                <img id="unfriend" src="../../../pictures/delete-friend.png">      
                            </button>
                            
                            <input type="hidden" name="unadd" value="<?php echo $_GET['id']; ?>">
                            <input type="hidden" name="userid" value="<?php echo $row['id']; ?>">

							<!-- header from settings -->
							<?php if(isset($_GET['header'])) { ?>
								<input type="hidden" name="header" value="<?php echo $_GET['header']; ?>">
							<?php } //END IF BRACKET ?>

                        </form>

                        <!-- IF NOT FRIENDS AND NOT USER'S OWN ACCOUNT -->

                        <?php } else { ?>

                        <form action="communities-view-form.php" method="post">

                            <button class="outer-button add">
                                <img id="friend" src="../../../pictures/plus.png">      
                            </button>
                                                    
                            <input type="hidden" name="add" value="<?php echo $_GET['id']; ?>">
                            <input type="hidden" name="userid" value="<?php echo $row['id']; ?>">

							<!-- header from settings -->
							<?php if(isset($_GET['header'])) { ?>
								<input type="hidden" name="header" value="<?php echo $_GET['header']; ?>">
							<?php } //END IF BRACKET ?>


                        </form>

                        <?php } //END IF BRACKET ?>

				<!-- END BTNS -->


		 
			</div>

		<?php include("../../../includes/footer.html"); ?>

	</div>


   

</body>


</html>   
