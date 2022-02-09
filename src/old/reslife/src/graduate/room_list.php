<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 6 || (int)$ihouse_admin_info[grade] == 7 || (int)$ihouse_admin_info[grade] == 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/grad_room_tpl.php");
			include_once("../common/header_tpl.php");

			$page_name .= " ¸®½ºÆ®";

			$tpl->define_dynamic(array(page_row  => "body",
			                           list_row  => "body"));

			$list_no = 20;
			$all_count = $room->getRoomCount($s_rate, $s_type, $s_text);
			$total_page = getTotalPage($all_count, $list_no);
			$page = getCurrentPage($page, $total_page);
			$offset = getOffset($page, $list_no);
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
			$tpl->assign(array(SEL_PAGE    => $page,
			                   SEARCH_RATE => $s_rate,
			                   SEARCH_TYPE => $s_type,
			                   SEARCH_TEXT => $s_text,
			                   SORT1_VALUE => $sort1,
			                   SORT2_VALUE => $sort2,
			                   PRE_PAGE    => $pre_page,
			                   NEXT_PAGE   => $next_page,
			                   TOTAL_PAGE  => $total_page,
			                   TOTAL_COUNT => $all_count));

			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$room->getRoomList($s_rate, $offset, $list_no, $s_type, $s_text, $sort);
			for ($i = 0; $i < count($room->roomListCode); $i++) {
				$tpl->assign(array(LIST_ROOM  => $room->roomListCode[$i],
				                   LIST_RATE  => $room->getRateName($room->roomListRate[$i]),
				                   LIST_PHONE => $room->roomListPhone[$i],
				                   LIST_IP    => $room->roomListIP[$i]));
				$tpl->parse(LIST_ROWS, ".list_row");
			}

			$room->closeDatabase();
			unset($room);

			include_once("../common/footer_tpl.php");
		}
	}
?>