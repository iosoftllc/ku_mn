<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 7 && (int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/apply_tpl.php");

			$page_name .= " ¸®½ºÆ®";

			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(page_row   => "body",
			                           list_row   => "body",
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

			$applicant->getPeriodList($kind);
			for ($i = 0; $i < count($applicant->periodCode); $i++) {
				$tpl->assign(array(PERIOD_CODE => $applicant->periodCode[$i],
				                   PERIOD_NAME => stripslashes($applicant->periodName[$i])));
				$tpl->parse(PERIOD_ROWS, ".period_row");
			}

			if ($s_kind == "U") $email_type = "stu";
			else if ($s_kind == "L") $email_type = "lan";
			else $email_type = "";

			$list_no = 20;
			$all_count = $applicant->getApplicantCount($sdate, $edate, $s_type, $s_text, $s_state, $s_kind, $s_current, $s_period);
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
			                   SEARCH_STATE   => $s_state,
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
			                   TOTAL_COUNT    => $all_count,
			                   EMAIL_TYPE     => $email_type));

			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$applicant->getApplicantList($sdate, $edate, $offset, $list_no, $s_type, $s_text, $s_state, $s_kind, $s_current, $s_period, $sort);
			for ($i = 0; $i < count($applicant->listNumber); $i++) {
				if ($applicant->listLastName[$i]) $name = stripslashes($applicant->listLastName[$i]) . ", " . stripslashes($applicant->listFirstName[$i]);
				else $name = stripslashes($applicant->listFirstName[$i]);
				$tpl->assign(array(LIST_NUMBER  => $applicant->listNumber[$i],
				                   LIST_STUDENT => $applicant->listStudentID[$i],
				                   LIST_NAME    => $name,
				                   LIST_GENDER  => $applicant->getGenderValue($applicant->listGender[$i]),
				                   LIST_EMAIL   => $applicant->listEmail[$i],
				                   LIST_APPLY   => substr($applicant->listDate[$i], 0, 10),
				                   LIST_CURRENT => $applicant->getResidentValue($applicant->listCurrent[$i]),
				                   LIST_STATE   => $applicant->getStateValue($applicant->listState[$i]),
				                   LIST_PERIOD  => stripslashes($applicant->listPeriodName[$i]),
				                   LIST_PAYMENT => number_format($applicant->listPayment[$i]),
				                   LIST_ROOM    => $applicant->listRoomCode[$i],
				                   LIST_PHOTO   => getListImage($pht_dir."/".$applicant->listNumber[$i].".jpg")));
				$tpl->parse(LIST_ROWS, ".list_row");
			}

			$applicant->closeDatabase();
			unset($applicant);

			include_once("../common/footer_tpl.php");
		}
	}
?>