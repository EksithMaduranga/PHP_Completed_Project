<?php  session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>
<?php 

	if (!isset($_SESSION['EmpId'])) {
		header('Location: index.php');
		// code...
	}

	$errors = array();
	$recNo = '';
	$recType = '';
	$ammount = '';
	$EmpId = '';
	$dateofrecord = '';
	$password = '';


	if (isset($_POST['submit'])) {

		$recNo =$_POST['recNo'];
		$recType =$_POST['recType'];
		$ammount =$_POST['ammount'];
		$EmpId =$_POST['EmpId'];
		$dateofrecord =$_POST['dateofrecord'];
		$password =$_POST['password'];

		// checking requierd fields
		$req_fields = array('recNo', 'recType', 'ammount', 'EmpId', 'dateofrecord', 'password');

		//looking function.php - check_req_fields function
		$errors = array_merge($errors, check_req_fields($req_fields)) ;

		//Checking if Record num alredy exist
		//Senitize record number- for priventing from the "sql injection"
		$recNo = mysqli_real_escape_string($connection, $_POST['recNo']);
		$query = "SELECT * FROM finance WHERE recNo = '{$recNo}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		//check db que
		if ($result_set) {
			if(mysqli_num_rows($result_set) == 1) {
				$errors[] = 'Finance Record number alredy exist in the DataBase';
			}

		}

		if (empty($errors)) {
			// No error found - execute
			// 1. Record num alredy sanitized
			$recType = mysqli_real_escape_string($connection, $_POST['recType']);
			$ammount = mysqli_real_escape_string($connection, $_POST['ammount']);
			$EmpId = mysqli_real_escape_string($connection, $_POST['EmpId']);
			$dateofrecord = mysqli_real_escape_string($connection, $_POST['dateofrecord']);
			$password = mysqli_real_escape_string($connection, $_POST['password']);

			$query = "INSERT INTO finance ( ";
			$query .= "recNo, recType, ammount, EmpId, dateofrecord, password, is_deleted" ;
			$query .= ") VALUES (";
			$query .= "'{$recNo}', '{$recType}', '{$ammount}','{$EmpId}','{$dateofrecord}','{$password}', 0";
			$query .= ")";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// Que Succsess... Redirect to the finance page
				header('Location: finance.php?user_added= true');
			} else {
				$errors[] = 'Failed to add new record...';
			}

		}

	}

?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add New Finance</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="all" />
      <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" media="all" />
      <link rel="stylesheet" type="text/css" href="css/animate.min.css" media="all" />
      <link rel="stylesheet" type="text/css" href="css/font-pizzaro.css" media="all" />
      <link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
      <link rel="stylesheet" type="text/css" href="css/red.css" media="all" />
      <link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.min.css" media="all" />
      <link rel="stylesheet" type="text/css" href="css/head2.css" media="all" />   
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CYanone+Kaffeesatz:200,300,400,700" rel="stylesheet">

</head>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<body>
	<header>
		<div class="appname">Finance Managemnet System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['EmpId']; ?>! <a href="logout.php">Log Out</a></div>
	</header>
	<main>
		<h1>Add New Finance<span><a href="finance.php">back to Finance List</a></span></h1>

		<?php 
			if (!empty($errors)) {
				echo '<div class="errmsg">';
				echo '<b>There were error(s) in form.</b><br>';
				foreach ($errors as $error) {
					echo $error . '<br>';
				}
				echo '</div>';
				// code...
			}
		?>
		
			<form action="add-finance.php" method="post" class="financeform">
				<p>
					<label for="">Record Number:</label>
					<input type="text" name="recNo" maxlength="10" <?php echo 'value = "' . $recNo. '"'; ?>>
				</p>
				
				<p>
					<label for="recType" >Record Type:</label>

					 <select name="recType" <?php echo 'value = "' . $recType. '"'; ?>>
					 	<option value="Diliver Ammount">Diliver Ammount</option>
					  <option value="Total Emplooyee Cost">Total Emplooyee Cost</option>
					  <option value="Total Order Cost">Total Order Cost</option>
					  <option value="Other">Other</option>
					  
					</select>
				</p>

				<p>
					<label for="">Ammount:</label>
					<input type="text" name="ammount" placeholder="10000.00" maxlength="16" <?php echo 'value = "' . $ammount. '"'; ?>>
				</p>

				<p>
					<label for="">Authorized Emplooyee ID:</label>
					<input type="text" name="EmpId" maxlength="10" <?php echo 'value = "' . $EmpId. '"'; ?>>
				</p>

				<p>
					<label for="">Date of Record:</label>
					<input type="Date" name="dateofrecord"  <?php echo 'value = "' . $dateofrecord. '"'; ?>>
				</p>

				<p>
					<label for="">Password:</label>
					<input type="password" name="password" maxlength="24" >
				</p>

				<p>
					<label for="">&nbsp;</label>
					<button type="submit" name="submit">Save</button>
				</p>

				





			</form>
		

	</main>

</body>
</html>