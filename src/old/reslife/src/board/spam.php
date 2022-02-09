<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../../lib/class.cBoardType.php");

		$main_index = 4;
		$sub_index = 0;
		$page_name = "게시판 스팸 설정";
		$on_load = "document.BoardForm.reject_id.focus();";
	
		include_once("../common/header_tpl.php");

		$bt = new cBoardType($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $boardTypeTable, $spamTable);
		$bt->connectDatabase();
		$bt->getRejectInfo();
		$tpl->assign(array(REJECT_ID   => $bt->rejectID,
		                   REJECT_IP   => $bt->rejectIP,
		                   REJECT_WORD => $bt->rejectWord));
		$bt->closeDatabase();
		unset($bt);

		include_once("../common/footer_tpl.php");
	}
?>