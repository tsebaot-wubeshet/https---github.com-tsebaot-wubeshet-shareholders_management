<?php
	$num1 = $_GET['cash_payment'];
	$num2 = $_GET['dividend_payablecap'];
	$num3 = $_GET['dividend_cap'];
	$num4 = $num1 + $num2 + $num3;
	echo $num4;
?>

