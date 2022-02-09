<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cRefund.php");

	$no = $_GET["no"];
	if ($no == "") $no = $_POST["no"];

	$refund = new cRefund($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $refundTable, $periodTable, $applicantTable);
	$refund->connectDatabase();
	$refund->rateTableName = $rateTable;
	$refund->paymentTableName = $paymentTable;

	$main_menu_index = 1;
	$page_menu_index = 9;
	$etc_menu_index = 0;
?>