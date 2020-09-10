<?php
	date_default_timezone_set('America/Los_Angeles');

	// codigo para entregar los datos ingresados por el usuario a la base de datos 
	if($_POST){
		if ($_POST['action'] == 'addSighting') {
	// filtros para proteger el codigo de datos de entrada alicioso  
			$date = $_POST['sighting_date'] ;
			$type = htmlspecialchars($_POST['creature_type']);
			$distance = htmlspecialchars($_POST['creature_distance']);
			$weight = htmlspecialchars($_POST['creature_weight']);
			$height = htmlspecialchars($_POST['creature_height']);
			$color = htmlspecialchars($_POST['creature_color_rgb']);
			$lat = htmlspecialchars($_POST['sighting_latitude']);
			$long = htmlspecialchars($_POST['sighting_longitude']);
			
			//Validación de los datos ingresados por el usuario
			$my_date = date('Y-m-d', strtotime($date));
			
			if($type == ''){
				$type = "Other";
			}
			
			//sentensia para ingresar un nuevo criptido a la base de datos
			$query = "INSERT INTO sightings (sighting_date, creature_type, creature_distance, creature_weight, creature_height, creature_color, sighting_latitude, sighting_longitude) ";
			$query .= "VALUES ('$my_date', '$type', '$distance', '$weight', '$height', '$color', '$lat', '$long') ";

			$result = db_connection($query);
			
			//Validación del exito o falla del ingreso de los datos
			if ($result) {
				$msg = "Creature added successfully";
				success($msg);
			} else {
				fail('Insert failed.');
			}
			exit;
		}
	}

	//Funcion para realizar la coneccion entre php y la base de datos
    function db_connection($query) {
    	$con = mysqli_connect('**************','***********','**********','**********') 
    	OR die( 'Could not connect to database.');
    	//Retorna los resultados de la solicitud SELECT de la base de datos.
    	return mysqli_query($con, $query);
    }
	
	//Función para reportar errores en la conversion de la matriz de datos
	function fail($message) {
		die(json_encode(array('status' => 'fail', 'message' => $message)));
	}

	//Función para reportar el exito de la conversion de la matriz de datos
	function success($message) {
		die(json_encode(array('status' => 'success', 'message' => $message)));
	}
?>