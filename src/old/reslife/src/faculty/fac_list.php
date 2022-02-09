<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 0 && (int)$ihouse_admin_info[grade] != 1 && (int)$ihouse_admin_info[grade] != 2 && (int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/facility_tpl.php");

			$page_name .= " 리스트";

			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(page_row  => "body",
			                           list_row  => "body",
			                           year_row  => "body",
			                           month_row => "body"));

			$begin_yr = 2005;
			$end_yr = date("Y");
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

			$list_no = 20;
			$all_count = $facility->getFacilityCount($s_room, $s_state, $s_grade, $sdate, $edate, $s_type, $s_text);
			$total_page = getTotalPage($all_count, $list_no);
			$page = getCurrentPage($page, $total_page);
			$offset = getOffset($page, $list_no);
			$next_page = getNextPage($page);
			$pre_page = getPrePage($next_page);
			if ($page != 0) {
				for ($i = (int)$next_page-10; $i <= (int)$next_page-1; $i++) {
					if ($i == $page) $page_value = "&nbsp;<b>" . $i . "</b>&nbsp;";
					else $page_value = "&nbsp;<a href=\"javascript:gotoPage(document.FacilityForm, '" . $i . "');\">" . $i . "</a>&nbsp;";
					$tpl->assign(PAGE_VALUE, $page_value);
					$tpl->parse(PAGE_ROWS, ".page_row");
					if ($i == $total_page) break;
				}
			}
			if ((int)$next_page > $total_page) $next_page = "";
			$tpl->assign(array(SEL_PAGE       => $page,
			                   SEARCH_TYPE    => $s_type,
			                   SEARCH_TEXT    => $s_text,
			                   SEARCH_STATE   => $s_state,
			                   SEARCH_GRADE   => $s_grade,
			                   SEARCH_ROOM    => $s_room,
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
			$facility->getFacilityList($offset, $list_no, $s_room, $s_state, $s_grade, $sdate, $edate, $s_type, $s_text, $sort);
			for ($i = 0; $i < count($facility->facListNumber); $i++) {
				$detail .= $facility->facListNumber[$i] . ", ";
				$tpl->assign(array(LIST_NUMBER    => $facility->facListNumber[$i],
				                   LIST_STATE     => $facility->getStateValue($facility->facListState[$i]),
				                   EVENT_NAME     => stripslashes($facility->facListEventName[$i]),
				                   EVENT_DATE     => $facility->facListEventDate[$i],
				                   LIST_APPLICANT => stripslashes($facility->facListApplicant[$i]),
				                   LIST_EMAIL     => $facility->facListEmail[$i],
				                   LIST_PHONE     => $facility->facListPhone[$i],
				                   LIST_REQUEST   => $facility->getRequestValue($facility->facListRequest[$i]),
				                   LIST_FEE       => number_format($facility->facListFee[$i]),
				                   LIST_MEAL      => number_format($facility->facListMeal[$i]),
				                   LIST_CANCEL    => number_format($facility->facListCancel[$i]),
				                   LIST_APPLY     => substr($facility->facListApply[$i], 0, 10),
				                   LIST_BREAKFAST => $facility->getBreakfastValue($facility->facListBreakfast[$i])));
				$tpl->parse(LIST_ROWS, ".list_row");
			}

			if ($detail != "") $detail = substr($detail, 0, -2) . " 시설예약 정보 조회";
			$facility->insertHistoryWork("F", "L", $detail);

			$facility->closeDatabase();
			unset($facility);

			include_once("../common/footer_tpl.php");
		}
	}
?>