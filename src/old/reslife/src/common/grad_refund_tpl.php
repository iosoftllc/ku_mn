<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.GraduateRefund.php");

	$mode = $_GET["mode"];
	$no = $_GET["no"];
	$page = $_GET["page"];
	$s_type = $_GET["s_type"];
	$s_text = $_GET["s_text"];
	$s_app = $_GET["s_app"];
	$s_kind = $_GET["s_kind"];
	$s_new = $_GET["s_new"];
	$s_period = $_GET["s_period"];
	$s_year1 = $_GET["s_year1"];
	$s_month1 = $_GET["s_month1"];
	$s_day1 = $_GET["s_day1"];
	$s_year2 = $_GET["s_year2"];
	$s_month2 = $_GET["s_month2"];
	$s_day2 = $_GET["s_day2"];
	$sort1 = $_GET["sort1"];
	$sort2 = $_GET["sort2"];
	if (!$mode) $mode = $_POST["mode"];
	if (!$no) $no = $_POST["no"];
	if (!$page) $page = $_POST["page"];
	if (!$s_type) $s_type = $_POST["s_type"];
	if (!$s_text) $s_text = $_POST["s_text"];
	if (!$s_app) $s_app = $_POST["s_app"];
	if (!$s_kind) $s_kind = $_POST["s_kind"];
	if (!$s_new) $s_new = $_POST["s_new"];
	if (!$s_state) $s_state = $_POST["s_state"];
	if (!$s_current) $s_current = $_POST["s_current"];
	if (!$s_period) $s_period = $_POST["s_period"];
	if (!$s_year1) $s_year1 = $_POST["s_year1"];
	if (!$s_month1) $s_month1 = $_POST["s_month1"];
	if (!$s_day1) $s_day1 = $_POST["s_day1"];
	if (!$s_year2) $s_year2 = $_POST["s_year2"];
	if (!$s_month2) $s_month2 = $_POST["s_month2"];
	if (!$s_day2) $s_day2 = $_POST["s_day2"];
	if (!$sort1) $sort1 = $_POST["sort1"];
	if (!$sort2) $sort2 = $_POST["sort2"];
	if ($s_year1 && $s_month1 && $s_day1) $sdate = "$s_year1-$s_month1-$s_day1";
	else $sdate = $s_year1 = $s_month1 = $s_day1 = "";
	if ($s_year2 && $s_month2 && $s_day2) $edate = "$s_year2-$s_month2-$s_day2";
	else $edate = $s_year2 = $s_month2 = $s_day2 = "";

	$max_attach = 1024 * 1024 * 5;
	$pht_dir = "../../../upload/grad_bank";
	$pht_width = "800";
	$pht_height = "0";

	$main_index = 3;
	$sub_index = 2;
	$on_load = "";
	$page_name = "ฐ๚ณณฑÝ";

	$refund = new GraduateRefund($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $graduateRefundTable, $graduatePeriodTable, $graduateApplicantTable, $graduatePaymentTable, $graduateStudentTable, $historyAccessTable, $historyWorkTable);
	$refund->connectDatabase();
?>