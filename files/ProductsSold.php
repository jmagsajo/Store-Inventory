<?php
include '../src/ProductsSoldInterface.php';

class ProductsSold implements ProductsSoldInterface{

	public function getSoldTotal(int $productId): int{
		$result = (int)$_SESSION['sold_stocks'][$productId];
		return $result;
	}
	
}