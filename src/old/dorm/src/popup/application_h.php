<?
	include_once("../../lib/conf.common.php");
	include_once("../common/facility_tpl.php");
	include_once("../../lib/class.rFastTemplate.php");

	$tpl = new rFastTemplate("../../tpl/popup");
	$tpl->define(array(main => "application_h.html"));

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
	if ($facility->facilityState == "IW" || $facility->facilityState == "CC" || $facility->facilityState == "RF") {
		$room1 = "";
		$room2 = "";
		$room3 = "";
	}

	$tpl->assign(array(FACILITY_NUMBER     => $no,
	                   FACILITY_SETTLE1    => $facility->getSettleValue($facility->facilitySettle1),
	                   FACILITY_SETTLE2    => $facility->getSettleValue($facility->facilitySettle2),
	                   FACILITY_SETTLE3    => "Àü°á",
	                   FACILITY_SETTLE4    => $facility->getSettleValue($facility->facilitySettle4),
	                   FACILITY_STATE      => $facility->getStateValue($facility->facilityState),
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
	                   FACILITY_BREAKFAST  => $facility->getBreakfastValue($facility->facilityBreakfast),
	                   FACILITY_REQUEST1   => $request1,
	                   FACILITY_REQUEST2   => $request2,
	                   FACILITY_REQUEST3   => $request3,
	                   FACILITY_ROOM1      => $room1,
	                   FACILITY_ROOM2      => $room2,
	                   FACILITY_ROOM3      => $room3,
	                   FACILITY_APPLY      => getEnglishDate($facility->facilityApply),
	                   FACILITY_ASSIGN     => getEnglishDate($facility->facilityAssign),
	                   FACILITY_CONFIRM    => getEnglishDate($facility->facilityConfirm),
	                   FACILITY_BILLED     => getEnglishDate($facility->facilityBilled),
	                   FACILITY_PAID       => getEnglishDate($facility->facilityPaid)));

	include("../common/tpl_variables.php");

	$facility->closeDatabase();
	unset($facility);

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>