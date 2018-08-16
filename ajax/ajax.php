<?php
	include '../files/OrderProcess.php';

	$ProcessOrder = new OrderProcess;
	$order = $ProcessOrder->processFromJson("../orders-sample.json");
	echo "<pre>"; print_r($_SESSION);
	session_destroy();
?>