
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<!DOCTYPE html>
<?php 
	//Checking if a user is logged in
	

	$order_list = '';

	//get the list of finance
	if (isset($_GET['search'])) {
		// code...
		$search = mysqli_real_escape_string($connection, $_GET['search']);
			$query = "SELECT * FROM orderdb.order WHERE (cusName LIKE '%{$search}%' OR conNo LIKE '%{$search}%' OR foodOrder LIKE '%{$search}%') AND is_deleted=0 ORDER BY id";
	} else {
			$query = "SELECT * FROM orderdb.order";

	}

	
	$orders = mysqli_query($connection, $query);

	
	verify_query($orders);
	//if ($orders) 
	{
		// code...
		while ($order = mysqli_fetch_assoc($orders)) {
			// code...
			$order_list .="<tr>";


				$order_list .="<td>{$order['id']}</td>";
				$order_list .="<td>{$order['cusName']}</td>";
				$order_list .="<td>{$order['conNo']}</td>";
				$order_list .="<td>{$order['dilAddr']}</td>";
				$order_list .="<td>{$order['dDate']}</td>";
				$order_list .="<td>{$order['foodOrder']}</td>";
				$order_list .="<td>{$order['flavor']}</td>";
				$order_list .="<td>{$order['type']}</td>";
				$order_list .="<td>{$order['quntity']}</td>";
				$order_list .="<td>{$order['price']}</td>";

				
				

			$order_list .="</tr>";
		}

	}
	
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Order</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<header>
		<div class="appname">Order Managemnet System</div>
		
		<div class="loggedin">Welcome ! </div>
	</header>
	<main>


		<h1>Order<span><a href="add-order.php">Add New Order</a> | <a href="order.php">Refresh</a></span></h1>
		<div class="search">
			<form action="order.php" method="get">
				<p>
					<input type="text" name="search" placeholder="Enter Customer Name, Contact Number or ID" required autofocus>
				</p>
			</form>
		</div>
		
		<table class="masterlist">
			<tr>

				<th>Order ID</th>
				<th>Customer Name</th>
				<th>Contact Number</th>
				<th>Diliver Address</th>
				<th>Date of the Order</th>
				<th>Food Order</th>
				<th>Flavor</th>
				<th>Type</th>
				<th>Quantity</th>
				<th>Price</th>
				

				
			</tr>


			<?php echo $order_list;?>
			<button onclick="window.print();" class="btn btn-primary" id="print-btn">Print</button>

			
		</table>

	</main>

</body>
</html>