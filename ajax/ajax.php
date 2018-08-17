<?php
	include '../files/OrderProcess.php';

	$ProcessOrder = new OrderProcess;
	$ProcessOrder->processFromJson("../orders-sample.json");
	$result = $ProcessOrder->getReports();
?>
	
	<div class="col-md-12">
		<h1>total units sold</h1>
		<table class="table">
			<tr>
				<th>Product</th>
				<th>Total Sold</th>
			</tr>
			<?php
				foreach($result['total_sold'] as $total_sold){
			?>
				<tr>
					<td><?php echo $total_sold['name']?></td>
					<td><?php echo $total_sold['total']?></td>
				</tr>
			<?php
				}
			?>
		</table>
	</div>

	<div class="col-md-12">
		<h1>total units purchased and pending</h1>
		<table class="table">
			<tr>
				<th>Product</th>
				<th>Total Pending</th>
			</tr>
			<?php
				foreach($result['pending'] as $pending){
			?>
				<tr>
					<td><?php echo $pending['name']?></td>
					<td><?php echo $pending['total']?></td>
				</tr>
			<?php
				}
			?>
		</table>
	</div>

	<div class="col-md-12">
		<h1>total units Received</h1>
		<table class="table">
			<tr>
				<th>Product</th>
				<th>Total Sold</th>
			</tr>
			<?php
				foreach($result['received'] as $received){
			?>
				<tr>
					<td><?php echo $received['name']?></td>
					<td><?php echo $received['total']?></td>
				</tr>
			<?php
				}
			?>
		</table>
	</div>

	<div class="col-md-12">
		<h1>current stock level</h1>
		<table class="table">
			<tr>
				<th>Product</th>
				<th>current stock</th>
			</tr>
			<?php
				foreach($result['inventory'] as $inventory){
			?>
				<tr>
					<td><?php echo $inventory['name']?></td>
					<td><?php echo $inventory['total']?></td>
				</tr>
			<?php
				}
			?>
		</table>
	</div>

<?php
	session_destroy();
?>