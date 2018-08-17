<?php
include '../src/InventoryInterface.php';

class Inventory implements InventoryInterface{
	
	public function getStockLevel(int $productId) : int{
		$result = (int)$_SESSION['products_stocks'][$productId];
		return $result;
	}

}