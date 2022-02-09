<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 0 && (int)$ihouse_admin_info[grade] != 1 && (int)$ihouse_admin_info[grade] != 2 && (int)$ihouse_admin_info[grade] != 7 && (int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/application_tpl.php");
			include_once("../common/header_tpl.php");

			$application->rateTableName = $rate1Table;
			$application->facultyTableName = $facultyTable;
			$application->bookTableName = $bookTable;

			$year = $_GET["year"];
			$month = $_GET["month"];
			if (!$year) $year = $_POST["year"];
			if (!$month) $month = $_POST["month"];
			if (!$year) $year = date('Y');
			if (!$month) $month = date('m');

			$tpl->define_dynamic(array(year_row  => "body",
			                           month_row => "body"));

			for ($i = 2007; $i <= date("Y") + 7; $i++) {
				$tpl->assign(YEAR_VALUE, $i);
				$tpl->parse(YEAR_ROWS, ".year_row");
			}
			for ($i = 1; $i <= 12; $i++) {
				$temp = $i;
				if ($temp < 10) $temp = "0" . $temp;
				$tpl->assign(MONTH_VALUE, $temp);
				$tpl->parse(MONTH_ROWS, ".month_row");
			}

			$prevmonth = (int)$month - 1;
			$nextmonth = (int)$month + 1;
			$prevyear = (int)$year;
			$nextyear = (int)$year;
			if ((int)$month == 1) {
				$prevmonth = 12;
				$prevyear = (int)$year - 1;
			} else if ((int)$month == 12) {
				$nextmonth = 1;
				$nextyear = (int)$year + 1;
			}
			if ((int)$prevmonth < 10) $prevmonth = "0" . $prevmonth;
			if ((int)$nextmonth < 10) $nextmonth = "0" . $nextmonth;
			if ($begin_yr == $year && (int)$month == 1) $prevyear = $prevmonth = "";
			if ($end_yr == $year && (int)$month == 12) $nextyear = $nextmonth = "";
			$tpl->assign(array(CURRENT_YEAR   => $year,
			                   CURRENT_MONTH  => $month,
			                   PREVIOUS_YEAR  => $prevyear,
			                   PREVIOUS_MONTH => $prevmonth,
			                   NEXT_YEAR      => $nextyear,
			                   NEXT_MONTH     => $nextmonth,
			                   SEL_PAGE       => $page,
			                   SEARCH_TYPE    => $s_type,
			                   SEARCH_TEXT    => $s_text,
			                   SEARCH_KIND    => $s_kind,
			                   SEARCH_DORM    => $s_dorm,
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
			                   SORT2_VALUE    => $sort2));

			$maxday = date('t', mktime(0, 0, 0, (int)$month, 1, $year));
			$sel_dt = "$year-$month";
			$sdate = $sel_dt . "-01";
			$edate = $sel_dt . "-" . $maxday;
			$application->getCalendarList($s_rate, $sdate, $edate, $s_dorm);
			$application->getCalendarList1($s_rate, $sdate, $edate, $s_dorm);
			$day_list = "";
			$empty_list = "";
			$room_count = array();
			for ($i = 1; $i <= $maxday; $i++) {
				$day_list .= "<td nowrap><b>$i</b></td>";
				$empty_list .= "<td nowrap></td>";
				$room_count[$i] = 0;
			}
			$room_list = "";
			$application->getRoomList($s_rate, $s_dorm);
			$total_room = count($application->roomListCode);
			if (count($application->calendarRoom) > count($application->calendarRoom1)) $cal_count = count($application->calendarRoom);
			else $cal_count = count($application->calendarRoom1);
			for ($i = 0; $i < $total_room; $i++) { // 모든호실별
				$room_list .= "<tr align=\"center\" bgcolor=\"#FFFFFF\"><td bgcolor=\"#F0F0F0\" nowrap>" . $application->roomListCode[$i] . "</td>"; // 호실
				$temp_list = "";
				$app_index = 0;
				$fac_index = 0;
				for ($j = 0; $j < $cal_count; $j++) { // 예약호실별
					if ($application->roomListCode[$i] == $application->calendarRoom[$j]) {
						for ($k = 1; $k <= $maxday; $k++) { // 월별
							$temp_dt = "$year-$month-";
							if ($k < 10) $temp_dt .= "0" . $k;
							else $temp_dt .= $k;
							if ($application->calendarCheckin[$j] <= $temp_dt && $temp_dt < $application->calendarCheckout[$j]) { // 찼을경우
								if ($application->calendarKind[$j] == "faculty") $temp_list .= "<td bgcolor=\"#F4D6DC\" onMouseover=\"this.style.cursor='hand';\" onClick=\"viewFaculty(" . $application->calendarApply[$j] . ");\" nowrap><font color=\"#F2A4B4\">$k</font></td>";
								else $temp_list .= "<td bgcolor=\"#F4D6DC\" onMouseover=\"this.style.cursor='hand';\" onClick=\"viewApplication(" . $application->calendarApply[$j] . ");\" nowrap><font color=\"#F2A4B4\">$k</font></td>";
								$room_count[$k]++;
							} else { // 비었을경우
								if ($application->calendarCheckin[$j] <= $temp_dt && $application->calendarRoom[$j] == $application->calendarRoom[$j + 1]) $j++;
								$temp_list .= "<td nowrap></td>";
							}
						}
						break;
					}
				}
				if ($temp_list) $room_list .= $temp_list;
				else $room_list .= $empty_list;
				$room_list .= "</tr>\n";
			}
			$total_list = "";
			$percent_list = "";
			for ($i = 1; $i <= $maxday; $i++) {
				if ($total_room) $percent = round($room_count[$i] / $total_room * 100);
				$total_list .= "<td bgcolor=\"F7F7F7\" nowrap>" . $room_count[$i] . "</td>";
				$percent_list .= "<td bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
			}
			$tpl->assign(array(DAY_LIST     => $day_list,
			                   TOTAL_LIST   => $total_list,
			                   PERCENT_LIST => $percent_list,
			                   ROOM_LIST    => $room_list,
			                   TOTAL_ROOM   => $total_room));

			$application->closeDatabase();
			unset($application);

			include_once("../common/footer_tpl.php");
		}
	}
?>