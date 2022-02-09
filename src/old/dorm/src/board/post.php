<?
	include_once("../../lib/conf.common.php");
	include_once("../common/board_tpl.php");

	if ($param_auth_post == "N") {
		$board->closeDatabase();
		unset($board);
		include_once("../common/admin_check_tpl.php");
	} else if ($param_auth_post == "M" && !$log_flag) {
		$board->closeDatabase();
		unset($board);
		include_once("../common/login_check_tpl.php");
	} else {
		$html_dir = "board";
		$html_file = "post";
		$on_load = "document.BoardForm.name.focus();";

		include_once("../common/tpl_header.php");

		$mode = $_POST["mode"];
		$no = $_POST["no"];
		$page = $_POST["page"];
		$s_type = $_POST["s_type"];
		$s_text = $_POST["s_text"];
		if ($mode == "") $mode = $_GET["mode"];
		if ($no == "") $no = $_GET["no"];
		if ($page == "") $page = $_GET["page"];
		if ($s_type == "") $s_type = $_GET["s_type"];
		if ($s_text == "") $s_text = $_GET["s_text"];

		$ref = "";
		$level = "";
		$color = "";
		$html = "N";
		$name = "";
		$email = "";
		$subject = "";
		$content = "";
		if ($mode == "reply" || $mode == "edit") {
			include_once("../../lib/func.common.php");
			$board->getBoardInfo($no);
			if ($mode == "reply") {
				$ref = $board->boardReference;
				$level = $board->boardLevel;
				$html = $board->htmlFlag;
				$subject = "[RE]" . $board->boardSubject;
				$content = getMessage($board->writerName, $board->postDate, $board->boardSubject, $board->boardContent);
			} else {
				$color = $board->fontColor;
				$html = $board->htmlFlag;
				$name = $board->writerName;
				$email = $board->writerEmail;
				$subject = $board->boardSubject;
				$content = $board->boardContent;
			}
		}

		if ($param_attach == "Y") {
			$att_no = "";
			$photo = "";
			if ($mode == "edit") {
				$board->getAttachList($no);
				$att_no = $board->listAttachNo[0];
				if (file_exists("../../upload/board/".$att_no.".jpg")) $photo = "The current attached photo file is <a href=\"javascript:previewImage('../../upload/board/$att_no.jpg')\">" . $board->listAttachName[0] . "</a>(" . round((int)$board->listAttachSize[0] / 1024, 1) . "KB) ÀÔ´Ï´Ù.";
			}
			$tpl->define_dynamic(attach_row, "body");
			$tpl->assign(array(ATTACH_NO  => $att_no,
			                   PHOTO_NAME => $photo));
			$tpl->parse(ATTACH_ROWS, ".attach_row");
		}

		$tpl->assign(array(BOARD_TYPE      => $type,
		                   SEL_PAGE        => $page,
		                   SEARCH_TYPE     => $s_type,
		                   SEARCH_TEXT     => $s_text,
		                   MODE            => $mode,
		                   BOARD_NUMBER    => $no,
		                   BOARD_REFERENCE => $ref,
		                   BOARD_LEVEL     => $level,
		                   FONT_COLOR      => $color,
		                   HTML_FLAG       => $html,
		                   WRITER_NAME     => $name,
		                   WRITER_EMAIL    => $email,
		                   BOARD_SUBJECT   => $subject,
		                   BOARD_CONTENT   => $content,
		                   BOARD_TITLE     => $board_img));

		$board->closeDatabase();
		unset($board);

		include_once("../common/tpl_footer.php");
	}
?>