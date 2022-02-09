<?
	///////////////////////////////////////////////////////////////////////////////////////
	// 수정 시 admin/src/faculty/fac_action.php 에서 mode="receipt" 메일 발송 부분도 수정하기 //
	///////////////////////////////////////////////////////////////////////////////////////

	include_once("../common/popup_header_tpl.php");
	include_once("../common/facility_tpl.php");

	$page_title = "Receipt";
	$sub_title = "Receipt";
	$on_load = "";
	$email_src = "../../src/faculty/fac_action.php?mode=receipt&no=$no";

	$item = $_GET["item"];
	if (!$item) $item = $_POST["item"];
	$item = explode(",", $item);

	$tpl->define_dynamic(array(rent_row      => "body",
	                           breakfast_row => "body",
	                           cancel_row    => "body"));

	$facility->getFacilityInfo($no);
	$hour = explode("|", $facility->facilityEventHour);
	if ($facility->facilityBreakfast == "Y") $title = "CONFERENCE BREAKFAST PACKAGE";
	else $title = "HALL BASE RENT";

	/*
	$total = 0;
	for ($i = 0; $i < count($item); $i++) {
		$tpl->assign(array(PAYMENT_DATE     => $facility->facilityPaid,
		                   PAYMENT_AMOUNT    => number_format($facility->facilityFee),
		                   PAYMENT_BREAKFAST => number_format($facility->facilityMeal)));
		if ($item[$i] == "R") {
			$total += (int)$facility->facilityFee;
			$tpl->parse(RENT_ROWS, ".rent_row");
		} else if ($item[$i] == "B") {
			$total += (int)$facility->facilityMeal;
			$tpl->parse(BREAKFAST_ROWS, ".breakfast_row");
		}
	}
	*/
	if ($facility->facilityCancelDate != "0000-00-00" && is_numeric($facility->facilityCancel) && (int)$facility->facilityCancel > 0) {
		$tpl->assign(array(CANCEL_DATE   => $facility->facilityCancelDate,
		                   CANCEL_AMOUNT => "-" . number_format($facility->facilityCancel)));
		$tpl->parse(CANCEL_ROWS, ".cancel_row");
	}

	$tpl->assign(array(INVOICE_NUMBER   => $no,
	                   INVOICE_DATE     => $facility->facilityBilled,
	                   INVOICE_TO       => stripslashes($facility->facilityEventName),
	                   INVOICE_TOTAL    => number_format((int)$facility->facilityFee + (int)$facility->facilityMeal - (int)$facility->facilityCancel),
	                   INVOICE_UNIT     => $facility->getUnitValue($facility->facilityRequest),
	                   INVOICE_CHECKIN  => $facility->facilityEventDate . "<br>" . $hour[0] . ":" . $hour[1],
	                   INVOICE_CHECKOUT => $facility->facilityEventDate . "<br>" . $hour[2] . ":" . $hour[3],
	                   PAYMENT_DATE     => $facility->facilityPaid,
	                   PAYMENT_TITLE    => $title,
	                   PAYMENT_AMOUNT   => number_format((int)$facility->facilityFee + (int)$facility->facilityMeal)));

	include("../common/variables_tpl.php");

	$facility->closeDatabase();
	unset($facility);

	include("../common/popup_footer_tpl.php");
?>