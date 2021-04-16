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
	<title>Account View All</title>
	<link href="../../../css/main-style.css" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	  
</head>

<?php


	$alert;


	
    if ($_POST['query'] == '' OR $_POST['query'] == NULL) {
		$alert = 'Something went wrong! Please return to search <a href="../search.php">here</a> or use the back button.';
	} else if ($_POST == '' OR $_POST == NULL) {
		$alert = 'Something went wrong! Please return to search <a href="../search.php">here</a> or use the back button.';
	} else  {
		$alert = 'See All Results:';
	}

    //WRITE FUNC FOR BOTH ON REG ACCOUNT VIEW

    //SEARCH QUERY
    $search_input = $_POST['query'];

    $search_query = "SELECT id,
                            first_name,
                            last_name,
                            username,
                            position 
                    FROM users 
                    WHERE first_name LIKE :input 
                    OR last_name LIKE :input
                    OR username LIKE :input";
    $search = $conn->prepare($search_query);

    //to get around wildcard issue, have to declare var with wildcards
    $query = "$search_input%";

    $search->bindParam(":input", $query);
    
    $search->execute();

    if($search->rowCount() > 0) {
        $results = TRUE;
    } else {
        $results = FALSE;
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
						<div class="title">Search Results</div>

						<div class="links">
							<a href="../search.php" class="link">Back to Search</a>
						</div>
					</div>

					<div class="section section2">

						<div class="section-title"><?php echo $alert ?></div>

                        <?php 

                            if($results) {

                                $count = $search->rowCount();
                                
                                if($count > 0) {
                                    echo '<div class="content-box">
                                    <div class="full-content">
                                        <h3 align="center">'.$count.' result[s] for: '.$search_input.'</h3>
                                    </div>
                                    </div>';
                                } else {
                                    echo '<div class="content-box">
                                    <div class="full-content">
                                        <h3 align="center">0 results for: '.$search_input.'</h3>
                                    </div>
                                    </div>';
                                }

                                while($row = $search->fetch(PDO::FETCH_ASSOC)) {

                        ?>
                                 <!-- CONTENT BOX  - RESULT OUTPUT -->
                                    <div class="content-box">
                                        <div class="segment1">
                                            <div class="result1">
                                                <h2>                
                                                    <a href="account-view.php?id=<?php echo $row['id']; ?>">
                                                        View
                                                    </a>
                                                </h2>
                                            </div>
                                        </div>
            
                                        <div class="segment2">
                                            <div class="result2">
                                                <h2><?php echo $row['first_name'].' '.$row['last_name']?></h2>
                                                <h3><?php echo $row['username']. ' - ' .ucwords($row['position'])?></h3>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        
                        ?>
					
					</div>

				</div>
		 
			</div>

		<?php include("../../../includes/footer.html"); ?>

	</div>


   

</body>


</html>   
