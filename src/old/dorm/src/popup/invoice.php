<?
	include_once("../../lib/conf.common.php");
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.rFastTemplate.php");
	include_once("../../lib/class.cApplicant.php");

	$no = $_POST["no"];
	if ($no == "") $no = $_GET["no"];

	$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
	$applicant->connectDatabase();

	$pay_total = $applicant->getPaymentAmount($no);
	$applicant->getApplicantInfo($no);
	$name = $applicant->personLastName . ", " . $applicant->personFirstName . " " . $applicant->personMiddleName;

	$tpl = new rFastTemplate("../../tpl/popup");
	if ($applicant->applyKind == "L") {
		if ($pay_total > 0 && $applicant->linkPeriodCode == "2006LS") $tpl->define(array(main => "invoice2.html"));
		else $tpl->define(array(main => "invoice1.html"));
	} else {
		if ($pay_total > 0 && ($applicant->linkPeriodCode == "2006SA" || $applicant->linkPeriodCode == "2006SB")) $tpl->define(array(main => "invoice2.html"));
		else $tpl->define(array(main => "invoice.html"));
	}
	$tpl->define_dynamic(array(payment1_row => "main",
	                           payment2_row => "main"));

	$pay_total = 0;
	$applicant->getPaymentList($no);
	for ($i = 0; $i < count($applicant->payListNumber); $i++) {
		$pay_total += (int)$applicant->payListPrice[$i];
		$tpl->assign(array(PAYMENT1_DATE   => substr($applicant->payListDate[$i], 0, 10),
		                   PAYMENT1_PRICE  => number_format($applicant->payListPrice[$i]),
		                   PAYMENT1_DETAIL => $applicant->getDetailValue($applicant->payListDetail[$i])));
		$tpl->parse(PAYMENT1_ROWS, ".payment1_row");
		$tpl->assign(array(PAYMENT2_DATE   => substr($applicant->payListDate[$i], 0, 10),
		                   PAYMENT2_PRICE  => number_format($applicant->payListPrice[$i]),
		                   PAYMENT2_DETAIL => $applicant->getDetailValue($applicant->payListDetail[$i])));
		$tpl->parse(PAYMENT2_ROWS, ".payment2_row");
	}

	if ($applicant->applyKind == "L") {
		$pay_period = "2006.4.3.";
		if ($pay_total > 0 && $applicant->linkPeriodCode == "2006LS") $pay_period = "2006.4.18. - 2006.4.20.";
	} else {
		$pay_period = "2006.12.5. - 2006.12.7.";
		if ($pay_total > 0 && ($applicant->linkPeriodCode == "2006SA" || $applicant->linkPeriodCode == "2006SB")) $pay_period = "2006.4.18. - 2006.4.20.";
	}

	$tpl->assign(array(APPLY_NUMBER   => $no,
	                   APPLY_ACCOUNT  => $applicant->applyAccount,
	                   APPLY_STUDENT  => $applicant->personStudentID,
	                   APPLY_NAME     => stripslashes($name),
	                   APPLY_ROOM     => stripslashes($applicant->linkRoomCode),
	                   APPLY_TOTAL    => number_format($pay_total),
	                   PAYMENT_PERIOD => $pay_period));

	$applicant->closeDatabase();
	unset($applicant);

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>