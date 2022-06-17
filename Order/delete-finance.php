
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>
<?php 

	
	

	if (isset($_GET['order_id'])) {
		// Getting user info...
		$order_id = mysqli_real_escape_string($connection, $_GET['order_id']);
		if ($order_id == order_id) {
			header('Location: order.php?err=cannot_delete');
			// code...
		} else {
			$query = "UPDATE orderdb.order SET is_deleted = 1 WHERE id = {$order_id} LIMIT 1";

			$result = mysqli_query($connection, $query);
			if ($result) {
				header('Location: order.php?msg=order_deleted');
				// code...
			} else {
				header('Location: order.php?err=delete_faild');
			}
		}
		
	} else {
		header('Location: order.php');
	}

?>
	