<?php
include 'ProductsPurchasedInterface.php';

class ProductsPurchased implements ProductsPurchasedInterface{

	public function getPurchasedReceivedTotal(int $productId): int{
		$result = (int)$_SESSION['received_stocks'][$productId];
		return $result;
	}

	public function getPurchasedPendingTotal(int $productId): int{
		$result = (int)$_SESSION['pending_stocks'][$productId]['stock'];
		return $result;
	}
	
}