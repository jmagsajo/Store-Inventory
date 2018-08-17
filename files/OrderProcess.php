<?php
include 'session.php';
include '../src/Products.php';
include '../src/OrderProcessorInterface.php';
include 'Inventory.php';
include 'ProductsPurchased.php';
include 'ProductsSold.php';

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
			Products::BROWNIE => [ "stock" => 0, 'days' => 0],
			Products::LAMINGTON => [ "stock" => 0, 'days' => 0],
			Products::BLUEBERRY_MUFFIN => ["stock" => 0, 'days' => 0],
			Products::CROISSANT => [ "stock" => 0, 'days' => 0],
			Products::CHOCOLATE_CAKE => [ "stock" => 0, 'days' => 0],
		];

		$received = [
			Products::BROWNIE => 0,
			Products::LAMINGTON => 0,
			Products::BLUEBERRY_MUFFIN => 0,
			Products::CROISSANT => 0,
			Products::CHOCOLATE_CAKE => 0,
		];

		$_SESSION['products_stocks'] = $stocks;
		$_SESSION['stocks_tracker'] = $stocks; //to track how much item will deduct to the original stock
		$_SESSION['pending_stocks'] = $peding;
		$_SESSION['received_stocks'] = $received;

		$_SESSION['sold_stocks_tracker'] = $sold; //to track how much item will be added to sold stocks
		$_SESSION['sold_stocks'] = $sold;

	}

	public function processFromJson($file) : void {

		$json_file = file_get_contents($file);
		$data = json_decode($json_file, true);
		
		foreach($data as $a => $day){ //1st loop orders per day
			//check remaining day(s) of shipping per day
			$this->checkShippingDays();
			foreach($day as $b => $orders){ //2nd loop orders per day
				
				$number_of_orders = count($orders); //number of orders per transaction
				$counter = 0;
				
				foreach($orders as $c => $order){ //3rd set of order per day
					$counter++;
					//begin transaction
					$this->transaction($c, $order);
					
					if($counter == $number_of_orders){
						if($this->reject_order){
							$_SESSION['stocks_tracker'] = $_SESSION['products_stocks']; //revert tracker
							$_SESSION['sold_stocks_tracker'] = $_SESSION['sold_stocks']; //revert tracker
							$this->reject_order = false; //revert validator if it's true
						}else{
							$this->saveTransaction();
							//check and order stock if below 10
							$this->checkAndOrderStock();
						}
					}
					//END OF TRANSACTION
				}
			}

		}

	}

	public function checkAndOrderStock(){

		for($id = 1; $id <= 5; $id++){
			if($_SESSION['products_stocks'][$id] < 10){
				if($_SESSION['pending_stocks'][$id]['stock'] <= 0 && $_SESSION['pending_stocks'][$id]['days'] <= 0){
					$_SESSION['pending_stocks'][$id]['stock'] = 20;
					$_SESSION['pending_stocks'][$id]['days'] = 2;
				}
			}
		}

	}

	public function restockItem(){
		
		foreach($_SESSION['pending_stocks'] as $id => $pending){
			if($pending['days'] == 0 && $pending['stock'] > 0){
				//re-stock items
				$new_stock = $_SESSION['products_stocks'][$id] + $_SESSION['pending_stocks'][$id]['stock'];
				$_SESSION['products_stocks'][$id] = $new_stock ;
				$_SESSION['stocks_tracker'][$id] = $_SESSION['products_stocks'][$id]; //update stock tracker

				//update received stocks
				$received_stocks = $_SESSION['received_stocks'][$id] + $_SESSION['pending_stocks'][$id]['stock'];
				$_SESSION['received_stocks'][$id] = $received_stocks;

				$_SESSION['pending_stocks'][$id]['stock'] = 0; //revert pending item to 0
			}
		}
	}

	public function checkShippingDays(){
		
		for($id = 1; $id <= 5; $id++){
			if($_SESSION['pending_stocks'][$id]['days'] > 0){
				$update_shipping_days = $_SESSION['pending_stocks'][$id]['days'] - 1;
				$_SESSION['pending_stocks'][$id]['days'] = $update_shipping_days;
			}
		}
		$this->restockItem();
		// debug($_SESSION['pending_stocks']);
	}

	public function transaction($id, $order){

		if( $_SESSION['stocks_tracker'][$id] > $order ){
			if(!$this->reject_order){
				/*process orders*/
				$stock_update = $_SESSION['stocks_tracker'][$id] - $order;
				$_SESSION['stocks_tracker'][$id] = $stock_update;

				$soldStock = $_SESSION['sold_stocks_tracker'][$id] + $order;
				$_SESSION['sold_stocks_tracker'][$id] = $soldStock;
			}
		}else{
			$this->reject_order = true; //reject the whole order
		}
	}

	public function saveTransaction(){
		//update current stock
		$_SESSION['products_stocks'] = $_SESSION['stocks_tracker']; //copy stock tracker if transaction is valid

		//update sold stock
		$_SESSION['sold_stocks'] = $_SESSION['sold_stocks_tracker']; //copy sold tracker if transaction is valid
	}


	public function getReports(){

		$inventory = new Inventory();
		$pruchased = new ProductsPurchased();
		$sold = new ProductsSold();

		$stocks_level = [];
		$pending = [];
		$received = [];
		$total_sold = [];

		for($id = 1; $id <= 5; $id++){
			$stocks_level[$id] = ['name' => $this->getProductName($id),'total'=> $inventory->getStockLevel($id)];
			$pending[$id] = ['name' => $this->getProductName($id), 'total'=> $pruchased->getPurchasedPendingTotal($id)];
			$received[$id] = ['name' => $this->getProductName($id), 'total'=> $pruchased->getPurchasedReceivedTotal($id)];
			$total_sold[$id] = ['name' => $this->getProductName($id), 'total'=> $sold->getSoldTotal($id)];
		}

		return ["inventory" => $stocks_level, 'pending' => $pending, 'received' => $received, 'total_sold' => $total_sold];

	}

	public function getProductName($id){

		$arr = [
			1 => 'BROWNIE',
			2 => 'LAMINGTON',
			3 => 'BLUEBERRY MUFFIN',
			4 => 'CROISSANT',
			5 => 'CHOCOLATE CAKE'
		];

		return $arr[$id];

	}

}