<?
	include_once("../../lib/conf.common.php");
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cApplicant.php");

	$on_load = "document.location.href='#';";

	$pht_dir = "../../upload/photo";

	$view_no = $_POST["view_no"];
	$view_fname = $_POST["view_fname"];
	$view_mname = $_POST["view_mname"];
	$view_lname = $_POST["view_lname"];
	if ($view_no == "") $view_no = $_GET["view_no"];
	if ($view_fname == "") $view_fname = $_GET["view_fname"];
	if ($view_mname == "") $view_mname = $_GET["view_mname"];
	if ($view_lname == "") $view_lname = $_GET["view_lname"];

	$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
	$applicant->connectDatabase();
	$applicant->refundTableName = $refundTable;

	if ($applicant->isExist($view_no, $view_fname, $view_mname, $view_lname)) {
		$html_dir = "apply";
		$html_file = "view";

		include_once("../../src/common/tpl_header.php");

		$tpl->define_dynamic(array(preference_row  => "body",
		                           room_prefer_row => "body",
		                           deposit_row     => "body",
		                           payment_use     => "body",
		                           payment_row     => "body",
		                           deposit1_row    => "body",
		                           invoice_row     => "body"));

		$applicant->getApplicantInfo($view_no);

		if ($applicant->applyKind == "L") {
			if ($applicant->currentResident == "Y") {
				$tpl->assign(APPLY_PREFER, $applicant->roomPrefer);
				$tpl->parse(ROOM_PREFER_ROWS, ".room_prefer_row");
				$title_img = "<td width=\"318\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_l.jpg\" width=\"501\" height=\"23\"></td>";
			} else {
				$tpl->parse(DEPOSIT_ROWS, ".deposit_row");
				$title_img = "<td width=\"318\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_l.jpg\" width=\"501\" height=\"23\"></td>";
			}
		} else {
			if ($applicant->currentResident == "Y") {
				$tpl->assign(APPLY_PREFER, $applicant->roomPrefer);
				$tpl->parse(ROOM_PREFER_ROWS, ".room_prefer_row");
				//$title_img = "<td width=\"311\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_c.jpg\" width=\"311\" height=\"23\"></td>";
			} else {
				$tpl->parse(DEPOSIT_ROWS, ".deposit_row");
				//$title_img = "<td width=\"318\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_n.jpg\" width=\"318\" height=\"23\"></td>";
			}
			$title_img = "<td width=\"251\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_new.jpg\" width=\"251\" height=\"23\"></td>";
		}

		$name = $applicant->personFirstName . " " . $applicant->personMiddleName . " " . $applicant->personLastName;

		$rate = "Not assigned yet";
		$period = $applicant->linkPeriodCode;
		if ($period) {
			$applicant->getPreferenceList($view_no, $period);
			for ($i = 0 ; $i < count($applicant->preRateCode); $i++) {
				if (trim($applicant->preRateCode[$i]) == trim($applicant->linkRateCode)) {
					if (trim($applicant->linkRateCode)) $rate = $applicant->getDormitoryValue($applicant->preRateDormitory[$i], $applicant->preRateCode[$i]) . ": " . $applicant->preRateName[$i] . " " . number_format($applicant->preRatePrice[$i]) . "KRW";
				}
				$preference = "";
				if ($applicant->preRateCode[$i]) $preference = $applicant->getDormitoryValue($applicant->preRateDormitory[$i], $applicant->preRateCode[$i]) . ": " . $applicant->preRateName[$i] . " - " . number_format($applicant->preRatePrice[$i]) . " KRW";
				if ($i == count($applicant->preRateCode) - 1) $divide = "";
				else $divide = "<tr><td colspan=\"6\" height=\"1\"></td></tr><tr><td colspan=\"6\" height=\"1\" background=\"../../images/board/board_hdot.jpg\"></td></tr><tr><td colspan=\"6\" height=\"1\"></td></tr>";
				$tpl->assign(array(PREFERENCE_NUMBER => ($i + 1),
				                   PREFERENCE_RATE   => $preference,
				                   DIVIDE_LINE       => $divide));
				$tpl->parse(PREFERENCE_ROWS, ".preference_row");
			}
			$period = $applicant->linkPeriodName . ": " . getEnglishDate($applicant->linkPeriodSDate) . " - " . getEnglishDate($applicant->linkPeriodEDate);
		} else $period = "";

		$ip_info = "";
		if ($applicant->linkRoomIP) {
			$ip_info .= "IP Address : " . $applicant->linkRoomIP . "<br>";
			$temp_ip = explode(".", $applicant->linkRoomIP);
			$ip_info .= "Subnet Mask : 255.255.255.0<br>";
			$ip_info .= "GateWay : " . $temp_ip[0] . "." . $temp_ip[1] . "." . $temp_ip[2] . ".1<br>";
			$ip_info .= "Main DNS Server : 219.252.0.1<br>";
			$ip_info .= "Ass. DNS server : 219.252.1.100";
		}

		$applicant->getRefundInfo($view_no);
		if ($applicant->refundApprove == "Y") {
			$refund_desc = "N/A";
			if ($applicant->refundCFApply) $refund_desc = "Deposit Transfer requested to Application No. " . $applicant->refundCFApply . " for " . stripslashes($applicant->refundPeriod) . " on " . getEnglishDate(substr($applicant->refundDate, 0, 10));
			else if ($applicant->refundMethodType == "M") $refund_desc = "Deposit Refund requested to " . stripslashes($applicant->refundMethodInfo1) . " at " . stripslashes($applicant->refundMethodInfo2) . " on " . getEnglishDate(substr($applicant->refundDate, 0, 10));
			else if ($applicant->refundMethodType == "W") $refund_desc = "Deposit Refund requested to " . stripslashes($applicant->refundMethodInfo3) . " at " . stripslashes($applicant->refundMethodInfo2) . " with " . stripslashes($applicant->refundMethodInfo1) . " on " . getEnglishDate(substr($applicant->refundDate, 0, 10));
			$tpl->assign(REFUND_DESC, $refund_desc);
			$tpl->parse(DEPOSIT1_ROWS, ".deposit1_row");
		}

		if ($applicant->applyState == "DP" || $applicant->applyState == "FP" || $applicant->applyState == "RR" || $applicant->applyState == "TR" || $applicant->applyState == "RD" || $applicant->applyState == "CF")$refund_flag = "N";
		else if ($applicant->applyState == "FD" || !$applicant->isRefundExist($view_no)) $refund_flag = "Y";
		else $refund_flag = "N";

		$tpl->assign(array(APPLY_NUMBER      => $view_no,
		                   APPLY_STATE       => $applicant->getStateValue($applicant->applyState, $applicant->currentResident),
		                   APPLY_STUDENT     => $applicant->personStudentID,
		                   APPLY_NAME        => stripslashes($name),
		                   APPLY_KRNAME      => stripslashes($applicant->personKoreanName),
		                   APPLY_CLASS      => $applicant->getClassValue($applicant->personClass),
		                   APPLY_GENDER      => $applicant->getGenderValue($applicant->personGender),
		                   APPLY_DOB         => getEnglishDate($applicant->personBirthDate),
		                   APPLY_NATION      => stripslashes($applicant->personNationality),
		                   APPLY_EMAIL       => $applicant->personEmail,
		                   APPLY_PHONE       => $applicant->personPhone,
		                   APPLY_CELL        => $applicant->personCell,
		                   APPLY_MAJOR       => stripslashes($applicant->personMajor),
		                   APPLY_HOME_UNI    => stripslashes($applicant->personHomeUni),
		                   APPLY_HOME_ADDR   => stripslashes($applicant->personHomeAddr),
		                   APPLY_MATE_NAME   => stripslashes($applicant->mateName),
		                   APPLY_MATE_DOB    => getEnglishDate($applicant->mateBirthDate),
		                   APPLY_CASE_NAME   => stripslashes($applicant->contactName),
		                   APPLY_CASE_RELATE => stripslashes($applicant->contactRelation),
		                   APPLY_CASE_PHONE  => $applicant->contactPhone,
		                   APPLY_CASE_ADDR   => stripslashes($applicant->contactAddress),
		                   APPLY_CURRENT     => $applicant->getResidentValue($applicant->applyKind, $applicant->currentResident),
		                   APPLY_ROOM        => $applicant->linkRoomCode,
		                   APPLY_ROOM_PH     => $applicant->linkRoomPhone,
		                   APPLY_ROOM_IP     => $ip_info,
		                   APPLY_DATE        => getEnglishDate(substr($applicant->applyDate, 0, 10)),
		                   APPLY_PERIOD      => $period,
		                   APPLY_RATE        => $rate,
		                   APPLY_ROOMMATES   => stripslashes($applicant->applyRoommate),
		                   APPLY_PREFERENCE1 => $applicant->getPreferenceValue($applicant->matchNonSmoker),
		                   APPLY_PREFERENCE2 => $applicant->getPreferenceValue($applicant->matchBedEarly),
		                   APPLY_PREFERENCE3 => $applicant->getPreferenceValue($applicant->matchGetupEarly),
		                   APPLY_PREFERENCE4 => $applicant->getPreferenceValue($applicant->matchSilenceStudy),
		                   APPLY_PREFERENCE5 => $applicant->getPreferenceValue($applicant->matchDayStudy),
		                   TITLE_IMAGE       => $title_img,
		                   PAYMENT_TOTAL     => number_format($pay_total),
		                   APPLY_PHOTO       => getOriginalImage("$pht_dir/$view_no.jpg"),
		                   REFUND_FLAG       => $refund_flag));

		include("../common/tpl_variables.php");

		$pay_total = 0;
		$applicant->getPaymentList($view_no);
		for ($i = 0; $i < count($applicant->payListNumber); $i++) {
			$pay_total += (int)$applicant->payListPrice[$i];
			if (count($applicant->payListNumber) - 1 == $i) $dot_line = "";
			else $dot_line = "<tr><td colspan=\"9\" height=\"1\" background=\"../../images/board/board_hdot.jpg\"></td></tr><tr><td colspan=\"9\" height=\"1\"></td></tr>";
			$tpl->assign(array(PAYMENT_DATE    => getEnglishDate(substr($applicant->payListDate[$i], 0, 10)),
			                   PAYMENT_PRICE   => number_format($applicant->payListPrice[$i]),
			                   PAYMENT_DETAIL  => $applicant->getDetailValue($applicant->payListDetail[$i]),
			                   DOT_LINE        => $dot_line));
			$tpl->parse(PAYMENT_ROWS, ".payment_row");
		}
		$tpl->assign(PAYMENT_TOTAL, number_format($pay_total));
		$tpl->parse(PAYMENT_USE, ".payment_use");

		//if ($applicant->applyAccount && ($applicant->applyState == "IW" || $applicant->applyState == "DP" || $applicant->applyState == "DD" || $applicant->applyState == "RA" || $applicant->applyState == "PR" || $applicant->applyState == "FP" || $applicant->applyState == "FD")) $tpl->parse(INVOICE_ROWS, ".invoice_row");
		if ($applicant->applyAccount) $tpl->parse(INVOICE_ROWS, ".invoice_row");

		$applicant->closeDatabase();
		unset($applicant);
	
		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
	} else {
		$applicant->closeDatabase();
		unset($applicant);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"There is not correspondant application.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	}
?>