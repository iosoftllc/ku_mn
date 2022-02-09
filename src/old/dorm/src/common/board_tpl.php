<?
	include_once("../../lib/class.cBoard.php");

	$type = $_GET["type"];
	if ($type == "") $type = $_POST["type"];
	if (!is_numeric($type)) $type = 2;
	if ((int)$type != 2) $type = 2;
	$main_menu_index = 1;
	$page_menu_index = 10;
	$etc_menu_index = 0;
	$board_img = "<td width=\"143\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_news.jpg\" width=\"143\" height=\"23\"></td>";

	$board = new cBoard($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $boardTypeTable, $boardTable, $commentTable, $attachTable, $spamTable, $type);
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

	$board->getRejectInfo();
	$reject_id = $board->rejectID;
	$reject_ip = $board->rejectIP;
	$reject_word = $board->rejectWord;
?>