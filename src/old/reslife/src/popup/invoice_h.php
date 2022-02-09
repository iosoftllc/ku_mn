<?
	///////////////////////////////////////////////////////////////////////////////////////
	// 수정 시 admin/src/faculty/fac_action.php 에서 mode="invoice" 메일 발송 부분도 수정하기 //
	///////////////////////////////////////////////////////////////////////////////////////

	include_once("../common/popup_header_tpl.php");
	include_once("../common/facility_tpl.php");

	$page_title = "Receipt";
	$sub_title = "Receipt";
	$on_load = "";
	$email_src = "../../src/faculty/fac_action.php?mode=invoice&no=$no";

	$tpl->define_dynamic(array(breakfast_row => "body",
	                           waive_row     => "body"));

	$facility->getFacilityInfo($no);
	$hour = explode("|", $facility->facilityEventHour);
	if ($facility->facilityBreakfast == "Y") $title = "CONFERENCE BREAKFAST PACKAGE";
	else $title = "HALL BASE RENT";

	if ($facility->facilityBreakfast == "Y") {
		$acc_no = "391-910007-48204";
		$acc_re = "CJ CAFETERIA";
	} else {
		$acc_no = "391-910001-03204";
		$acc_re = "Korea University Anam Residence Life";
	}

	$tpl->assign(array(INVOICE_NUMBER    => $no,
	                   INVOICE_DATE      => $facility->facilityBilled,
	                   INVOICE_TO        => stripslashes($facility->facilityEventName),
	                   INVOICE_TOTAL     => number_format((int)$facility->facilityFee + (int)$facility->facilityMeal - (int)$facility->facilityWaive),
	                   INVOICE_UNIT      => $facility->getUnitValue($facility->facilityRequest),
	                   INVOICE_CHECKIN   => $facility->facilityEventDate . "<br>" . $hour[0] . ":" . $hour[1],
	                   INVOICE_CHECKOUT  => $facility->facilityEventDate . "<br>" . $hour[2] . ":" . $hour[3],
	                   PAYMENT_DATE      => $facility->facilityAssign,
	                   PAYMENT_TITLE     => $title,
	                   PAYMENT_AMOUNT    => number_format((int)$facility->facilityFee + (int)$facility->facilityMeal),
	                   PAYMENT_BREAKFAST => number_format($facility->facilityMeal),
	                   ACCOUNT_NUMBER    => $acc_no,
	                   ACCOUNT_RECIPIENT => $acc_re));

	if ((int)$facility->facilityWaive > 0) {
		$tpl->assign(array(WAIVE_DATE   => $facility->facilityWaiveDate,
		                   WAIVE_AMOUNT => number_format($facility->facilityWaive)));
		$tpl->parse(WAIVE_ROWS, ".waive_row");
	}

	//if ((int)$facility->facilityMeal > 0) $tpl->parse(BREAKFAST_ROWS, ".breakfast_row");

	include("../common/variables_tpl.php");

	$facility->closeDatabase();
	unset($facility);

	include("../common/popup_footer_tpl.php");
?>