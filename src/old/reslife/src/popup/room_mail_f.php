<?
	include_once("../common/popup_header_tpl.php");
	include_once("../common/faculty_tpl.php");

	$page_title = "Room Assignment Mail";
	$sub_title = "Room Assignment Mail";
	$on_load = "";
	$email_src = "../../src/faculty/room_action.php?mode=room&no=$no";

	$faculty->getFacultyInfo($no);
	$name = "";
	if ($faculty->facultyTitle) $name .= $faculty->facultyTitle . ". ";
	$name .= $faculty->facultyLName;
	if (trim($faculty->facultyFName)) $name .= ", " . $faculty->facultyFName . " " . $faculty->facultyMName;
	$room = $faculty->getRoomValue($no);
	$period = $faculty->facultyArrival . " ~ " . $faculty->facultyDeparture;
	$deposit = $faculty->getDepositFee($no);
	$rate = number_format($faculty->getRentalFee($no)) . "won";
	$from = $ihouse_admin_info[name] . "<" . $ihouse_admin_info[email] . ">";
	$to = $name . "<" . $faculty->facultyEmail . ">";
	$subject = "[KU Residence Life] Room Assigment & Payment Information";
	$msg = "Dear $name,<br><br>\n";
	$msg .= "Thank you for your application.<br>\n";
	$msg .= "Your reservation is confirmed:<br><br>\n";
	$msg .= "<font style=\"text-decoration:underline;\">Application Number: <b>$no</b><br>\n";
	$msg .= "Room Number: <b>$room</b><br>\n";
	$msg .= "Room Phone Number: <b>$faculty->roomPhone</b><br>\n";
	$msg .= "Staying Period: <b>$period</b><br>\n";
	if ($deposit) $msg .= "Deposit(for long term residency of one month and longer only): <b>" . number_format($deposit) . "won</b><br>\n";
	$msg .= "Rate($period): <b>$rate</b></font><br><br>\n";
	$msg .= "The amount should be wired to our bank account before your arrival according to Korea University residence hall policy.  Please note that Korea University Anam Residence Life Office does not accept cash or credit card.<br><br>\n";
	$msg .= "Our bank information is as follows:<br><br>\n";
	$msg .= "<font style=\"text-decoration:underline;\">BANK: Hana Bank, Godae Branch<br>\n";
	$msg .= "RECIPIENT: Korea University Anam Residence Life<br>\n";
	$msg .= "SWIFT CODE: HNBNKRSE<br>\n";
	$msg .= "ACCOUNT NO.: 391-910001-03204</font><br><br>\n";
	$msg .= "Please make sure to write your name in the reference field for Recipient.<br>\n";
	$msg .= "Upon checking in, there is a key deposit of 10,000won per key.<br><br>\n";
	if ($deposit) $msg .= "Please drop by the residence life office in CJ International House to sign a lease contract within 1 week after you check in.<br><br>\n";
	$msg .= "Thank you and we look forward to seeing you soon.<br><br>\n";
	$msg .= "Regards,<br><br>\n";
	$msg .= "Korea University<br>\n";
	$msg .= "Anam Residence Life<br>\n";
	$msg .= "International Residence<br>\n";
	$msg .= "Anam-Dong Seongbuk-Gu Seoul, 136-701 Korea<br>\n";
	//$msg .= "Tel: 82-2-3290-1555<br>\n";
	$msg .= "Fax: 82-2-926-3464<br>\n";
	$msg .= "<a href=\"mailto:reslife@korea.ac.kr\">Email: reslife@korea.ac.kr</a>";

	$tpl->assign(array(DOMAIN_URL => $HTTP_SERVER_VARS["SERVER_NAME"],
	                   MESSAGE    => stripslashes($msg)));

	$faculty->closeDatabase();
	unset($faculty);

	include("../common/popup_footer_tpl.php");
?>