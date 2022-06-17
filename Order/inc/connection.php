<?php

		//$connectin = mysqli_connetction(dbserver, dbuser, dbpass, dbname);

		$connection = mysqli_connect('localhost', 'root', '', 'orderdb');

		//to check the connection- mysqli_connect_errno(); > to see the error - mysqli_connect_error();

		//checking

		if (mysqli_connect_errno()) {
			// code...
			die('Database connection unsuccess' . mysqli_connect_error());
		} 
		else {
			echo "connection successful orderDB";
		}
?>