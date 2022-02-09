<?
	include_once("../common/popup_header_tpl.php");
	include_once("../common/application_tpl.php");

	$page_title = "Residence Hall Fee Receipt";
	$sub_title = "Residence Hall Fee Receipt";
	$on_load = "";

	$tpl->define_dynamic(payment_row, "body");

	$application->getApplicationInfo($no);
	$name = $application->personLastName . ", " . $application->personFirstName . " " . $application->personMiddleName;
	$period = $application->linkPeriodCode;
	if ($period) $period = $application->linkPeriodName . ": " . getEnglishDate($application->linkPeriodSDate) . " - " . getEnglishDate($application->linkPeriodEDate);
	else $period = "";
	if (strtolower(substr($application->linkRoomCode, 0, 1)) == "a") $hall_type = "Anam 2 Hall";
	else if (strtolower(substr($application->linkRoomCode, 0, 1)) == "g") $hall_type = "Anam Global House";
	else $hall_type = "CJ International House";

	$pay_total = 0;
	$total = 0;
	$application->getHallReceipt($no);
	for ($i = 0; $i < count($application->payListNumber); $i++) {
		//$amount = abs((int)$application->payListPrice[$i]);
		//if ($application->payListDetail[$i] == "TR") $amount = "-" . $amount;
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
	                   APP_HALL      => $hall_type,
	                   APP_ROOM      => $application->linkRoomCode,
	                   PAYMENT_TOTAL => number_format(abs($pay_total)),
	                   PAYMENT_ALL   => number_format($total),
	                   RECEIPT_DATE  => getEnglishDate(date("Y-m-d"))));

	$application->closeDatabase();
	unset($application);

	include("../common/popup_footer_tpl.php");
?>