<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cFaculty.php");

	$mode = $_GET["mode"];
	$no = $_GET["no"];
	$view_no = $_GET["view_no"];
	$view_fname = $_GET["view_fname"];
	$view_mname = $_GET["view_mname"];
	$view_lname = $_GET["view_lname"];
	if (!$mode) $mode = $_POST["mode"];
	if (!$no) $no = $_POST["no"];
	if (!$view_no) $view_no = $_POST["view_no"];
	if (!$view_fname) $view_fname = $_POST["view_fname"];
	if (!$view_mname) $view_mname = $_POST["view_mname"];
	if (!$view_lname) $view_lname = $_POST["view_lname"];

	$faculty = new cFaculty($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $facultyTable, $rate1Table, $payment1Table, $roomTable, $bookTable);
	$faculty->connectDatabase();

	$main_menu_index = 2;
	$page_menu_index = 3;
	$etc_menu_index = 0;
?>