<?php 
	function verify_query($result_set){
		global $connection;

		if (!$result_set) {
			// code...
			die("Database Query Failed: " . mysqli_error($connection));
		}

	}

	function check_req_fields($req_fields) {
		//check req fieds
		$errors = array();

		foreach ($req_fields as  $field) {

			if (empty(trim($_POST[$field]))) {
			$errors[] = $field . '  is requierd';
		}
		}
		return $errors;
	}



?>