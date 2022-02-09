<?
	include_once("../../lib/conf.common.php");
	include_once("../common/board_tpl.php");

	if ($param_auth_view == "N") {
		$board->closeDatabase();
		unset($board);
		include_once("../common/admin_check_tpl.php");
	} else if ($param_auth_view == "M" && !$log_flag) {
		$board->closeDatabase();
		unset($board);
		include_once("../common/login_check_tpl.php");
	} else {
		$no = $_POST["no"];
		$page = $_POST["page"];
		$s_type = $_POST["s_type"];
		$s_text = $_POST["s_text"];
		if ($no == "") $no = $_GET["no"];
		if ($page == "") $page = $_GET["page"];
		if ($s_type == "") $s_type = $_GET["s_type"];
		if ($s_text == "") $s_text = $_GET["s_text"];

		$board->getBoardInfo($no);
		$br_ref = $board->boardReference;
		if ($br_ref != "") {
			$html_dir = "board";
			$html_file = "view";
			$on_load = "";

			include_once("../../lib/func.common.php");
			include_once("../common/tpl_header.php");
	
			$tpl->define_dynamic(array(btn_write_row    => "body",
			                           attach_row       => "body",
			                           comment_row      => "body",
			                           comment_list_row => "body",
			                           reply_row        => "body",
			                           board_row        => "body",
			                           btn_reply_row    => "body"));

			if ($param_auth_post == "M" && $log_flag) {
				$tpl->assign(BOARD_NUMBER, $no);
				$tpl->parse(BTN_WRITE_ROWS, ".btn_write_row");
			} else if ($param_auth_post == "A") {
				$tpl->assign(BOARD_NUMBER, $no);
				$tpl->parse(BTN_WRITE_ROWS, ".btn_write_row");
			}

			if ($param_attach == "Y") {
				$photo = "";
				$board->getAttachList($no);
				if (file_exists("../../upload/board/thumbnail/".$board->listAttachNo[0].".jpg")) $photo = "<a href=\"javascript:previewImage('../../upload/board/" . $board->listAttachNo[0] . ".jpg');\" target=\"_top\"><img src=\"../../upload/board/thumbnail/" . $board->listAttachNo[0] . ".jpg?tmp=" . md5(time()) . "\" border=\"0\" align=\"left\" style=\"padding-right:10px;padding-bottom:10px;\"></a>";
				$tpl->assign(FILE_LIST, $photo);
				$tpl->parse(ATTACH_ROWS, ".attach_row");
			}

			$pre_no = "";
			$pre_title = "";
			$next_no = "";
			$next_title = "";
			$board->increaseReadCount($no);
			$board->getPreBoard($br_ref);
			if ($board->titleNumber != "") {
				$pre_no = $board->titleNumber;
				$pre_title = $board->titleSubject;
			}
			$board->getNextBoard($br_ref);
			if ($board->titleNumber != "") {
				$next_no = $board->titleNumber;
				$next_title = $board->titleSubject;
			}
			$subject = $board->boardSubject;
			if ($board->fontColor != "") $subject = "<font color=\"" . $board->fontColor . "\">" . $subject . "</font>";
			if ($param_time == "F") $date = getFullDate($board->postDate);
			else $date = getFullDate(substr($board->postDate, 0, 13));
			if ($param_ip == "Y") $ip = "(from: " . $board->postIP . ")";
			else $ip = "";
			if ($board->writerEmail) $name = "<a href=\"mailto:" . $board->writerEmail . "\">" . $board->writerName . "</a>";
			else $name = $board->writerName;
			$content = $photo . getContents($board->boardContent, $board->htmlFlag);
			$content = makeAutoLink($content);
			$read_cnt = (int)$board->readCount + 1;
			$tpl->assign(array(BOARD_TYPE       => $type,
			                   SEL_PAGE         => $page,
			                   SEARCH_TYPE      => $s_type,
			                   SEARCH_TEXT      => $s_text,
			                   MEMBER_NAME      => $myung_log_name,
			                   BOARD_NUMBER     => $no,
			                   BOARD_REF        => $br_ref,
			                   PRE_BOARD_NO     => $pre_no,
			                   PRE_BOARD_TITLE  => $pre_title,
			                   NEXT_BOARD_NO    => $next_no,
			                   NEXT_BOARD_TITLE => $next_title,
			                   WRITER_NAME      => $name,
			                   READ_COUNT       => $read_cnt,
			                   POST_DATE        => $date,
			                   POST_IP          => $ip,
			                   BOARD_SUBJECT    => $subject,
			                   BOARD_CONTENT    => $content,
			                   BOARD_TITLE      => $board_img));

			if ($param_comment == "Y") {
				$board->getCommentList($no);
				for ($i = 0; $i < count($board->listCommentNo); $i++) {
					$content = getContents($board->listComentContent[$i], "N");
					$content = makeAutoLink($content);
					$date = substr($board->listCommentDate[$i], 5);
					if ($param_ip == "Y") $date = $date . ", from: " . $board->listCommentIP[$i];
					$tpl->assign(array(COMMENT_NUMBER  => $board->listCommentNo[$i],
					                   COMMENT_NAME    => $board->listCommentName[$i],
					                   COMMENT_DATE    => $date,
					                   COMMENT_CONTENT => $content));
					$tpl->parse(COMMENT_LIST_ROWS, ".comment_list_row");
				}
				$tpl->parse(COMMENT_ROWS, ".comment_row");
			}

			if ($param_reply == "Y") {
				$name_len = "7";
				$board->getBoardList($br_ref, $param_reply, "", "", "", "");
				if (count($board->listNumber) > 1) {
					for ($i = 0; $i < count($board->listNumber); $i++) {
						$reply_img = "";
						$new_img = "";
						$hot_img = "";
						$date = getShortDate($board->listDate[$i]);
						if ($board->listEmail[$i]) $name = "<a href=\"mailto:" . $board->listEmail[$i] . "\">" . cutString($board->listName[$i], $name_len, "") . "</a>";
						else $name = cutString($board->listName[$i], $name_len, "");
						if ($board->listNumber[$i] == $no) {
							$bgcolor = "#F9F9F9";
							$reply_img = getSelectedReplyImage($board->listLevel[$i]);
						} else {
							$bgcolor = "#FFFFFF";
							$reply_img = getReplyImage($board->listLevel[$i]);
						}
						$new_img = getNewImage($date, $param_new);
						$hot_img = getHotImage($param_hot, $board->listCount[$i]);
						$str_len = getSubjectLength(52, $board->listLevel[$i], $param_comment, $board->listCmtCount[$i], $reply_img, $new_img, $hot_img);
						$subject = cutString($board->listSubject[$i], $str_len);
						if ($board->listFont[$i] != "") $subject = "<font color=\"" . $board->listFont[$i] . "\">" . $subject . "</font>";
						if ($param_comment == "Y" && (int)$board->listCmtCount[$i] > 0) $subject .= " <font color=\"#000000\">[" . $board->listCmtCount[$i] . "]</font>";
						$line = "<tr><td colspan=\"11\" height=\"1\" background=\"../../images/board/board_hdot.jpg\"></td></tr>";
						if ($i == count($board->listNumber) - 1) $line = "";
						$tpl->assign(array(REPLY_NUMBER  => $board->listNumber[$i],
						                   REPLY_SUBJECT => $subject,
						                   REPLY_IMAGE   => $reply_img,
						                   NEW_IMAGE     => $new_img,
						                   HOT_IMAGE     => $hot_img,
						                   REPLY_NAME    => $name,
						                   REPLY_DATE    => $date,
						                   REPLY_COUNT   => $board->listCount[$i],
						                   BG_COLOR      => $bgcolor,
						                   DIVIDE_LINE   => $line));
						$tpl->parse(BOARD_ROWS, ".board_row");
					}
					$tpl->parse(REPLY_ROWS, ".reply_row");
				}
				$tpl->parse(BTN_REPLY_ROWS, ".btn_reply_row");
			}

			$board->closeDatabase();
			unset($board);
		
			include_once("../common/tpl_footer.php");
		} else {
			$board->closeDatabase();
			unset($board);
			header("Location: list.php?type=$type");
		}
	}
?>