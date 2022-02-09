<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cHistoryWork.php");

	$no = getRequestVariable("no");
	$mode = getRequestVariable("mode");
	$page = getRequestVariable("page");
	$s_building = getRequestVariable("s_building");
	$s_menu = getRequestVariable("s_menu");
	$s_kind = getRequestVariable("s_kind");
	$s_admin = getRequestVariable("s_admin");
	$s_yy1 = getRequestVariable("s_yy1");
	$s_mm1 = getRequestVariable("s_mm1");
	$s_dd1 = getRequestVariable("s_dd1");
	$s_yy2 = getRequestVariable("s_yy2");
	$s_mm2 = getRequestVariable("s_mm2");
	$s_dd2 = getRequestVariable("s_dd2");
	$s_type = getRequestVariable("s_type");
	$s_text = getRequestVariable("s_text", true);
	$sort1 = getRequestVariable("sort1");
	$sort2 = getRequestVariable("sort2");
	if ($s_yy1 && $s_mm1 && $s_dd1) $sdate = $s_yy1 . "-" . $s_mm1 . "-" . $s_dd1;
	else $sdate = "";
	if ($s_yy2 && $s_mm2 && $s_dd2) $edate = $s_yy2 . "-" . $s_mm2 . "-" . $s_dd2;
	else $edate = "";

	$main_index = 6;
	$sub_index = 1;
	$page_name = "업무내역";

	$historyWork = new cHistoryWork($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $adminTable, $historyWorkTable);
	$historyWork->connectDatabase();
?>