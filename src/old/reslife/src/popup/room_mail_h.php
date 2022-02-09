<?
	include_once("../common/popup_header_tpl.php");
	include_once("../common/facility_tpl.php");

	$page_title = "Assignment & Payment Information";
	$sub_title = "Assignment & Payment Information";
	$on_load = "";
	$email_src = "../../src/faculty/fac_action.php?mode=room&no=$no";

	$facility->getFacilityInfo($no);

	$temp = explode("|", $facility->facilityEventHour);
	if ($temp[0] && $temp[2]) {
		$event_hr = $temp[0] . ":" . $temp[1] . " ~ " . $temp[2] . ":" . $temp[3] . " (" . $facility->calculateTime($temp[0], $temp[1], $temp[2], $temp[3]) . " hours)";
	} else $event_hr = "";

	$subject = "[KU Residence Life] Assignment & Payment Information";
	$msg = "Dear " . $facility->facilityApplicant . ",<br><br>\n";
	$msg .= "Thank you for your application.<br>\n";
	$msg .= "Your reservation is confirmed:<br><br>\n";
	$msg .= "<b>* Application Number : " . $facility->facilityNumber . "<br>\n";
	$msg .= "* Room Number : " . $facility->getRequestValue1($facility->facilityRequest) . "<br>\n";
	$msg .= "* Date of Event : " . $facility->facilityEventDate . "<br>\n";
	$msg .= "* Hours of Event : " . $event_hr . "<br>\n";
	$msg .= "* Rate : KR " . number_format($facility->facilityFee) . "</b><br><br>\n";
	$msg .= "The amount should be wired to our bank account before your event.<br>\n";
	$msg .= "Please note that Korea University Anam Residence Life Office does not accept cash or credit card.<br><br>\n";
	$msg .= "Our bank information is as follows:<br>\n";
	$msg .= "<b>BANK: Hana Bank, Godae Branch<br>\n";
	if ($facility->facilityBreakfast == "Y") $msg .= "RECIPIENT: CJ CAFETERIA<br>\n";
	else $msg .= "RECIPIENT: Korea University Anam Residence Life<br>\n";
	$msg .= "SWIFT CODE: HNBNKRSE<br>\n";
	if ($facility->facilityBreakfast == "Y") $msg .= "ACCOUNT NO.: 391-910007-48204</b><br><br>\n";
	else $msg .= "ACCOUNT NO.: 391-910001-03204</b><br><br>\n";
	$msg .= "Please make sure to write your name of event or organization in the reference field for Recipient.<br>\n";
	$msg .= "Thank you and we look forward to seeing you soon.<br>\n";
	$msg .= "Sincerely,<br><br>\n";
	$msg .= "Korea University<br>\n";
	$msg .= "Anam Residence Life<br>\n";
	$msg .= "International Residence<br>\n";
	$msg .= "Anam-Dong Seongbuk-Gu Seoul, 136-701 Korea<br>\n";
	//$msg .= "Tel: 82-2-3290-1555<br>\n";
	$msg .= "Fax: 82-2-926-3464<br>\n";
	$msg .= "<a href=\"mailto:reslife@korea.ac.kr\">Email: reslife@korea.ac.kr</a>";

	$tpl->assign(array(DOMAIN_URL => $HTTP_SERVER_VARS["HTTP_HOST"],
	                   MESSAGE    => stripslashes($msg)));

	$facility->closeDatabase();
	unset($facility);

	include("../common/popup_footer_tpl.php");
?>