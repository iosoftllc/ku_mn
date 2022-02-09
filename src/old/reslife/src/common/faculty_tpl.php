<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cFaculty.php");

	$mode = $_POST["mode"];
	$no = $_POST["no"];
	$page = $_POST["page"];
	$s_type = $_POST["s_type"];
	$s_text = $_POST["s_text"];
	$s_term = $_POST["s_term"];
	$s_state = $_POST["s_state"];
	$s_grade = $_POST["s_grade"];
	$s_rate = $_POST["s_rate"];
	$s_room = $_POST["s_room"];
	$s_dorm = $_POST["s_dorm"];
	$s_year1 = $_POST["s_year1"];
	$s_month1 = $_POST["s_month1"];
	$s_day1 = $_POST["s_day1"];
	$s_year2 = $_POST["s_year2"];
	$s_month2 = $_POST["s_month2"];
	$s_day2 = $_POST["s_day2"];
	$sort1 = $_POST["sort1"];
	$sort2 = $_POST["sort2"];
	if (!$mode) $mode = $_GET["mode"];
	if (!$no) $no = $_GET["no"];
	if (!$page) $page = $_GET["page"];
	if (!$s_type) $s_type = $_GET["s_type"];
	if (!$s_text) $s_text = $_GET["s_text"];
	if (!$s_term) $s_term = $_GET["s_term"];
	if (!$s_state) $s_state = $_GET["s_state"];
	if ($s_grade == "") $s_grade = $_GET["s_grade"];
	if (!$s_rate) $s_rate = $_GET["s_rate"];
	if (!$s_room) $s_room = $_GET["s_room"];
	if (!$s_dorm) $s_dorm = $_GET["s_dorm"];
	if (!$s_year1) $s_year1 = $_GET["s_year1"];
	if (!$s_month1) $s_month1 = $_GET["s_month1"];
	if (!$s_day1) $s_day1 = $_GET["s_day1"];
	if (!$s_year2) $s_year2 = $_GET["s_year2"];
	if (!$s_month2) $s_month2 = $_GET["s_month2"];
	if (!$s_day2) $s_day2 = $_GET["s_day2"];
	if (!$sort1) $sort1 = $_GET["sort1"];
	if (!$sort2) $sort2 = $_GET["sort2"];
	if ($s_year1 && $s_month1 && $s_day1) $sdate = "$s_year1-$s_month1-$s_day1";
	else $sdate = $s_year1 = $s_month1 = $s_day1 = "";
	if ($s_year2 && $s_month2 && $s_day2) $edate = "$s_year2-$s_month2-$s_day2";
	else $edate = $s_year2 = $s_month2 = $s_day2 = "";

	if ($html_file == "room_calendar1") {
		$main_index = 2;
		$sub_index = 2;
		$on_load = "";
		$page_name = "교원동예약현황";
	} else if ($html_file == "room_calendar2") {
		$main_index = 2;
		$sub_index = 3;
		$on_load = "";
		$page_name = "교수동사실배정현황";
	} else {
		$main_index = 2;
		$sub_index = 0;
		$on_load = "";
		$page_name = "객실예약";
	}

	$faculty = new cFaculty($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $facultyTable, $facultyAttachTable, $rate1Table, $payment1Table, $roomTable, $bookTable, $applicantTable, $historyAccessTable, $historyWorkTable);
	$faculty->connectDatabase();

	$max_attach = 1024 * 1024 * 5;
	$attach_dir = $webdir . "/upload/faculty";
?>