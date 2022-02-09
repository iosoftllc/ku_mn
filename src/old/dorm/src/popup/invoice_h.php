<?
	include_once("../../lib/conf.common.php");
	include_once("../common/facility_tpl.php");
	include_once("../../lib/class.rFastTemplate.php");

	$tpl = new rFastTemplate("../../tpl/popup");
	$tpl->define(array(main => "invoice_h.html"));
	$tpl->define_dynamic(payment_row, "main");

	$tpl->define_dynamic(payment_row, "body");

	$facility->getFacilityInfo($no);
	$hour = explode("|", $facility->facilityEventHour);

	$tpl->assign(array(INVOICE_NUMBER   => $no,
	                   INVOICE_DATE     => $facility->facilityBilled,
	                   INVOICE_TO       => stripslashes($facility->facilityEventName),
	                   INVOICE_TOTAL    => number_format($facility->facilityFee),
	                   INVOICE_UNIT     => $facility->getUnitValue($facility->facilityRequest),
	                   INVOICE_CHECKIN  => $facility->facilityEventDate . "<br>" . $hour[0] . ":" . $hour[1],
	                   INVOICE_CHECKOUT => $facility->facilityEventDate . "<br>" . $hour[2] . ":" . $hour[3],
	                   PAYMENT_DATE     => $facility->facilityAssign,
	                   PAYMENT_AMOUNT   => number_format($facility->facilityFee)));

	$facility->closeDatabase();
	unset($facility);

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>