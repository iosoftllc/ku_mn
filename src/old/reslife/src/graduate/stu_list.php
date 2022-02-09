<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 6 || (int)$ihouse_admin_info[grade] == 7 || (int)$ihouse_admin_info[grade] == 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/grad_student_tpl.php");
			include_once("../common/header_tpl.php");

			$page_name .= " 리스트";

			$tpl->define_dynamic(array(page_row  => "body",
			                           list_row  => "body",
			                           year_row  => "body",
			                           month_row => "body"));

			$begin_yr = 2019;
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
			$all_count = $student->getStudentCount($sdate, $edate, $s_type, $s_text, $s_kind, $s_nation, $s_current);
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
			                   SEARCH_NATION  => $s_nation,
			                   SEARCH_CURRENT => $s_current,
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
			$student->getStudentList($sdate, $edate, $offset, $list_no, $s_type, $s_text, $s_kind, $s_nation, $s_current, $sort);
			for ($i = 0; $i < count($student->stuListNumber); $i++) {
				$detail .= $student->stuListID[$i] . ", ";
				if ($student->stuListLastName[$i]) $name = stripslashes($student->stuListLastName[$i]) . ", " . stripslashes($student->stuListFirstName[$i]);
				else $name = stripslashes($student->stuListFirstName[$i]);
				$tpl->assign(array(LIST_NUMBER  => $student->stuListNumber[$i],
				                   LIST_STUDENT => $student->stuListID[$i],
				                   LIST_NAME    => $name,
				                   LIST_GENDER  => $student->getGenderValue($student->stuListGender[$i]),
				                   LIST_EMAIL   => $student->stuListEmail[$i],
				                   LIST_DATE    => substr($student->stuListDate[$i], 0, 10),
				                   LIST_NATION  => stripslashes($student->stuListNationality[$i]),
				                   LIST_CURRENT => $student->getCurrentValue($student->stuListCurrent[$i]),
				                   LIST_PHOTO   => getListImage($pht_dir."/".$student->stuListNumber[$i].".jpg")));
				$tpl->parse(LIST_ROWS, ".list_row");
			}

			if ($detail != "") $detail = substr($detail, 0, -2) . " 학번 정보 조회";
			$student->insertHistoryWork("S", "L", $detail);

			$student->closeDatabase();
			unset($student);

			include_once("../common/footer_tpl.php");
		}
	}
?>