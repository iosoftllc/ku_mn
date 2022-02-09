<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cFacility.php");

	$mode = $_GET["mode"];
	$no = $_GET["no"];
	$page = $_GET["page"];
	$s_type = $_GET["s_type"];
	$s_text = $_GET["s_text"];
	$s_state = $_GET["s_state"];
	$s_grade = $_GET["s_grade"];
	$s_room = $_GET["s_room"];
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
	if (!$s_state) $s_state = $_POST["s_state"];
	if ($s_grade == "") $s_grade = $_POST["s_grade"];
	if (!$s_room) $s_room = $_POST["s_room"];
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

	if ($html_file == "fac_calendar") {
		$main_index = 2;
		$sub_index = 4;
		$on_load = "";
		$page_name = "회의실예약현황";
	} else {
		$main_index = 2;
		$sub_index = 1;
		$on_load = "";
		$page_name = "시설예약";
	}

	$facility = new cFacility($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $facilityTable, $historyAccessTable, $historyWorkTable);
	$facility->connectDatabase();
?>