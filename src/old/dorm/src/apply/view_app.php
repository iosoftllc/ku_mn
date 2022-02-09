<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/application_tpl.php");

	$on_load = "";

	if (!$application->isEmailExist($email)) {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"There is no matching personal data available.\\n\\nCheck your personal information.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if (!$application->checkPassword($email, $pw)) {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The password you input is not correct.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else {
		$application->getApplicationInfo($no);
		if ($application->applyNumber) {
			$html_dir = "apply";
			$html_file = "view_app";
			include_once("../../src/common/tpl_header.php");

			$tpl->define_dynamic(array(preference_row  => "body",
			                           room_prefer_row => "body",
			                           deposit_row     => "body",
			                           payment_use     => "body",
			                           payment1_row    => "body",
			                           payment2_row    => "body",
			                           deposit1_row    => "body",
			                           invoice_row     => "body",
			                           edit_row        => "body",
			                           defer_row       => "body"));

			if ($application->applyKind == "L") {
				if ($application->currentResident == "Y") {
					$tpl->assign(APPLY_PREFER, $application->roomPrefer);
					//$tpl->parse(ROOM_PREFER_ROWS, ".room_prefer_row");
				} else {
					//$tpl->parse(DEPOSIT_ROWS, ".deposit_row");
				}
			} else {
				if ($application->currentResident == "Y") {
					$tpl->assign(APPLY_PREFER, $application->roomPrefer);
					//$tpl->parse(ROOM_PREFER_ROWS, ".room_prefer_row");
				} else {
					//$tpl->parse(DEPOSIT_ROWS, ".deposit_row");
				}
			}

			$name = $application->personFirstName . " " . $application->personMiddleName . " " . $application->personLastName;

			//$rate = "Not assigned yet";
			$rate = "Not assigned";
			$period = $application->linkPeriodCode;
			if ($period) {
				$application->getPreferenceList($no, $period);
				for ($i = 0 ; $i < count($application->preRateCode); $i++) {
					$dorm_name = $application->getDormitoryValue($application->preRateDormitory[$i], $application->preRateCode[$i]);
					if (trim($dorm_name) != "") $dorm_name .= ": ";
					if (trim($application->preRateCode[$i]) == trim($application->linkRateCode)) {
						if (trim($application->linkRateCode)) $rate = $dorm_name . $application->preRateName[$i] . " " . number_format($application->preRatePrice[$i]) . "KRW";
					}
					$preference = "";
					if ($application->preRateCode[$i]) $preference = $dorm_name . $application->preRateName[$i] . " - " . number_format($application->preRatePrice[$i]) . " KRW";
					if ($i == count($application->preRateCode) - 1) $divide = "";
					else $divide = "<tr><td colspan=\"6\" height=\"1\"></td></tr><tr><td colspan=\"6\" height=\"1\" background=\"../../images/board/board_hdot.jpg\"></td></tr><tr><td colspan=\"6\" height=\"1\"></td></tr>";
					$tpl->assign(array(PREFERENCE_NUMBER => ($i + 1),
					                   PREFERENCE_RATE   => $preference,
					                   DIVIDE_LINE       => $divide));
					$tpl->parse(PREFERENCE_ROWS, ".preference_row");
				}
				$period = $application->linkPeriodName . ": " . getEnglishDate($application->linkPeriodSDate) . " - " . getEnglishDate($application->linkPeriodEDate);
			} else $period = "";

			$ip_info = "";
			if ($application->linkRoomIP) {
				$ip_info .= "IP Address : " . $application->linkRoomIP . "<br>";
				$temp_ip = explode(".", $application->linkRoomIP);
				$ip_info .= "Subnet Mask : 255.255.255.0<br>";
				$ip_info .= "GateWay : " . $temp_ip[0] . "." . $temp_ip[1] . "." . $temp_ip[2] . ".1<br>";
				$ip_info .= "Main DNS Server : 219.252.0.1<br>";
				$ip_info .= "Ass. DNS server : 219.252.1.100";
			}

			$application->getRefundInfo($no);
			$refund_desc = "Not Provided";
			if ($application->refundCFApply) $refund_desc = "Deposit Carry-Forward requested to Application No. " . $application->refundCFApply . " for " . stripslashes($application->refundPeriod) . " on " . getEnglishDate(substr($application->refundDate, 0, 10)) . ".";
			else if ($application->refundMethodType == "M") {
				$refund_desc = "Deposit Refund by Money Order requested to " . stripslashes($application->refundMethodInfo1) . " at " . stripslashes($application->refundMethodInfo2) . " on " . getEnglishDate(substr($application->refundDate, 0, 10)) . ".";
				if ($application->refundMethodInfo3) $refund_desc .= "<br>Name of Mail Recipient: " . stripslashes($application->refundMethodInfo3);
			} else if ($application->refundMethodType == "W") $refund_desc = "Deposit Refund by Wire Transfer requested to " . stripslashes($application->refundMethodInfo3) . " at " . stripslashes($application->refundMethodInfo2) . " with " . stripslashes($application->refundMethodInfo1) . " on " . getEnglishDate(substr($application->refundDate, 0, 10)) . ".";
			if ($application->refundApprove == "Y") {
				$deduction = number_format(200000 - (int)$application->refundDeduction);
				if ($application->refundCFApply) $refund_desc .= "<br><b>Office Approval:</b> Carry-forward approved in the amount of $deduction to Application No. " . $application->refundCFApply . " for " . stripslashes($application->refundPeriod) . " on " . getEnglishDate(substr($application->refundDate, 0, 10));
				else if ($application->refundMethodType == "M") $refund_desc .= "<br><b>Office Approval:</b> Refund by money order approved in the amount of $deduction to " . stripslashes($application->refundMethodInfo1) . " at " . stripslashes($application->refundMethodInfo2) . " on " . getEnglishDate(substr($application->refundDate, 0, 10));
				else if ($application->refundMethodType == "W") $refund_desc .= "<br><b>Office Approval:</b> Refund by wire transfer approved in the amount of $deduction to " . stripslashes($application->refundMethodInfo3) . " at " . stripslashes($application->refundMethodInfo2) . " with " . stripslashes($application->refundMethodInfo1) . " on " . getEnglishDate(substr($application->refundDate, 0, 10));
			} else if ($application->refundApprove == "N") $refund_desc .= "<br><b>Office Approval:</b> Request is currently on review.";
			$tpl->assign(REFUND_DESC, $refund_desc);
			//$tpl->parse(DEPOSIT1_ROWS, ".deposit1_row");

			//if ($application->applyState == "DP" || $application->applyState == "FP" || $application->applyState == "RR" || $application->applyState == "TR" || $application->applyState == "RD" || $application->applyState == "CF") $refund_flag = "N";
			//else if ($application->applyState == "FD" || !$application->isRefundExist($no)) $refund_flag = "Y";
			//else $refund_flag = "N";

			//if ((int)$application->getDepositAmount($no) || $application->applyState == "DP" || $application->applyState == "DD" || $application->applyState == "FP" || $application->applyState == "FD") $refund_flag = "Y";
			if ((int)$application->getDepositPaidAmount($no)) $refund_flag = "Y";
			else $refund_flag = "N";
			//if ($email == "webmaster@intia.co.kr") $refund_flag = "Y";

			if (is_numeric($application->deferNumber) && (int)$application->deferNumber > 0) $defer_no = (int)$application->deferNumber;
			else $defer_no = 0;
			if ($defer_no > 0) {
				if ($application->deferApprove == "Y") $defer_desc = "Approved";
				else if ($application->deferApprove == "N") $defer_desc = "Processing";
				else if ($application->deferApprove == "C") $defer_desc = "Canceled";
			} else $defer_desc = "Not Provided";

			$tpl->assign(array(SEL_EMAIL          => $email,
			                   SEL_PASSWORD       => $pw,
			                   SEARCH_STATE       => $s_state,
			                   SORT1_VALUE        => $sort1,
			                   SORT2_VALUE        => $sort2,
			                   APPLY_NUMBER       => $no,
			                   APPLY_STATE        => $application->getStateValue($application->applyState),
			                   APPLY_STUDENT      => $application->personStudentID,
			                   APPLY_NAME         => stripslashes($name),
			                   APPLY_KRNAME       => stripslashes($application->personKoreanName),
			                   APPLY_CLASS        => $application->getClassValue($application->personClass),
			                   APPLY_GENDER       => $application->getGenderValue($application->personGender),
			                   APPLY_DOB          => getEnglishDate($application->personBirthDate),
			                   APPLY_NATION       => stripslashes($application->personNationality),
			                   APPLY_EMAIL        => $application->personEmail,
			                   APPLY_PHONE        => $application->personPhone,
			                   APPLY_CELL         => $application->personCell,
			                   APPLY_MAJOR        => stripslashes($application->personMajor),
			                   APPLY_HOME_UNI     => stripslashes($application->personHomeUni),
			                   APPLY_HOME_ADDR    => stripslashes($application->personHomeAddr),
			                   APPLY_MATE_NAME    => stripslashes($application->mateName),
			                   APPLY_MATE_ID      => stripslashes($application->mateID),
			                   APPLY_MATE_DOB     => getEnglishDate($application->mateBirthDate),
			                   APPLY_CASE_NAME    => stripslashes($application->contactName),
			                   APPLY_CASE_RELATE  => stripslashes($application->contactRelation),
			                   APPLY_CASE_PHONE   => $application->contactPhone,
			                   APPLY_CASE_ADDR    => stripslashes($application->contactAddress),
			                   APPLY_CURRENT      => $application->getKindValue($application->applyKind) . " - " . $application->getCurrentValue($application->currentResident),
			                   APPLY_ROOM         => $application->linkRoomCode,
			                   APPLY_ROOM_PH      => $application->linkRoomPhone,
			                   APPLY_ROOM_IP      => $ip_info,
			                   APPLY_DATE         => getEnglishDate(substr($application->applyDate, 0, 10)),
			                   APPLY_PERIOD       => $period,
			                   APPLY_RATE         => $rate,
			                   APPLY_ROOMMATES    => stripslashes($application->applyRoommate),
			                   APPLY_PREFERENCE1  => $application->getPreferenceValue($application->matchNonSmoker),
			                   APPLY_PREFERENCE2  => $application->getPreferenceValue($application->matchBedEarly),
			                   APPLY_PREFERENCE3  => $application->getPreferenceValue($application->matchGetupEarly),
			                   APPLY_PREFERENCE4  => $application->getPreferenceValue($application->matchSilenceStudy),
			                   APPLY_PREFERENCE5  => $application->getPreferenceValue($application->matchDayStudy),
			                   APPLY_PREFERENCE6  => $application->getPreferenceValue($application->matchLocal),
			                   APPLY_DORM_WAIVED  => $application->getPreferenceValue($application->dormWaived),
			                   APPLY_FEE_TRANSFER => getUploadImage("$fee_transfer_dir/$no.jpg"),//getOriginalImage("$fee_transfer_dir/$no.jpg"),
			                   APPLY_FEE_SUPPORT  => getUploadImage("$fee_support_dir/$no.jpg"),//getOriginalImage("$fee_support_dir/$no.jpg"),
			                   APPLY_TB_TEST      => getUploadImage("$tb_test_dir/$no.jpg"),//getOriginalImage("$tb_test_dir/$no.jpg"),
			                   PAYMENT_TOTAL      => number_format($pay_total),
			                   APPLY_PHOTO        => getOriginalImage("$pht_dir/$application->personStudentNo.jpg"),
			                   REFUND_FLAG        => $refund_flag,
			                   DEFER_DESC         => $defer_desc));

			include("../common/tpl_variables.php");

			$pay_total = 0;
			$application->getPaymentList1($no);
			for ($i = 0; $i < count($application->payListNumber); $i++) {
				$pay_total += (int)$application->payListPrice[$i];
				if (count($application->payListNumber) - 1 == $i) $dot_line = "";
				else $dot_line = "<tr><td colspan=\"9\" height=\"1\" background=\"../../images/board/board_hdot.jpg\"></td></tr><tr><td colspan=\"9\" height=\"1\"></td></tr>";
				$tpl->assign(array(PAYMENT1_DATE    => getEnglishDate(substr($application->payListDate[$i], 0, 10)),
				                   PAYMENT1_PRICE   => number_format($application->payListPrice[$i]),
				                   PAYMENT1_DETAIL  => $application->getDetailValue($application->payListDetail[$i]),
				                   DOT_LINE        => $dot_line));
				$tpl->parse(PAYMENT1_ROWS, ".payment1_row");
			}
			$tpl->assign(PAYMENT1_TOTAL, number_format($pay_total));
			$pay_total = 0;
			$application->getPaymentList2($no);
			for ($i = 0; $i < count($application->payListNumber); $i++) {
				$pay_total += (int)$application->payListPrice[$i];
				if (count($application->payListNumber) - 1 == $i) $dot_line = "";
				else $dot_line = "<tr><td colspan=\"9\" height=\"1\" background=\"../../images/board/board_hdot.jpg\"></td></tr><tr><td colspan=\"9\" height=\"1\"></td></tr>";
				$tpl->assign(array(PAYMENT2_DATE    => getEnglishDate(substr($application->payListDate[$i], 0, 10)),
				                   PAYMENT2_PRICE   => number_format($application->payListPrice[$i]),
				                   PAYMENT2_DETAIL  => $application->getDetailValue($application->payListDetail[$i]),
				                   DOT_LINE        => $dot_line));
				$tpl->parse(PAYMENT2_ROWS, ".payment2_row");
			}
			$tpl->assign(PAYMENT2_TOTAL, number_format($pay_total));
			$tpl->parse(PAYMENT_USE, ".payment_use");

			//if ($application->applyAccount && ($application->applyState == "IW" || $application->applyState == "DP" || $application->applyState == "DD" || $application->applyState == "RA" || $application->applyState == "PR" || $application->applyState == "FP" || $application->applyState == "FD")) $tpl->parse(INVOICE_ROWS, ".invoice_row");
			if ($application->applyAccount && $pay_total > 0) $tpl->parse(INVOICE_ROWS, ".invoice_row");

			if (substr($application->linkPeriodCode, 0, 6) == "2008WA" || substr($application->linkPeriodCode, 0, 6) == "2008WB") $tpl->parse(EDIT_ROWS, ".edit_row");

			if (substr($application->linkPeriodCode, 0, 6) == "2010SG" && $defer_no < 1) $tpl->parse(DEFER_ROWS, ".defer_row");
			//else if (substr($application->linkPeriodCode, 0, 6) == "2009SG" && $defer_no < 1) $tpl->parse(DEFER_ROWS, ".defer_row");

			$application->closeDatabase();
			unset($application);
		
			include_once("../../src/common/tpl_footer.php");
			include_once("../../src/common/counter_tpl.php");
		} else {
			$application->closeDatabase();
			unset($application);
			echo "<script langauage=\"javascript\">";
			echo "alert(\"There is not correspondant application.\\n\\nPlease try again later.\");";
			echo "history.go(-1);";
			echo "</script>";
		}
	}
?>