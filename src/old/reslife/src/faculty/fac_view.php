<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 0 && (int)$ihouse_admin_info[grade] != 1 && (int)$ihouse_admin_info[grade] != 2 && (int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/facility_tpl.php");

			$page_name .= " 상세정보 보기";

			include_once("../common/header_tpl.php");

			$facility->getFacilityInfo($no);
			if ($facility->facilityResident == "Y") {
				$resident1 = "( <b>O</b> )";
				$resident2 = "(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)";
			} else {
				$resident1 = "(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)";
				$resident2 = "( <b>O</b> )";
			}
			$temp = explode("|", $facility->facilityEventHour);
			if ($temp[0] && $temp[2]) $event_hr = $temp[0] . ":" . $temp[1] . " to " . $temp[2] . ":" . $temp[3];
			else $event_hr = "";
			$temp = explode("|", $facility->facilityRequest);
			if ($temp[0] == "C1") {
				$request1 = "( <b>O</b> )";
				$room1 = "<b> - B113</b>";
			} else {
				$request1 = "(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)";
				$room1 = "";
			}
			if ($temp[1] == "S1") {
				$request2 = "( <b>O</b> )";
				$room2 = "<b> - B105</b>";
			} else {
				$request2 = "(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)";
				$room2 = "";
			}
			if ($temp[2] == "S2") {
				$request3 = "( <b>O</b> )";
				$room3 = "<b> - B104</b>";
			} else {
				$request3 = "(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)";
				$room3 = "";
			}
			if ($temp[3] == "R1") {
				$request4 = "( <b>O</b> )";
				$room4 = "<b> - 441</b>";
			} else {
				$request4 = "(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)";
				$room4 = "";
			}
			if ($temp[4] == "R2") {
				$request5 = "( <b>O</b> )";
				$room5 = "<b> - 641</b>";
			} else {
				$request5 = "(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)";
				$room5 = "";
			}
			if ($facility->facilityState == "IW" || $facility->facilityState == "CC" || $facility->facilityState == "RF") {
				$room1 = "";
				$room2 = "";
				$room3 = "";
				$room4 = "";
				$room5 = "";
			}
			$cancel = getEnglishDate($facility->facilityCancelDate);
			if (trim($cancel) != "") $cancel .= " (" . number_format($facility->facilityCancel) . "원)";
			$waive = getEnglishDate($facility->facilityWaiveDate);
			if (trim($waive) != "") $waive .= " (" . number_format($facility->facilityWaive) . "원)";

			$tpl->assign(array(SEL_PAGE            => $page,
			                   SEARCH_TYPE         => $s_type,
			                   SEARCH_TEXT         => $s_text,
			                   SEARCH_STATE        => $s_state,
			                   SEARCH_GRADE        => $s_grade,
			                   SEARCH_ROOM         => $s_room,
			                   SORT1_VALUE         => $sort1,
			                   SORT2_VALUE         => $sort2,
			                   FACILITY_NUMBER     => $no,
			                   FACILITY_SETTLE1    => $facility->getSettleValue($facility->facilitySettle1, $facility->facilitySettleDate1),
			                   FACILITY_SETTLE2    => $facility->getSettleValue($facility->facilitySettle2, $facility->facilitySettleDate2),
			                   FACILITY_SETTLE3    => $facility->getSettleValue($facility->facilitySettle3, $facility->facilitySettleDate3),
			                   FACILITY_SETTLE4    => $facility->getSettleValue($facility->facilitySettle4, $facility->facilitySettleDate4),
			                   FACILITY_STATE      => $facility->getStateValue($facility->facilityState),
			                   FACILITY_STATE1     => $facility->facilityState,
			                   EVENT_NAME          => stripslashes($facility->facilityEventName),
			                   EVENT_DATE          => getEnglishDate($facility->facilityEventDate),
			                   EVENT_HOUR          => $event_hr,
			                   FACILITY_APPLICANT  => stripslashes($facility->facilityApplicant),
			                   FACILITY_RESIDENT1  => $resident1,
			                   FACILITY_RESIDENT2  => $resident2,
			                   FACILITY_DEPARTMENT => stripslashes($facility->facilityDepartment),
			                   FACILITY_POSITION   => stripslashes($facility->facilityPosition),
			                   FACILITY_EMAIL      => $facility->facilityEmail,
			                   FACILITY_PHONE      => $facility->facilityPhone,
			                   FACILITY_ATTENDEE   => $facility->facilityAttendee,
			                   FACILITY_REQUEST1   => $request1,
			                   FACILITY_REQUEST2   => $request2,
			                   FACILITY_REQUEST3   => $request3,
			                   FACILITY_REQUEST4   => $request4,
			                   FACILITY_REQUEST5   => $request5,
			                   FACILITY_ROOM1      => $room1,
			                   FACILITY_ROOM2      => $room2,
			                   FACILITY_ROOM3      => $room3,
			                   FACILITY_ROOM4      => $room4,
			                   FACILITY_ROOM5      => $room5,
			                   FACILITY_BREAKFAST  => $facility->getBreakfastValue($facility->facilityBreakfast),
			                   FACILITY_DISCOUNT1  => $facility->getDiscountValue($facility->facilityDiscount1),
			                   FACILITY_DISCOUNT2  => $facility->getDiscountValue($facility->facilityDiscount2),
			                   FACILITY_FEE        => number_format($facility->facilityFee),
			                   FACILITY_MEAL       => number_format($facility->facilityMeal),
			                   FACILITY_CONFIRM    => getEnglishDate($facility->facilityConfirm),
			                   FACILITY_APPLY      => getEnglishDate($facility->facilityApply),
			                   FACILITY_ASSIGN     => getEnglishDate($facility->facilityAssign),
			                   FACILITY_BILLED     => getEnglishDate($facility->facilityBilled),
			                   FACILITY_PAID       => getEnglishDate($facility->facilityPaid),
			                   FACILITY_CANCEL     => $cancel,
			                   FACILITY_WAIVE      => $waive,
			                   FACILITY_ADMIN      => nl2br(stripslashes($facility->facilityAdmin))));

			include("../common/variables_tpl.php");

			$detail = "$no 시설예약 상세 정보 조회";
			$facility->insertHistoryWork("F", "I", $detail);

			$facility->closeDatabase();
			unset($facility);

			include_once("../common/footer_tpl.php");
		}
	}
?>