<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		include_once("../../lib/func.common.php");
		include_once("../common/board_tpl.php");
		include_once("../common/header_tpl.php");

		$on_load = "";

		$tpl->define_dynamic(array(page_row  => "body",
		                           top_row   => "body",
		                           board_row => "body"));
	
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
	
		$top_count = 0;
		if ($s_text == "") {
			$board->getTopList();
			for ($i = 0; $i < count($board->listNumber); $i++) {
				$new_img = "";
				$hot_img = "";
				$date = getShortDate($board->listDate[$i]);
				$new_img = getNewImage($date, $param_new);
				$hot_img = getHotImage($param_hot, $board->listCount[$i]);
				$subject = $board->listSubject[$i];
				if ($board->listFont[$i] != "") $subject = "<font color=\"" . $board->listFont[$i] . "\">" . $subject . "</font>";
				$tpl->assign(array(COUNT_NO     => $count--,
				                   BOARD_NUMBER => $board->listNumber[$i],
				                   SUBJECT      => $subject,
				                   NEW_IMAGE    => $new_img,
				                   HOT_IMAGE    => $hot_img,
				                   WRITER_NAME  => $board->listName[$i],
				                   WRITER_EMAIL => $board->listEmail[$i],
				                   WRITE_DATE   => $date,
				                   READ_COUNT   => $board->listCount[$i]));
				$tpl->parse(TOP_ROWS, ".top_row");
				$top_count++;
			}
		}
	
		$count = getOrderNumber($all_count, $param_list, $page);
		$board->getBoardList($reference, $param_reply, $offset, $param_list, $s_type, $s_text);
		for ($i = 0; $i < count($board->listNumber); $i++) {
			$reply_img = "";
			$new_img = "";
			$hot_img = "";
			$date = getShortDate($board->listDate[$i]);
			if ($param_reply == "Y") $reply_img = getReplyImage($board->listLevel[$i]);
			$new_img = getNewImage($date, $param_new);
			$hot_img = getHotImage($param_hot, $board->listCount[$i]);
			$subject = $board->listSubject[$i];
			if ($board->listFont[$i] != "") $subject = "<font color=\"" . $board->listFont[$i] . "\">" . $subject . "</font>";
			if ($param_comment == "Y" && (int)$board->listCmtCount[$i] > 0) $subject .= " <font color=\"#000000\">[" . $board->listCmtCount[$i] . "]</font>";
			$tpl->assign(array(COUNT_NO     => $count--,
			                   BOARD_NUMBER => $board->listNumber[$i],
			                   SUBJECT      => $subject,
			                   REPLY_IMAGE  => $reply_img,
			                   NEW_IMAGE    => $new_img,
			                   HOT_IMAGE    => $hot_img,
			                   WRITER_NAME  => $board->listName[$i],
			                   WRITER_EMAIL => $board->listEmail[$i],
			                   WRITE_DATE   => $date,
			                   READ_COUNT   => $board->listCount[$i]));
			$tpl->parse(BOARD_ROWS, ".board_row");
		}
	
		$tpl->assign(array(BOARD_TYPE  => $type,
		                   SEL_PAGE    => $page,
		                   SEARCH_TYPE => $s_type,
		                   SEARCH_TEXT => $s_text,
		                   PRE_PAGE    => $pre_page,
		                   NEXT_PAGE   => $next_page,
		                   TOTAL_PAGE  => $total_page,
		                   TOTAL_COUNT => $all_count,
		                   TOP_COUNT   => $top_count));
	
		$board->closeDatabase();
		unset($board);
	
		include_once("../common/footer_tpl.php");
	}
?>