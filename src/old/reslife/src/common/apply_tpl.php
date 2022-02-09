<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cApplicant.php");

	$mode = $_POST["mode"];
	$no = $_POST["no"];
	$page = $_POST["page"];
	$s_type = $_POST["s_type"];
	$s_text = $_POST["s_text"];
	$s_kind = $_POST["s_kind"];
	$s_state = $_POST["s_state"];
	$s_current = $_POST["s_current"];
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
	if ($s_kind == "") $s_kind = $_GET["s_kind"];
	if ($s_state == "") $s_state = $_GET["s_state"];
	if ($s_current == "") $s_current = $_GET["s_current"];
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
	if ($s_kind != "L") $s_kind = "U";
	if ($s_year1 && $s_month1 && $s_day1) $sdate = "$s_year1-$s_month1-$s_day1";
	else $sdate = $s_year1 = $s_month1 = $s_day1 = "";
	if ($s_year2 && $s_month2 && $s_day2) $edate = "$s_year2-$s_month2-$s_day2";
	else $edate = $s_year2 = $s_month2 = $s_day2 = "";

	$max_attach = 1024 * 1024;
	$pht_dir = "../../../upload/photo";
	$pht_width = "90";
	$pht_height = "120";

	$main_index = 1;
	if ($s_kind == "L") {
		$sub_index = 3;
		$kind = "LAN";
		$page_name = "어학당 지원";
	} else {
		$sub_index = 2;
		$kind = "GEN";
		$page_name = "일반 지원";
	}

	$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
	$applicant->connectDatabase();
?>