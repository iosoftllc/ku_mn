<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cAdmin.php");

	$mode = $_GET["mode"];
	$id = $_GET["id"];
	$page = $_GET["page"];
	$s_type = $_GET["s_type"];
	$s_text = $_GET["s_text"];
	$s_grade = $_GET["s_grade"];
	$sort1 = $_GET["sort1"];
	$sort2 = $_GET["sort2"];
	if (!$mode) $mode = $_POST["mode"];
	if (!$id) $id = $_POST["id"];
	if (!$page) $page = $_POST["page"];
	if (!$s_type) $s_type = $_POST["s_type"];
	if (!$s_text) $s_text = $_POST["s_text"];
	if (trim($s_grade) == "") $s_grade = $_POST["s_grade"];
	if (!$sort1) $sort1 = $_POST["sort1"];
	if (!$sort2) $sort2 = $_POST["sort2"];

	$admin = new cAdmin($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $adminTable, $historyAccessTable, $historyWorkTable);
	$admin->connectDatabase();
?>