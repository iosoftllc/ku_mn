<?
	include_once("../../lib/conf.common.php");
	include_once("../common/faculty_tpl.php");
	include_once("../../lib/class.rFastTemplate.php");

	$tpl = new rFastTemplate("../../tpl/popup");
	$tpl->define(array(main => "invoice_f.html"));
	$tpl->define_dynamic(array(payment_row => "main",
	                           method_row  => "main"));

	$faculty->getFacultyInfo($no);

	$checkin = $faculty->facultyArrival;
	$checkout = $faculty->facultyDeparture;
	$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($checkin, 5, 2) + 1, substr($checkin, 8, 2), substr($checkin, 0, 4)));
	if ($checkout < $temp_dt) {
		$dt = "";
	} else {
		$tpl->parse(METHOD_ROWS, ".method_row");
		$dt = date("Y-m");
		if (substr($dt, 0, 7) != substr($checkin, 0, 7)) $checkin = $dt . "-01";
		if (substr($dt, 0, 7) != substr($checkout, 0, 7)) $checkout = $dt . "-" . date("t", mktime(0, 0, 0, substr($dt, 5, 2), 1, substr($dt, 0, 4)));
	}

	$room_info = "";
	$faculty->getRoomValue($no);
	for ($i = 0; $i < count($faculty->roomCode); $i++) {
		$room_info .= $faculty->roomCode[$i] . ",";
	}
	if ($room_info) $room_info = substr($room_info, 0, -1);

	$name = "";
	if ($faculty->facultyTitle) $name .= $faculty->facultyTitle . ". ";
	$name .= $faculty->facultyLName;
	if (trim($faculty->facultyFName)) $name .= ", " . $faculty->facultyFName . " " . $faculty->facultyMName;

	$invoice_total = 0;
	$faculty->getPaymentList($no, $dt);
	for ($i = 0; $i < count($faculty->payListNumber); $i++) {
		//if ((int)$faculty->payListPrice[$i] > 0) {
			$invoice_total += (int)$faculty->payListPrice[$i];
			$tpl->assign(array(PAYMENT_DATE   => substr($faculty->payListDate[$i], 0, 10),
			                   PAYMENT_DETAIL => $faculty->getDetailValue($faculty->payListDetail[$i]),
			                   PAYMENT_AMOUNT => number_format($faculty->payListPrice[$i])));
			$tpl->parse(PAYMENT_ROWS, ".payment_row");
		//}
	}

	$assign_dt = $faculty->getRoomDate($no);
	if (substr($assign_dt, 0, 10) == "0000-00-00") $assign_dt = "2006-11-28";

	if ($dt == "") $invoice_no = $no;
	else $invoice_no = $no . "-" . substr($dt, 0, 4) . substr($dt, 5, 2);

	$tpl->assign(array(INVOICE_NUMBER   => $invoice_no,
	                   INVOICE_DATE     => substr($assign_dt, 0, 10),
	                   INVOICE_TO       => stripslashes($name),
	                   INVOICE_TOTAL    => number_format($invoice_total),
	                   INVOICE_PROPERTY => $faculty->getDormitoryCode($faculty->facultyDormitory),
	                   INVOICE_UNIT     => $room_info,
	                   INVOICE_CHECKIN  => $checkin,
	                   INVOICE_CHECKOUT => $checkout));

	$faculty->closeDatabase();
	unset($faculty);

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>