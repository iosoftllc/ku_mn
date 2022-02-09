<?
	include_once("lib/conf.common.php");
	include_once("lib/func.common.php");
	include_once("lib/class.cApplicant.php");
	include_once("lib/class.rFastTemplate.php");

	$student = array();
	$student[] = "2006950066";
	$student[] = "2005950225";
	$student[] = "2006950010";
	$student[] = "2004150389";
	$student[] = "2006950062";
	$student[] = "2006950069";
	$student[] = "2006950068";
	$student[] = "2006950067";
	$student[] = "2006950051";
	$student[] = "2006950022";
	$student[] = "2006950076";
	$student[] = "2005950118";
	$student[] = "2005950127";
	$student[] = "2006950074";
	$student[] = "2006950070";
	$student[] = "2005950191";
	$student[] = "2006950075";
	$student[] = "2006950072";
	$student[] = "2006950002";
	$student[] = "2005950234";
	$student[] = "2005950136";
	$student[] = "2006950031";
	$student[] = "2006950016";
	$student[] = "2006950055";
	$student[] = "2006950030";
	$student[] = "2005950227";
	$student[] = "2005475036";
	$student[] = "2005950214";
	$student[] = "2006950064";
	$student[] = "2006950095";
	$student[] = "2006950097";
	$student[] = "2006950013";
	$student[] = "2006950096";
	$student[] = "2006950063";
	$student[] = "2005950095";
	$student[] = "2005950210";
	$student[] = "2006950071";
	$student[] = "2006950017";
	$student[] = "2006950035";
	$student[] = "2005950098";
	$student[] = "2006950038";
	$student[] = "2006950037";
	$student[] = "2005230033";
	$student[] = "2005950189";
	$student[] = "2006950003";
	$student[] = "2005950157";
	$student[] = "2005950145";
	$student[] = "2006950045";
	$student[] = "2006950011";
	$student[] = "2005950187";
	$student[] = "2006950061";
	$student[] = "2005950150";
	$student[] = "2005950090";
	$student[] = "2006950005";
	$student[] = "2005950185";
	$student[] = "2005950089";
	$student[] = "2005950100";
	$student[] = "2005950228";
	$student[] = "2006950065";
	$student[] = "2006950012";
	$student[] = "2005950186";
	$student[] = "2006950007";
	$student[] = "2006472003";
	$student[] = "2005950101";
	$student[] = "2005950102";
	$student[] = "2001170286";

	$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
	$applicant->connectDatabase();

	$count = 0;
	for ($i = 0; $i < count($student); $i++) {
		$applicant->getApplicantInfo1($student[$i]);
		$name = $applicant->personFirstName . " " . $applicant->personMiddleName . " " . $applicant->personLastName;
		$price = $applicant->getApplicantPrice($applicant->linkRateCode, $applicant->linkPeriodCode);
		$period = $applicant->linkPeriodName . " (" . getEnglishDate($applicant->linkPeriodSDate) . " - " . getEnglishDate($applicant->linkPeriodEDate) . ")";
		$from = "reslife@korea.ac.kr";
		$to = $applicant->personEmail;
		//$to = "ksh@intia.co.kr";
		$subject = "[KU Residence Life] residence hall fee payment";
		$msg = "This is a reminder that the deferred payment period for KU residence halls is Wednesday, March 8 to Friday, March 10 per the payment deferral agreement.<br><br>\n";
		$msg .= "Late fee will apply after the due date. Failure to make the payment by due date may result in forfeiture of your deposit and immediate termination of your residence hall contract.<br><br>\n";
		$msg .= "Please refer to the following payment information.<br><br>\n";
		$msg .= "Application number: " . $applicant->applyNumber . "<br>\n";
		$msg .= "Name: " . $applicant->personFirstName . " " . $applicant->personMiddleName . " " . $applicant->personLastName . "<br>\n";
		$msg .= "Your room number: " . $applicant->linkRoomCode . "<br>\n";
		$msg .= "Session Applied: " . $period . "<br><br>\n";
		$pay_total = 0;
		$applicant->getPaymentList($applicant->applyNumber);
		if (count($applicant->payListNumber)) {
			$msg .= "::: Payment History :::<br>\n";
			$msg .= "<table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#4B4D4C'>\n";
			$msg .= "<tr bgcolor='#FFFFFF'><td align='center'>Date</td><td align='center'>Detail</td><td align='center'>Amount</td></tr>\n";
		}
		for ($j = 0; $j < count($applicant->payListNumber); $j++) {
			$pay_total += (int)$applicant->payListPrice[$j];
			$msg .= "<tr bgcolor='#FFFFFF'>\n";
			$msg .= "<td align='center'>" . getEnglishDate(substr($applicant->payListDate[$j], 0, 10)) . "</td>\n";
			$msg .= "<td align='center'>" . $applicant->getDetailValue($applicant->payListDetail[$j]) . "</td>\n";
			$msg .= "<td align='right'>" . number_format($applicant->payListPrice[$j]) . " KRW</td>\n";
			$msg .= "</tr>\n";
		}
		if (count($applicant->payListNumber)) {
			$msg .= "<tr bgcolor='#FFFFFF'><td colspan='2' align='center'><b>Total Amount Due / (Overpaid)</b></td><td align='right'><b>" . number_format($pay_total) . " KRW</b></td></tr>\n";
			$msg .= "</table>\n<br>";
		}
		$msg .= "1. Your billing statement is available online. Go to your application status page and print your billing statement. You are required to input your application number and name to view your application status.<br><br>\n";
		$msg .= "2. Payment methods<br><br>\n";
		$msg .= "<b>In Person</b><br>\n";
		$msg .= "Find a Hana Bank branch that is closest to your work or home. Bring your billing statement to your branch of choice and pay by cash during the period from March 8 to March 10, 2006.<br>\n";
		$msg .= "Note: In person payment is available between 9:30 am and 4:30 pm on weekdays, except holidays.<br><br>\n";
		$msg .= "<b>Online</b><br>\n";
		$msg .= "Pay by Internet Banking - Electronic Funds Transfer only from a Korean bank account, during the period from March 8 to March 10, 2006.<br>\n";
		$msg .= "Note: Online payment is available between 9:30 am and 4:30 pm on weekdays, except holidays.<br><br>\n";
		$msg .= "<b>Failure to make the payment by due date may result in forfeiture of your deposit and immediate termination of your residence hall contract.</b><br><br>\n";
		$msg .= "If you decide to cancel during any stage of this process you must notify the Office of Residence Life as soon as possible to reduce the risk of penalty. Please see the contract for more information.<br><br>\n";
		$msg .= "Please print this page for your record.<br>\n";
		$msg .= "Your Application Number is  " . $applicant->applyNumber . ".<br>\n";
		$msg .= "If you have any further questions, please contact Residence Life at reslife@korea.ac.kr.<br>\n";
		$msg .= "Thank you.\n";

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

		if ($flag) echo $student[$i] . " : success<br>";
		else echo $student[$i] . " : fail<br>";
		$count++;
	}

	echo $count;

	$applicant->closeDatabase();
	unset($applicant);
?>