<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.GraduateStudent.php");

	$mode = $_GET["mode"];
	$no = $_GET["no"];
	$page = $_GET["page"];
	$s_type = $_GET["s_type"];
	$s_text = $_GET["s_text"];
	$s_kind = $_GET["s_kind"];
	$s_nation = $_GET["s_nation"];
	$s_current = $_GET["s_current"];
	$s_year1 = $_GET["s_year1"];
	$s_month1 = $_GET["s_month1"];
	$s_day1 = $_GET["s_day1"];
	$s_year2 = $_GET["s_year2"];
	$s_month2 = $_GET["s_month2"];
	$s_day2 = $_GET["s_day2"];
	$sort1 = $_GET["sort1"];
	$sort2 = $_GET["sort2"];
	if (!$mode) $mode = $_POST["mode"];
	if ($no == "") $no = $_POST["no"];
	if ($page == "") $page = $_POST["page"];
	if ($s_type == "") $s_type = $_POST["s_type"];
	if ($s_text == "") $s_text = $_POST["s_text"];
	if ($s_kind == "") $s_kind = $_POST["s_kind"];
	if ($s_nation == "") $s_nation = $_POST["s_nation"];
	if ($s_current == "") $s_current = $_POST["s_current"];
	if ($s_year1 == "") $s_year1 = $_POST["s_year1"];
	if ($s_month1 == "") $s_month1 = $_POST["s_month1"];
	if ($s_day1 == "") $s_day1 = $_POST["s_day1"];
	if ($s_year2 == "") $s_year2 = $_POST["s_year2"];
	if ($s_month2 == "") $s_month2 = $_POST["s_month2"];
	if ($s_day2 == "") $s_day2 = $_POST["s_day2"];
	if ($sort1 == "") $sort1 = $_POST["sort1"];
	if ($sort2 == "") $sort2 = $_POST["sort2"];

	if (!is_numeric($page)) $page = 1;
	if ($s_year1 && $s_month1 && $s_day1) $sdate = "$s_year1-$s_month1-$s_day1";
	else $sdate = $s_year1 = $s_month1 = $s_day1 = "";
	if ($s_year2 && $s_month2 && $s_day2) $edate = "$s_year2-$s_month2-$s_day2";
	else $edate = $s_year2 = $s_month2 = $s_day2 = "";

	$max_attach = 1024 * 1024;
	$pht_dir = "../../../upload/grad_photo";
	$pht_width = "90";
	$pht_height = "120";

	$main_index = 3;
	$sub_index = 0;
	$page_name = "Áö¿øÀÚ";

	$student = new GraduateStudent($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $graduateStudentTable, $accountTable, $graduateApplicantTable, $historyAccessTable, $historyWorkTable);
	$student->connectDatabase();
?>