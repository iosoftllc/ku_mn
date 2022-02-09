<?
	include_once("lib/conf.common.php");
	include_once("lib/func.common.php");
	include_once("lib/class.cApplicant.php");
	include_once("lib/class.rFastTemplate.php");

	$no = array();
	$no[] = "2006050315";
	$no[] = "2006050236";
	$no[] = "2006050347";
	$no[] = "2006050122";
	$no[] = "2006050042";
	$no[] = "2006050020";
	$no[] = "2006060007";
	$no[] = "2006050070";
	$no[] = "2006050331";
	$no[] = "2006050304";
	$no[] = "2006050225";
	$no[] = "2006060011";
	$no[] = "2006050330";
	$no[] = "2006050100";
	$no[] = "2006050342";
	$no[] = "2006050101";
	$no[] = "2006050111";
	$no[] = "2006050243";
	$no[] = "2006050169";
	$no[] = "2006050185";
	$no[] = "2006050276";
	$no[] = "2006050214";
	$no[] = "2006050073";
	$no[] = "2006050219";
	$no[] = "2006050194";
	$no[] = "2006050034";
	$no[] = "2006050321";
	$no[] = "2006050227";
	$no[] = "2006050344";
	$no[] = "2006050072";
	$no[] = "2006050171";
	$no[] = "2006050258";
	$no[] = "2006050222";
	$no[] = "2006050252";
	$no[] = "2006050166";

	$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
	$applicant->connectDatabase();

	$count = 0;
	for ($i = 0; $i < count($no); $i++) {
		$applicant->getApplicantInfo($no[$i]);
		$name = $applicant->personFirstName . " " . $applicant->personMiddleName . " " . $applicant->personLastName;
		$price = $applicant->getApplicantPrice($applicant->linkRateCode, $applicant->linkPeriodCode);
		$period = $applicant->linkPeriodName . " (" . getEnglishDate($applicant->linkPeriodSDate) . " - " . getEnglishDate($applicant->linkPeriodEDate) . ")";
		$from = "reslife@korea.ac.kr";
		$to = $applicant->personEmail;
		//$to = "ksh@intia.co.kr";
		//$to = "heeryun@korea.ac.kr";
		$subject = "ATTN: KU Residence Hall Application Deposit";
		$msg = "Dear " . $applicant->personLastName . ", " . $applicant->personFirstName . " " . $applicant->personMiddleName . ",<br><br>\n";
		$msg .= "Your residence hall application for Fall 2006 is registered. However, your deposit of 200,000 KRW which is needed for a room assignment ";
		$msg .= "has not been paid as of June 23.<br><br>\n";
		$msg .= "Therefore, your room assignment has not been processed.<br><br>\n";
		$msg .= "If you already made the deposit payment, you should fax the application with the deposit payment confirmation stub at 82-2-926-3464 ";
		$msg .= "so that residence life office can identify your payment. For payment instruction, please consult the application procedure in our website ";
		$msg .= "at <a href=\"http://reslife.korea.ac.kr\">reslife.korea.ac.kr</a>.<br><br>\n";
		$msg .= "For international students: Please note that the residence hall fee payment deferral application is only for deferring residence hall fee ";
		$msg .= "payment. THE DEPOSIT PAYMENT is required for EVERY APPLICANT, even though you may apply to defer your residence hall fee payment.<br><br>\n";
		$msg .= "You can check your application status at \"check your application status\" page with inputting your application number and name.<br><br>\n";
		$msg .= "Your application Number is " . $applicant->applyNumber . ".<br><br>\n";
		$msg .= "Thank you.<br><br>\n";
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