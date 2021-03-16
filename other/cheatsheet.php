<html>

<h1>CHEAT SHEET PAGE</h1>
<h2 color="blue">Probably won't print anything tho</h2>

<?php



//a bunch of stuff that I will probably forget about

///

data_default_timezone_set("UTC");

// Prints the day, date, month, year, time, AM or PM
echo date("l jS \of F Y h:i:s A");

/* 
d - The day of the month (from 01 to 31)
D - A textual representation of a day (three letters)
j - The day of the month without leading zeros (1 to 31)
S - The English ordinal suffix for the day of the month (2 characters st, nd, rd or th. Works well with j)
w - A numeric representation of the day (0 for Sunday, 6 for Saturday)
z - The day of the year (from 0 through 365)
F - A full textual representation of a month (January through December)
m - A numeric representation of a month (from 01 to 12)
M - A short textual representation of a month (three letters)
n - A numeric representation of a month, without leading zeros (1 to 12)
t - The number of days in the given month
Y - A four digit representation of a year
y - A two digit representation of a year
a - Lowercase am or pm
A - Uppercase AM or PM
*/


///


//Good for data handling instead of doing a bunch of if statements yk

$var = "Abdi";

switch ($var) {
	case 'Abdi':
		echo "<h4>Variable equals Abdi!</h6>";
		break;
	
	default:
		echo "YERRRRR";
		break;
}

//Good for display stuff after u put in it in array and assigned variables

$randomarray = array("Abdi" => $FirstName, "Nur" => $LastName);

foreach ($randomarray as $key => $value){
	echo $key.":".$value;
}

//

$another_array = array(
	array("Abdi", "Nur", 16),
	array("Jake", "Long", "Dragon"),
	array("Harry", "Potter", 17)
);

for($row = 0; $row => 3; $row++){
	for ($col=0; $col => 3; $col++) { 
		echo $another_array[$col][$row];
	}
}

?>

</html>