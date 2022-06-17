<?php  session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>
<?php 

	if (!isset($_SESSION['EmpId'])) {
		header('Location: index.php');
		// code...
	}

	$errors = array();
	$finance_id = '';
	$recNo = '';
	$recType = '';
	$ammount = '';
	$EmpId = '';
	$dateofrecord = '';
	$password = '';

	if (isset($_GET['finance_id'])) {
		// Getting user info...
		$finance_id = mysqli_real_escape_string($connection, $_GET['finance_id']);
		$query = "SELECT * FROM finance WHERE id = {$finance_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				// Finance Found...
				$result = mysqli_fetch_assoc($result_set);
				$recNo = $result['recNo'];
				$recType = $result['recType'];
				$ammount = $result['ammount'];
				$EmpId = $result['EmpId'];
				$dateofrecord = $result['dateofrecord'];
				$password = $result['password'];

			} else {
				//Finance Not Found
				header('Location: finance.php?user_not_found');
			}
			
		} else {
			// que umsuccessful
			header('Location: finance.php?err=query_failed');
		}


	}


	if (isset($_POST['submit'])) {

		$finance_id =$_POST['finance_id'];
		$recNo =$_POST['recNo'];
		$recType =$_POST['recType'];
		$ammount =$_POST['ammount'];
		$EmpId =$_POST['EmpId'];
		$dateofrecord =$_POST['dateofrecord'];
		

		// checking requierd fields
		$req_fields = array('finance_id', 'recNo', 'recType', 'ammount', 'EmpId', 'dateofrecord');

		//looking function.php - check_req_fields function
		$errors = array_merge($errors, check_req_fields($req_fields)) ;

		//Checking if Record num alredy exist
		//Senitize record number- for priventing from the "sql injection"
		$recNo = mysqli_real_escape_string($connection, $_POST['recNo']);
		$query = "SELECT * FROM finance WHERE recNo = '{$recNo}' AND id != {$finance_id} LIMIT 1";

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
			

			$query = "UPDATE finance SET ";
			$query .= "recNo = '{$recNo}',";
			$query .= "recType = '{$recType}',";
			$query .= "ammount = '{$ammount}',";
			$query .= "EmpId = '{$EmpId}',";			
			$query .= "dateofrecord = '{$dateofrecord}'";
			$query .= "WHERE id = {$finance_id} LIMIT 1";


			$result = mysqli_query($connection, $query);

			if ($result) {
				// Que Succsess... Redirect to the finance page
				header('Location: finance.php?user_modified= true');
			} else {
				$errors[] = 'Failed to modify the record...';
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
	<title>View/Modify Finance</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<header>
		<div class="appname">Finance Managemnet System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['EmpId']; ?>! <a href="logout.php">Log Out</a></div>
	</header>
	<main>
		<h1>View/Modify Finance<span><a href="finance.php">back to Finance List</a></span></h1>

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
		
			<form action="modify-finance.php" method="post" class="financeform">
				<input type="hidden" name="finance_id" value="<?php echo $finance_id?>">
				<p>
					<label for="">Record Number:</label>
					<input type="text" name="recNo" maxlength="10" <?php echo 'value = "' . $recNo. '"'; ?>>
				</p>
				oop
				<p>
					<label for="">Record Type:</label>
					<input type="text" name="recType" maxlength="16" <?php echo 'value = "' .$recType . '"'; ?>>
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
					<span>**********</span> | <a href="change-password.php?finance_id=<?php echo $finance_id; ?>">Change Password</a>
				</p>

				<p>
					<label for="">&nbsp;</label>
					<button type="submit" name="submit">Save</button>
				</p>

				





			</form>
		

	</main>

</body>
</html>