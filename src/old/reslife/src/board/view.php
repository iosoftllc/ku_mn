<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		$no = $_POST["no"];
		if ($no == "") $no = $_GET["no"];
	
		include_once("../common/board_tpl.php");
	
		$board->getBoardInfo($no);
		$br_ref = $board->boardReference;
		if ($br_ref != "") {
			include_once("../../lib/func.common.php");
			include_once("../common/header_tpl.php");
	
			if ($param_attach == "Y") {
				$photo = "";
				$board->getAttachList($no);
				if (file_exists($webdir."/upload/board/thumbnail/".$board->listAttachNo[0].".jpg")) $photo = "<a href=\"javascript:previewImage('../../../upload/board/" . $board->listAttachNo[0] . ".jpg');\" target=\"_top\"><img src=\"../../../upload/board/thumbnail/" . $board->listAttachNo[0] . ".jpg?tmp=" . md5(time()) . "\" border=\"0\" align=\"left\" style=\"padding-right:10px;padding-bottom:10px;\"></a>";
				$tpl->define_dynamic(attach_row, "body");
				$tpl->assign(FILE_LIST, $photo);
				$tpl->parse(ATTACH_ROWS, ".attach_row");
			}
	
			$pre_no = "";
			$pre_title = "";
			$next_no = "";
			$next_title = "";
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
			else $date = $board->postDate;
			if ($board->topFlag == "Y") $top_flag = "설정";
			else $top_flag = "해제";
			if ($board->boardMember == "SU") $board_mem = "관리자";
			else if ($board->boardMember != "") $board_mem = "회원 - " . $board->boardMember;
			else $board_mem = "비회원";
			$content = getContents($board->boardContent, $board->htmlFlag);
			$content = makeAutoLink($content);
			$tpl->assign(array(BOARD_TYPE       => $type,
			                   SEL_PAGE         => $page,
			                   SEARCH_TYPE      => $s_type,
			                   SEARCH_TEXT      => $s_text,
			                   BOARD_MEMBER     => $board_mem,
			                   BOARD_NO         => $no,
			                   BOARD_REF        => $br_ref,
			                   PRE_BOARD_NO     => $pre_no,
			                   PRE_BOARD_TITLE  => $pre_title,
			                   NEXT_BOARD_NO    => $next_no,
			                   NEXT_BOARD_TITLE => $next_title,
			                   WRITER_NAME      => $board->writerName,
			                   WRITER_EMAIL     => $board->writerEmail,
			                   READ_COUNT       => $board->readCount,
			                   TOP_FLAG         => $top_flag,
			                   POST_DATE        => $date,
			                   POST_IP          => $board->postIP,
			                   SUBJECT          => $subject,
			                   CONTENT          => $content));
		
			if ($param_comment == "Y") {
				$tpl->define_dynamic(array(comment_row      => "body",
				                           comment_list_row => "body"));
				$board->getCommentList($no);
				for ($i = 0; $i < count($board->listCommentNo); $i++) {
					if ($board->listCommentMember[$i] == "SU") $comment_mem = "관리자";
					else if ($board->listCommentMember[$i] != "") $comment_mem = "회원 - " . $board->listCommentMember[$i];
					else $comment_mem = "비회원";
					$content = getContents($board->listCommentContent[$i], "N");
					$content = makeAutoLink($content);
					$tpl->assign(array(COMMENT_NUMBER  => $board->listCommentNo[$i],
					                   COMMENT_MEMBER  => $comment_mem,
					                   COMMENT_NAME    => $board->listCommentName[$i],
					                   COMMENT_DATE    => substr($board->listCommentDate[$i], 5),
					                   COMMENT_IP      => $board->listCommentIP[$i],
					                   COMMENT_CONTENT => $content));
					$tpl->parse(COMMENT_LIST_ROWS, ".comment_list_row");
				}
				$tpl->assign(COMMENT_INPUT_NAME, $ihouse_admin_info[name]);
				$tpl->parse(COMMENT_ROWS, ".comment_row");
			}
	
			if ($param_reply == "Y") {
				$tpl->define_dynamic(array(reply_row         => "body",
				                           board_row         => "body",
				                           reply_button_row  => "body"));
				$board->getBoardList($br_ref, $param_reply, "", "", "", "");
				if (count($board->listNumber) > 1) {
					for ($i = 0; $i < count($board->listNumber); $i++) {
						$date = getShortDate($board->listDate[$i]);
						$reply_img = getSelectedReplyImage($board->listLevel[$i]);
						$new_img = getNewImage($date, $param_new);
						$hot_img = getHotImage($param_hot, $board->listCount[$i]);
						if ($no == $board->listNumber[$i]) $bgcolor = "#F5F5F5";
						else $bgcolor = "#FFFFFF";
						$subject = $board->listSubject[$i];
						if ($board->listFont[$i] != "") $subject = "<font color=\"" . $board->listFont[$i] . "\">" . $subject . "</font>";
						if ($param_comment == "Y" && (int)$board->listCmtCount[$i] > 0) $subject .= " <font color=\"#000000\">[" . $board->listCmtCount[$i] . "]</font>";
						$tpl->assign(array(REPLY_NUMBER  => $board->listNumber[$i],
						                   REPLY_SUBJECT => $subject,
						                   REPLY_IMAGE   => $reply_img,
						                   NEW_IMAGE     => $new_img,
						                   HOT_IMAGE     => $hot_img,
						                   REPLY_NAME    => $board->listName[$i],
						                   REPLY_EMAIL   => $board->listEmail[$i],
						                   REPLY_DATE    => $date,
						                   REPLY_COUNT   => $board->listCount[$i],
						                   REPLY_BGCOLOR => $bgcolor));
						$tpl->parse(BOARD_ROWS, ".board_row");
					}
					$tpl->parse(REPLY_ROWS, ".reply_row");
				}
				$tpl->parse(REPLY_BUTTON_ROWS, ".reply_button_row");
			}
		
			$board->closeDatabase();
			unset($board);
		
			include_once("../common/footer_tpl.php");
		} else {
			$board->closeDatabase();
			unset($board);
			header("Location: list.php?type=$type");
		}
	}
?>