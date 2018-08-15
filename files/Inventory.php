<?php
include '../src/InventoryInterface.php';

class Inventory implements InventoryInterface{
	
	public function getStockLevel(int $productId) : int{
		return $productId;
	}

}