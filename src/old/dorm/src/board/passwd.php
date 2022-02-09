<?
	include_once("../../lib/conf.common.php");
	include_once("../common/board_tpl.php");

	$board->closeDatabase();
	unset($board);

	if ($param_auth_post == "N") include_once("../common/admin_check_tpl.php");
	else if ($param_auth_post == "M" && !$log_flag) include_once("../common/login_check_tpl.php");
	else {
		$html_dir = "board";
		$html_file = "passwd";
		$on_load = "document.BoardForm.pw.focus();";

		include_once("../common/tpl_header.php");

		$mode = $_POST["mode"];
		$no = $_POST["no"];
		$cmt_no = $_POST["cmt_no"];
		$page = $_POST["page"];
		$s_type = $_POST["s_type"];
		$s_text = $_POST["s_text"];
		if ($mode == "") $mode = $_GET["mode"];
		if ($no == "") $no = $_GET["no"];
		if ($cmt_no == "") $cmt_no = $_GET["cmt_no"];
		if ($page == "") $page = $_GET["page"];
		if ($s_type == "") $s_type = $_GET["s_type"];
		if ($s_text == "") $s_text = $_GET["s_text"];

		if ($mode == "cmt_del") $desc = "선택하신 댓글을 삭제합니다.";
		else $desc = "선택하신 게시물을 삭제합니다.";
		$tpl->assign(array(BOARD_TYPE     => $type,
		                   SEL_PAGE       => $page,
		                   SEARCH_TYPE    => $s_type,
		                   SEARCH_TEXT    => $s_text,
		                   MODE           => $mode,
		                   BOARD_NUMBER   => $no,
		                   COMMENT_NUMBER => $cmt_no,
		                   DESCRIPTION    => $desc,
		                   BOARD_TITLE    => $board_img));

		include_once("../common/tpl_footer.php");
	}
?>