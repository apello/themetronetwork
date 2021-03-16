<!-- basic skill test -->

<html>
	
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="index.css">
</head>

<style type="text/css">
	input {
		display: block;
		margin: 5px;
	}

</style>


<body>

	<h1>PHP Calculator!</h1>
	
	<form action="calculator.php" method="post">
		Enter first number here:	<input type="number" name="number1">
		Enter operation here (+, - , /, *): <input type="text" name="operator">
		Enter second number here:	<input type="number" name="number2">
		<input type="submit" name="submit">

	</form>

<?php

	$number1 = $_POST["number1"];
	$number2 = $_POST["number2"];
	$operator = $_POST["operator"];
	$return = 0;

	


	if(isset($_POST["submit"])){
		if($operator == "+"){
			$return = $number1 + $number2;
		} elseif ($operator == "-"){
			$return = $number1 - $number2;
		} elseif ($operator == "/"){
			$return = $number1 / $number2;
		} elseif ($operator == "*"){
			$return = $number1 * $number2;
		}

		echo "<h1>The result of " . $number1 . " " . $operator . " " . $number2 . " is " . $return . ".</h1>";
	}

?>


</body>


</html>