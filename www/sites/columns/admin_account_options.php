<?php
/*
 * CURRENT DIRECTORY: /sites/account.php -> MAIN PAGE DIR
 */
	//user? -> show user info
	//admin? -> show admin panel
	//other -> login / create acount forms
	
	if(isset($_SESSION['order_position'])){
		$orderPosition = $_SESSION['order_position'];
	} else {
		$orderPosition=0;
	}
	
	if(isset($_SESSION['last_status'])) {
		$lastStatus = $_SESSION['last_status'];
	} else {
		$lastStatus = null;
	}
	
	
	$selectedStatus = 1;
	$totalNumberOfOrders = 0;
	$limit = 3;
	$prevBtnEnabled = true;
	$nextBtnEnabled = true;
	
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$selectedStatus = $_POST['order_status_select'];
		$limit = $_POST['result_limit'];
		
		if($selectedStatus != $lastStatus) $orderPosition = 0;
		
		$totalNumberOfOrders = Order::GetStatusCount($selectedStatus);
		
		if(isset($_POST['prev_page'])){
			$orderPosition -= $limit;
			if($orderPosition < 0) $orderPosition = 0;
		}
		elseif(isset($_POST['next_page'])){
			$orderPosition += $limit;
			
			if($orderPosition > $totalNumberOfOrders) {
				$orderPosition -= $limit;
			}
		}
		
		$_SESSION['last_status'] = $selectedStatus;
	} else {
		if(isset($_SESSION['last_status'])) unset($_SESSION['last_status']);
		$totalNumberOfOrders = Order::GetStatusCount($selectedStatus);
	}
	
	$_SESSION['order_position'] = $orderPosition;
	
	if($orderPosition === 0) $prevBtnEnabled = false;
	elseif($orderPosition >= $totalNumberOfOrders - $limit) $nextBtnEnabled = false;
?>


<fieldset>
	<legend>
	ORDERS 
	<strong>by</strong> 
		<select form='orders_form' name='order_status_select' id='order-status-select-id'>
<?php 
	$optionNames = array('STATUS: Placed', 'STATUS: Paid', 'STATUS: Processed');
	for($i = 1; $i < 4; $i++) {
		$selected = "";
		if($i == $selectedStatus) $selected = "selected";
		echo "<option $selected value='".$i."'>".$optionNames[$i-1]."</option>";
	}
?>
		</select>
	<STRONG>Display:</STRONG>
		<input min='1' max='10' form='orders_form' name='result_limit' id='result-limit-id' type='number' value='<?php echo $limit; ?>'>
	</legend>
	<form id='orders_form' method='post'></form>
	<div class='margin-top-spacing'>
<?php 
	if(($orders = Order::GetAllOrdersByStatus($selectedStatus, $orderPosition, $limit))) {
		foreach($orders as $ord) {
			$user = User::Load($ord->getUserID());
			echo "<div>" . $user->getEmail() . ", date: " . $ord->getDate() . "</div>";
		}
	}
?>
	<div style='margin-top: 10px; margin-bottom: 5px'>
<?php 		
if($prevBtnEnabled && $totalNumberOfOrders > 0) echo "<button form='orders_form' name='prev_page' id='prev-page' class='submit-btn-update' style='float:left; width:30%'>Prev</button>";
if($nextBtnEnabled && $totalNumberOfOrders > 0)	echo "<button form='orders_form' name='next_page' id='next-page' class='submit-btn-update' style='float:right; width:30%; margin-right: 5px'>Next</button>";
?>
	</div>
	</div>
</fieldset>

<script>
	var orderStatusSelect = document.getElementById('order-status-select-id');
	if(orderStatusSelect) {
		orderStatusSelect.addEventListener('change', onOrderStatusSelectChange);
		document.getElementById('result-limit-id').addEventListener('change', onOrderStatusSelectChange);
	}

	function onOrderStatusSelectChange(e) {
		e.preventDefault();
		//var selectedStatus = orderStatusSelect.value;
		//var limit = getLimit();
		//load form 0 to limit
		//loadOrders(selectedStatus,limit);
		document.getElementById('orders_form').submit();
	}

	function loadOrders(status,limit) {
		var formdata = new FormData();
		formdata.append('status', status);
		formdata.append('limit', limit);
		
		var xhr = new XMLHttpRequest();
		xhr.addEventListener('load', onOrdersLoaded);
		xhr.open('POST', '../actions/load_orders.php');
		xhr.send(formdata);
	}

	function onOrdersLoaded(e) {
		var response = JSON.parse(e.target.responseText);
		if(response.status === "success") {
			var orders = response.orders;
			for(var idx in orders) {
				console.log(orders[idx]);
			}
		}
	}

	function getLimit() {
		return document.getElementById('result-limit-id').value;
	}
</script>