<?php

use PHPUnit\Framework\TestCase;

class OrderProcessTest extends TestCase{

	public function testIfCanGetprocessFromJson() : void
    {	
		$OrderProcess = new OrderProcess;
		try {
			$OrderProcess->processFromJson("../orders-sample.json");
		} catch (InvalidArgumentException $notExpected) {
			$this->fail();
		}
	    $this->assertTrue(TRUE);
    }

    public function testIfCanGetPurchasedReceivedTotal(){
		
		$ProductsPurchased = new ProductsPurchased;
		try {
			$ProductsPurchased->getPurchasedReceivedTotal(1); //if can get BROWNIE
			$ProductsPurchased->getPurchasedReceivedTotal(2); //if can get LAMINGTON
			$ProductsPurchased->getPurchasedReceivedTotal(3); //if can get BLUEBERRY_MUFFIN
			$ProductsPurchased->getPurchasedReceivedTotal(4); //if can get CROISSANT
			$ProductsPurchased->getPurchasedReceivedTotal(5); //if can get CHOCOLATE_CAKE
		} catch (InvalidArgumentException $notExpected) {
			$this->fail();
		}
	    $this->assertTrue(TRUE);

	}

	public function testIfCanGetPurchasedPendingTotal(){
		
		$ProductsPurchased = new ProductsPurchased;
		try {
			$ProductsPurchased->getPurchasedPendingTotal(1); //if can get BROWNIE
			$ProductsPurchased->getPurchasedPendingTotal(2); //if can get LAMINGTON
			$ProductsPurchased->getPurchasedPendingTotal(3); //if can get BLUEBERRY_MUFFIN
			$ProductsPurchased->getPurchasedPendingTotal(4); //if can get CROISSANT
			$ProductsPurchased->getPurchasedPendingTotal(5); //if can get CHOCOLATE_CAKE
		} catch (InvalidArgumentException $notExpected) {
			$this->fail();
		}
	    $this->assertTrue(TRUE);

	}

	public function testIfCanGetProductsSold(){
		$ProductsSold = new ProductsSold;
		try {
			$ProductsSold->getSoldTotal(1); //if can get BROWNIE
			$ProductsSold->getSoldTotal(2); //if can get LAMINGTON
			$ProductsSold->getSoldTotal(3); //if can get BLUEBERRY_MUFFIN
			$ProductsSold->getSoldTotal(4); //if can get CROISSANT
			$ProductsSold->getSoldTotal(5); //if can get CHOCOLATE_CAKE
		} catch (InvalidArgumentException $notExpected) {
			$this->fail();
		}
	    $this->assertTrue(TRUE);
	}

	public function testIfCanGetStockLevel(){
		$Inventory = new Inventory;
		try {
			$Inventory->getStockLevel(1); //if can get BROWNIE
			$Inventory->getStockLevel(2); //if can get LAMINGTON
			$Inventory->getStockLevel(3); //if can get BLUEBERRY_MUFFIN
			$Inventory->getStockLevel(4); //if can get CROISSANT
			$Inventory->getStockLevel(5); //if can get CHOCOLATE_CAKE
		} catch (InvalidArgumentException $notExpected) {
			$this->fail();
		}
	    $this->assertTrue(TRUE);
	}

}