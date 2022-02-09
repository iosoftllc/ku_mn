<?
	///////////////////////////////////////////////////////////////////////////////////////
	// 수정 시 admin/src/faculty/room_action.php 에서 mode="receipt" 메일 발송 부분도 수정하기 //
	///////////////////////////////////////////////////////////////////////////////////////

	include_once("../common/popup_header_tpl.php");
	include_once("../common/faculty_tpl.php");

	$dt = trim($_GET["dt"]);
	$receipt_no = $_GET["receipt_no"];
	if (trim($dt) == "") $dt = trim($_POST["dt"]);
	if (!$receipt_no) $receipt_no = $_POST["receipt_no"];

	$page_title = "Receipt";
	$sub_title = "Receipt";
	$on_load = "";
	$email_src = "../../src/faculty/room_action.php?mode=receipt&no=$no&dt=$dt&receipt_no=$receipt_no";

	$tpl->define_dynamic(array(payment_row => "body",
	                           method_row  => "body"));

	$faculty->getFacultyInfo($no);
	$sel_room = $faculty->getRoomValue($no);

	$arrival = $faculty->facultyArrival;
	$departure = $faculty->facultyDeparture;
	$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($arrival, 5, 2) + 1, substr($arrival, 8, 2), substr($arrival, 0, 4)));
	if ($departure >= $temp_dt) $tpl->parse(METHOD_ROWS, ".method_row");

	$name = "";
	if ($faculty->facultyTitle) $name .= $faculty->facultyTitle . ". ";
	$name .= $faculty->facultyLName;
	if (trim($faculty->facultyFName)) $name .= ", " . $faculty->facultyFName . " " . $faculty->facultyMName;

	$receipt_total;
	$faculty->getPaymentList1($no, $receipt_no);
	for ($i = 0; $i < count($faculty->payListNumber); $i++) {
		if ((int)$faculty->payListPrice[$i] < 0) {
			$receipt_total += abs($faculty->payListPrice[$i]);
			$tpl->assign(array(PAYMENT_DATE   => substr($faculty->payListDate[$i], 0, 10),
			                   PAYMENT_DETAIL => $faculty->getDetailValue($faculty->payListDetail[$i]),
			                   PAYMENT_AMOUNT => number_format(abs($faculty->payListPrice[$i]))));
			$tpl->parse(PAYMENT_ROWS, ".payment_row");
		}
	}

	$assign_dt = $faculty->getRoomDate($no);
	if (substr($assign_dt, 0, 10) == "0000-00-00") $assign_dt = "2006-11-28";

	$checkin = $faculty->facultyArrival;
	$checkout = $faculty->facultyDeparture;
	if ($dt) {
		$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($checkin, 5, 2) + 1, substr($checkin, 8, 2), substr($checkin, 0, 4)));
		if ($checkout < $temp_dt) {
		} else {
			if (substr($dt, 0, 7) != substr($checkin, 0, 7)) $checkin = $dt . "-01";
			if (substr($dt, 0, 7) != substr($checkout, 0, 7)) $checkout = $dt . "-" . date("t", mktime(0, 0, 0, substr($dt, 5, 2), 1, substr($dt, 0, 4)));
		}
	}

	$tpl->assign(array(INVOICE_NUMBER   => $no,
	                   INVOICE_DATE     => date("Y-m-d"),//substr($assign_dt, 0, 10),
	                   INVOICE_TO       => stripslashes($name),
	                   INVOICE_TOTAL    => number_format($receipt_total),
	                   INVOICE_PROPERTY => $faculty->getDormitoryCode($faculty->facultyDormitory),
	                   INVOICE_UNIT     => $sel_room,
	                   INVOICE_CHECKIN  => $checkin,
	                   INVOICE_CHECKOUT => $checkout));

	include("../common/variables_tpl.php");

	$faculty->closeDatabase();
	unset($faculty);

	include("../common/popup_footer_tpl.php");
?>