
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>
<?php 



	$errors = array();

	$order_id = '';
	$cusName = '';
	$conNo = '';
	$dilAddr = '';
	$dDate = '';
	$foodOrder = '';
	$flavor = '';
	$type = '';
	$quntity = '';
	$price = '';

	if (isset($_GET['order_id'])) {
		// Getting user info...
		$order_id = mysqli_real_escape_string($connection, $_GET['order_id']);
		$query = "SELECT * FROM orderdb.order WHERE id = {$order_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				// Finance Found...
				$result = mysqli_fetch_assoc($result_set);

				
				$cusName = $result['cusName'];
				$conNo = $result['conNo'];
				$dilAddr = $result['dilAddr'];
				$dDate = $result['dDate'];
				$foodOrder = $result['foodOrder'];
				$flavor = $result['flavor'];
				$type = $result['type'];
				$quntity = $result['quntity'];
				$price = $result['price'];

			} else {
				//Finance Not Found
				header('Location: order.php?order_not_found');
			}
			
		} else {
			// que umsuccessful
			header('Location: order.php?err=query_failed');
		}


	}


	if (isset($_POST['submit'])) {

				$order_id = $_POST['order_id'];
				$cusName = $_POST['cusName'];
				$conNo = $_POST['conNo'];
				$dilAddr = $_POST['dilAddr'];
				$dDate = $_POST['dDate'];
				$foodOrder = $_POST['foodOrder'];
				$flavor = $_POST['flavor'];
				$type = $_POST['type'];
				$quntity = $_POST['quntity'];
				$price = $_POST['price'];
		

		// checking requierd fields

				//order_id.
		$req_fields = array('order_id', 'cusName', 'conNo', 'dilAddr', 'dDate', 'foodOrder', 'flavor', 'type', 'quntity', 'price');

		//looking function.php - check_req_fields function
		$errors = array_merge($errors, check_req_fields($req_fields)) ;

		//Checking if Record num alredy exist
		//Senitize record number- for priventing from the "sql injection"
		$cusName = mysqli_real_escape_string($connection, $_POST['cusName']);
		$query = "SELECT * FROM orderdb.order WHERE cusName = '{$cusName}'AND id != {$order_id} LIMIT 1";

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
			$cusName = mysqli_real_escape_string($connection, $_POST['cusName']);
			$conNo = mysqli_real_escape_string($connection, $_POST['conNo']);
			$dilAddr = mysqli_real_escape_string($connection, $_POST['dilAddr']);
			$dDate = mysqli_real_escape_string($connection, $_POST['dDate']);
			$foodOrder = mysqli_real_escape_string($connection, $_POST['foodOrder']);
			$flavor = mysqli_real_escape_string($connection, $_POST['flavor']);
			$type = mysqli_real_escape_string($connection, $_POST['type']);
			$quntity = mysqli_real_escape_string($connection, $_POST['quntity']);
			$price = mysqli_real_escape_string($connection, $_POST['price']);
			

			$query = "UPDATE orderdb.order SET ";

			//$query .= "recNo = '{$recNo}',";
			$cusName .= "cusName = '{$cusName}',";
			$conNo .= "conNo = '{$conNo}',";
			$dilAddr .= "dilAddr = '{$dilAddr}',";
			$dDate .= "dDate = '{$dDate}',";
			$foodOrder .= "foodOrder = '{$foodOrder}',";
			$flavor .= "flavor = '{$flavor}',";
			$type .= "type = '{$type}',";
			$quntity .= "quntity = '{$quntity}',";
			$query .= "price = '{$price}'";
			$query .= "WHERE id = {$order_id} LIMIT 1";


			$result = mysqli_query($connection, $query);

			if ($result) {
				// Que Succsess... Redirect to the order page
				header('Location: order.php?user_modified= true');
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
	<title>View/Modify Order</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<header>
		<div class="appname">Order Managemnet System</div>
		<div class="loggedin">Welcome </div>
	</header>
	<main>
		<h1>View/Modify Order<span><a href="order.php">back to Order List</a></span></h1>

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
		
			<form action="modify-order.php" method="post" class="financeform">
				<input type="hidden" name="order_id" value="<?php echo $order_id?>">


				<p>
					 <label for="">Customer Name</label>
					<input type="text" name="cusName" maxlength="50" <?php echo 'value = "' . $cusName. '"'; ?>>
				</p>

				<p>
					 <label for="">Contact Number:</label>
					<input type="text" name="conNo" maxlength="16" <?php echo 'value = "' . $conNo. '"'; ?>>
				</p>

				<p>
					 <label for="">Diliver Address:</label>
					<input type="text" name="dilAddr" maxlength="64" <?php echo 'value = "' . $dilAddr. '"'; ?>>
				</p>

				<p>
					 <label for="">Order Date:</label>
					<input type="date" name="dDate"  <?php echo 'value = "' . $dDate. '"'; ?>>
				</p>

				<p>
					 <label for="">Food Order:</label>
					<input type="text" name="foodOrder" maxlength="24" <?php echo 'value = "' . $foodOrder. '"'; ?>>
				</p>

				<p>
					 <label for="">Flavour:</label>
					<input type="text" name="flavor" maxlength="24" <?php echo 'value = "' . $flavor. '"'; ?>>
				</p>

				<p>
					 <label for="">Type:</label>
					<input type="text" name="type" maxlength="16" <?php echo 'value = "' . $type. '"'; ?>>
				</p>

				<p>
					 <label for="">Quantity:</label>
					<input type="text" name="quntity" maxlength="3" <?php echo 'value = "' . $quntity. '"'; ?>>
				</p>

				<p>
					 <label for="">Price:</label>
					<input type="text" name="price" maxlength="16" <?php echo 'value = "' . $price. '"'; ?>>
				</p>






				<p>
					<label for="">&nbsp;</label>
					<button type="submit" name="submit">Save</button>
				</p>

				





			</form>
		

	</main>

</body>
</html>