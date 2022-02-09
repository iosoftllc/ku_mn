<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 0 && (int)$ihouse_admin_info[grade] != 1 && (int)$ihouse_admin_info[grade] != 2 && (int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			$kind = $_GET["kind"];
			$year = $_GET["year"];
			$month = $_GET["month"];
			if (!$kind) $kind = $_POST["kind"];
			if (!$year) $year = $_POST["year"];
			if (!$month) $month = $_POST["month"];
			if ($kind != "2") $kind = "1";
			if (!$year) $year = date('Y');
			if (!$month) $month = date('m');

			if ($kind == "2") $html_file = "room_calendar2";
			else $html_file = "room_calendar1";
			include_once("../common/faculty_tpl.php");
			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(year_row  => "body",
			                           month_row => "body",
			                           dorm_row  => "body",
			                           rate_row  => "body",
			                           week_row  => "body",
			                           total_row => "body",
			                           cj_row    => "body",
			                           cj1_row   => "body",
			                           cj2_row   => "body",
			                           cj3_row   => "body",
			                           fh_row    => "body",
			                           fh1_row   => "body",
			                           fh2_row   => "body",
			                           fh3_row   => "body",
			                           fh4_row   => "body"));

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

			if (trim($s_dorm) == "") $temp_dorm = "IFRH";
			else $temp_dorm = $s_dorm;

			$faculty->getDormList("IFRH");
			for ($i = 0; $i < count($faculty->dormListCode); $i++) {
				$tpl->assign(array(DORM_VALUE => $faculty->dormListCode[$i],
				                   DORM_NAME  => $faculty->getDormitoryValue($faculty->dormListCode[$i])));
				$tpl->parse(DORM_ROWS, ".dorm_row");
			}

			//if (trim($s_dorm) != "") {
				$faculty->getRateList($temp_dorm);
				for ($i = 0; $i < count($faculty->rateListCode); $i++) {
					$tpl->assign(array(RATE_VALUE => $faculty->rateListCode[$i],
					                   RATE_NAME  => $faculty->getDormitoryValue($faculty->rateListDormitory[$i]) . " - " . $faculty->rateListUnit[$i]));
					$tpl->parse(RATE_ROWS, ".rate_row");
				}
			//}

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
			                   KIND_VALUE     => $kind,
			                   SEL_PAGE       => $page,
			                   SEARCH_TYPE    => $s_type,
			                   SEARCH_TEXT    => $s_text,
			                   SEARCH_TERM    => $s_term,
			                   SEARCH_STATE   => $s_state,
			                   SEARCH_GRADE   => $s_grade,
			                   SEARCH_RATE    => $s_rate,
			                   SEARCH_ROOM    => $s_room,
			                   SEARCH_DORM    => $s_dorm,
			                   SORT1_VALUE    => $sort1,
			                   SORT2_VALUE    => $sort2));

			$maxday = date('t', mktime(0, 0, 0, (int)$month, 1, $year));
			$sel_dt = "$year-$month";
			$sdate = $sel_dt . "-01";
			$edate = $sel_dt . "-" . $maxday;
			$faculty->getCalendarList($s_rate, $sdate, $edate, $temp_dorm);
			if ($kind == "1") { // 달력별
				$count = 0;
				$offset = 0;
				$startday = date('w', mktime(0, 0, 0, (int)$month, 1, $year));
				for ($i = 1; $i <= $maxday; $i++) {
					$room[$i] = "";
				}
				for ($i = 0; $i < count($faculty->calendarRoom); $i++) {
					$room_nm = "<a href=\"javascript:viewFaculty(document.FacultyForm, " . $faculty->calendarApply[$i] . ");\"><b>" . $faculty->calendarRoom[$i] . "</b>";
					$room_nm .= "(" . $faculty->calendarName[$i] . ")</a>";
					if (substr($faculty->calendarDeparture[$i], 0, 4) == $year && substr($faculty->calendarDeparture[$i], 5, 2) == $month && substr($faculty->calendarDeparture[$i], 8, 2) == "02") $room[1] .= $room_nm . "<br>";
					else if ($faculty->calendarArrival[$i] == $edate) $room[$maxday] .= $room_nm . "<br>";
					else {
						if (substr($faculty->calendarArrival[$i], 0, 4) < $year) $sp = 1;
						else if (substr($faculty->calendarArrival[$i], 5, 2) < $month) $sp = 1;
						else $sp = (int)substr($faculty->calendarArrival[$i], 8, 2);
						if (substr($faculty->calendarDeparture[$i], 0, 4) > $year) $ep = $maxday;
						else if (substr($faculty->calendarDeparture[$i], 5, 2) > $month) $ep = $maxday;
						else $ep = (int)substr($faculty->calendarDeparture[$i], 8, 2) - 1;
						for ($j = $sp; $j <= $ep; $j++) {
							$room[$j] .= $room_nm . "<br>";
						}
					}
				}
				while ($count < $maxday) {
					$date[$offset] = "";
					$desc[$offset] = "";
					$property[$offset] = " style=\"text-align:left;\"";
					if ($startday <= $offset) {
						$temp_day = ++$count;
						if ((int)$temp_day < 10) $temp_day = "0" . $temp_day;
						$date[$offset] = "<b><font color=\"#909203\">" . $count . "</font></b>";
						if ($year == date('Y') && $month == date('m') && $count == date('j')) $property[$offset] .= " bgcolor=\"#F2F9F4\" ";
						else if ($offset == 0) $property[$offset] .= " bgcolor=\"#FEF4F8\" ";
						else if ($offset == 6) $property[$offset] .= " bgcolor=\"#EFF9FD\" ";
						else $property[$offset] .= " bgcolor=\"#FFFFFF\" ";
						$property[$offset] .= "onMouseover=\"this.style.backgroundColor='#F5F5F5';\" onMouseout=\"this.style.backgroundColor='';\" ";
						if ($room[$count]) $desc[$offset] = substr($room[$count], 0, strlen($room[$count]) - 4);
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
			} else if ($kind == "2") { // 호실별
				$day_list = "";
				$empty_list = "";
				$room_count = array();
				$room_count_cj = array();
				$room_count_cj1 = array();
				$room_count_cj2 = array();
				$room_count_cj3 = array();
				$room_count_fh = array();
				$room_count_fh1 = array();
				$room_count_fh2 = array();
				$room_count_fh3 = array();
				$room_count_fh4 = array();
				$room_count_anam = array();
				$room_count_anam1 = array();
				$room_count_anam2 = array();
				$room_count_anam3 = array();
				$room_count_anam4 = array();
				for ($i = 1; $i <= $maxday; $i++) {
					$day_list .= "<td colspan=\"2\" nowrap><b>$i</b></td>";
					$empty_list .= "<td colspan=\"2\" nowrap></td>";
					$room_count[$i] = 0;
					$room_count_cj[$i] = 0;
					$room_count_cj1[$i] = 0;
					$room_count_cj2[$i] = 0;
					$room_count_cj3[$i] = 0;
					$room_count_fh[$i] = 0;
					$room_count_fh1[$i] = 0;
					$room_count_fh2[$i] = 0;
					$room_count_fh3[$i] = 0;
					$room_count_fh4[$i] = 0;
					$room_count_anam[$i] = 0;
					$room_count_anam1[$i] = 0;
					$room_count_anam2[$i] = 0;
					$room_count_anam3[$i] = 0;
					$room_count_anam4[$i] = 0;
				}
				$room_list = "";
				$faculty->getRoomList1($s_rate, $temp_dorm);
				$total_room = count($faculty->roomListCode);
				$total_room_cj = 0;
				$total_room_cj1 = 0;
				$total_room_cj2 = 0;
				$total_room_cj3 = 0;
				$total_room_fh = 0;
				$total_room_fh1 = 0;
				$total_room_fh2 = 0;
				$total_room_fh3 = 0;
				$total_room_fh4 = 0;
				$total_room_anam = 0;
				$total_room_anam1 = 0;
				$total_room_anam2 = 0;
				$total_room_anam3 = 0;
				$total_room_anam4 = 0;
				for ($i = 0; $i < $total_room; $i++) { // 모든호실별
					if (strtoupper($faculty->roomListRate[$i]) == "STUDIO1") {
						$total_room_cj++;
						$total_room_cj1++;
					}
					if (strtoupper($faculty->roomListRate[$i]) == "DOUBLE") {
						$total_room_cj++;
						$total_room_cj2++;
					}
					if (strtoupper($faculty->roomListRate[$i]) == "FAMILY") {
						$total_room_cj++;
						$total_room_cj3++;
					}
					if (strtoupper($faculty->roomListRate[$i]) == "STUDIO2") {
						$total_room_fh++;
						$total_room_fh1++;
					}
					if (strtoupper($faculty->roomListRate[$i]) == "1BED") {
						$total_room_fh++;
						$total_room_fh2++;
					}
					if (strtoupper($faculty->roomListRate[$i]) == "2BED") {
						$total_room_fh++;
						$total_room_fh3++;
					}
					if (strtoupper($faculty->roomListRate[$i]) == "DEPART") {
						$total_room_fh++;
						$total_room_fh4++;
					}
					if (strtoupper($faculty->roomListRate[$i]) == "ANAMDB") {
						$total_room_anam++;
						$total_room_anam1++;
					}
					if (strtoupper($faculty->roomListRate[$i]) == "ANAMFA") {
						$total_room_anam++;
						$total_room_anam2++;
					}
					if (strtoupper($faculty->roomListRate[$i]) == "ANAMFB") {
						$total_room_anam++;
						$total_room_anam3++;
					}
					if (strtoupper($faculty->roomListRate[$i]) == "ANAMFC") {
						$total_room_anam++;
						$total_room_anam4++;
					}
					$room_list .= "<tr align=\"center\" bgcolor=\"#FFFFFF\"><td bgcolor=\"#F0F0F0\" nowrap>" . $faculty->roomListCode[$i] . "</td>"; // 호실
					$temp_list = "";
					for ($j = 0; $j < count($faculty->calendarRoom); $j++) { // 예약호실별
						if ($faculty->roomListCode[$i] == $faculty->calendarRoom[$j]) {
							for ($k = 1; $k <= $maxday; $k++) { // 월별
								$temp_dt = "$year-$month-";
								if ($k < 10) $temp_dt .= "0" . $k;
								else $temp_dt .= $k;
								if ($faculty->calendarArrival[$j] <= $temp_dt && $temp_dt < $faculty->calendarDeparture[$j]) { // 찼을경우
									$temp_list .= "<td colspan=\"2\" bgcolor=\"#F4D6DC\" onMouseover=\"this.style.cursor='hand';\" onClick=\"viewFaculty(document.FacultyForm, " . $faculty->calendarApply[$j] . ");\" nowrap><font color=\"#F2A4B4\">$k</font></td>";
									$room_count[$k]++;
									if (strtoupper($faculty->calendarRateCode[$j]) == "STUDIO1") {
										$room_count_cj[$k]++;
										$room_count_cj1[$k]++;
									}
									if (strtoupper($faculty->calendarRateCode[$j]) == "DOUBLE") {
										$room_count_cj[$k]++;
										$room_count_cj2[$k]++;
									}
									if (strtoupper($faculty->calendarRateCode[$j]) == "FAMILY") {
										$room_count_cj[$k]++;
										$room_count_cj3[$k]++;
									}
									if (strtoupper($faculty->calendarRateCode[$j]) == "STUDIO2") {
										$room_count_fh[$k]++;
										$room_count_fh1[$k]++;
									}
									if (strtoupper($faculty->calendarRateCode[$j]) == "1BED") {
										$room_count_fh[$k]++;
										$room_count_fh2[$k]++;
									}
									if (strtoupper($faculty->calendarRateCode[$j]) == "2BED") {
										$room_count_fh[$k]++;
										$room_count_fh3[$k]++;
									}
									if (strtoupper($faculty->calendarRateCode[$j]) == "DEPART") {
										$room_count_fh[$k]++;
										$room_count_fh4[$k]++;
									}
									if (strtoupper($faculty->calendarRateCode[$j]) == "ANAMDB") {
										$room_count_anam[$k]++;
										$room_count_anam1[$k]++;
									}
									if (strtoupper($faculty->calendarRateCode[$j]) == "ANAMFA") {
										$room_count_anam[$k]++;
										$room_count_anam2[$k]++;
									}
									if (strtoupper($faculty->calendarRateCode[$j]) == "ANAMFB") {
										$room_count_anam[$k]++;
										$room_count_anam3[$k]++;
									}
									if (strtoupper($faculty->calendarRateCode[$j]) == "ANAMFC") {
										$room_count_anam[$k]++;
										$room_count_anam4[$k]++;
									}
								} else { // 비었을경우
									if ($faculty->calendarArrival[$j] <= $temp_dt) {
										if ($faculty->calendarRoom[$j] == $faculty->calendarRoom[$j + 1]) {
											if ($faculty->calendarDeparture[$j] == $faculty->calendarArrival[$j + 1]) {
												$j++;
												$k--;
												continue;
											} else $j++;
										}
									}
									$temp_list .= "<td colspan=\"2\" nowrap></td>";
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
				$total_cj_list = "";
				for ($i = 1; $i <= $maxday; $i++) {
					if ($total_room) $percent = round($room_count[$i] / $total_room * 100);
					else $percent = 0;
					$total_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count[$i] . "</td>";
					if ($total_room_cj) $percent = round($room_count_cj[$i] / $total_room_cj * 100);
					else $percent = 0;
					$total_cj_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_cj_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_cj[$i] . "</td>";
					if ($total_room_cj1) $percent = round($room_count_cj1[$i] / $total_room_cj1 * 100);
					else $percent = 0;
					$total_cj1_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_cj1_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_cj1[$i] . "</td>";
					if ($total_room_cj2) $percent = round($room_count_cj2[$i] / $total_room_cj2 * 100);
					else $percent = 0;
					$total_cj2_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_cj2_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_cj2[$i] . "</td>";
					if ($total_room_cj3) $percent = round($room_count_cj3[$i] / $total_room_cj3 * 100);
					else $percent = 0;
					$total_cj3_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_cj3_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_cj3[$i] . "</td>";
					if ($total_room_fh) $percent = round($room_count_fh[$i] / $total_room_fh * 100);
					else $percent = 0;
					$total_fh_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_fh_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_fh[$i] . "</td>";
					if ($total_room_fh1) $percent = round($room_count_fh1[$i] / $total_room_fh1 * 100);
					else $percent = 0;
					$total_fh1_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_fh1_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_fh1[$i] . "</td>";
					if ($total_room_fh2) $percent = round($room_count_fh2[$i] / $total_room_fh2 * 100);
					else $percent = 0;
					$total_fh2_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_fh2_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_fh2[$i] . "</td>";
					if ($total_room_fh3) $percent = round($room_count_fh3[$i] / $total_room_fh3 * 100);
					else $percent = 0;
					$total_fh3_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_fh3_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_fh3[$i] . "</td>";
					if ($total_room_fh4) $percent = round($room_count_fh4[$i] / $total_room_fh4 * 100);
					else $percent = 0;
					$total_fh4_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_fh4_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_fh4[$i] . "</td>";
					if ($total_room_anam) $percent = round($room_count_anam[$i] / $total_room_anam * 100);
					else $percent = 0;
					$total_anam_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_anam_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_anam[$i] . "</td>";
					if ($total_room_anam1) $percent = round($room_count_anam1[$i] / $total_room_anam1 * 100);
					else $percent = 0;
					$total_anam1_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_anam1_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_anam1[$i] . "</td>";
					if ($total_room_anam2) $percent = round($room_count_anam2[$i] / $total_room_anam2 * 100);
					else $percent = 0;
					$total_anam2_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_anam2_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_anam2[$i] . "</td>";
					if ($total_room_anam3) $percent = round($room_count_anam3[$i] / $total_room_anam3 * 100);
					else $percent = 0;
					$total_anam3_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_anam3_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_anam3[$i] . "</td>";
					if ($total_room_anam4) $percent = round($room_count_anam4[$i] / $total_room_anam4 * 100);
					else $percent = 0;
					$total_anam4_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $percent . "%</td>";
					$total_anam4_list .= "<td align=\"right\" bgcolor=\"F7F7F7\" nowrap>" . $room_count_anam4[$i] . "</td>";
				}
				$tpl->assign(array(DAY_LIST         => $day_list,
				                   TOTAL_ROOM       => $total_room,
				                   TOTAL_LIST       => $total_list,
				                   TOTAL_CJ_ROOM    => $total_room_cj,
				                   TOTAL_CJ_LIST    => $total_cj_list,
				                   TOTAL_CJ1_ROOM   => $total_room_cj1,
				                   TOTAL_CJ1_LIST   => $total_cj1_list,
				                   TOTAL_CJ2_ROOM   => $total_room_cj2,
				                   TOTAL_CJ2_LIST   => $total_cj2_list,
				                   TOTAL_CJ3_ROOM   => $total_room_cj3,
				                   TOTAL_CJ3_LIST   => $total_cj3_list,
				                   TOTAL_FH_ROOM    => $total_room_fh,
				                   TOTAL_FH_LIST    => $total_fh_list,
				                   TOTAL_FH1_ROOM   => $total_room_fh1,
				                   TOTAL_FH1_LIST   => $total_fh1_list,
				                   TOTAL_FH2_ROOM   => $total_room_fh2,
				                   TOTAL_FH2_LIST   => $total_fh2_list,
				                   TOTAL_FH3_ROOM   => $total_room_fh3,
				                   TOTAL_FH3_LIST   => $total_fh3_list,
				                   TOTAL_FH4_ROOM   => $total_room_fh4,
				                   TOTAL_FH4_LIST   => $total_fh4_list,
				                   TOTAL_ANAM_ROOM  => $total_room_anam,
				                   TOTAL_ANAM_LIST  => $total_anam_list,
				                   TOTAL_ANAM1_ROOM => $total_room_anam1,
				                   TOTAL_ANAM1_LIST => $total_anam1_list,
				                   TOTAL_ANAM2_ROOM => $total_room_anam2,
				                   TOTAL_ANAM2_LIST => $total_anam2_list,
				                   TOTAL_ANAM3_ROOM => $total_room_anam3,
				                   TOTAL_ANAM3_LIST => $total_anam3_list,
				                   TOTAL_ANAM4_ROOM => $total_room_anam4,
				                   TOTAL_ANAM4_LIST => $total_anam4_list,
				                   ROOM_LIST        => $room_list));
				if (strtoupper($s_rate) == "STUDIO1") $tpl->parse(CJ1_ROW, ".cj1_row");
				else if (strtoupper($s_rate) == "DOUBLE") $tpl->parse(CJ2_ROW, ".cj2_row");
				else if (strtoupper($s_rate) == "FAMILY") $tpl->parse(CJ3_ROW, ".cj3_row");
				else if (strtoupper($s_rate) == "STUDIO2") $tpl->parse(FH1_ROW, ".fh1_row");
				else if (strtoupper($s_rate) == "1BED") $tpl->parse(FH2_ROW, ".fh2_row");
				else if (strtoupper($s_rate) == "2BED") $tpl->parse(FH3_ROW, ".fh3_row");
				else if (strtoupper($s_rate) == "DEPART") $tpl->parse(FH4_ROW, ".fh4_row");
				else if (strtoupper($s_rate) == "ANAMDB") $tpl->parse(ANAM1_ROW, ".anam1_row");
				else if (strtoupper($s_rate) == "ANAMFA") $tpl->parse(ANAM2_ROW, ".anam2_row");
				else if (strtoupper($s_rate) == "ANAMFB") $tpl->parse(ANAM3_ROW, ".anam3_row");
				else if (strtoupper($s_rate) == "ANAMFC") $tpl->parse(ANAM4_ROW, ".anam4_row");
				else if (strtoupper($s_dorm) == "IFRH_CJ") {
					$tpl->parse(CJ_ROW, ".cj_row");
					$tpl->parse(CJ1_ROW, ".cj1_row");
					$tpl->parse(CJ2_ROW, ".cj2_row");
					$tpl->parse(CJ3_ROW, ".cj3_row");
				} else if (strtoupper($s_dorm) == "IFRH_FH") {
					$tpl->parse(FH_ROW, ".fh_row");
					$tpl->parse(FH1_ROW, ".fh1_row");
					$tpl->parse(FH2_ROW, ".fh2_row");
					$tpl->parse(FH3_ROW, ".fh3_row");
					$tpl->parse(FH4_ROW, ".fh4_row");
				} else if (strtoupper($s_dorm) == "IFRH_ANAM") {
					$tpl->parse(ANAM_ROW, ".anam_row");
					$tpl->parse(ANAM1_ROW, ".anam1_row");
					$tpl->parse(ANAM2_ROW, ".anam2_row");
					$tpl->parse(ANAM3_ROW, ".anam3_row");
					$tpl->parse(ANAM4_ROW, ".anam4_row");
				} else {
					$tpl->parse(TOTAL_ROW, ".total_row");
					$tpl->parse(CJ_ROW, ".cj_row");
					$tpl->parse(CJ1_ROW, ".cj1_row");
					$tpl->parse(CJ2_ROW, ".cj2_row");
					$tpl->parse(CJ3_ROW, ".cj3_row");
					$tpl->parse(FH_ROW, ".fh_row");
					$tpl->parse(FH1_ROW, ".fh1_row");
					$tpl->parse(FH2_ROW, ".fh2_row");
					$tpl->parse(FH3_ROW, ".fh3_row");
					$tpl->parse(FH4_ROW, ".fh4_row");
					$tpl->parse(ANAM_ROW, ".anam_row");
					$tpl->parse(ANAM1_ROW, ".anam1_row");
					$tpl->parse(ANAM2_ROW, ".anam2_row");
					$tpl->parse(ANAM3_ROW, ".anam3_row");
					$tpl->parse(ANAM4_ROW, ".anam4_row");
				}
			}

			$faculty->closeDatabase();
			unset($faculty);

			include_once("../common/footer_tpl.php");
		}
	}
?>