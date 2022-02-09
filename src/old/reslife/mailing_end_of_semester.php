<?
	include_once("lib/conf.common.php");
	include_once("lib/func.common.php");
	include_once("lib/class.cApplicant.php");
	include_once("lib/class.rFastTemplate.php");

	$no = array();
	//$no[] = "2006050002"; // À±Èñ·É
	//$no[] = "2005120227"; // ±è½ÂÈ¯
	$no[] = "2006050002";
	$no[] = "2006050002";
	$no[] = "2006050219";
	$no[] = "2006050235";
	$no[] = "2006110003";
	$no[] = "2006110011";
	$no[] = "2006110023";

	$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
	$applicant->connectDatabase();

	$count = 0;
	for ($i = 0; $i < count($no); $i++) {
		$applicant->getApplicantInfo($no[$i]);
		$name = $applicant->personLastName . " - Family, " . $applicant->personFirstName . " - Given " . $applicant->personMiddleName . " - Middle";
		$from = "reslife@korea.ac.kr";
		$to = $applicant->personEmail;
		//$to = "ksh@intia.co.kr";
		//$to = "heeryun@korea.ac.kr";

		$subject = "[KU Residence Life] END OF SEMESTER REMINDERS";

		$msg = "As we approach the end of the Fall Semester, the staff of the Residence Life Office wishes you success in your finals and other academic endeavors. It has been a privilege to have worked for you. If you are completing your studies and moving on from Korea University, we congratulate you on your achievements. To the continuing students, congratulations for the successful completion of this semester- we look forward to your return!<br><br>\n";
		$msg .= "Below are important reminders. Keep this message for your reference.<br><br>\n";
		$msg .= "1. IMPORTANT DATES<br><br>\n";
		$msg .= "Sign-up for Express Checkout & Regular Check-out:<br>\n";
		$msg .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;December 8 - December 18 at CJ International House Information Desk<br>\n";
		$msg .= "START EARLY AND AVOID LAST MINUTE RUSH<br><br>\n";
		$msg .= "Check-out Period:<br>\n";
		$msg .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;December 15 - December 19, 9 am - 12 pm, 1 pm- 5 pm<br>\n";
		$msg .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;December 20, 9 am - 12 pm<br><br>\n";
		$msg .= "Room Switch Date:   December 21<br>\n";
		$msg .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Check-out hours: 9 am - 12 pm<br>\n";
		$msg .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Check-in hours: 1 pm - 5 pm<br><br>\n";
		$msg .= "Request for a Deposit Refund by: January 5, 2007<br><br>\n";
		$msg .= "2. CHECK-OUT<br><br>\n";
		$msg .= "1) Make an appointment for your check-out inspection at least 24 hours in advance of your departure date.<br>\n";
		$msg .= "2) Make your room ready for check-out according to the Check-Out Instructions at the residence life website.<br>\n";
		$msg .= "3) The Express Check Out is available students who depart other than check-out hours. It requires students to have made all the same preparations as a regular check out, but allows students to depart without setting up an inspection appointment with the Residence Life Office. Students still need to fill out the express check out request form.<br><br>\n";
		$msg .= "3. ROOM CHANGE<br><br>\n";
		$msg .= "1) Make an appointment for your check-out and check-in inspection at least 24 hours in advance of Room Switch Date, December 21.<br>\n";
		$msg .= "2) Have all your belongings packed and your room for Fall Term inspected by Noon of Room Switch Date.<br>\n";
		$msg .= "3) Sign for your room and other keys at the information desk in CJ International House<br>\n";
		$msg .= "4) Complete a check-in inspection for the new assignment with Residence Life staff during check-in.<br><br>\n";
		$msg .= "4. DEPOSIT REFUND<br><br>\n";
		$msg .= "The deposit will be refunded to the student upon online request when all financial obligations of the resident are paid and the contract is fulfilled. Residence hall charges, including damages will be deducted from the deposit. Any amount remaining from the deposit will be returned to the resident.<br><br>\n";
		$msg .= "Students who will not return to KU housing and want to get the deposit back must fill out the deposit request form via online.<br><br>\n";
		$msg .= "1) Go to \"Check My Housing Account\" page to request deposit refund<br>\n";
		$msg .= "You are required to input your current term's application number(" . $no[$i] . ") and name(" . $name . ").<br>\n";
		$msg .= "2) Click on Deposit Refund/Transfer button on the bottom of your application<br>\n";
		$msg .= "3) Fill in the check-out date.<br>\n";
		$msg .= "4) Indicate you are requesting \"Refund\".<br>\n";
		$msg .= "5) Choose the method of receiving the deposit; Refunds can be 1) wired to the student's bank account in KOREA, or 2) mailed in the form of money order (only after the recipient name in English for issuing a money order for the recipient, and his/her foreign mailing address is given).<br>\n";
		$msg .= "6) Fill in the form with necessary information accordingly.<br>\n";
		$msg .= "7) Submit the refund request<br>\n";
		$msg .= "8) If money order is chosen, you are advised to write your (home) mailing address in your home country¡¯s language on the envelope provided at the information desk in CJ International House for efficient delivery.  Any mailing address change requests should be directed to the Residence Life office via email before the deposit is refunded.<br><br>\n";
		$msg .= "If money order is chosen, any mailing address change requests should be directed to the Residence Life office via email before the deposit is refunded. The refund process will take between six to eight weeks after the request has been made.<br><br>\n";
		$msg .= "NOTE: After completing and signing the refund request form, a new residence hall application with the required deposit must be submitted to reapply for residence hall.<br><br>\n";
		$msg .= "NOTE: The residents for Winter 2007 are not able to request a refund as they already transferred the deposit to the new term.<br><br>\n";
		$msg .= "Korea University<br>\n";
		$msg .= "Anam Residence Life<br>\n";
		$msg .= "International Residence<br>\n";
		$msg .= "Fax: 82-2-926-3464<br>\n";
		$msg .= "email: <a href=\"mailto:reslife@korea.ac.kr\">reslife@korea.ac.kr</a><br>\n";
		$msg .= "<a href=\"http://reslife.korea.ac.kr\">http://reslife.korea.ac.kr</a>\n";

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