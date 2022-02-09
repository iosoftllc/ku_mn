<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../../lib/class.cCounter.php");
		include_once("../../lib/class.rFastTemplate.php");
	
		$counter = new cCounter($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $counterTable);
		$counter->connectDatabase();
		$main_index = 5;
		$sub_index = 0;
		$on_load = "";

		$ct_type = $_POST["ct_type"];
		$ct_year = $_POST["ct_year"];
		$ct_month = $_POST["ct_month"];
		$ct_day = $_POST["ct_day"];
		if (!$ct_type) $ct_type = $_GET["ct_type"];
		if (!$ct_type) $ct_type = "month_day";
		if (!$ct_year) $ct_year = date("Y");
		if (!$ct_month) $ct_month = date("m");
		if (!$ct_day) $ct_day = date("d");
		$page_name = "";
		$ct_date = "";
		$ct_period = "";
		$submenu = "stat_blank.html";
		$result = "ct_result.html";
		if ($ct_type == "month_day" || $ct_type == "month_week" || $ct_type == "month_hour" || $ct_type == "month_os" || $ct_type == "month_brow") {
			$page_name = "월별 접속통계";
			$ct_date = $ct_year . "-" . $ct_month . "-01";
			$ct_period = $ct_year . "년 " . $ct_month . "월";
			$submenu = "ct_month_submenu.html";
		} else if ($ct_type == "year_month" || $ct_type == "year_hour" || $ct_type == "year_os" || $ct_type == "year_brow" || $ct_type == "year_week") {
			$page_name = "년도별 접속통계";
			$ct_date = $ct_year . "-01-01";
			$ct_period = $ct_year . "년";
			$submenu = "ct_year_submenu.html";
		} else if ($ct_type == "info") {
			$page_name = "접속정보";
			$ct_date = $ct_year . "-" . $ct_month . "-" . $ct_day;
			$submenu = "ct_info_submenu.html";
			$result = "ct_info_result.html";
		} else if ($ct_type == "hour") $page_name = "시간별 접속통계";
		else if ($ct_type == "week") $page_name = "요일별 접속통계";
		else if ($ct_type == "os") $page_name = "운영체제별 접속통계";
		else if ($ct_type == "brow") $page_name = "브라우져별 접속통계";
		
		include_once("../common/header_tpl.php");

		if ($ct_type == "hour" || $ct_type == "week" || $ct_type == "os" || $ct_type == "brow") {
			$tpl->define_dynamic(array(result_row => "stat_result"));
		} else {
			$tpl->define_dynamic(array(year_row   => "stat_submenu",
			                           month_row  => "stat_submenu",
			                           day_row    => "stat_submenu",
			                           result_row => "stat_result"));
			$counter->getYearList();
			if (count($counter->listYear) == 0) {
				$tpl->assign(YEAR_VALUE, date("Y"));
				$tpl->parse(YEAR_ROW, ".year_row");
			} else {
				for ($i = 0; $i < count($counter->listYear); $i++) {
					$tpl->assign(YEAR_VALUE, $counter->listYear[$i]);
					$tpl->parse(YEAR_ROW, ".year_row");
				}
			}
			for ($i = 1; $i <= 31; $i++) {
				if ($i < 10) $temp = "0" . $i;
				else $temp = $i;
				if ($i <= 12) {
					$tpl->assign(MONTH_VALUE, $temp);
					$tpl->parse(MONTH_ROW, ".month_row");
				}
				$tpl->assign(DAY_VALUE, $temp);
				$tpl->parse(DAY_ROW, ".day_row");
			}
		}
	
		if ($ct_type == "info") $total_count = $counter->getConnectionCount($ct_date);
		else $total_count = $counter->getCount($ct_type, $ct_date);
		$tpl->assign(array(COUNTER_TYPE => $ct_type,
		                   COUNT_PERIOD => $ct_period,
		                   SEL_YEAR     => $ct_year,
		                   SEL_MONTH    => $ct_month,
		                   SEL_DAY      => $ct_day,
		                   TOTAL_COUNT  => $total_count));
	
		if ($ct_type == "info") {
			include_once("../../lib/func.common.php");
			$list_no = 10;
			$total_page = getTotalPage($total_count, $list_no);
			$page = getCurrentPage($page, $total_page);
			$offset = getOffset($page, $list_no);
			$next_page = getNextPage($page);
			$pre_page = getPrePage($next_page);
	
			$tpl->define_dynamic(array(page_row => "stat_result"));
			if ($page != 0) {
				for ($i = (int)$next_page-10; $i <= (int)$next_page-1; $i++) {
					if ($i == $page) $page_value = "&nbsp;<font>" . $i . "</font>&nbsp;";
					else $page_value = "&nbsp;<a href=\"javascript:gotoPage('" . $i . "');\">" . $i . "</a>&nbsp;";
					$tpl->assign(PAGE_VALUE, $page_value);
					$tpl->parse(PAGE_ROWS, ".page_row");
					if ($i == $total_page) break;
				}
			}
			if ((int)$next_page > $total_page) $next_page = "";
	
			$tpl->assign(array(SEL_PAGE  => $page,
			                   PRE_PAGE  => $pre_page,
			                   NEXT_PAGE => $next_page));
	
			$counter->getConnectionInfo($offset, $list_no, $ct_date);
			for ($i = 0; $i < count($counter->listType); $i++) {
				$tpl->assign(array(LIST_TYPE    => $counter->listType[$i],
				                   LIST_TIME    => substr($counter->listDate[$i], 11, 5),
				                   LIST_IP      => $counter->listIP[$i],
				                   LIST_BROWSER => $counter->listBrowser[$i],
				                   LIST_OS      => $counter->listOS[$i]));
				$tpl->parse(RESULT_ROW, ".result_row");
			}
		} else {
			$counter->getInformation($ct_type, $ct_year, $ct_month, $ct_day);
			if ($ct_type == "month_day") $loop_cnt = date(t, mktime(0, 0, 0, $ct_month, 1, $ct_year));
			else if ($ct_type == "year_month") $loop_cnt = 12;
			else if ($ct_type == "hour" || $ct_type == "month_hour" || $ct_type == "year_hour") $loop_cnt = 24;
			else if ($ct_type == "week" || $ct_type == "month_week" || $ct_type == "year_week") $loop_cnt = 7;
			else $loop_cnt = count($counter->listType);
			$arr_index = 0;
			for ($i = 0; $i < $loop_cnt; $i++) {
				if ($ct_type == "hour" || $ct_type == "month_hour" || $ct_type == "year_hour") $check = $i;
				else $check = $i + 1;
				if (count($counter->listType) > 0 && ($loop_cnt == count($counter->listType) || $check == $counter->listType[$arr_index])) {
					$ct_daycnt = $counter->listCount[$arr_index];
					$ct_perc = intval($ct_daycnt / $total_count * 100);
					$list_type = $counter->listType[$arr_index];
					$arr_index++;
				} else {
					$ct_daycnt = 0;
					$ct_perc = 0;
					if ($ct_type == "hour" || $ct_type == "month_hour" || $ct_type == "year_hour") $list_type = $i;
					else $list_type = $i + 1;
				}
				if ($list_type != "0" && ($list_type == "" || !$list_type)) $list_type = "UNKNOW";
				if ($ct_type == "month_week" || $ct_type == "year_week" || $ct_type == "week") {
					if ($list_type == "1") $list_type = "일요일";
					else if ($list_type == "2") $list_type = "월요일";
					else if ($list_type == "3") $list_type = "화요일";
					else if ($list_type == "4") $list_type = "수요일";
					else if ($list_type == "5") $list_type = "목요일";
					else if ($list_type == "6") $list_type = "금요일";
					else if ($list_type == "7") $list_type = "토요일";
				}
				$tpl->assign(array(LIST_TYPE    => $list_type,
				                   LIST_PERCENT => $ct_perc,
				                   LIST_REST    => 100 - (int)$ct_perc,
				                   LIST_COUNT   => $ct_daycnt));
				$tpl->parse(RESULT_ROW, ".result_row");
			}
		}
	
		$counter->closeDatabase();
		unset($counter);
	
		$tpl->parse(STAT_MENU, "stat_menu");
		$tpl->parse(STAT_SUBMENU, "stat_submenu");
		$tpl->parse(STAT_RESULT, "stat_result");
	
		include_once("../common/footer_tpl.php");
	}
?>