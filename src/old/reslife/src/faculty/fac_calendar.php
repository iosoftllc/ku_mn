<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 0 && (int)$ihouse_admin_info[grade] != 1 && (int)$ihouse_admin_info[grade] != 2 && (int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			$year = $_GET["year"];
			$month = $_GET["month"];
			if (!$year) $year = $_POST["year"];
			if (!$month) $month = $_POST["month"];
			if (!$year) $year = date('Y');
			if (!$month) $month = date('m');

			include_once("../common/facility_tpl.php");
			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(year_row  => "body",
			                           month_row => "body",
			                           week_row  => "body"));

			for ($i = 2005; $i <= date("Y") + 7; $i++) {
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
			                   SEARCH_ROOM    => $s_room));

			$startday = date('w', mktime(0, 0, 0, (int)$month, 1, $year));
			$maxday = date('t', mktime(0, 0, 0, (int)$month, 1, $year));
			$sel_dt = "$year-$month";
			$facility->getCalendarList($s_room, $year, $month);
			$count = 0;
			$offset = 0;
			$room = array();
			for ($i = 1; $i <= $maxday; $i++) {
				$room[$i] = "";
			}
			for ($i = 0; $i < count($facility->calendarDay); $i++) {
				$day = $facility->calendarDay[$i];
				$room[$day] .= "<a href=\"../../src/faculty/fac_view.php?no=" . $facility->calendarApply[$i] . "\"><b>[" . $facility->calendarTime[$i] . "]</b> " . $facility->getRequestValue($facility->calendarRoom[$i]) . " - " . stripslashes($facility->calendarName[$i]) . "</a><br>";
			}
			$date = array();
			$desc = array();
			$property = array();
			while ($count < $maxday) {
				$date[$offset] = "";
				$desc[$offset] = "";
				$property[$offset] = " style=\"text-align:left;\"";
				if ($startday <= $offset) {
					$temp_day = ++$count;
					if ((int)$temp_day < 10) $temp_day = "0" . $temp_day;
					$date[$offset] = "<b><font color=\"#909203\">" . $count . "</font></b>";
					if ($year == date('Y') &&  $month == date('m') && $count == date('j')) $property[$offset] .= " bgcolor=\"#F2F9F4\" ";
					else if ($offset == 0) $property[$offset] .= " bgcolor=\"#FEF4F8\" ";
					else if ($offset == 6) $property[$offset] .= " bgcolor=\"#EFF9FD\" ";
					else $property[$offset] .= " bgcolor=\"#FFFFFF\" ";
					$property[$offset] .= "onMouseover=\"this.style.backgroundColor='#F5F5F5';\" onMouseout=\"this.style.backgroundColor='';\" ";
					if ($room[$count]) $desc[$offset] = $room[$count];
					$startday = 0;
				}
				if ($offset == 6 || $count == $maxday) {
					$tpl->assign(array(WEEK_DATE1     => $date[0],
					                   WEEK_DATE2     => $date[1],
					                   WEEK_DATE3     => $date[2],
					                   WEEK_DATE4     => $date[3],
					                   WEEK_DATE5     => $date[4],
					                   WEEK_DATE6     => $date[5],
					                   WEEK_DATE7     => $date[6],
					                   WEEK_PROPERTY1 => $property[0],
					                   WEEK_PROPERTY2 => $property[1],
					                   WEEK_PROPERTY3 => $property[2],
					                   WEEK_PROPERTY4 => $property[3],
					                   WEEK_PROPERTY5 => $property[4],
					                   WEEK_PROPERTY6 => $property[5],
					                   WEEK_PROPERTY7 => $property[6],
					                   WEEK_DESC1     => $desc[0],
					                   WEEK_DESC2     => $desc[1],
					                   WEEK_DESC3     => $desc[2],
					                   WEEK_DESC4     => $desc[3],
					                   WEEK_DESC5     => $desc[4],
					                   WEEK_DESC6     => $desc[5],
					                   WEEK_DESC7     => $desc[6]));
					$tpl->parse(WEEK_ROW, ".week_row");
					$date = null;
					$desc = null;
					$property = null;
					$offset = 0;
				} else $offset++;
			}

			$facility->closeDatabase();
			unset($facility);

			include_once("../common/footer_tpl.php");
		}
	}
?>