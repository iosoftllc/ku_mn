<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] == 8 || (int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/facility_tpl.php");
			include_once("../common/header_tpl.php");

			if ($mode == "edit") {
				$page_name .= " 수정";
				$facility->getFacilityInfo($no);
			  $no = $facility->facilityNumber;
			  $state = $facility->facilityState;
			  $event_nm = stripslashes($facility->facilityEventName);
			  $applicant = stripslashes($facility->facilityApplicant);
			  $resident = $facility->facilityResident;
			  $department = stripslashes($facility->facilityDepartment);
				$position = stripslashes($facility->facilityPosition);
				$email = $facility->facilityEmail;
				$phone = $facility->facilityPhone;
				$event_dt = $facility->facilityEventDate;
			  $event_hr = explode("|", $facility->facilityEventHour);
				$attendee = $facility->facilityAttendee;
				$request = explode("|", $facility->facilityRequest);
				$breakfast = $facility->facilityBreakfast;
				$discount1 = $facility->facilityDiscount1;
				$discount2 = $facility->facilityDiscount2;
				$settle1 = $facility->facilitySettle1;
				$settle2 = $facility->facilitySettle2;
				$settle3 = $facility->facilitySettle3;
				$settle4 = $facility->facilitySettle4;
				$assign_dt = $facility->facilityAssign;
				$confirm_dt = $facility->facilityConfirm;
				$billed_dt = $facility->facilityBilled;
				$paid_dt = $facility->facilityPaid;
				$cancel = $facility->facilityCancel;
				$cancel_dt = $facility->facilityCancelDate;
				$waive = $facility->facilityWaive;
				$waive_dt = $facility->facilityWaiveDate;
				$admin = $facility->facilityAdmin;
			} else {
				$page_name .= " 추가";
			  $no = "";
			  $state = "IW";
			  $event_nm = "";
			  $applicant = "";
			  $resident = "N";
			  $department = "";
				$position = "";
				$email = "";
				$phone = "";
				$event_dt = "";
			  $event_hr = array();
				$attendee = "";
				$request = array();
				$breakfast = "N";
				$discount1 = "N";
				$discount2 = "N";
				$settle1 = "N";
				$settle2 = "N";
				$settle3 = "N";
				$settle4 = "N";
				$assign_dt = "";
				$confirm_dt = "";
				$billed_dt = "";
				$paid_dt = "";
				$cancel = "";
				$cancel_dt = "";
				$waive = "";
				$waive_dt = "";
				$admin = "";
			}

			if ($event_dt == "0000-00-00") $event_dt = "";
			if ($assign_dt == "0000-00-00") $assign_dt = "";
			if ($confirm_dt == "0000-00-00") $confirm_dt = "";
			if ($billed_dt == "0000-00-00") $billed_dt = "";
			if ($paid_dt == "0000-00-00") $paid_dt = "";
			if ($cancel_dt == "0000-00-00") $cancel_dt = "";
			if ($waive_dt == "0000-00-00") $waive_dt = "";

			$tpl->assign(array(MODE                => $mode,
			                   SEL_PAGE            => $page,
			                   SEARCH_TYPE         => $s_type,
			                   SEARCH_TEXT         => $s_text,
			                   SEARCH_STATE        => $s_state,
			                   SEARCH_GRADE        => $s_grade,
			                   SEARCH_ROOM         => $s_room,
			                   SORT1_VALUE         => $sort1,
			                   SORT2_VALUE         => $sort2,
			                   FACILITY_NUMBER     => $no,
			                   FACILITY_STATE      => $state,
			                   EVENT_NAME          => $event_nm,
			                   EVENT_DATE          => $event_dt,
			                   EVENT_HOUR1         => $event_hr[0],
			                   EVENT_MINUTE1       => $event_hr[1],
			                   EVENT_HOUR2         => $event_hr[2],
			                   EVENT_MINUTE2       => $event_hr[3],
			                   FACILITY_APPLICANT  => $applicant,
			                   FACILITY_RESIDENT   => $resident,
			                   FACILITY_DEPARTMENT => $department,
			                   FACILITY_POSITION   => $position,
			                   FACILITY_EMAIL      => $email,
			                   FACILITY_PHONE      => $phone,
			                   FACILITY_ATTENDEE   => $attendee,
			                   FACILITY_REQUEST1   => $request[0],
			                   FACILITY_REQUEST2   => $request[1],
			                   FACILITY_REQUEST3   => $request[2],
			                   FACILITY_REQUEST4   => $request[3],
			                   FACILITY_REQUEST5   => $request[4],
			                   FACILITY_BREAKFAST  => $breakfast,
			                   FACILITY_DISCOUNT1  => $discount1,
			                   FACILITY_DISCOUNT2  => $discount2,
			                   FACILITY_SETTLE1    => $settle1,
			                   FACILITY_SETTLE2    => $settle2,
			                   FACILITY_SETTLE3    => $settle3,
			                   FACILITY_SETTLE4    => $settle4,
			                   FACILITY_ASSIGN     => $assign_dt,
			                   FACILITY_CONFIRM    => $confirm_dt,
			                   FACILITY_BILLED     => $billed_dt,
			                   FACILITY_PAID       => $paid_dt,
			                   FACILITY_CANCEL     => $cancel,
			                   FACILITY_CANCEL_DT  => $cancel_dt,
			                   FACILITY_WAIVE      => $waive,
			                   FACILITY_WAIVE_DT   => $waive_dt,
			                   FACILITY_ADMIN      => $admin));

			$facility->closeDatabase();
			unset($facility);

			include_once("../common/footer_tpl.php");
		}
	}
?>