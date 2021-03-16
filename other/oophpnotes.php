<!DOCTYPE html>
<html>
<head>
	<title>OO PHP</title>
</head>
<body>

<?php

	class Animal {

		//protected -> similar to private, however subclasses (classes that aren't in the initial class) can also change elements of the class

		//public -> any piece of code can change elements of the class

		//private -> only methods or functions inside the class can change elements of the class

		//example of declaring variable

		protected $name;
		protected $favorite_food;
		protected $sound;
		protected $id;

		//static attributes are constant for every subclass. in this example, the $number_of_animals will be the same for all sublcasses

		public static $number_of_animals = 0;

		//to alter statics, call class name along with two colons along with the name of the static variable --> Animal::$number_of_animals = ?;

		//const (constants) never change

		const PI = "3.14159";

		//to call constants, call class name along with two colons along with the name of the static variable --> echo Animal::PI;


		function getName() {

			//if any piece of code not related to this class wants to use information from class Animal, they have to call the functions in the class, or in this case, getName();

			return $this->name;

			//$this is used as a generic placeholder for the name of variables to protect that data from being altered from outside to class.
		}

		//anything with an underscore is a magic function

		function __construct() {

			//construct functions is initializes variable i.e. adds data

			$this->id = rand(100,1000000);
			echo $this->id . " has been assigned.<br/>";

			Animal::$number_of_animals++;
		}

		public function __destruct() {

			//called when all references to an object is being reset

			echo $this->name . " is being destroyed.<br/>"; 

		}

		function __get($name) {

			//__get functions retrieve information from protected variables

			echo "Asked for " . $name . ".<br/>";

			return $this->name;
		}

		function __set($name, $value) {
			switch($name){
				case "name":
					$this
			}
		}



	}


?>

</body>
</html>
