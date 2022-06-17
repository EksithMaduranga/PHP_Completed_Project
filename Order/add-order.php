
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>
<?php 



	$errors = array();

	
	$cusName = '';
	$conNo = '';
	$dilAddr = '';
	$dDate = '';
	$foodOrder = '';
	$flavor = '';
	$type = '';
	$quntity = '';
	$price = '';
	


	if (isset($_POST['submit'])) {

	
		$cusName =$_POST['cusName'];
		$$conNo =$_POST['conNo'];
		$dilAddr =$_POST['dilAddr'];
		$dDate =$_POST['dDate'];
		$foodOrder =$_POST['foodOrder'];
		$flavor =$_POST['flavor'];
		$type =$_POST['type'];
		$quntity =$_POST['quntity'];
		$price =$_POST['price'];
		

		// checking requierd fields
		$req_fields = array('cusName', 'conNo', 'dilAddr', 'dDate', 'foodOrder', 'flavor', 'type', 'quntity', 'price');

		//looking function.php - check_req_fields function
		$errors = array_merge($errors, check_req_fields($req_fields)) ;

		//Checking if Record num alredy exist
		//Senitize for priventing from the "sql injection"
		
		$query = "SELECT * FROM orderdb.order WHERE cusName = '{$cusName}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		//check db que
		if ($result_set) {
			if(mysqli_num_rows($result_set) == 1) {
				$errors[] = ' alredy exist in the DataBase';
			}

		}
//uda balapannnnnnnnnnnnnnnnnnn
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

			

			

			$query = "INSERT INTO orderdb.order ( ";
			$query .= "cusName, conNo, dilAddr, dDate, foodOrder, flavor, type, quntity, price, is_deleted" ;
			$query .= ") VALUES (";
			$query .= "'{$cusName}', '{$conNo}','{$dilAddr}','{$dDate}','{$foodOrder}','{$flavor}','{$type}','{$quntity}','{$price}', 0";
			$query .= ")";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// Que Succsess... Redirect to the finance page
				header('Location: order.php?order_added= true');
			} else {
				$errors[] = 'Failed to add new order...';
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
	<title>Add New Order</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<header>
		<div class="appname">Order Managemnet System</div>
		<div class="loggedin">Welcome Hungry Hub! </div>
	</header>
	<main>
		<h1>Add New Order<span><a href="order.php">back to Order List</a></span></h1>

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
		
			<form action="add-order.php" method="post" class="financeform">



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
					 <label for="Food Order" >Food Order:</label>

					 <select name="foodOrder" <?php echo 'value = "' . $foodOrder. '"'; ?>>
					 	<option value="Pizza">Pizza</option>
					  <option value="saab">Burger</option>
					  <option value="mercedes">Submarin</option>
					  
					</select>					
				</p>



				<p>
					<label for="Flavour" >Flavour:</label>

					 <select name="flavor" <?php echo 'value = "' . $flavor. '"'; ?>>
					 	<option value="BBQ">BBQ</option>
					  <option value="Chiken">Chiken</option>
					  <option value="Beef">Beef</option>
					  <option value="Mutton">Mutton</option>
					  
					</select>
				</p>



				<p>
					<label for="type" >Type:</label>

					 <select name="type" <?php echo 'value = "' . $type. '"'; ?>>
					 	<option value="Small">Small</option>
					  <option value="Medium">Medium</option>
					  <option value="Large">Large</option>					  
					</select>
				</p>



				<p>
					<label for="quntity" >Quantity:</label>

					 <select name="quntity" <?php echo 'value = "' . $quntity. '"'; ?>>
					 	<option value="1">1</option>
					  <option value="2">2</option>
					  <option value="3">3</option>	
					  <option value="4">4</option>
					  <option value="5">5</option>				  
					</select>
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