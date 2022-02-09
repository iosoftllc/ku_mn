<?
	include_once("../../lib/conf.common.php");
	include_once("../common/facility_tpl.php");

	if ($facility->isExist($view_no, $view_event)) {
		$html_dir = "facility";
		$html_file = "view";
		$on_load = "";

		include_once("../../src/common/tpl_header.php");

		$tpl->define_dynamic(invoice_row, "body");

		$facility->getFacilityInfo($view_no);
		$temp = explode("|", $facility->facilityEventHour);
		if ($temp[0] && $temp[2]) $event_hr = $temp[0] . ":" . $temp[1] . " to " . $temp[2] . ":" . $temp[3];
		else $event_hr = "";

		$tpl->assign(array(FACILITY_NUMBER     => $view_no,
		                   FACILITY_STATE      => $facility->getStateValue($facility->facilityState),
		                   FACILITY_ASSIGN     => getEnglishDate($facility->facilityAssign),
		                   FACILITY_CONFIRM    => getEnglishDate($facility->facilityConfirm),
		                   FACILITY_BILLED     => getEnglishDate($facility->facilityBilled),
		                   FACILITY_PAID       => getEnglishDate($facility->facilityPaid),
		                   EVENT_NAME          => stripslashes($facility->facilityEventName),
		                   EVENT_DATE          => getEnglishDate($facility->facilityEventDate),
		                   EVENT_HOUR          => $event_hr,
		                   FACILITY_APPLICANT  => stripslashes($facility->facilityApplicant),
		                   FACILITY_RESIDENT   => $facility->getResidentValue($facility->facilityResident),
		                   FACILITY_DEPARTMENT => stripslashes($facility->facilityDepartment),
		                   FACILITY_POSITION   => stripslashes($facility->facilityPosition),
		                   FACILITY_EMAIL      => $facility->facilityEmail,
		                   FACILITY_PHONE      => $facility->facilityPhone,
		                   FACILITY_ATTENDEE   => $facility->facilityAttendee,
		                   FACILITY_BREAKFAST  => $facility->getBreakfastValue($facility->facilityBreakfast),
		                   FACILITY_REQUEST    => $facility->getRoomValue($facility->facilityRequest),
		                   PAYMENT_TOTAL       => number_format($pay_total)));

		include("../common/tpl_variables.php");

		if ($facility->facilityState == "CF") $tpl->parse(INVOICE_ROWS, ".invoice_row");

		$facility->closeDatabase();
		unset($facility);

		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
	} else {
		$facility->closeDatabase();
		unset($facility);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"There is not correspondant application.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	}
?>