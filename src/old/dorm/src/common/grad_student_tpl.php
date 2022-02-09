<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.GraduateStudent.php");

	$mode = $_GET["mode"];
	$no = $_GET["no"];
	$pw = $_GET["pw"];
	$email = $_GET["email"];
	if (!$mode) $mode = $_POST["mode"];
	if ($no == "") $no = $_POST["no"];
	if ($pw == "") $pw = $_POST["pw"];
	if ($email == "") $email = $_POST["email"];

	$max_attach = 1024 * 1024;
	$pht_dir = "../../../upload/grad_photo";
	$pht_width = "90";
	$pht_height = "120";

	$student = new GraduateStudent($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $graduateStudentTable, $graduateApplicantTable, $graduatePeriodTable, $graduateRateTable, $graduatePriceTable, $roomTable, $accountTable, $graduateRateTable);
	$student->connectDatabase();

	$main_menu_index = 4;
	$page_menu_index = 10;
	$etc_menu_index = 0;
?>