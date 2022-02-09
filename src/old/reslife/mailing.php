<?
	include_once("lib/conf.common.php");
	include_once("lib/func.common.php");
	include_once("lib/class.cApplicant.php");
	include_once("lib/class.rFastTemplate.php");

	$no = array();
	//$no[] = "2006050002"; // À±Èñ·É
	//$no[] = "2005120227"; // ±è½ÂÈ¯
	$no[] = "2006050002";
	$no[] = "2006050013";
	$no[] = "2006050021";
	$no[] = "2006050032";
	$no[] = "2006050033";
	$no[] = "2006050034";
	$no[] = "2006050037";
	$no[] = "2006050041";
	$no[] = "2006050053";
	$no[] = "2006050054";
	$no[] = "2006050070";
	$no[] = "2006050072";
	$no[] = "2006050073";
	$no[] = "2006050074";
	$no[] = "2006050076";
	$no[] = "2006050120";
	$no[] = "2006050121";
	$no[] = "2006050143";
	$no[] = "2006050161";
	$no[] = "2006050167";
	$no[] = "2006050171";
	$no[] = "2006050183";
	$no[] = "2006050185";
	$no[] = "2006050186";
	$no[] = "2006050187";
	$no[] = "2006050188";
	$no[] = "2006050189";
	$no[] = "2006050191";
	$no[] = "2006050194";
	$no[] = "2006050195";
	$no[] = "2006050214";
	$no[] = "2006050223";
	$no[] = "2006050235";
	$no[] = "2006050236";
	$no[] = "2006050239";
	$no[] = "2006050241";
	$no[] = "2006050252";
	$no[] = "2006050253";
	$no[] = "2006050256";
	$no[] = "2006050269";
	$no[] = "2006050276";
	$no[] = "2006050311";
	$no[] = "2006050312";
	$no[] = "2006050314";
	$no[] = "2006050315";
	$no[] = "2006050316";
	$no[] = "2006050321";
	$no[] = "2006050328";
	$no[] = "2006050329";
	$no[] = "2006050330";
	$no[] = "2006050331";
	$no[] = "2006050332";
	$no[] = "2006050336";
	$no[] = "2006050341";
	$no[] = "2006050348";
	$no[] = "2006060006";
	$no[] = "2006060007";
	$no[] = "2006060014";
	$no[] = "2006070001";
	$no[] = "2006070002";
	$no[] = "2006070003";
	$no[] = "2006070004";
	$no[] = "2006070005";
	$no[] = "2006070006";
	$no[] = "2006070007";
	$no[] = "2006070009";
	$no[] = "2006070010";
	$no[] = "2006070012";
	$no[] = "2006070013";
	$no[] = "2006070015";
	$no[] = "2006070016";
	$no[] = "2006070017";
	$no[] = "2006070018";
	$no[] = "2006070019";
	$no[] = "2006070020";
	$no[] = "2006070021";
	$no[] = "2006070022";
	$no[] = "2006070023";
	$no[] = "2006070024";
	$no[] = "2006070025";
	$no[] = "2006070026";
	$no[] = "2006070027";
	$no[] = "2006070028";
	$no[] = "2006070030";
	$no[] = "2006070032";
	$no[] = "2006070033";
	$no[] = "2006070034";
	$no[] = "2006070035";
	$no[] = "2006070037";
	$no[] = "2006070038";
	$no[] = "2006070040";
	$no[] = "2006070041";
	$no[] = "2006070043";
	$no[] = "2006070044";
	$no[] = "2006070047";
	$no[] = "2006070048";
	$no[] = "2006070049";
	$no[] = "2006070051";
	$no[] = "2006070053";
	$no[] = "2006070054";
	$no[] = "2006070055";
	$no[] = "2006070056";
	$no[] = "2006070057";
	$no[] = "2006070060";
	$no[] = "2006070061";
	$no[] = "2006070065";
	$no[] = "2006070068";
	$no[] = "2006070069";
	$no[] = "2006070070";
	$no[] = "2006070071";
	$no[] = "2006070072";
	$no[] = "2006070073";
	$no[] = "2006070074";
	$no[] = "2006070083";
	$no[] = "2006070085";
	$no[] = "2006070086";
	$no[] = "2006070088";
	$no[] = "2006070089";
	$no[] = "2006070090";
	$no[] = "2006070095";
	$no[] = "2006070101";
	$no[] = "2006070104";
	$no[] = "2006070105";
	$no[] = "2006070106";
	$no[] = "2006070107";
	$no[] = "2006070109";
	$no[] = "2006070112";
	$no[] = "2006070113";
	$no[] = "2006070114";
	$no[] = "2006070115";
	$no[] = "2006070116";
	$no[] = "2006070117";
	$no[] = "2006070119";
	$no[] = "2006070120";
	$no[] = "2006070122";
	$no[] = "2006070123";
	$no[] = "2006070125";
	$no[] = "2006070126";
	$no[] = "2006070129";
	$no[] = "2006070130";
	$no[] = "2006070131";
	$no[] = "2006070137";
	$no[] = "2006070139";
	$no[] = "2006070140";
	$no[] = "2006070141";
	$no[] = "2006070142";
	$no[] = "2006070144";
	$no[] = "2006070149";
	$no[] = "2006070150";
	$no[] = "2006070159";
	$no[] = "2006080005";
	$no[] = "2006080006";
	$no[] = "2006080013";
	$no[] = "2006080014";
	$no[] = "2006080015";
	$no[] = "2006080016";
	$no[] = "2006080017";
	$no[] = "2006080018";
	$no[] = "2006080019";
	$no[] = "2006080020";
	$no[] = "2006080021";
	$no[] = "2006080022";
	$no[] = "2006080023";
	$no[] = "2006080025";
	$no[] = "2006080028";
	$no[] = "2006080030";
	$no[] = "2006080031";
	$no[] = "2006080033";
	$no[] = "2006080038";
	$no[] = "2006090001";
	$no[] = "2006090002";

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
		$subject = "[KU Residence Life] Residence Hall Fee Payment";

		$msg = "We hope your adjustment to a new home at Korea University goes smooth!<br>\n";
		$msg .= "This is a kind reminder that the deferred payment period for the fall 2006 semester is Wednesday, September 6 - Friday, September 8.<br>\n";
		$msg .= "Please refer to the following payment information.<br><br>\n";

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

		$msg .= "1. Your billing statement is available online. Go to your application status page and print your billing statement. You are required to input your application number and name to view your application status.<br><br>\n";
		$msg .= "2. Payment methods<br><br>\n";
		$msg .= "<b>In Person</b><br>\n";
		$msg .= "Find a Hana Bank branch that is closest to your work or home. Bring your billing statement to your branch of choice and pay by cash during the period from <font style='text-decoration:underline;'>September 6 to September 8, 2006</font>. Note: In person payment is available between 9:30 am and 4:30 pm on weekdays, except holidays.<br><br>\n";
		$msg .= "<b>Online</b><br>\n";
		$msg .= "Pay by Internet Banking - Electronic Funds Transfer only from a Korean bank account, during the period from <font style='text-decoration:underline;'>September 6 to September 8, 2006</font>. Note: Online payment is available between 9:30 am and 4:30 pm on weekdays, except holidays.<br><br>\n";
		$msg .= "Failure to pay the amount due by the dates specified in the Deferred Payment Agreement, shall result in an additional 30,000 KRW late fee and loss of the fee deferral privilege for future sessions.<br><br>\n";

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