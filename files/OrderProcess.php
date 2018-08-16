<?php
include 'session.php';
include '../src/Products.php';
include '../src/OrderProcessorInterface.php';

class OrderProcess implements OrderProcessorInterface{
	
	public $reject_order = false;

	public function __construct(){

		$stocks = [
			Products::BROWNIE => 20,
			Products::LAMINGTON => 20,
			Products::BLUEBERRY_MUFFIN => 20,
			Products::CROISSANT => 20,
			Products::CHOCOLATE_CAKE => 20,
		];

		$sold = [
			Products::BROWNIE => 0,
			Products::LAMINGTON => 0,
			Products::BLUEBERRY_MUFFIN => 0,
			Products::CROISSANT => 0,
			Products::CHOCOLATE_CAKE => 0,
		];

		$peding = [
			[Products::BROWNIE => 0, 'days' => 0],
			[Products::LAMINGTON => 0, 'days' => 0],
			[Products::BLUEBERRY_MUFFIN => 0, 'days' => 0],
			[Products::CROISSANT => 0, 'days' => 0],
			[Products::CHOCOLATE_CAKE => 0, 'days' => 0],
		];

		$received = [
			Products::BROWNIE => 0,
			Products::LAMINGTON => 0,
			Products::BLUEBERRY_MUFFIN => 0,
			Products::CROISSANT => 0,
			Products::CHOCOLATE_CAKE => 0,
		];

		$_SESSION['products_stocks'] = $stocks;
		$_SESSION['pending_stocks'] = $peding;
		$_SESSION['received_stocks'] = $received;
		$_SESSION['sold_stocks'] = $sold;

	}

	public function processFromJson($file) : void {

		$json_file = file_get_contents($file);
		$data = json_decode($json_file, true);
		
		foreach($data as $a => $day){ //1st loop orders per day
			foreach($day as $b => $orders){ //2nd loop orders per day\
				
				foreach($orders as $c => $order){ //3rd set of order per day
					
					/*if( $_SESSION['products_stocks'][$c] > $order ){

						//update stock count
						$stock_update = $_SESSION['products_stocks'][$c] - $order;
						$_SESSION['products_stocks'][$c] = $stock_update;

						//update sold stock
						$soldStock = $_SESSION['sold_stocks'][$c] + $order;
						$_SESSION['sold_stocks'][$c] = $soldStock;
					}*/
				}

			}

		}

	}

	public function orderStock($id){

	}

	public function shippingDays($id){

	}

	public function transaction($id, $order){

	}

	public function saveTransaction($transaction){

	}

}