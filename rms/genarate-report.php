<?php  session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



<!DOCTYPE html>
<?php 
	//Checking if a user is logged in
	if (!isset($_SESSION['EmpId'])) {
		header('Location: index.php');
		// code...
	}

	$finance_list = '';

	//get the list of finance
	if (isset($_GET['search'])) {
		// code...
		$search = mysqli_real_escape_string($connection, $_GET['search']);
			$query = "SELECT * FROM finance WHERE (recNo LIKE '%{$search}%' OR recType LIKE '%{$search}%' OR EmpId LIKE '%{$search}%') AND is_deleted=0 ORDER BY EmpId";
	} else {
			$query = "SELECT * FROM finance WHERE is_deleted=0 ORDER BY EmpId";

	}

	
	$finances = mysqli_query($connection, $query);

	
	verify_query($finances);
	//if ($finances) 
	{
		// code...
		while ($finance = mysqli_fetch_assoc($finances)) {
			// code...
			$finance_list .="<tr>";

				$finance_list .="<td>{$finance['recNo']}</td>";
				$finance_list .="<td>{$finance['recType']}</td>";
				$finance_list .="<td>{$finance['ammount']}</td>";
				$finance_list .="<td>{$finance['EmpId']}</td>";
				$finance_list .="<td>{$finance['dateofrecord']}</td>";
				
				

			$finance_list .="</tr>";
		}

	}
	
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Finance</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CYanone+Kaffeesatz:200,300,400,700" rel="stylesheet">
  <link rel="shortcut icon" href="image/fav-icon.png">

	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" media="all" />
</head>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<body>

	<header>


		<div class="appname">Finance Managemnet System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['EmpId']; ?>! <a href="logout.php">Log Out</a></div>
		


	</header>
	<main>


		<h1>Finance<span><a href="add-finance.php">Add New Finance</a> | <a href="index2.php">Back To Finance Main Page</a></span></h1>
		<div class="search">
			<form action="genarate-report.php" method="get">
				<p>
					<input type="text" name="search" placeholder="Enter Record No, Record Type Or Emplooyee ID" required autofocus>
				</p>
			</form>

		</div>
		
		<table class="masterlist">
			<tr>
				<th>Record Number</th>
				<th>Record Type</th>
				<th>Ammount</th>
				<th>Authorized Emplooyee ID</th>
				<th>Date of the record</th>
				
			</tr>

			<?php echo $finance_list;?>

			<button onclick="window.print();" class="btn btn-primary" id="print-btn">Print</button>
		</table>

	</main>



</body>
</html>