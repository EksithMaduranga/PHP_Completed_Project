<?php  session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>

<?php  
	//Check for Form submition
if (isset($_POST['submit'])) {
	// code...
	$errors = array();


		//Check username pass hass been enterd
	if (! isset($_POST['EmpId']) || strlen(trim($_POST['EmpId'])) < 1) {
		// code...
		$errors[] = 'EmpId is missing / Invalid';

	}

	if (! isset($_POST['password']) || strlen(trim($_POST['password'])) < 1) {
		// code...
		$errors[] = 'password is missing / Invalid';

	}
	

	//Check if therr are any errors
	if (empty($errors)) {
		
		//save username and pass into var
		$EmpId 		= mysqli_real_escape_string($connection, $_POST['EmpId']);
		$password 	= mysqli_real_escape_string($connection, $_POST['password']);


		//prepare database queiry
		$query = "SELECT * FROM finance
					WHERE EmpId = '{$EmpId}'
					AND password = '{$password}' 
					LIMIT 1";

		$result_set = mysqli_query($connection, $query);
		if ($result_set) {
			// query sucsess...
			if (mysqli_num_rows($result_set) == 1 ) {
			//check user is valid
				$finance = mysqli_fetch_assoc($result_set);
				$_SESSION['finance_id'] = $finance['id'];
				$_SESSION['EmpId'] = $finance['EmpId'];
				
				/*// updating last login
				$query = "UPDATE finance SET dateofrecord = NOW()";
				$query .= "WHERE id = {$_SESSION['finance_id']} LIMIT 1";

				$resultset = mysqli_query($connection, $query);

				if (!$result_set){
					die("Database query failed...")
				}
				*/

				//redirect to finance.php
				header('Location: finance.php');

			} else{
				$errors[] = 'Invalide Emplooyee ID / Password';
			}

		} else {
			$errors[] = 'Invalide DB que';
		}
		

		

		

		//if not, display the erorr
	}

		

}


?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Log In - Finance Management</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div class="login">

		<form action="index.php" method="post">
			<fieldset>
				<legend><h1>Log In</h1></legend>
				<?php  
					if (isset($errors) && !empty($errors)) {
						echo '<p class="error">Invalide Emplooyee Id / Password</p>';
						// code...


					}
				?>
				<?php 
					if (isset($_GET['logout'])) {
						// code...
						echo '<p class="info">You have succesefully logout from the system</p>';
					}
				?>


				<p>
					<label for="">Emplooyee Id</label>
					<input type="text" name="EmpId" id="" placeholder="Emplooyee Id : Ex:- Fin001">
				</p>

				<p>
					<label for="">Password</label>
					<input type="Password" name="password" id="" placeholder="Password">
				</p>

				<p>
					<button type="submit" name="submit">Log In</button>
				</p>
			</fieldset>
			
		</form>
		

	</div>

</body>
</html>

<?php mysqli_close($connection); ?>