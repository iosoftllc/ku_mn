<?
	include_once("lib/conf.common.php");
	include_once("lib/func.common.php");
	include_once("lib/class.cApplicant.php");
	include_once("lib/class.rFastTemplate.php");

	$no = array();
	//$no[] = "2006050002"; // À±Èñ·É
	//$no[] = "2005120227"; // ±è½ÂÈ¯
	$no[] = "2006110002";
	$no[] = "2006110022";
	$no[] = "2006100003";
	$no[] = "2006110043";
	$no[] = "2006110040";
	$no[] = "2006110062";
	$no[] = "2006110061";
	$no[] = "2006110056";
	$no[] = "2006110019";
	$no[] = "2006110028";
	$no[] = "2006110046";
	$no[] = "2006110037";
	$no[] = "2006110017";
	$no[] = "2006110035";
	$no[] = "2006110060";
	$no[] = "2006110057";
	$no[] = "2006110016";
	$no[] = "2006110054";
	$no[] = "2006110024";
	$no[] = "2006110055";
	$no[] = "2006100001";
	$no[] = "2006110014";
	$no[] = "2006100002";
	$no[] = "2006110004";
	$no[] = "2006110009";
	$no[] = "2006110013";
	$no[] = "2006110032";
	$no[] = "2006110027";
	$no[] = "2006110008";
	$no[] = "2006110020";
	$no[] = "2006110018";
	$no[] = "2006110021";
	$no[] = "2006110012";
	$no[] = "2006110041";
	$no[] = "2006110029";
	$no[] = "2006110042";
	$no[] = "2006110034";
	$no[] = "2006110051";
	$no[] = "2006110053";
	$no[] = "2006110048";
	$no[] = "2006110030";
	$no[] = "2006110044";
	$no[] = "2006110049";
	$no[] = "2006110036";
	$no[] = "2006110047";

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
		//$to = "ksh@intia.co.kr";
		//$to = "heeryun@korea.ac.kr";
		$subject = "[KU Residence Life] Room Assignment & Payment Information";

		$msg = "Thank you for your on-line residence hall application. Please refer to the following room assignment and payment Information<br><br>\n";

		$msg .= "Application number: " . $applicant->applyNumber . "<br>\n";
		$msg .= "Name: " . $name . "<br>\n";
		$msg .= "Your room number: " . $applicant->linkRoomCode . "<br>\n";
		$msg .= "Session Applied: " . $period . "<br><br>\n";

		$pay_total = 0;
		$applicant->getPaymentList($applicant->applyNumber);
		if (count($applicant->payListNumber)) {
			$msg .= "::: Payment History :::<br>\n";
			$msg .= "<table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#4B4D4C'>\n";
			$msg .= "<tr bgcolor='#FFFFFF'><td align='center'>Date</td><td align='center'>Description</td><td align='center'>Amount</td></tr>\n";
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
			$msg .= "<tr bgcolor='#FFFFFF'><td colspan='2' align='center'><b>Total Amount Due / (Overpaid, if negative)</b></td><td align='right'><b>" . number_format($pay_total) . " KRW</b></td></tr>\n";
			$msg .= "</table>\n<br>";
		}

		$msg .= "NOTE: Total due may change to reflect damage deductions, if any, for current residents.<br><br>\n";

		$msg .= "1. Your billing statement is available online. Go to \"Check My Housing Account\" page and print your billing statement. You are required to input your application number and name to view your application status.<br><br>\n";
		$msg .= "2. Payment methods<br><br>\n";
		$msg .= "<b>In Person</b><br>\n";
		$msg .= "Find a Hana Bank branch that is closest to your work or home. Bring your billing statement to your branch of choice and pay by cash during the period from <font style='text-decoration:underline;'>December 5 to December 7, 2006</font>. Note: In person payment is available between 9:30 am and 4:30 pm on weekdays, except holidays.<br><br>\n";
		$msg .= "<b>Online</b><br>\n";
		$msg .= "Pay by Internet Banking - Electronic Funds Transfer only from a Korean bank account, during the period from <font style='text-decoration:underline;'>December 5 to December 7, 2006</font>. Note: Online payment is available between 9:30 am and 4:30 pm on weekdays, except holidays.<br><br>\n";

		$msg .= "Late fee will apply after the due date. Failure to make the payment by due date may result in forfeiture of your deposit and immediate termination of your residence hall contract.<br><br>\n";

		$msg .= "If you decide to cancel during any stage of this process, you must notify the Office of Residence Life as soon as possible to reduce the risk of penalty. Please see the contract for more information.<br><br>\n";

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