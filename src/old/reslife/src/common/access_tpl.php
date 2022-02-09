<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cHistoryAccess.php");

	$no = getRequestVariable("no");
	$mode = getRequestVariable("mode");
	$page = getRequestVariable("page");
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
	$sub_index = 0;
	$page_name = "접속내역";

	$historyAccess = new cHistoryAccess($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $adminTable, $historyAccessTable);
	$historyAccess->connectDatabase();
?>