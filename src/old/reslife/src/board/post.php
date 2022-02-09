<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		$mode = $_POST["mode"];
		$no = $_POST["no"];
		$top_count = $_POST["top_count"];
		if ($mode == "") $mode = $_GET["mode"];
		if ($no == "") $no = $_GET["no"];
		if ($top_count == "") $top_count = $_GET["top_count"];

		$on_load = "document.BoardForm.subject.focus();";

		include_once("../common/board_tpl.php");
		include_once("../common/header_tpl.php");

		$top_yn = "N";
		if ((int)$top_count < (int)$param_notice) $top_yn = "Y";
		if ($mode == "reply" || $mode == "edit") $board->getBoardInfo($no);
	
		$ref = "";
		$level = "";
		$color = "";
		$html = "N";
		$top = "N";
		$name = $ihouse_admin_info[name];
		$email = $ihouse_admin_info[email];
		$subject = "";
		$content = "";
		if ($mode == "reply") {
			include_once("../../lib/func.common.php");
			$page_name = "$param_name 답장";
			$ref = $board->boardReference;
			$level = $board->boardLevel;
			$html = $board->htmlFlag;
			$subject = "[RE]" . $board->boardSubject;
			$content = getMessage($board->writerName, $board->postDate, $board->boardSubject, $board->boardContent);
		} else if ($mode == "edit") {
			$page_name = "$param_name 수정";
			$ref = $board->boardReference;
			$top = $board->topFlag;
			$color = $board->fontColor;
			$html = $board->htmlFlag;
			$name = $board->writerName;
			$email = $board->writerEmail;
			$subject = $board->boardSubject;
			$content = $board->boardContent;
		} else $page_name = "$param_name 추가";
	
		if ($param_attach == "Y") {
			$att_no = "";
			$photo = "";
			if ($mode == "edit") {
				$board->getAttachList($no);
				$att_no = $board->listAttachNo[0];
				if (file_exists($webdir."/upload/board/".$att_no.".jpg")) $photo = "현재 등록된 사진은 <a href=\"javascript:previewImage('../../../upload/board/$att_no.jpg')\">" . $board->listAttachName[0] . "</a>(" . round((int)$board->listAttachSize[0] / 1024, 1) . "KB) 입니다.";
			}
			$tpl->define_dynamic(attach_row, "body");
			$tpl->assign(array(ATTACH_NO  => $att_no,
			                   PHOTO_NAME => $photo,
			                   MAX_ATTACH => $param_size));
			$tpl->parse(ATTACH_ROWS, ".attach_row");
		}
	
		$tpl->assign(array(BOARD_TYPE   => $type,
		                   SEL_PAGE     => $page,
		                   SEARCH_TYPE  => $s_type,
		                   SEARCH_TEXT  => $s_text,
		                   MODE         => $mode,
		                   MAX_ATTACH   => $param_size,
		                   BOARD_NO     => $no,
		                   BOARD_REF    => $ref,
		                   BOARD_LEVEL  => $level,
		                   FONT_COLOR   => $color,
		                   HTML_FLAG    => $html,
		                   TOP_FLAG     => $top,
		                   TOP_YN       => $top_yn,
		                   WRITER_NAME  => $name,
		                   WRITER_EMAIL => $email,
		                   SUBJECT      => $subject,
		                   CONTENT      => $content));
	
		$board->closeDatabase();
		unset($board);
	
		include_once("../common/footer_tpl.php");
	}
?>