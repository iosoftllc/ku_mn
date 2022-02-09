<?
	include_once("../common/popup_header_tpl.php");
	include_once("../common/grad_application_tpl.php");

	$page_title = "Deposit Receipt";
	$sub_title = "Deposit Receipt";
	$on_load = "";

	$tpl->define_dynamic(payment_row, "body");

	$application->getApplicationInfo($no);
	$name = $application->personLastName . ", " . $application->personFirstName . " " . $application->personMiddleName;
	$period = $application->linkPeriodCode;
	if ($period) $period = $application->linkPeriodName . ": " . getEnglishDate($application->linkPeriodSDate) . " - " . getEnglishDate($application->linkPeriodEDate);
	else $period = "";

	$pay_total = 0;
	$total = 0;
	$application->getDepositReceipt($no);
	for ($i = 0; $i < count($application->payListNumber); $i++) {
		//$amount = abs((int)$application->payListPrice[$i]);
		//if ($application->payListDetail[$i] == "OR" || $application->payListDetail[$i] == "OC" || $application->payListDetail[$i] == "DC" || $application->payListDetail[$i] == "DR" || $application->payListDetail[$i] == "DD" || $application->payListDetail[$i] == "CF" || $application->payListDetail[$i] == "CO") $amount = "-" . $amount;
		//$pay_total += $amount;
		$amount = (int)$application->payListPrice[$i];
		if ($amount < 0) $pay_total += $amount;
		$total += $amount;
		$tpl->assign(array(PAYMENT_DATE   => substr($application->payListDate[$i], 0, 10),
		                   PAYMENT_DETAIL => $application->getDetailValue($application->payListDetail[$i]),
		                   PAYMENT_AMOUNT => number_format($amount)));
		$tpl->parse(PAYMENT_ROWS, ".payment_row");
	}

	$tpl->assign(array(APP_NUMBER    => $no,
	                   APP_STUDENT   => $application->personStudentID,
	                   APP_NAME      => stripslashes($name),
	                   APP_PERIOD    => stripslashes($period),
	                   PAYMENT_TOTAL => number_format(abs($pay_total)),
	                   PAYMENT_ALL   => number_format($total),
	                   RECEIPT_DATE  => getEnglishDate(date("Y-m-d"))));

	$application->closeDatabase();
	unset($application);

	include("../common/popup_footer_tpl.php");
?>