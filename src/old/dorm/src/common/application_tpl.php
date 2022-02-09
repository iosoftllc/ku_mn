<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cApplication.php");

	$mode = $_GET["mode"];
	$no = $_GET["no"];
	$pw = $_GET["pw"];
	$email = $_GET["email"];
	$page = $_GET["page"];
	$s_state = $_GET["s_state"];
	$s_type = $_GET["s_type"];
	$s_text = $_GET["s_text"];
	$sort1 = $_GET["sort1"];
	$sort2 = $_GET["sort2"];
	if (!$mode) $mode = $_POST["mode"];
	if ($no == "") $no = $_POST["no"];
	if ($pw == "") $pw = $_POST["pw"];
	if ($email == "") $email = $_POST["email"];
	if ($page == "") $page = $_POST["page"];
	if ($s_state == "") $s_state = $_POST["s_state"];
	if ($s_type == "") $s_type = $_POST["s_type"];
	if ($s_text == "") $s_text = $_POST["s_text"];
	if ($sort1 == "") $sort1 = $_POST["sort1"];
	if ($sort2 == "") $sort2 = $_POST["sort2"];

	if (!is_numeric($page)) $page = 1;

	$max_attach = 1024 * 1024 * 1;
	$pht_dir = "../../../upload/photo";
	$pht_width = "90";
	$pht_height = "120";

	$bank_dir = "../../../upload/bank";
	$bank_width = "800";
	$bank_height = "0";

	$fee_transfer_dir = "../../../upload/fee_transfer";
	$fee_transfer_width = "800";
	$fee_transfer_height = "0";
	$fee_support_dir = "../../../upload/fee_support";
	$fee_support_width = "800";
	$fee_support_height = "0";
	$tb_test_dir = "../../../upload/tb_test";
	$tb_test_width = "800";
	$tb_test_height = "0";

	$application = new cApplication($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $studentTable, $applicantTable, $periodTable, $roomTable, $accountTable, $rateTable, $priceTable, $preferenceTable, $paymentTable, $refundTable, $deferTable);
	$application->connectDatabase();

	$main_menu_index = 1;
	$page_menu_index = 9;
	$etc_menu_index = 0;
?>