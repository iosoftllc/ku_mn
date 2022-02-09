<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cDefer.php");

	$mode = $_POST["mode"];
	$no = $_POST["no"];
	$page = $_POST["page"];
	$s_type = $_POST["s_type"];
	$s_text = $_POST["s_text"];
	$s_approve = $_POST["s_approve"];
	$s_period = $_POST["s_period"];
	$s_year1 = $_POST["s_year1"];
	$s_month1 = $_POST["s_month1"];
	$s_day1 = $_POST["s_day1"];
	$s_year2 = $_POST["s_year2"];
	$s_month2 = $_POST["s_month2"];
	$s_day2 = $_POST["s_day2"];
	$sort1 = $_POST["sort1"];
	$sort2 = $_POST["sort2"];
	if (!$mode) $mode = $_GET["mode"];
	if ($no == "") $no = $_GET["no"];
	if ($page == "") $page = $_GET["page"];
	if ($s_type == "") $s_type = $_GET["s_type"];
	if ($s_text == "") $s_text = $_GET["s_text"];
	if ($s_approve == "") $s_approve = $_GET["s_approve"];
	if ($s_period == "") $s_period = $_GET["s_period"];
	if ($s_year1 == "") $s_year1 = $_GET["s_year1"];
	if ($s_month1 == "") $s_month1 = $_GET["s_month1"];
	if ($s_day1 == "") $s_day1 = $_GET["s_day1"];
	if ($s_year2 == "") $s_year2 = $_GET["s_year2"];
	if ($s_month2 == "") $s_month2 = $_GET["s_month2"];
	if ($s_day2 == "") $s_day2 = $_GET["s_day2"];
	if ($sort1 == "") $sort1 = $_GET["sort1"];
	if ($sort2 == "") $sort2 = $_GET["sort2"];

	if (!is_numeric($page)) $page = 1;
	if ($s_year1 && $s_month1 && $s_day1) $sdate = "$s_year1-$s_month1-$s_day1";
	else $sdate = $s_year1 = $s_month1 = $s_day1 = "";
	if ($s_year2 && $s_month2 && $s_day2) $edate = "$s_year2-$s_month2-$s_day2";
	else $edate = $s_year2 = $s_month2 = $s_day2 = "";

	$main_index = 1;
	$sub_index = 5;
	$page_name = "³³ºÎ¿¬±â";

	$defer = new cDefer($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $studentTable, $applicantTable, $accountTable, $periodTable, $paymentTable, $deferTable, $historyAccessTable, $historyWorkTable);
	$defer->connectDatabase();
?>