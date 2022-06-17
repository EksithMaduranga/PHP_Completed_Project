<?php  session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>
<?php 

	if (!isset($_SESSION['EmpId'])) {
		header('Location: index.php');
		// code...
	}

	

	if (isset($_GET['finance_id'])) {
		// Getting user info...
		$finance_id = mysqli_real_escape_string($connection, $_GET['finance_id']);
		if ($finance_id == $_SESSION['finance_id']) {
			header('Location: finance.php?err=cannot_delete_current_finance');
			// code...
		} else {
			$query = "UPDATE finance SET is_deleted = 1 WHERE id = {$finance_id} LIMIT 1";

			$result = mysqli_query($connection, $query);
			if ($result) {
				header('Location: finance.php?msg=finance_deleted');
				// code...
			} else {
				header('Location: finance.php?err=delete_faild');
			}
		}
		
	} else {
		header('Location: finance.php');
	}

?>
	