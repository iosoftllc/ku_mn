<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 0 && (int)$ihouse_admin_info[grade] != 1 && (int)$ihouse_admin_info[grade] != 2 && (int)$ihouse_admin_info[grade] != 7 && (int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/application_tpl.php");

			$page_name .= " 리스트";

			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(rate_row   => "body",
			                           page_row   => "body",
			                           title1_row => "body",
			                           title2_row => "body",
			                           list1_row  => "body",
			                           list2_row  => "body",
			                           period_row => "body",
			                           view_row   => "body",
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

			$application->getRateList1();
			for ($i = 0; $i < count($application->rateCode); $i++) {
				$tpl->assign(array(RATE_VALUE => $application->rateCode[$i],
				                   RATE_TEXT  => "[" . $application->rateDormitory[$i] . "] " . stripslashes($application->rateName[$i])));
				$tpl->parse(RATE_ROWS, ".rate_row");
			}

			$application->getPeriodList("");
			for ($i = 0; $i < count($application->periodCode); $i++) {
				$tpl->assign(array(PERIOD_CODE => $application->periodCode[$i],
				                   PERIOD_NAME => stripslashes($application->periodName[$i])));
				$tpl->parse(PERIOD_ROWS, ".period_row");
			}

			$list_no = 20;
			$all_count = $application->getApplicationCount($sdate, $edate, $s_type, $s_text, $s_rate, $s_state, $s_grade, $s_kind, $s_current, $s_period);
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
			                   SEARCH_KIND    => $s_kind,
			                   SEARCH_RATE    => $s_rate,
			                   SEARCH_STATE   => $s_state,
			                   SEARCH_GRADE   => $s_grade,
			                   SEARCH_CURRENT => $s_current,
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
			$application->getApplicationList($sdate, $edate, $offset, $list_no, $s_type, $s_text, $s_rate, $s_state, $s_grade, $s_kind, $s_current, $s_period, $sort);
			for ($i = 0; $i < count($application->listNumber); $i++) {
				$detail .= $application->listNumber[$i] . ", ";
				if ($application->listLastName[$i]) $name = stripslashes($application->listLastName[$i]) . ", " . stripslashes($application->listFirstName[$i]);
				else $name = stripslashes($application->listFirstName[$i]);
				if ($s_state == "IW" || $s_state == "DP" || $s_state == "DD") $room = $application->listPreRateName[$i];
				else $room = $application->listRoomCode[$i];
				$tpl->assign(array(LIST_NUMBER     => $application->listNumber[$i],
				                   LIST_STUDENT_NO => $application->listStudentNo[$i],
				                   LIST_STUDENT_ID => $application->listStudentID[$i],
				                   LIST_NAME       => $name,
				                   LIST_GENDER     => $application->getGenderValue($application->listGender[$i]),
				                   LIST_EMAIL      => $application->listEmail[$i],
				                   LIST_APPLY      => substr($application->listDate[$i], 0, 10),
				                   LIST_APP_DATE   => substr($application->getDepositPaidDate($application->listNumber[$i]), 0, 10),
				                   LIST_NATION     => stripslashes($application->listNation[$i]),
				                   LIST_CURRENT    => $application->getCurrentValue($application->listCurrent[$i]),
				                   LIST_STATE      => $application->getStateValue($application->listState[$i]),
				                   LIST_PERIOD     => stripslashes($application->listPeriodName[$i]),
				                   LIST_DEPOSIT    => number_format($application->getDepositPaidAmount($application->listNumber[$i])),
				                   LIST_RESIDENCE  => number_format($application->getResidencePaidAmount($application->listNumber[$i])),
				                   LIST_PAYMENT    => number_format($application->listPayment[$i]),
				                   LIST_ROOM       => $room,
				                   LIST_PHOTO      => getListImage($pht_dir."/".$application->listStudentNo[$i].".jpg")));
				if ($s_state == "IW" || $s_state == "DP" || $s_state == "DD") $tpl->parse(LIST2_ROWS, ".list2_row");
				else $tpl->parse(LIST1_ROWS, ".list1_row");
			}

			if ($s_state == "IW" || $s_state == "DP" || $s_state == "DD") $tpl->parse(TITLE2_ROWS, ".title2_row");
			else $tpl->parse(TITLE1_ROWS, ".title1_row");

			if ($detail != "") $detail = substr($detail, 0, -2) . " 온라인지원 정보 조회";
			$application->insertHistoryWork("A", "L", $detail);

			$application->closeDatabase();
			unset($application);

			include_once("../common/footer_tpl.php");
		}
	}
?>