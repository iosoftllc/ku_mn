<?
	///////////////////////////////////////////////////////////////////////////////////////
	// 수정 시 admin/src/faculty/room_action.php 에서 mode="invoice" 메일 발송 부분도 수정하기 //
	///////////////////////////////////////////////////////////////////////////////////////

	include_once("../common/popup_header_tpl.php");
	include_once("../common/faculty_tpl.php");
	// 전송 데이터 받기
	$dt = trim($_GET["dt"]);
	$invoice_no = $_GET["invoice_no"];
	if (trim($dt) == "") $dt = trim($_POST["dt"]);
	if (!$invoice_no) $invoice_no = $_POST["invoice_no"];
	// 페이지 설정
	$page_title = "Invoice";
	$sub_title = "Invoice";
	$on_load = "";
	$email_src = "../../src/faculty/room_action.php?mode=invoice&no=$no&dt=$dt&invoice_no=$invoice_no";
	$tpl->define_dynamic(array(payment_row => "body",
	                           method_row  => "body"));

	$faculty->getFacultyInfo($no);
	$sel_room = $faculty->getRoomValue($no);

	$name = "";
	if ($faculty->facultyTitle) $name .= $faculty->facultyTitle . ". ";
	$name .= $faculty->facultyLName;
	if (trim($faculty->facultyFName)) $name .= ", " . $faculty->facultyFName . " " . $faculty->facultyMName;
	// 입금 내역 리스트
	$deposit_flag = false;
	//$faculty->getPaymentList($no, $dt);
	$faculty->getPaymentList1($no, $invoice_no);
	$invoice_total = 0;
	$invoice_count = count($faculty->payListNumber);
	for ($i = 0; $i < $invoice_count; $i++) {
		if ($invoice_count == 1 && $faculty->payListDetail[$i] == "DB") $deposit_flag = true;
		//if ((int)$faculty->payListPrice[$i] > 0) {
			$invoice_total += (int)$faculty->payListPrice[$i];
			$tpl->assign(array(PAYMENT_DATE   => substr($faculty->payListDate[$i], 0, 10),
			                   PAYMENT_DETAIL => $faculty->getDetailValue($faculty->payListDetail[$i]),
			                   PAYMENT_AMOUNT => number_format($faculty->payListPrice[$i])));
			$tpl->parse(PAYMENT_ROWS, ".payment_row");
		//}
	}
	// 기간 설정
	if (trim($dt) != "") {
		$checkin = $dt . "-01";
		$checkout = $dt . "-" . date("t", mktime(0, 0, 0, substr($dt, 5, 2), 1, substr($dt, 0, 4)));
	} else {
		$checkin = $faculty->facultyArrival;
		$checkout = $faculty->facultyDeparture;
	}
/*
	$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($faculty->facultyArrival, 5, 2) + 1, substr($faculty->facultyArrival, 8, 2), substr($faculty->facultyArrival, 0, 4)));
	if ($deposit_flag || $faculty->facultyDeparture < $temp_dt) {
		$checkin = $faculty->facultyArrival;
		$checkout = $faculty->facultyDeparture;
	} else {
		$checkin = substr($faculty->payListDate[0], 0, 10);
		if ($faculty->facultyArrival > $checkin) $checkin = substr($faculty->facultyArrival, 0, 10);
		$checkout = substr($faculty->payListDate[$invoice_count - 1], 0, 10);
		$temp_dt = substr($checkout, 0, 7);
		if (substr($faculty->facultyDeparture, 0, 7) == $temp_dt) $checkout = substr($faculty->facultyDeparture, 0, 10);
		else if (substr($faculty->facultyDeparture, 0, 7) != $temp_dt) $checkout = $temp_dt . "-" . date("t", mktime(0, 0, 0, substr($checkout, 5, 2), 1, substr($checkout, 0, 4)));
	}

	$assign_dt = $faculty->getRoomDate($no);
	if ($assign_dt == "" || substr($assign_dt, 0, 10) == "0000-00-00") $assign_dt = date("Y-m-d");
*/
/*
	$checkin = $faculty->facultyArrival;
	$checkout = $faculty->facultyDeparture;
	$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($checkin, 5, 2) + 1, substr($checkin, 8, 2), substr($checkin, 0, 4)));
	if ($checkout < $temp_dt) {
	} else {
		$tpl->parse(METHOD_ROWS, ".method_row");
		if (substr($dt, 0, 7) != substr($checkin, 0, 7)) $checkin = $dt . "-01";
		if (substr($dt, 0, 7) != substr($checkout, 0, 7)) $checkout = $dt . "-" . date("t", mktime(0, 0, 0, substr($dt, 5, 2), 1, substr($dt, 0, 4)));
	}
*/

	if ($dt == "") $inv_no = $no;
	else $inv_no = $no . "-" . substr($dt, 0, 4) . substr($dt, 5, 2);

	$tpl->assign(array(INVOICE_NUMBER   => $inv_no,
	                   INVOICE_DATE     => date("Y-m-d"),//substr($assign_dt, 0, 10),
	                   INVOICE_TO       => stripslashes($name),
	                   INVOICE_TOTAL    => number_format($invoice_total),
	                   INVOICE_PROPERTY => $faculty->getDormitoryCode($faculty->facultyDormitory),
	                   INVOICE_UNIT     => $sel_room,
	                   INVOICE_CHECKIN  => $checkin,
	                   INVOICE_CHECKOUT => $checkout));

	include("../common/variables_tpl.php");

	$faculty->closeDatabase();
	unset($faculty);

	include("../common/popup_footer_tpl.php");
?>