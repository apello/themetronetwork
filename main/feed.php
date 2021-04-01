<?php 
    //dont forget db is included auth-check
    session_start();

    require_once("../includes/db.php");
    require_once("../includes/auth-check.php");
    require_once("../includes/session-check.php");

    $_SESSION['LAST_ACTIVITY'] = time();
?>


<html>


<head>
    <!-- link to stylesheet -->
    <title>Home</title>
    <link href="../css/main-style.css" rel="stylesheet" type="text/css">
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
                    <li>Home</li>
                    <li><a href="search/search.php">Search</a></li>
                    <li>Communities</li>
                    <li><a href="settings/account/settings.php">Settings</a></li>
                    <li><a href="../logout.php">Logout</a></li>

                </ul>
            </nav>
        </header>

        <div class="content">

            <div class="container"></div>

      
            <div class="container" style="display: none;">
                

                <div class="section section1">

                <div class="title">Hi, <?php echo $row['first_name']; ?>!</div>

                <div class="links">
                    <div class="link" style="background-color: rgba(50, 231, 255, 0.7);">Communities</div>
                    <div class="link">English 12</div>
                    <div class="link">Algebra 1</div>
                </div>

                </div>

                <div class="section section2">

                    <div class="section-title">Posts - Scroll:</div>

                    <div class="content-box">
                        
                        <div class="segment segment1">
                            <button class="heart-outline"></button>
                            <button class="heart-filled"></button>
                            <button class="comment"></button>
                        </div>

                        <div class="segment segment2">

                            <h1>Abdirahman Nur</h1>
                            <h3>Lorem ipsum dolor sit amet, </h3>

                        </div>

                    </div> 

                </div> 

            </div>  


        </div>

            <?php include("../includes/footer.html"); ?>

    </div>


   

</body>


</html>   

