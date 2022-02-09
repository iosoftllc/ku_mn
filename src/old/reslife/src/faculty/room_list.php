<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 0 && (int)$ihouse_admin_info[grade] != 1 && (int)$ihouse_admin_info[grade] != 2 && (int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/faculty_tpl.php");

			$page_name .= " 리스트";

			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(page_row   => "body",
			                           title1_row => "body",
			                           title2_row => "body",
			                           list1_row  => "body",
			                           list2_row  => "body",
			                           year_row   => "body",
			                           month_row  => "body",
			                           rate_row   => "body",
			                           room_row   => "body"));

			$begin_yr = 2005;
			$end_yr = date("Y") + 1;
			for ($i = $begin_yr; $i <= $end_yr; $i++) {
				$tpl->assign(YEAR_VALUE, $i);
				$tpl->parse(YEAR_ROWS, ".year_row");
			}
			for ($i = 1; $i <= 12; $i++) {
				$temp = $i;
				if ($temp < 10) $temp = "0" . $temp;
				$tpl->assign(MONTH_VALUE, $temp);
				$tpl->parse(MONTH_ROWS, ".month_row");
			}

			$faculty->getRateList("IFRH");
			for ($i = 0; $i < count($faculty->rateListCode); $i++) {
				$tpl->assign(array(RATE_VALUE => $faculty->rateListCode[$i],
				                   RATE_NAME  => $faculty->getDormitoryValue($faculty->rateListDormitory[$i]) . " - " . $faculty->rateListUnit[$i]));
				$tpl->parse(RATE_ROWS, ".rate_row");
			}

			if ($s_rate) {
				$faculty->getRoomList($s_rate, "", "");
				for ($i = 0; $i < count($faculty->roomListCode); $i++) {
					$tpl->assign(array(ROOM_VALUE => $faculty->roomListCode[$i],
					                   ROOM_NAME  => $faculty->roomListCode[$i]));
					$tpl->parse(ROOM_ROWS, ".room_row");
				}
			}

			$list_no = 20;
			$all_count = $faculty->getFacultyCount($s_dorm, $sdate, $edate, $s_type, $s_text, $s_term, $s_state, $s_grade, $s_rate, $s_room);
			$total_page = getTotalPage($all_count, $list_no);
			$page = getCurrentPage($page, $total_page);
			$offset = getOffset($page, $list_no);
			$next_page = getNextPage($page);
			$pre_page = getPrePage($next_page);
			if ($page != 0) {
				for ($i = (int)$next_page-10; $i <= (int)$next_page-1; $i++) {
					if ($i == $page) $page_value = "&nbsp;<b>" . $i . "</b>&nbsp;";
					else $page_value = "&nbsp;<a href=\"javascript:gotoPage(document.FacultyForm, '" . $i . "');\">" . $i . "</a>&nbsp;";
					$tpl->assign(PAGE_VALUE, $page_value);
					$tpl->parse(PAGE_ROWS, ".page_row");
					if ($i == $total_page) break;
				}
			}
			if ((int)$next_page > $total_page) $next_page = "";
			$tpl->assign(array(SEL_PAGE       => $page,
			                   SEARCH_TYPE    => $s_type,
			                   SEARCH_TEXT    => $s_text,
			                   SEARCH_TERM    => $s_term,
			                   SEARCH_STATE   => $s_state,
			                   SEARCH_GRADE   => $s_grade,
			                   SEARCH_RATE    => $s_rate,
			                   SEARCH_ROOM    => $s_room,
			                   SEARCH_DORM    => $s_dorm,
			                   SEARCH_YEAR1   => $s_year1,
			                   SEARCH_MONTH1  => $s_month1,
			                   SEARCH_DAY1    => $s_day1,
			                   SEARCH_YEAR2   => $s_year2,
			                   SEARCH_MONTH2  => $s_month2,
			                   SEARCH_DAY2    => $s_day2,
			                   SORT1_VALUE    => $sort1,
			                   SORT2_VALUE    => $sort2,
			                   PRE_PAGE       => $pre_page,
			                   NEXT_PAGE      => $next_page,
			                   TOTAL_PAGE     => $total_page,
			                   TOTAL_COUNT    => $all_count));

			$detail = "";
			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$faculty->getFacultyList($offset, $list_no, $s_dorm, $sdate, $edate, $s_type, $s_text, $s_term, $s_state, $s_grade, $s_rate, $s_room, $sort);
			for ($i = 0; $i < count($faculty->facListNumber); $i++) {
				$detail .= $faculty->facListNumber[$i] . ", ";
				$name = "";
				if ($faculty->facListTitle[$i]) $name .= $faculty->facListTitle[$i] . ". ";
				$name .= $faculty->facListLName[$i];
				if (trim($faculty->facListFName[$i])) $name .= ", " . $faculty->facListFName[$i] . " " . $faculty->facListMName[$i];
				$tpl->assign(array(LIST_NUMBER   => $faculty->facListNumber[$i],
				                   LIST_STATE    => $faculty->getStateValue($faculty->facListState[$i]),
				                   LIST_NAME     => stripslashes($name),
				                   LIST_EMAIL    => $faculty->facListREmail[$i],
				                   LIST_CHECKIN  => substr($faculty->facListArrival[$i], 0, 10),
				                   LIST_CHECKOUT => substr($faculty->facListDeparture[$i], 0, 10),
				                   LIST_DATE     => substr($faculty->facListDate[$i], 0, 10),
				                   LIST_PAYMENT  => number_format($faculty->getTotalPayment($faculty->facListNumber[$i])),
				                   LIST_ROOM     => $faculty->getRoomValue($faculty->facListNumber[$i]),
				                   LIST_RATE     => stripslashes($faculty->getDormitoryValue2($faculty->facListDormitory[$i]) . " - " . $faculty->facListUnit[$i]),
				                   LIST_ROOM_NO  => number_format($faculty->facListNoRoom[$i])));
				if ($s_state == "IW") $tpl->parse(LIST2_ROWS, ".list2_row");
				else $tpl->parse(LIST1_ROWS, ".list1_row");
			}
			if ($s_state == "IW") $tpl->parse(TITLE2_ROWS, ".title2_row");
			else $tpl->parse(TITLE1_ROWS, ".title1_row");

			if ($detail != "") $detail = substr($detail, 0, -2) . " 객실예약 정보 조회";
			$faculty->insertHistoryWork("R", "L", $detail);

			$faculty->closeDatabase();
			unset($faculty);

			include_once("../common/footer_tpl.php");
		}
	}
?>