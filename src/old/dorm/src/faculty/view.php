<?
	include_once("../../lib/conf.common.php");
	include_once("../common/faculty_tpl.php");

	if ($faculty->isExist($view_no, $view_fname, $view_mname, $view_lname)) {
		$html_dir = "faculty";
		$html_file = "view";
		$on_load = "";

		include_once("../../src/common/tpl_header.php");

		$tpl->define_dynamic(array(payment_row    => "body",
		                           invoice_row    => "body",
		                           logn_term1_row => "body",
		                           logn_term2_row => "body",
		                           logn_term3_row => "body"));

		$pay_total = 0;
		$faculty->getPaymentList1($view_no);
		for ($i = 0; $i < count($faculty->payListNumber); $i++) {
			$pay_total += (int)$faculty->payListPrice[$i];
			if (count($faculty->payListNumber) - 1 == $i) $dot_line = "";
			else $dot_line = "<tr><td colspan=\"9\" height=\"1\" background=\"../../images/board/board_hdot.jpg\"></td></tr><tr><td colspan=\"9\" height=\"1\"></td></tr>";
			$tpl->assign(array(PAYMENT_DATE    => getEnglishDate(substr($faculty->payListDate[$i], 0, 10)),
			                   PAYMENT_PRICE   => number_format($faculty->payListPrice[$i]),
			                   PAYMENT_DETAIL  => $faculty->getDetailValue($faculty->payListDetail[$i]),
			                   DOT_LINE        => $dot_line));
			$tpl->parse(PAYMENT_ROWS, ".payment_row");
		}

		$faculty->getFacultyInfo($view_no);
		$rate = $faculty->facultyRate;
		$arrival = $faculty->facultyArrival;
		$departure = $faculty->facultyDeparture;

		$room_info = "";
		$faculty->getRoomValue($view_no);
		for ($i = 0; $i < count($faculty->roomCode); $i++) {
			$temp = "";
			if ($faculty->roomPhone[$i]) $temp .= "Phone No : " . $faculty->roomPhone[$i];
			if ($faculty->roomIP[$i]) {
				if ($temp) $temp .= ", ";
				$temp_ip = explode(".", $faculty->roomIP[$i]);
				$temp .= "IP Address : " . $faculty->roomIP[$i];
				$temp .= ", Subnet Mask : 255.255.255.0";
				$temp .= ", GateWay : " . $temp_ip[0] . "." . $temp_ip[1] . "." . $temp_ip[2] . ".1";
				$temp .= ", Main DNS Server : 219.252.0.1";
				$temp .= ", Ass. DNS server : 219.252.1.100";
			}
			if ($temp) $temp = " (" . $temp . ")";
			$room_info .= "<b>" . $faculty->roomCode[$i] . "</b>" . $temp . "<br>";
		}
		if ($room_info) $room_info = substr($room_info, 0, -4);

		$name = "";
		if ($faculty->facultyTitle) $name .= $faculty->facultyTitle . ". ";
		$name .= $faculty->facultyLName;
		if (trim($faculty->facultyFName)) $name .= ", " . $faculty->facultyFName . " " . $faculty->facultyMName;
		$reference = $faculty->facultyRLName;
		if (trim($faculty->facultyRFName)) $reference .= ", " . $faculty->facultyRFName . " " . $faculty->facultyRMName;

		$tpl->assign(array(FACULTY_NUMBER    => $view_no,
		                   FACULTY_STATE     => $faculty->getStateValue($faculty->facultyState),
		                   FACULTY_ARRIVAL   => getEnglishDate($arrival),
		                   FACULTY_DEPARTURE => getEnglishDate($departure),
		                   FACULTY_RATE      => stripslashes($faculty->getDormitoryValue1($faculty->facultyDormitory) . " - " . $faculty->facultyUnit),
		                   FACULTY_ROOM      => $room_info,
		                   FACULTY_NAME      => stripslashes($name),
		                   FACULTY_KOREAN    => stripslashes($faculty->facultyKName),
		                   FACULTY_EMPLOY    => stripslashes($faculty->facultyEmployee),
		                   FACULTY_PURPOSE   => stripslashes($faculty->facultyPurpose),
		                   FACULTY_KDEPART   => stripslashes($faculty->facultyKDepart),
		                   FACULTY_KPOS      => stripslashes($faculty->facultyKPosition),
		                   FACULTY_HDEPART   => stripslashes($faculty->facultyHDepart),
		                   FACULTY_HPOS      => stripslashes($faculty->facultyHPosition),
		                   FACULTY_NATION    => stripslashes($faculty->facultyNationality),
		                   FACULTY_DOB       => getEnglishDate($faculty->facultyDOB),
		                   FACULTY_COUNTRY   => stripslashes($faculty->facultyCountry),
		                   FACULTY_EMAIL     => $faculty->facultyEmail,
		                   FACULTY_PHONE     => stripslashes($faculty->facultyPhone),
		                   FACULTY_PAY       => $faculty->getPaymentMethod($faculty->facultyPMethod),
		                   FACULTY_RNAME     => stripslashes($reference),
		                   FACULTY_RDEPART   => stripslashes($faculty->facultyRDepart),
		                   FACULTY_RPOS      => stripslashes($faculty->facultyRPosition),
		                   FACULTY_REMAIL    => $faculty->facultyREmail,
		                   FACULTY_RPHONE    => stripslashes($faculty->facultyRPhone),
		                   FACULTY_REQUEST   => nl2br(stripslashes($faculty->facultyRequest)),
		                   PAYMENT_TOTAL     => number_format($pay_total)));

		include("../common/tpl_variables.php");

		if ($faculty->facultyState == "AS" || $faculty->facultyState == "CF" || $faculty->facultyState == "PR" || $faculty->facultyState == "PD") $tpl->parse(INVOICE_ROWS, ".invoice_row");

		$faculty->closeDatabase();
		unset($faculty);

		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
	} else {
		$faculty->closeDatabase();
		unset($faculty);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"There is not correspondant application.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	}
?>