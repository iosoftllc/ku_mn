<?
	include_once("../../lib/conf.common.php");
	include_once("../common/board_tpl.php");

	if ($param_auth_list == "N") {
		$board->closeDatabase();
		unset($board);
		include_once("../common/admin_check_tpl.php");
	} else if ($param_auth_list == "M" && !$log_flag) {
		$board->closeDatabase();
		unset($board);
		include_once("../common/login_check_tpl.php");
	} else {
		$html_dir = "board";
		$html_file = "list";
		$on_load = "";

		include_once("../../lib/func.common.php");
		include_once("../common/tpl_header.php");

		$page = $_POST["page"];
		$s_type = $_POST["s_type"];
		$s_text = $_POST["s_text"];
		if ($page == "") $page = $_GET["page"];
		if ($s_type == "") $s_type = $_GET["s_type"];
		if ($s_text == "") $s_text = $_GET["s_text"];

		$tpl->define_dynamic(array(page_row  => "body",
		                           post_row  => "body",
		                           top_row   => "body",
		                           board_row => "body"));

		if ($param_auth_post == "M" && $log_flag) $tpl->parse(POST_ROWS, ".post_row");
		else if ($param_auth_post == "A") $tpl->parse(POST_ROWS, ".post_row");

		$reference = "0";
		$all_count = $board->getBoardCount($reference, $param_reply, $s_type, $s_text);
		$total_page = getTotalPage($all_count, $param_list);
		$page = getCurrentPage($page, $total_page);
		$offset = getOffset($page, $param_list);
		$next_page = getNextPage($page);
		$pre_page = getPrePage($next_page);
		if ($page != 0) {
			for ($i = (int)$next_page-10; $i <= (int)$next_page-1; $i++) {
				if ($i == $page) $page_value = "&nbsp;<b>" . $i . "</b>&nbsp;";
				else $page_value = "&nbsp;<a href=\"javascript:gotoPage('" . $i . "');\">" . $i . "</a>&nbsp;";
				$tpl->assign(PAGE_VALUE, $page_value);
				$tpl->parse(PAGE_ROWS, ".page_row");
				if ($i == $total_page) break;
			}
		}
		if ((int)$next_page > $total_page) $next_page = "";
		$tpl->assign(array(BOARD_TYPE  => $type,
		                   SEL_PAGE    => $page,
		                   SEARCH_TYPE => $s_type,
		                   SEARCH_TEXT => $s_text,
		                   PRE_PAGE    => $pre_page,
		                   NEXT_PAGE   => $next_page,
		                   TOTAL_PAGE  => $total_page,
		                   TOTAL_COUNT => $all_count,
		                   BOARD_TITLE => $board_img));

		$name_len = 7;
		$subject_len = 45;
		if ($s_text == "") {
			$board->getTopList();
			for ($i = 0; $i < count($board->listNumber); $i++) {
				$date = getShortDate($board->listDate[$i]);
				if ($board->listEmail[$i]) $name = "<a href=\"mailto:" . $board->listEmail[$i] . "\">" . cutString($board->listName[$i], $name_len, "") . "</a>";
				else $name = cutString($board->listName[$i], $name_len, "");
				$str_len = getSubjectLength($subject_len, "", "", "", "", "", "");
				$subject = cutString($board->listSubject[$i], $str_len);
				if ($board->listFont[$i] != "") $subject = "<font color=\"" . $board->listFont[$i] . "\">" . $subject . "</font>";
				$tpl->assign(array(COUNT_NO     => $count--,
				                   BOARD_NUMBER => $board->listNumber[$i],
				                   SUBJECT      => $subject,
				                   WRITER_NAME  => $name,
				                   WRITE_DATE   => $date,
				                   READ_COUNT   => $board->listCount[$i]));
				$tpl->parse(TOP_ROWS, ".top_row");
			}
		}

		$count = getOrderNumber($all_count, $param_list, $page);
		$board->getBoardList($reference, $param_reply, $offset, $param_list, $s_type, $s_text);
		for ($i = 0; $i < count($board->listNumber); $i++) {
			$reply_img = "";
			$new_img = "";
			$hot_img = "";
			$date = getShortDate($board->listDate[$i]);
			if ($board->listEmail[$i]) $name = "<a href=\"mailto:" . $board->listEmail[$i] . "\">" . cutString($board->listName[$i], $name_len, "") . "</a>";
			else $name = cutString($board->listName[$i], $name_len, "");
			if ($param_reply == "Y") $reply_img = getReplyImage($board->listLevel[$i]);
			$new_img = getNewImage($date, $param_new);
			$hot_img = getHotImage($param_hot, $board->listCount[$i]);
			$str_len = getSubjectLength($subject_len, $board->listLevel[$i], $param_comment, $board->listCmtCount[$i], $reply_img, $new_img, $hot_img);
			$subject = cutString($board->listSubject[$i], $str_len);
			if ($board->listFont[$i] != "") $subject = "<font color=\"" . $board->listFont[$i] . "\">" . $subject . "</font>";
			if ($param_comment == "Y" && (int)$board->listCmtCount[$i] > 0) $subject .= " <font color=\"#000000\">[" . $board->listCmtCount[$i] . "]</font>";
			$line = "<tr><td colspan=\"13\" height=\"1\" background=\"../../images/board/board_hdot.jpg\"></td></tr>";
			if ($i == count($board->listNumber) - 1) $line = "";
			$tpl->assign(array(COUNT_NO     => $count--,
			                   BOARD_NUMBER => $board->listNumber[$i],
			                   SUBJECT      => $subject,
			                   REPLY_IMAGE  => $reply_img,
			                   NEW_IMAGE    => $new_img,
			                   HOT_IMAGE    => $hot_img,
			                   WRITER_NAME  => $name,
			                   WRITE_DATE   => $date,
			                   READ_COUNT   => $board->listCount[$i],
			                   DIVIDE_LINE  => $line));
			$tpl->parse(BOARD_ROWS, ".board_row");
		}

		$board->closeDatabase();
		unset($board);

		include_once("../common/tpl_footer.php");
	}
?>