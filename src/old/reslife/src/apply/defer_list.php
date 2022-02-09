<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 7 && (int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/defer_tpl.php");

			$page_name .= " 리스트";

			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(list_row   => "body",
			                           period_row => "body",
			                           year_row   => "body",
			                           month_row  => "body"));

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

			$defer->getPeriodList("");
			for ($i = 0; $i < count($defer->periodCode); $i++) {
				$tpl->assign(array(PERIOD_CODE => $defer->periodCode[$i],
				                   PERIOD_NAME => stripslashes($defer->periodName[$i])));
				$tpl->parse(PERIOD_ROWS, ".period_row");
			}

			$list_no = 20;
			$all_count = $defer->getDeferCount($sdate, $edate, $s_type, $s_text, $s_approve, $s_period);
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
			$tpl->assign(array(SEL_PAGE       => $page,
			                   SEARCH_TYPE    => $s_type,
			                   SEARCH_TEXT    => $s_text,
			                   SEARCH_APPROVE => $s_approve,
			                   SEARCH_PERIOD  => $s_period,
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
			$defer->getDeferList($sdate, $edate, $offset, $list_no, $s_type, $s_text, $s_approve, $s_period, $sort);
			for ($i = 0; $i < count($defer->deferListNumber); $i++) {
				$detail .= $defer->deferListApplyNo[$i] . ", ";
				$tpl->assign(array(LIST_NUMBER     => $defer->deferListNumber[$i],
				                   LIST_APPROVE    => $defer->getApproveValue($defer->deferListApprove[$i]),
				                   LIST_APPLY_NO   => $defer->deferListApplyNo[$i],
				                   LIST_STUDENT_NO => $defer->deferListStudentNo[$i],
				                   LIST_STUDENT_ID => $defer->deferListStudentID[$i],
				                   LIST_NAME       => stripslashes($defer->deferListSurName[$i] . ", " . $defer->deferListGivenName[$i]),
				                   LIST_EMAIL      => $defer->deferListEmail[$i],
				                   LIST_UNPAID     => number_format($defer->deferListAmount[$i]),
				                   LIST_EDIT       => substr($defer->deferListEdit[$i], 0, 10),
				                   LIST_POST       => substr($defer->deferListPost[$i], 0, 10),
				                   LIST_PERIOD     => stripslashes($defer->deferListPeriod[$i])));
				$tpl->parse(LIST_ROWS, ".list_row");
			}

			if ($detail != "") $detail = substr($detail, 0, -2) . " 지원번호 납부연기 정보 조회";
			$defer->insertHistoryWork("P", "L", $detail);

			$defer->closeDatabase();
			unset($defer);

			include_once("../common/footer_tpl.php");
		}
	}
?>