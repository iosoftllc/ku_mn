<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 0 && (int)$ihouse_admin_info[grade] != 1 && (int)$ihouse_admin_info[grade] != 2 && (int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/faculty_tpl.php");

			$page_name .= " 상세정보 보기";

			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(year_row       => "body",
			                           month_row      => "body",
			                           rate_row       => "body",
			                           attach_row     => "body",
			                           payment_row    => "body",
			                           room_new_row   => "body",
			                           room_del_row   => "body",
			                           invioce_dt_row => "body"));

			for ($i = 2005; $i <= date("Y") + 1; $i++) {
				$tpl->assign(YEAR_VALUE, $i);
				$tpl->parse(YEAR_ROWS, ".year_row");
			}
			for ($i = 1; $i <= 12; $i++) {
				$temp = $i;
				if ($temp < 10) $temp = "0" . $temp;
				$tpl->assign(MONTH_VALUE, $temp);
				$tpl->parse(MONTH_ROWS, ".month_row");
			}

			$faculty->getFacultyInfo($no);
			$rate = $faculty->facultyRate;
			$arrival = $faculty->facultyArrival;
			$departure = $faculty->facultyDeparture;
			if ($faculty->facultyAccount) $account = $faculty->facultyAccount;
			else $account = "391-910001-03204";

			$room_info = "";
			$sel_room = $faculty->getRoomValue($no);
			for ($i = 0; $i < count($faculty->roomListCode); $i++) {
				$room_info .= "<b>" . $faculty->roomListCode[$i] . "</b> - ";
				if ($faculty->roomListPhone[$i]) $room_info .= "전화번호 : " . $faculty->roomListPhone[$i];
				if ($faculty->roomListIP[$i]) {
					$temp_ip = explode(".", $faculty->roomListIP[$i]);
					if ($room_info) $room_info .= ", ";
					$room_info .= "IP주소 : " . $faculty->roomListIP[$i];
					$room_info .= ", 서브넷마스크 : 255.255.255.0";
					$room_info .= ", GateWay : " . $temp_ip[0] . "." . $temp_ip[1] . "." . $temp_ip[2] . ".1";
					$room_info .= ", 주 DNS Server : 219.252.0.1";
					$room_info .= ", 보조 DNS server : 219.252.1.100";
				}
				$room_info .= "<br>";
			}

			$name = "";
			if ($faculty->facultyTitle) $name .= $faculty->facultyTitle . ". ";
			$name .= $faculty->facultyLName;
			if (trim($faculty->facultyFName)) $name .= ", " . $faculty->facultyFName . " " . $faculty->facultyMName;
			$reference = $faculty->facultyRLName;
			if (trim($faculty->facultyRFName)) $reference .= ", " . $faculty->facultyRFName . " " . $faculty->facultyRMName;

			$tpl->assign(array(SEL_PAGE          => $page,
			                   SEARCH_TYPE       => $s_type,
			                   SEARCH_TEXT       => $s_text,
			                   SEARCH_TERM       => $s_term,
			                   SEARCH_STATE      => $s_state,
			                   SEARCH_GRADE      => $s_grade,
			                   SEARCH_RATE       => $s_rate,
			                   SEARCH_ROOM       => $s_room,
			                   SEARCH_DORM       => $s_dorm,
			                   SORT1_VALUE       => $sort1,
			                   SORT2_VALUE       => $sort2,
			                   FACULTY_NUMBER    => $no,
			                   FACULTY_SETTLE1   => $faculty->getSettleValue($faculty->facultySettle1, $faculty->facultySettleDate1),
			                   FACULTY_SETTLE2   => $faculty->getSettleValue($faculty->facultySettle2, $faculty->facultySettleDate2),
			                   FACULTY_SETTLE3   => $faculty->getSettleValue($faculty->facultySettle3, $faculty->facultySettleDate3),
			                   FACULTY_SETTLE4   => $faculty->getSettleValue($faculty->facultySettle4, $faculty->facultySettleDate4),
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
			                   FACULTY_ARRIVAL   => getEnglishDate($arrival),
			                   FACULTY_DEPARTURE => getEnglishDate($departure),
			                   FACULTY_AFFILIATE => $faculty->getAffiliateValue($faculty->facultyAffiliate),
			                   FACULTY_PAY       => $faculty->getPaymentMethod($faculty->facultyPMethod),
			                   FACULTY_RATE      => $rate,
			                   FACULTY_RATE1     => stripslashes($faculty->getDormitoryValue1($faculty->facultyDormitory) . " - " . $faculty->facultyUnit),
			                   FACULTY_DATE      => getEnglishDate($faculty->facultyDate),
			                   FACULTY_RNAME     => stripslashes($reference),
			                   FACULTY_RDEPART   => stripslashes($faculty->facultyRDepart),
			                   FACULTY_RPOS      => stripslashes($faculty->facultyRPosition),
			                   FACULTY_REMAIL    => $faculty->facultyREmail,
			                   FACULTY_RPHONE    => stripslashes($faculty->facultyRPhone),
			                   FACULTY_ACCOUNT   => $account,
			                   FACULTY_ROOM      => $sel_room,
			                   FACULTY_ROOM_INFO => $room_info,
			                   FACULTY_NO_ROOM   => $faculty->facultyNoRoom,
			                   FACULTY_STATE     => $faculty->getStateValue($faculty->facultyState),
			                   FACULTY_DISCOUNT  => $faculty->getDiscountValue($faculty->facultyDiscount),
			                   FACULTY_REQUEST   => nl2br(stripslashes($faculty->facultyRequest)),
			                   FACULTY_ADMIN     => nl2br(stripslashes($faculty->facultyAdmin)),
			                   FACULTY_PAY_YY    => date("Y"),
			                   FACULTY_PAY_MM    => date("m"),
			                   FACULTY_PAY_DD    => date("d"),
			                   PAYMENT_TOTAL     => ""));

			include("../common/variables_tpl.php");

			$faculty->getRateList("IFRH");
			for ($i = 0; $i < count($faculty->rateListCode); $i++) {
				$tpl->assign(array(RATE_VALUE => $faculty->rateListCode[$i],
				                   RATE_NAME  => $faculty->getDormitoryValue($faculty->rateListDormitory[$i]) . " - " . $faculty->rateListUnit[$i]));
				$tpl->parse(RATE_ROWS, ".rate_row");
			}

			$faculty->getRoomList($rate, $arrival, $departure);
			for ($i = 0; $i < count($faculty->roomListCode); $i++) {
				$tpl->assign(array(ROOM_NEW_VALUE => $faculty->roomListCode[$i],
				                   ROOM_NEW_NAME  => $faculty->roomListCode[$i]));
				$tpl->parse(ROOM_NEW_ROWS, ".room_new_row");
			}

			$del_room = explode(", ", $sel_room);
			for ($i = 0; $i < count($del_room); $i++) {
				$tpl->assign(array(ROOM_DEL_VALUE => $del_room[$i],
				                   ROOM_DEL_NAME  => $del_room[$i]));
				$tpl->parse(ROOM_DEL_ROWS, ".room_del_row");
			}

			$faculty->getInvoiceDateList($no);
			for ($i = 0; $i < count($faculty->dateListInvoice); $i++) {
				$tpl->assign(INVOICE_DT_VALUE, $faculty->dateListInvoice[$i]);
				$tpl->parse(INVOICE_DT_ROWS, ".invioce_dt_row");
			}

			$faculty->getAttachmentList($no);
			for ($i = 0; $i < count($faculty->attachListNumber); $i++) {
				$name = "<a href=\"../../src/main/download.php?file=../../../upload/faculty/" . $faculty->attachListNumber[$i] . "&name=" . $faculty->attachListName[$i] . "\">" . $faculty->attachListName[$i] . "</a>";
				$tpl->assign(array(ATTACH_NUMBER => $faculty->attachListNumber[$i],
				                   ATTACH_NAME   => $name,
				                   ATTACH_DATE   => $faculty->attachListDate[$i]));
				$tpl->parse(ATTACH_ROWS, ".attach_row");
			}

			$pay_total = 0;
			$faculty->getPaymentList($no);
			for ($i = 0; $i < count($faculty->payListNumber); $i++) {
				//$temp = (int)(substr($faculty->payListPrice[$i], 0, -2) . "00");
				//echo $faculty->payListPrice[$i]." ".$temp."<br>";
				$pay_total += (int)$faculty->payListPrice[$i];
				if ($faculty->payListKind[$i] != "E") {
					$check = "";
					$radio = "";
				} else {
					$check = "<input type=\"checkbox\" name=\"list_no\" value=\"" . $faculty->payListNumber[$i] . "\">";
					$radio = "<input type=\"radio\" name=\"update_no\" value=\"" . $faculty->payListNumber[$i] . "\" onClick=\"showUpdateInfo(document.FacultyForm, this, '" . substr($faculty->payListDate[$i], 0, 4) . "', '" . substr($faculty->payListDate[$i], 5, 2) . "', '" . substr($faculty->payListDate[$i], 8, 2) . "', '" . $faculty->payListDetail[$i] . "', '" . $faculty->payListPrice[$i] . "');\">";
				}
				$invoice = "<input type=\"checkbox\" name=\"list_invoice\" value=\"" . $faculty->payListNumber[$i] . "\">";
				if ((int)$faculty->payListPrice[$i] < 0) $receipt = "<input type=\"checkbox\" name=\"list_receipt\" value=\"" . $faculty->payListNumber[$i] . "\">";
				else $receipt = "";
				$tpl->assign(array(PAYMENT_NUMBER  => $faculty->payListNumber[$i],
				                   PAYMENT_DATE    => getFullDate(substr($faculty->payListDate[$i], 0, 10)),
				                   PAYMENT_TYPE    => $faculty->getPaymentValue($faculty->payListPrice[$i]),
				                   PAYMENT_PRICE   => number_format($faculty->payListPrice[$i]),
				                   PAYMENT_DETAIL  => $faculty->getDetailValue($faculty->payListDetail[$i] , substr($faculty->payListDate[$i], 0, 10), $arrival, $departure),
				                   PAYMENT_CHECK   => $check,
				                   PAYMENT_RADIO   => $radio,
				                   PAYMENT_INVOICE => $invoice,
				                   PAYMENT_RECEIPT => $receipt));
				$tpl->parse(PAYMENT_ROWS, ".payment_row");
			}
			$tpl->assign(PAYMENT_TOTAL, number_format($pay_total));

			$detail = "$no 객실예약 상세 정보 조회";
			$faculty->insertHistoryWork("R", "I", $detail);

			$faculty->closeDatabase();
			unset($faculty);

			include_once("../common/footer_tpl.php");
		}
	}
?>