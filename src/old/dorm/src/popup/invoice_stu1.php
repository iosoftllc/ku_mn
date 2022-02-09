<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/application_tpl.php");
	include_once("../../lib/class.rFastTemplate.php");

	$pay_total = $application->getPaymentAmount($no);
	$application->getApplicationInfo($no);
	$name = $application->personLastName . ", " . $application->personFirstName . " " . $application->personMiddleName;

	$tpl = new rFastTemplate("../../tpl/popup");
	if ($application->applyKind == "L") {
		if ($pay_total > 0 && $application->linkPeriodCode == "2006LS") $tpl->define(array(main => "invoice2_stu.html"));
		else $tpl->define(array(main => "invoice1_stu.html"));
	} else {
		if ($pay_total > 0 && ($application->linkPeriodCode == "2006SA" || $application->linkPeriodCode == "2006SB")) $tpl->define(array(main => "invoice2_stu.html"));
		else $tpl->define(array(main => "invoice_stu.html"));
	}
	$tpl->define_dynamic(array(payment1_row => "main",
	                           payment2_row => "main"));

	$pay_total = 0;
	$application->getPaymentList($no);
	for ($i = 0; $i < count($application->payListNumber); $i++) {
		$pay_total += (int)$application->payListPrice[$i];
		$tpl->assign(array(PAYMENT1_DATE   => substr($application->payListDate[$i], 0, 10),
		                   PAYMENT1_PRICE  => number_format($application->payListPrice[$i]),
		                   PAYMENT1_DETAIL => $application->getDetailValue($application->payListDetail[$i])));
		$tpl->parse(PAYMENT1_ROWS, ".payment1_row");
		$tpl->assign(array(PAYMENT2_DATE   => substr($application->payListDate[$i], 0, 10),
		                   PAYMENT2_PRICE  => number_format($application->payListPrice[$i]),
		                   PAYMENT2_DETAIL => $application->getDetailValue($application->payListDetail[$i])));
		$tpl->parse(PAYMENT2_ROWS, ".payment2_row");
	}

	if ($application->applyKind == "L") {
		$pay_period = "2006.4.3.";
		if ($pay_total > 0 && $application->linkPeriodCode == "2006LS") $pay_period = "2006.4.18. - 2006.4.20.";
	} else {
		$pay_period = "2007.9.9";
		if ($pay_total > 0 && ($application->linkPeriodCode == "2006SA" || $application->linkPeriodCode == "2006SB")) $pay_period = "2006.4.18. - 2006.4.20.";
	}

	$tpl->assign(array(APPLY_NUMBER   => $no,
	                   APPLY_ACCOUNT  => $application->applyAccount,
	                   APPLY_STUDENT  => $application->personStudentID,
	                   APPLY_NAME     => stripslashes($name),
	                   APPLY_ROOM     => stripslashes($application->linkRoomCode),
	                   APPLY_TOTAL    => number_format($pay_total),
	                   PAYMENT_PERIOD => $pay_period));

	$application->closeDatabase();
	unset($application);

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>