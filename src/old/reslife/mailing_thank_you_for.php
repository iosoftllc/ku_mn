<?
	include_once("lib/conf.common.php");
	include_once("lib/func.common.php");
	include_once("lib/class.cApplicant.php");
	include_once("lib/class.rFastTemplate.php");

	$no = array();
	//$no[] = "2006050002"; // À±Èñ·É
	$no[] = "2005120227"; // ±è½ÂÈ¯

	$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
	$applicant->connectDatabase();

	$count = 0;
	for ($i = 0; $i < count($no); $i++) {
		$applicant->getApplicantInfo($no[$i]);
		$name = $applicant->personLastName . ", " . $applicant->personFirstName . " " . $applicant->personMiddleName;
		$price = $applicant->getApplicantPrice($applicant->linkRateCode, $applicant->linkPeriodCode);
		$period = $applicant->linkPeriodName . " (" . getEnglishDate($applicant->linkPeriodSDate) . " - " . getEnglishDate($applicant->linkPeriodEDate) . ")";
		$from = "reslife@korea.ac.kr";
		$to = $applicant->personEmail;
		$to = "ksh@intia.co.kr";
		//$to = "heeryun@korea.ac.kr";
		$subject = "[KU Residence Life] Room Assigment & Payment Information";

		$msg = "Thank you for your on-line residence hall application. Please refer to the following room assignment and payment information.<br><br>\n";
		$msg .= "Application number: " . $applicant->applyNumber . "<br>\n";
		$msg .= "Name: " . $name . "<br>\n";
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
		$msg .= "<b>NOTE: Total due may change to reflect damage deductions, if any, for cuurent residents.</b><br><br>\n";

		$msg .= "1. Your billing statement is available online. Go to your application status page and print your billing statement. ";
		$msg .= "You are required to input your application number and name to view your application status.<br><br>\n";
		$msg .= "2.  Payment methods<br><br>\n";
		$msg .= "<b>In Person</b><br><br>\n";
		$msg .= "Find a Hana Bank branch that is closest to your work or home. Bring your billing statement to your branch of choice and pay by cash ";
		$msg .= "during the period from <font style='text-decoration:underline;'>August 7 to August 9, 2006</font>. ";
		$msg .= "Note: In person payment is available between 9:30 am and 4:30 pm on weekdays, except holidays.<br><br>\n";
		$msg .= "<b>Online</b><br><br>\n";
		$msg .= "Pay by Internet Banking - Electronic Funds Transfer only from a Korean bank account, ";
		$msg .= "during the period from <font style='text-decoration:underline;'>August 7 to August 9, 2006</font>. ";
		$msg .= "Note: Online payment is available between 9:30 am and 4:30 pm on weekdays, except holidays.<br><br>\n";
		$msg .= "Late fee will apply after the due date. Failure to make the payment by due date may result in forfeiture of your deposit and immediate ";
		$msg .= "termination of your residence hall contract.<br><br>\n";
		$msg .= "<b>For International Students only:</b><br><br>\n";
		$msg .= "If you are an international student of Korea University exchange programs, then you may defer your residence hall fee. ";
		$msg .= "The residence hall fee can be paid between <font style='text-decoration:underline;'>September 6 and September 8, 2006</font>. ";
		$msg .= "Students participating in the deferred payment plan must download the payment deferral application/agreement and mail it to Residence Life";
		$msg .= "(Anam Residence Life - International Residence, Korea University, Anam-dong Seongbuk-gu, Seoul 136-701) ";
		$msg .= "<font style='text-decoration:underline;'>by August 9, 2006</font>.<br><br>\n";
		$msg .= "Failure to pay the amount due by the dates specified in the Deferred Payment Agreement, shall result in an additional 30,000 KRW late fee ";
		$msg .= "and loss of the fee deferral privilege for future sessions.<br><br>\n";
		$msg .= "If you decide to cancel during any stage of this process you must notify the Office of Residence Life as soon as possible to reduce the ";
		$msg .= "risk of penalty. Please see the contract for more information.<br><br>\n";
		$msg .= "Please print this page for your record.<br>\n";
		$msg .= "Your Application Number is <font style='text-decoration:underline;'>" . $applicant->applyNumber . "</font>.<br>\n";
		$msg .= "If you have any further questions, please contact Residence Life at <a href=\"mailto:reslife@korea.ac.kr\">reslife@korea.ac.kr</a>.<br><br>\n";
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