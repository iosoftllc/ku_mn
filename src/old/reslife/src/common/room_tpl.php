<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cRoom.php");

	$code = $_GET["code"];
	$page = $_GET["page"];
	$s_rate = $_GET["s_rate"];
	$s_type = $_GET["s_type"];
	$s_text = $_GET["s_text"];
	$sort1 = $_GET["sort1"];
	$sort2 = $_GET["sort2"];
	if ($code == "") $code = $_POST["code"];
	if ($page == "") $page = $_POST["page"];
	if ($s_rate == "") $s_rate = $_POST["s_rate"];
	if ($s_type == "") $s_type = $_POST["s_type"];
	if ($s_text == "") $s_text = $_POST["s_text"];
	if ($sort1 == "") $sort1 = $_POST["sort1"];
	if ($sort2 == "") $sort2 = $_POST["sort2"];
	if (!is_numeric($page)) $page = 1;

	$main_index = 1;
	$sub_index = 7;
	$page_name = "È£½Ç";

	$room = new cRoom($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $roomTable);
	$room->connectDatabase();
?>