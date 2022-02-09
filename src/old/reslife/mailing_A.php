<?
	include_once("lib/conf.common.php");
	include_once("lib/func.common.php");
	include_once("lib/class.cApplicant.php");
	include_once("lib/class.rFastTemplate.php");

	$no = array();

	$no[] = "2005110114";
	$no[] = "2005110133";
	$no[] = "2005110138";
	$no[] = "2005110142";
	$no[] = "2005110154";
	$no[] = "2005110181";
	$no[] = "2005110230";
	$no[] = "2005110243";
	$no[] = "2005120015";
	$no[] = "2005120027";
	$no[] = "2005120042";
	$no[] = "2005120043";
	$no[] = "2005120054";
	$no[] = "2005120070";
	$no[] = "2005120083";
	$no[] = "2005120109";
	$no[] = "2005120124";
	$no[] = "2005120151";
	$no[] = "2006010012";
	$no[] = "2006010025";
	$no[] = "2006010033";
	$no[] = "2006010052";
	$no[] = "2006010114";
	$no[] = "2006010121";
	$no[] = "2006010128";

	$no[] = "2005120229";

	$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
	$applicant->connectDatabase();

	$count = 0;
	for ($i = 0; $i < count($no); $i++) {
		$applicant->getApplicantInfo($no[$i]);
		$from = "reslife@korea.ac.kr";
		$to = $applicant->personEmail;

		$subject = "[KU Residence Life] Spring A CHECK IN & DIRECTIONS TO RESIDENCE LIFE OFFICE";

		$msg = "<b>CHECK IN & DIRECTIONS TO RESIDENCE LIFE OFFICE</b><br><br>\n";
		$msg .= "<b>CHECK IN</b><br><br>\n";
		$msg .= "You must check in and out with the Office of Residence Life. The International Residence Life is located in the CJ International House. At the information desk, you will be able to:<br><br>\n";
		$msg .= "- Sign for your room and other keys and make the key deposit of 40,000 KRW (10,000 KRW/key). Note the key deposit is fully refundable when keys are returned upon check out.<br>\n";
		$msg .= "- Complete a Room Inventory Checklist.<br>\n";
		$msg .= "- Get directions to your residence hall.<br>\n";
		$msg .= "- Sign up for Residence Hall Orientation.<br><br>\n";
		$msg .= "Check in hours for both new and returning students:<br><br>\n";
		$msg .= "Spring A (Feb 17 - June 20) residents:<br>\n";
		$msg .= "February Friday 17 through Monday 20, 2006<br>\n";
		$msg .= "9:30 AM to 12:00 AM<br>\n";
		$msg .= "1:00 PM to 6:00 PM<br>\n";
		$msg .= "7:00 PM to 9:00 PM<br><br>\n";
		$msg .= "Please make every effort to arrive between hours listed above. If you arrive on campus after 9:00 p.m. come to the information desk in the CJ International House and wait for assistance.<br><br>\n";
		$msg .= "<b>DIRECTIONS</b><br><br>\n";
		$msg .= "<b>BY SUBWAY</b><br><br>\n";
		$msg .= "From Anam Subway station (Line 6) Exit # 2 -> Walk for 7 min. toward Gaewoon-sa gil (Gaewoon Temple Street) -> Main Gate of Anam Residence Life -> Walk for 7 min. to CJ International House<br>\n";
		$msg .= "(For Campus Map: Go to www.korea.edu -> Click CAMPUS GUIDE MAP located on bottom left)<br><br>\n";
		$msg .= "<b>BY OTHER TRANSPORTAION SYSTEMS</b><br><br>\n";
		$msg .= "Go to www.korea.edu -> Click ABOUT KOREA UNIVERSITY -> Click HOW TO GET TO KU<br><br>\n";
		$msg .= "Also, 'Buddy' volunteers may be available to pick you up at the airport, to help you move in to the residence hall. The Office of International Affairs can arrange a buddy for the airport pick-up with at least two-week advanced notice. However, you are required to pay for the traveling cost for yourself and the buddy.<br><br>\n";
		$msg .= "Students must download & fax the airport pick-up application to The Office of International Affairs (FAX number: +82 2 922 5820) at least two weeks in advance.  To download the airport pick-up application form: go to www.korea.edu -> Click INTERNATIONAL STUDENTS -> Click APPLICATION -> Download AIRPORT PICK-UP SERVICE APPLICATION<br><br>\n";

		$tpl = new rFastTemplate("../tpl/main");
		$tpl->define(array(main => "letter.html"));
		$tpl->assign(array(DOMAIN_URL => $web_http_url,
		                   MESSAGE    => $msg));
		$tpl->parse(FINAL, "main");
		$content = $tpl->GetTemplate(FINAL);
		$headers = "Reply-To: " . $from . "\n";
		$headers .= "From: " . $from . "\n";
		$headers .= "Content-Type: text/html; charset=euc-kr\n";
		$headers .= "Mime-Version: 1.0\n";
		$flag = mail($to, $subject, $content, $headers);
		unset($tpl);

		if ($flag) echo $no[$i] . " : success<br>";
		else echo $no[$i] . " : fail<br>";
		$count++;
	}

	echo $count;

	$applicant->closeDatabase();
	unset($applicant);
?>