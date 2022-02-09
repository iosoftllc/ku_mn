<?
	include_once("class.cMysql.php");

	class cFacility extends cMysql {
		var $facilityTableName;
		var $historyAccessTableName;
		var $historyWorkTableName;
		var $facListNumber = array();
		var $facListState = array();
		var $facListEventName = array();
		var $facListApplicant = array();
		var $facListResident = array();
		var $facListDepartment = array();
		var $facListPosition = array();
		var $facListEmail = array();
		var $facListPhone = array();
		var $facListEventDate = array();
		var $facListEventHour = array();
		var $facListAttendee = array();
		var $facListRequest = array();
		var $facListFee = array();
		var $facListMeal = array();
		var $facListCancel = array();
		var $facListWaive = array();
		var $facListBreakfast = array();
		var $facListDiscount1 = array();
		var $facListDiscount2 = array();
		var $facListSettle1 = array();
		var $facListSettle2 = array();
		var $facListSettle3 = array();
		var $facListSettle4 = array();
		var $facListSettleDate1 = array();
		var $facListSettleDate2 = array();
		var $facListSettleDate3 = array();
		var $facListSettleDate4 = array();
		var $facListApply = array();
		var $facListAssign = array();
		var $facListConfirm = array();
		var $facListBilled = array();
		var $facListPaid = array();
		var $facListCancelDate = array();
		var $facListWaiveDate = array();
		var $facListAdmin = array();
		var $facilityNumber;
		var $facilityState;
		var $facilityEventName;
		var $facilityApplicant;
		var $facilityResident;
		var $facilityDepartment;
		var $facilityPosition;
		var $facilityEmail;
		var $facilityPhone;
		var $facilityEventDate;
		var $facilityEventHour;
		var $facilityAttendee;
		var $facilityRequest;
		var $facilityFee;
		var $facilityMeal;
		var $facilityCancel;
		var $facilityWaive;
		var $facilityBreakfast;
		var $facilityDiscount1;
		var $facilityDiscount2;
		var $facilitySettle1;
		var $facilitySettle2;
		var $facilitySettle3;
		var $facilitySettle4;
		var $facilityApply;
		var $facilityAssign;
		var $facilityConfirm;
		var $facilityBilled;
		var $facilityPaid;
		var $facilityCancelDate;
		var $facilityWaiveDate;
		var $facilityAdmin;
		var $errorMessage;
		var $calendarApply = array();
		var $calendarRoom = array();
		var $calendarName = array();
		var $calendarDay = array();
		var $calendarTime = array();

		function cFacility($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3) {
			$this->facilityTableName = $tbl1;
			$this->historyAccessTableName = $tbl2;
			$this->historyWorkTableName = $tbl3;
			$this->cMysql($host, $id, $pw, $db);
		}

		function getStateValue($val){
			if ($val == "IW") $returnValue = "Applied";
			else if ($val == "AS") $returnValue = "Assigned";
			else if ($val == "CC") $returnValue = "Cancelled";
			else if ($val == "CF") $returnValue = "Confirmed";
			else if ($val == "PR") $returnValue = "Paid Rental Fee";
			else if ($val == "PB") $returnValue = "Paid Breakfast";
			else if ($val == "PD") $returnValue = "Paid Deposit";
			else if ($val == "RF") $returnValue = "Refund";
			else $returnValue = "";
			return $returnValue;
		}

		function getRoomValue($val) {
			if ($val == "C1") $returnValue = "Korea University Alumni Association Conference Hall with beam projector - Seat 23";
			else if ($val == "S1") $returnValue = "Kang Hyun Suk Seminar Room with white board - Seat 8";
			else if ($val == "S2") $returnValue = "Korea University Alumni Association of Southern California Seminar Room with white board - Seat 8";
			else if ($val == "R1") $returnValue = "Koryo Lions Club Study Room - Seat 30";
			else if ($val == "R2") $returnValue = "Choi, Sang Yong Study Room - Seat 25";
			else $returnValue = "";
			return $returnValue;
		}

		function getRequestValue($val) {
			$returnValue = "";
			$val = explode("|", $val);
			if ($val[0] == "C1") $returnValue .= "컨퍼런스홀,";
			if ($val[1] == "S1") $returnValue .= "세미나실(강현석),";
			if ($val[2] == "S2") $returnValue .= "세미나실(캘리포니아),";
			if ($val[3] == "R1") $returnValue .= "스터디룸(고려사자클럽),";
			if ($val[4] == "R2") $returnValue .= "스터디룸(최상용),";
			if ($returnValue) $returnValue = substr($returnValue, 0, strlen($returnValue) - 1);
			return $returnValue;
		}

		function getRequestValue1($val) {
			$returnValue = "";
			$val = explode("|", $val);
			if ($val[0] == "C1") $returnValue .= "Korea University Alumni Association Conference Hall with beam projector, ";
			if ($val[1] == "S1") $returnValue .= "Kang Hyun Suk Seminar Room with white board, ";
			if ($val[2] == "S2") $returnValue .= "Korea University Alumni Association of Southern California Seminar Room with white board, ";
			if ($val[3] == "R1") $returnValue .= "Koryo Lions Club Study Room, ";
			if ($val[4] == "R2") $returnValue .= "Choi, Sang Yong Study Room, ";
			if ($returnValue) $returnValue = substr($returnValue, 0, strlen($returnValue) - 2);
			return $returnValue;
		}

		function getUnitValue($val) {
			$returnValue = "";
			$val = explode("|", $val);
			if ($val[0] == "C1") $returnValue .= "B113 Conference, ";
			if ($val[1] == "S1") $returnValue .= "B105 Seminar, ";
			if ($val[2] == "S2") $returnValue .= "B104 Seminar, ";
			if ($val[3] == "R1") $returnValue .= "441 Study Room, ";
			if ($val[4] == "R2") $returnValue .= "641 Study Room, ";
			if ($returnValue) $returnValue = substr($returnValue, 0, strlen($returnValue) - 2);
			return $returnValue;
		}

		function getSettleValue($val, $dt="0000-00-00") {
			if ($val == "Y") {
				$returnValue = "결재";
				if (trim($dt) != "" && trim($dt) != "0000-00-00") $returnValue .= "<br>" . substr(trim($dt), 2, 8);
			} else $returnValue = "";
			return $returnValue;
		}

		function getBreakfastValue($val) {
			if ($val == "Y") $returnValue = "Yes";
			else $returnValue = "No";
			return $returnValue;
		}

		function getDiscountValue($val) {
			if ($val == "Y") $returnValue = "할인";
			else $returnValue = "미할인";
			return $returnValue;
		}

		function getResidentValue($val) {
			if ($val == "Y") $returnValue = "CJ International House Resident (거주자)";
			else if ($val == "N") $returnValue = "Non Resident (비거주자)";
			else $returnValue = "";
			return $returnValue;
		}

		function getFacilityNumber($dt) {
			$returnValue = "";
			$where = "";
			if ($dt) $where = "WHERE apply_no>$dt" . "0000";
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt FROM $this->facilityTableName $where");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			$this->freeResult();
			return $returnValue;
		}

		function getFacilityCondition($room, $state, $grade, $sdate, $edate, $stype, $stext) {
			$returnValue = "";
			$list_dorm = "";
			if ($room) {
				$arr_temp = explode(",", $room);
				for ($i = 0; $i < count($arr_temp); $i++) {
					$list_room .= "request LIKE '%" . $arr_temp[$i] . "%' OR ";
				}
				if ($list_room) {
					$list_room = "(" . substr($list_room, 0, strlen($list_room) - 4) . ")";
					if ($returnValue) $returnValue .= " AND $list_room";
					else $returnValue .= " WHERE $list_room";
				}
			}
			if ($state) {
				if ($returnValue) $returnValue .= " AND state='$state'";
				else $returnValue .= " WHERE state='$state'";
			}
			if ($grade == "0") {
				if ($returnValue) $returnValue .= " AND settle1='N' AND settle2='N' AND settle3='N' AND settle4='N'";
				else $returnValue .= " WHERE settle1='N' AND settle2='N' AND settle3='N' AND settle4='N'";
			} else if ($grade == "1") {
				if ($returnValue) $returnValue .= " AND settle1='Y' AND settle2='N' AND settle3='N' AND settle4='N'";
				else $returnValue .= " WHERE settle1='Y' AND settle2='N' AND settle3='N' AND settle4='N'";
			} else if ($grade == "2") {
				if ($returnValue) $returnValue .= " AND settle1='Y' AND settle2='Y' AND settle3='N' AND settle4='N'";
				else $returnValue .= " WHERE settle1='Y' AND settle2='Y' AND settle3='N' AND settle4='N'";
			} else if ($grade == "3") {
				if ($returnValue) $returnValue .= " AND settle1='Y' AND settle2='Y' AND settle3='Y' AND settle4='N'";
				else $returnValue .= " WHERE settle1='Y' AND settle2='Y' AND settle3='Y' AND settle4='N'";
			} else if ($grade == "4") {
				if ($returnValue) $returnValue .= " AND settle1='Y' AND settle2='Y' AND settle3='Y' AND settle4='Y'";
				else $returnValue .= " WHERE settle1='Y' AND settle2='Y' AND settle3='Y' AND settle4='Y'";
			}
			if ($sdate) {
				if ($returnValue) $returnValue .= " AND apply_date>='$sdate 00:00:00'";
				else $returnValue .= " WHERE apply_date>='$sdate 00:00:00'";
			}
			if ($edate) {
				if ($returnValue) $returnValue .= " AND apply_date<='$edate 23:59:59'";
				else $returnValue .= " WHERE apply_date<='$edate 23:59:59'";
			}
			if (trim($stext) == "") $stype = "0";
			switch ($stype) {
				case "1":
					if ($returnValue) $returnValue .= " AND event LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE event LIKE '%" . $stext . "%'";
					break;
				case "2":
					if ($returnValue) $returnValue .= " AND applicant LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE applicant LIKE '%" . $stext . "%'";
					break;
				case "3":
					if ($returnValue) $returnValue .= " AND apply_no LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE apply_no LIKE '%" . $stext . "%'";
					break;
				case "4":
					if ($returnValue) $returnValue .= " AND email LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE email LIKE '%" . $stext . "%'";
					break;
			}
			$returnValue = "FROM $this->facilityTableName" . $returnValue;
			return $returnValue;
		}

		function getFacilityCount($room, $state, $grade, $sdate, $edate, $stype, $stext) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt " . $this->getFacilityCondition($room, $state, $grade, $sdate, $edate, $stype, $stext));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getFacilityList($start, $size, $room, $state, $grade, $sdate, $edate, $stype, $stext, $sort) {
			if ($sort == "") $sort = " ORDER BY apply_date DESC";
			else $sort = " ORDER BY $sort";
			if ($start != "" || $start == "0") $limit = " LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT * " . $this->getFacilityCondition($room, $state, $grade, $sdate, $edate, $stype, $stext) . $sort . $limit);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
			  $this->facListNumber[$cnt] = $this->getField("apply_no");
			  $this->facListState[$cnt] = $this->getField("state");
			  $this->facListEventName[$cnt] = $this->getField("event");
			  $this->facListApplicant[$cnt] = $this->getField("applicant");
			  $this->facListResident[$cnt] = $this->getField("resident");
			  $this->facListDepartment[$cnt] = $this->getField("department");
				$this->facListPosition[$cnt] = $this->getField("position");
				$this->facListEmail[$cnt] = $this->getField("email");
				$this->facListPhone[$cnt] = $this->getField("phone");
				$this->facListEventDate[$cnt] = $this->getField("event_dt");
			  $this->facListEventHour[$cnt] = $this->getField("event_hr");
				$this->facListAttendee[$cnt] = $this->getField("attendee");
				$this->facListRequest[$cnt] = $this->getField("request");
				$this->facListFee[$cnt] = $this->getField("fee");
				$this->facListMeal[$cnt] = $this->getField("meal");
				$this->facListCancel[$cnt] = $this->getField("cancel");
				$this->facListWaive[$cnt] = $this->getField("waive");
				$this->facListBreakfast[$cnt] = $this->getField("breakfast");
				$this->facListDiscount1[$cnt] = $this->getField("discount1");
				$this->facListDiscount2[$cnt] = $this->getField("discount2");
				$this->facListSettle1[$cnt] = $this->getField("settle1");
				$this->facListSettle2[$cnt] = $this->getField("settle2");
				$this->facListSettle3[$cnt] = $this->getField("settle3");
				$this->facListSettle4[$cnt] = $this->getField("settle4");
				$this->facListSettleDate1[$cnt] = $this->getField("settle1_dt");
				$this->facListSettleDate2[$cnt] = $this->getField("settle2_dt");
				$this->facListSettleDate3[$cnt] = $this->getField("settle3_dt");
				$this->facListSettleDate4[$cnt] = $this->getField("settle4_dt");
				$this->facListApply[$cnt] = $this->getField("apply_date");
				$this->facListAssign[$cnt] = $this->getField("assign_date");
				$this->facListConfirm[$cnt] = $this->getField("confirm_date");
				$this->facListBilled[$cnt] = $this->getField("billed_date");
				$this->facListPaid[$cnt] = $this->getField("paid_date");
				$this->facListCancelDate[$cnt] = $this->getField("cancel_date");
				$this->facListWaiveDate[$cnt] = $this->getField("waive_date");
				$this->facListAdmin[$cnt] = $this->getField("admin");
			  $this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getFacilityInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->facilityTableName WHERE apply_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
			  $this->facilityNumber = $this->getField("apply_no");
			  $this->facilityState = $this->getField("state");
			  $this->facilityEventName = $this->getField("event");
			  $this->facilityApplicant = $this->getField("applicant");
			  $this->facilityResident = $this->getField("resident");
			  $this->facilityDepartment = $this->getField("department");
				$this->facilityPosition = $this->getField("position");
				$this->facilityEmail = $this->getField("email");
				$this->facilityPhone = $this->getField("phone");
				$this->facilityEventDate = $this->getField("event_dt");
			  $this->facilityEventHour = $this->getField("event_hr");
				$this->facilityAttendee = $this->getField("attendee");
				$this->facilityRequest = $this->getField("request");
				$this->facilityFee = $this->getField("fee");
				$this->facilityMeal = $this->getField("meal");
				$this->facilityCancel = $this->getField("cancel");
				$this->facilityWaive = $this->getField("waive");
				$this->facilityBreakfast = $this->getField("breakfast");
				$this->facilityDiscount1 = $this->getField("discount1");
				$this->facilityDiscount2 = $this->getField("discount2");
				$this->facilitySettle1 = $this->getField("settle1");
				$this->facilitySettle2 = $this->getField("settle2");
				$this->facilitySettle3 = $this->getField("settle3");
				$this->facilitySettle4 = $this->getField("settle4");
				$this->facilityApply = $this->getField("apply_date");
				$this->facilityAssign = $this->getField("assign_date");
				$this->facilityConfirm = $this->getField("confirm_date");
				$this->facilityBilled = $this->getField("billed_date");
				$this->facilityPaid = $this->getField("paid_date");
				$this->facilityCancelDate = $this->getField("cancel_date");
				$this->facilityWaiveDate = $this->getField("waive_date");
				$this->facilityAdmin = $this->getField("admin");
			}
			$this->freeResult();
		}

		function getCalendarList($room, $yr, $mth) {
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no, event, request, event_dt, event_hr FROM $this->facilityTableName ");
			$this->appendSQL("WHERE state IN ('AS','CF','PR') AND DATE_FORMAT(event_dt, '%Y')=$yr AND DATE_FORMAT(event_dt, '%m')=$mth");
			if ($room) $this->appendSQL(" AND request LIKE '%" . $room . "%'");
			$this->appendSQL(" ORDER BY event_dt, event_hr");
			$this->parseQuery();
			$cnt = 0; 
			while (!$this->EOF) {
				$this->calendarApply[$cnt] = $this->getField("apply_no");
				$this->calendarRoom[$cnt] = $this->getField("request");
				$this->calendarName[$cnt] = $this->getField("event");
				$this->calendarDay[$cnt] = (int)substr($this->getField("event_dt"), 8, 2);
				$temp = explode("|", $this->getField("event_hr"));
				$this->calendarTime[$cnt] = $temp[0] . ":" . $temp[1];
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function insertFacility($no, $state, $event, $applicant, $resident, $department, $position, $email, $phone, $event_dt, $event_hr, $attendee, $request, $fee, $meal, $cancel, $waive, $breakfast, $dis1, $dis2, $settle1, $settle2, $settle3, $settle4, $assign_dt, $confirm_dt, $billed_dt, $paid_dt, $cancel_dt, $waive_dt, $admin) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->facilityTableName (apply_no, state, event, applicant, resident, department, position, email, phone, event_dt, ");
			$this->appendSQL("event_hr, attendee, request, fee, meal, cancel, waive, breakfast, discount1, discount2, settle1, settle2, settle3, settle4, apply_date, assign_date, ");
			$this->appendSQL("confirm_date, billed_date, paid_date, cancel_date, waive_date, admin) VALUES (");
			$this->appendSQL("'$no', '$state', '$event', '$applicant', '$resident', '$department', '$position', '$email', '$phone', '$event_dt', '$event_hr', ");
			$this->appendSQL("'$attendee', '$request', '$fee', '$meal', '$cancel', '$waive', '$breakfast', '$dis1', '$dis2', '$settle1', '$settle2', '$settle3', '$settle4', now(), '$assign_dt', ");
			$this->appendSQL("'$confirm_dt', '$billed_dt', '$paid_dt', '$cancel_dt', '$waive_dt', '$admin')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->facilityNumber = $this->getInsertID();
				$no = $this->facilityNumber;
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$no 시설예약 정보 추가";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'F', 'F', 'N', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function copyFacility($no) {
			global $ihouse_admin_info;
			$returnValue = false;
			$this->getFacilityInfo($no);
			if ($this->facilityNumber) {
				if (!$this->getFacilityNumber(date("Y").date("m"))) $facility_no = date("Y"). date("m") . "0001";
				else $facility_no = "";
				$this->clearSQL();
				$this->appendSQL("INSERT INTO $this->facilityTableName (apply_no, state, event, applicant, resident, department, position, email, phone, event_dt, ");
				$this->appendSQL("event_hr, attendee, request, fee, meal, cancel, waive, breakfast, discount1, discount2, settle1, settle2, settle3, settle4, apply_date, assign_date, ");
				$this->appendSQL("confirm_date, billed_date, paid_date, cancel_date, waive_date) VALUES (");
				$this->appendSQL("'$facility_no', '$this->facilityState', '$this->facilityEventName', '$this->facilityApplicant', '$this->facilityResident', '$this->facilityDepartment', '$this->facilityPosition', '$this->facilityEmail', '$this->facilityPhone', '$this->facilityEventDate', '$this->facilityEventHour', ");
				$this->appendSQL("'$this->facilityAttendee', '$this->facilityRequest', '$this->facilityFee', '$this->facilityMeal', '$this->facilityCancel', '$this->facilityWaive', '$this->facilityBreakfast', '$this->facilityDiscount1', '$this->facilityDiscount2', '$this->facilitySettle1', '$this->facilitySettle2', '$this->facilitySettle3', '$this->facilitySettle4', now(), '$this->facilityAssign', ");
				$this->appendSQL("'$this->facilityConfirm', '$this->facilityBilled', '$this->facilityPaid', '$this->facilityCancelDate', '$this->facilityWaiveDate')");
				$returnValue = $this->execQuery();
				if ($returnValue) {
					$this->facilityNumber = $this->getInsertID();
					$new_no = $this->facilityNumber;
					$admin_id = $ihouse_admin_info[id];
					if (strtolower($admin_id) != "intia") {
						$ip = $_SERVER["REMOTE_ADDR"];
						$detail = "$new_no 시설예약 정보 추가 ($no 시설예약 복사)";
						$this->clearSQL();
						$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'F', 'F', 'N', '$ip', now(), '$detail')");
						$this->execQuery();
					}
				}
			}
			return $returnValue;
		}

		function updateFacility($no, $state, $event, $applicant, $resident, $department, $position, $email, $phone, $event_dt, $event_hr, $attendee, $request, $fee, $meal, $cancel, $waive, $breakfast, $dis1, $dis2, $settle1, $settle2, $settle3, $settle4, $assign_dt, $confirm_dt, $billed_dt, $paid_dt, $cancel_dt, $waive_dt, $admin) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->facilityTableName SET state='$state', event='$event', applicant='$applicant', resident='$resident', ");
			$this->appendSQL("department='$department', position='$position', email='$email', phone='$phone', event_dt='$event_dt', event_hr='$event_hr', ");
			$this->appendSQL("attendee='$attendee', request='$request', fee='$fee', meal='$meal', cancel='$cancel', waive='$waive', breakfast='$breakfast', discount1='$dis1', discount2='$dis2', settle1='$settle1', ");
			$this->appendSQL("settle2='$settle2', settle3='$settle3', settle4='$settle4', assign_date='$assign_dt', confirm_date='$confirm_dt', ");
			$this->appendSQL("billed_date='$billed_dt', paid_date='$paid_dt', cancel_date='$cancel_dt', waive_date='$waive_dt', admin='$admin' WHERE apply_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$no 시설예약 정보 수정";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'F', 'F', 'E', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function updateFacilityState($no, $state) {
			if ($state) {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->facilityTableName SET state='$state' WHERE apply_no=$no");
				$returnValue = $this->execQuery();
				return $returnValue;
			}
		}

		function deleteFacility($no) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->facilityTableName WHERE apply_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$no 시설예약 정보 삭제";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'F', 'F', 'D', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
 			return $returnValue;
		}

		function isRoomAvailable($no, $rm1, $rm2, $rm3, $rm4, $rm5, $dt, $start, $end) {
			$returnValue = true;
			if ($no) $apply_no = "apply_no<>'$no' AND";
			else $apply_no = "";
			if ($dt && $rm1) {
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->facilityTableName WHERE $apply_no state IN ('AS', 'CF', 'PR', 'PD') AND request LIKE '%" . $rm1 . "%' AND event_dt='$dt' AND ");
				$this->appendSQL("((SUBSTRING(event_hr, 1, 5)<='$start' AND SUBSTRING(event_hr, 7, 5)>'$start') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)<'$end' AND SUBSTRING(event_hr, 7, 5)>='$end') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)>'$start' AND SUBSTRING(event_hr, 7, 5)<'$end'))");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->facilityNumber = $this->getField("apply_no");
					$returnValue = false;
				}
			}
			if ($dt && $rm2) {
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->facilityTableName WHERE $apply_no state IN ('AS', 'CF', 'PR', 'PD') AND request LIKE '%" . $rm2 . "%' AND event_dt='$dt' AND ");
				$this->appendSQL("((SUBSTRING(event_hr, 1, 5)<='$start' AND SUBSTRING(event_hr, 7, 5)>'$start') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)<'$end' AND SUBSTRING(event_hr, 7, 5)>='$end') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)>'$start' AND SUBSTRING(event_hr, 7, 5)<'$end'))");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->facilityNumber = $this->getField("apply_no");
					$returnValue = false;
				}
			}
			if ($dt && $rm3) {
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->facilityTableName WHERE $apply_no state IN ('AS', 'CF', 'PR', 'PD') AND request LIKE '%" . $rm3 . "%' AND event_dt='$dt' AND ");
				$this->appendSQL("((SUBSTRING(event_hr, 1, 5)<='$start' AND SUBSTRING(event_hr, 7, 5)>'$start') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)<'$end' AND SUBSTRING(event_hr, 7, 5)>='$end') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)>'$start' AND SUBSTRING(event_hr, 7, 5)<'$end'))");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->facilityNumber = $this->getField("apply_no");
					$returnValue = false;
				}
			}
			if ($dt && $rm4) {
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->facilityTableName WHERE $apply_no state IN ('AS', 'CF', 'PR', 'PD') AND request LIKE '%" . $rm4 . "%' AND event_dt='$dt' AND ");
				$this->appendSQL("((SUBSTRING(event_hr, 1, 5)<='$start' AND SUBSTRING(event_hr, 7, 5)>'$start') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)<'$end' AND SUBSTRING(event_hr, 7, 5)>='$end') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)>'$start' AND SUBSTRING(event_hr, 7, 5)<'$end'))");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->facilityNumber = $this->getField("apply_no");
					$returnValue = false;
				}
			}
			if ($dt && $rm5) {
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->facilityTableName WHERE $apply_no state IN ('AS', 'CF', 'PR', 'PD') AND request LIKE '%" . $rm5 . "%' AND event_dt='$dt' AND ");
				$this->appendSQL("((SUBSTRING(event_hr, 1, 5)<='$start' AND SUBSTRING(event_hr, 7, 5)>'$start') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)<'$end' AND SUBSTRING(event_hr, 7, 5)>='$end') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)>'$start' AND SUBSTRING(event_hr, 7, 5)<'$end'))");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->facilityNumber = $this->getField("apply_no");
					$returnValue = false;
				}
			}
			$this->freeResult();
			return $returnValue;
		}

		function calculateTime($h1, $m1, $h2, $m2) {
			$hour = (int)$h2 - (int)$h1;
			$minute = (int)$m2 - (int)$m1;
			if ($minute > 0) $hour++;
			return $hour;
		}

		function calculateFee($rm1, $rm2, $rm3, $rm4, $rm5, $h1, $m1, $h2, $m2, $breakfast, $dis1, $dis2) {
			$returnValue = 0;
			$hour = $this->calculateTime($h1, $m1, $h2, $m2);
			if ($rm1) {
				if ($hour > 2) $returnValue += 50000 + (($hour - 2) * 20000);
				else $returnValue += 50000;
			}
			if ($rm2) {
				if ($breakfast == "Y") $base_rent = 50000;
				else $base_rent = 30000;
				if ($hour > 2) $returnValue += $base_rent + (($hour - 2) * 10000);
				else $returnValue += $base_rent;
			}
			if ($rm3) {
				if ($breakfast == "Y") $base_rent = 50000;
				else $base_rent = 30000;
				if ($hour > 2) $returnValue += $base_rent + (($hour - 2) * 10000);
				else $returnValue += $base_rent;
			}
			if ($rm4) {
				if ($hour > 2) $returnValue += 50000 + (($hour - 2) * 20000);
				else $returnValue += 50000;
			}
			if ($rm5) {
				if ($hour > 2) $returnValue += 50000 + (($hour - 2) * 20000);
				else $returnValue += 50000;
			}
			if ($dis1 == "Y") $returnValue = $returnValue * 0.5;
			if ($dis2 == "Y") $returnValue = $returnValue * 0.8;
			return $returnValue;
		}

		function calculateMeal($attendee, $breakfast) {
			$returnValue = 0;
			if (is_numeric($attendee) && (int)$attendee > 10 && $breakfast == "Y") $returnValue = ((int)$attendee - 10) * 5000;
			return $returnValue;
		}

		function approveFacility($no, $grade, $flag) {
			$returnValue = true;
			if (is_numeric($no) && $no > 0 && ($grade == "9" || $grade == "7" || $grade == "2" || $grade == "1" || $grade == "0") && ($flag == "Y" || $flag == "N")) {
				if ($flag == "Y") $this->errorMessage = "결재 승인이 성공적으로 이루어졌습니다.";
				else $this->errorMessage = "결재 취소가 성공적으로 이루어졌습니다.";
				$settle1 = "";
				$settle2 = "";
				$settle3 = "";
				$settle4 = "";
				$this->clearSQL();
				$this->appendSQL("SELECT settle1, settle2, settle3, settle4 FROM $this->facilityTableName WHERE apply_no=$no;");
				$this->parseQuery();
				if (!$this->EOF) {
					$settle1 = $this->getField("settle1");
					$settle2 = $this->getField("settle2");
					$settle3 = $this->getField("settle3");
					$settle4 = $this->getField("settle4");
				}
				$this->freeResult();
				if (strtoupper($flag) == "Y") $cur_date = "now()";
				else $cur_date = "'0000-00-00'";
				if ($grade == "9" || $grade == "7") {
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->facilityTableName SET settle2='N', settle2_dt='0000-00-00' WHERE apply_no=$no;");
					$returnValue = $this->execQuery();
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->facilityTableName SET settle3='N', settle3_dt='0000-00-00' WHERE apply_no=$no;");
					$returnValue = $this->execQuery();
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->facilityTableName SET settle4='N', settle4_dt='0000-00-00' WHERE apply_no=$no;");
					$returnValue = $this->execQuery();
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->facilityTableName SET settle1='$flag', settle1_dt=$cur_date WHERE apply_no=$no");
					$returnValue = $this->execQuery();
				} else if ($grade == "2") {
					if ($flag == "Y" && $settle3 != "Y") $this->errorMessage = "팀장 미결 상태이므로 결재할 수 없습니다.";
					else {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->facilityTableName SET settle4='$flag', settle4_dt=$cur_date WHERE apply_no=$no");
						$returnValue = $this->execQuery();
					}
				} else if ($grade == "1") {
					if ($flag == "Y" && $settle2 != "Y") $this->errorMessage = "과장 미결 상태이므로 결재할 수 없습니다.";
					else if ($flag == "N" && $settle4 != "N") $this->errorMessage = "이미 사감장님의 결재가 이루어져 결재취소를 할 수 없습니다.";
					else {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->facilityTableName SET settle3='$flag', settle3_dt=$cur_date WHERE apply_no=$no");
						$returnValue = $this->execQuery();
					}
				} else if ($grade == "0") {
					if ($flag == "Y" && $settle1 != "Y") $this->errorMessage = "담당자의 결재가 이루어지지 않아 결재승인을 할 수 없습니다.";
					else if ($flag == "N" && $settle3 != "N") $this->errorMessage = "이미 팀장님의 결재가 이루어져 결재취소를 할 수 없습니다.";
					else {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->facilityTableName SET settle2='$flag', settle2_dt=$cur_date WHERE apply_no=$no");
						$returnValue = $this->execQuery();
					}
				}
			}
			if (!$returnValue) $this->errorMessage = "작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.";
			return $returnValue;
		}

		function insertHistoryWork($menu, $kind, $detail) {
			global $ihouse_admin_info;
			$admin_id = $ihouse_admin_info[id];
			if (strtolower($admin_id) != "intia") {
				$ip = $_SERVER["REMOTE_ADDR"];
				$this->clearSQL();
				$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'F', '$menu', '$kind', '$ip', now(), '$detail')");
				$this->execQuery();
			}
		}
	}
?>