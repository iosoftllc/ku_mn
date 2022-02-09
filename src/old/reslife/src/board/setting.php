<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../../lib/class.cBoardType.php");

		$main_index = 4;
		$sub_index = 1;
		$page_name = "게시판 환경 설정";
		$on_load = "";

		$no = $_POST["no"];
		if ($no == "") $no = $_GET["no"];
		if (!is_numeric($no)) $no = 0;

		include_once("../common/header_tpl.php");

		$bt = new cBoardType($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $boardTypeTable, $spamTable);
		$bt->connectDatabase();

		$tpl->define_dynamic(boardtype_row, "body");
		$bt->getBoardTypeList($no);
		for ($i = 0; $i < count($bt->listTypeNumber); $i++) {
			if ($no == "0") $no = $bt->listTypeNumber[0];
			$tpl->assign(array(BOARDTYPE_NO   => $bt->listTypeNumber[$i],
			                   BOARDTYPE_NAME => $bt->listTypeName[$i]));
			$tpl->parse(BOARDTYPE_ROWS, ".boardtype_row");
		}
	
		$bt->getSettingInfo($no);
		$tpl->assign(array(BOARDTYPE_NUMBER => $no,
		                   LIST_NUMBER      => $bt->blistNumber,
		                   NEW_NUMBER       => $bt->newNumber,
		                   HOT_NUMBER       => $bt->hotNumber,
		                   IP_FLAG          => $bt->ipFlag,
		                   TIME_FLAG        => $bt->timeFlag,
		                   REPLY_FLAG       => $bt->replyFlag,
		                   COMMENT_FLAG     => $bt->commentFlag,
		                   ATTACH_SIZE      => $bt->attachFileSize,
		                   ATTACH_FLAG      => $bt->attachFlag,
		                   AUTH_LIST        => $bt->authList,
		                   AUTH_VIEW        => $bt->authView,
		                   AUTH_POST        => $bt->authPost,
		                   NOTICE_NUMBER    => $bt->noticeNumber));
	
		$bt->closeDatabase();
		unset($bt);

		include_once("../common/footer_tpl.php");
	}
?>