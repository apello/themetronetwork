<?php 
    session_start();

    require_once("../../includes/db.php");
    require_once("../../includes/auth-check.php");
    require_once("../../includes/session-check.php");

    $_SESSION['LAST_ACTIVITY'] = time();

?>


<html>

<head>
    <!-- link to stylesheet -->
    <title>Search</title>
    <link href="../../css/main-style.css" rel="stylesheet" type="text/css">
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
                    <li><a href="../feed.php">Home</a></li>
                    <li>Search</li>
                    <li>Communities</li>
                    <li><a href="../settings/account/settings.php">Settings</a></li>
                    <li><a href="../../logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <div class="content">
      
                <div class="container">

                    <div class="section section1">

                        <div class="search">
                            <div class="alert">Missing Value</div>
                            <input type="text" placeholder="Search here:"/>
                            <input type="submit" name="submit" class="submit-btn" value="Go">
                        </div>

                    </div>

                <div class="section section2">

                    <div class="content-box">
                        <div class="full-content">
                            <h3 align="center">Results for: Green Boy</h3>
                        </div>
                    </div>

                    <div class="content-box">
                        <div class="full-content">
                            <h1>Posts</h1>
                        </div>
                    </div>

                    <div class="content-box">
                            <div class="segment1">
                                <div class="result1">
                                    <h2>View More</h2>
                                </div>
                            </div>

                            <div class="segment2">
                                <div class="result2">
                                    <h1>Abdirahman Nur</h1>
                                    <h3>Student</h3>
                                </div>
                            </div>
                    </div>


                    <div style="margin-top:20px;" class="content-box">
                        <div class="full-content">
                            <h1>Communities</h1>
                        </div>
                    </div>

                    <div class="content-box">
                            <div class="segment1">
                                <div class="result1">
                                    <h2>View More</h2>
                                </div>
                            </div>

                            <div class="segment2">
                                <div class="result2">
                                    <h1>Algebra 2</h1>
                                    <h3>Carol Van Fossen</h3>

                                </div>
                            </div>
                    </div>

                    <div style="margin-top:20px;" class="content-box">
                        <div class="full-content">
                            <h1>Posts</h1>
                        </div>
                    </div>

                    <div class="content-box">
                            <div class="segment1">
                                <div class="result1">
                                    <h2>View More</h2>
                                </div>
                            </div>

                            <div class="segment2">
                                <div class="result2">
                                    <h3>Post by Abdirahman Nur</h3>
                                    <h1>What is that</h1>
                                    <h4>
                                        Lorem ipsum dolor sit amet, consectetur... <h5>See More</h5>
                                    </h4>

                                </div>
                            </div>
                    </div>


                

                </div>
            </div>

         

                
         
        </div>

        <footer>
            <h1>The Metro Network</h1>
            <h1>Created by Abdirahman Nur</h1>

        </footer>
    </div>


   

</body>


</html>   
