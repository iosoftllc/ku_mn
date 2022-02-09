<?
	include_once("../../lib/class.cBoard.php");

	$type = $_POST["type"];
	$page = $_POST["page"];
	$s_type = $_POST["s_type"];
	$s_text = $_POST["s_text"];
	if ($type == "") $type = $_GET["type"];
	if ($page == "") $page = $_GET["page"];
	if ($s_type == "") $s_type = $_GET["s_type"];
	if ($s_text == "") $s_text = $_GET["s_text"];
	if (!is_numeric($type)) $type = 1;
	if ((int)$type < 1 || (int)$type > 2) $type = 1;
	$main_index = 4;
	$sub_index = (int)$type + 1;

	$board = new cBoard($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $boardTypeTable, $spamTable, $boardTable, $commentTable, $attachTable, $type);
	$board->connectDatabase();

	$board->getSettingInfo($type);
	$param_name = $board->boardName;
	$param_ip = $board->ipFlag;
	$param_time = $board->timeFlag;
	$param_reply = $board->replyFlag;
	$param_comment = $board->commentFlag;
	$param_size = $board->attachFileSize;
	$param_attach = $board->attachFlag;
	$param_auth_list = $board->authList;
	$param_auth_view = $board->authView;
	$param_auth_post = $board->authPost;
	$param_list = $board->blistNumber;
	$param_new = $board->newNumber;
	$param_hot = $board->hotNumber;
	$param_notice = $board->noticeNumber;
?>