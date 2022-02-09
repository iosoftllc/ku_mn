<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cFacility.php");

	$mode = $_GET["mode"];
	$no = $_GET["no"];
	$view_no = $_GET["view_no"];
	$view_event = $_GET["view_event"];
	if (!$mode) $mode = $_POST["mode"];
	if (!$no) $no = $_POST["no"];
	if (!$view_no) $view_no = $_POST["view_no"];
	if (!$view_event) $view_event = $_POST["view_event"];

	$facility = new cFacility($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $facilityTable);
	$facility->connectDatabase();

	$main_menu_index = 3;
	$page_menu_index = 0;
	$etc_menu_index = 0;
?>