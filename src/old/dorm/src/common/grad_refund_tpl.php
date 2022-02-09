<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.GraduateRefund.php");

	$no = $_GET["no"];
	if ($no == "") $no = $_POST["no"];

	$refund = new GraduateRefund($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $graduateRefundTable, $graduatePeriodTable, $graduateApplicantTable);
	$refund->connectDatabase();
	$refund->rateTableName = $graduateRateTable;
	$refund->paymentTableName = $graduatePaymentTable;

	$main_menu_index = 4;
	$page_menu_index = 10;
	$etc_menu_index = 0;
?>