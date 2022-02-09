<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 0 && (int)$ihouse_admin_info[grade] != 1 && (int)$ihouse_admin_info[grade] != 2 && (int)$ihouse_admin_info[grade] != 6 && (int)$ihouse_admin_info[grade] < 9) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/grad_application_tpl.php");

			$page_name .= " 상세정보 보기";

			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(preference_row => "body",
			                           period_row     => "body",
			                           cf_period_row  => "body",
			                           year_row       => "body",
			                           month_row      => "body",
			                           payment1_row   => "body",
			                           payment2_row   => "body"));

			for ($i = 2019; $i <= date("Y"); $i++) {
				$tpl->assign(YEAR_VALUE, $i);
				$tpl->parse(YEAR_ROWS, ".year_row");
			}
			for ($i = 1; $i <= 12; $i++) {
				$temp = $i;
				if ($temp < 10) $temp = "0" . $temp;
				$tpl->assign(MONTH_VALUE, $temp);
				$tpl->parse(MONTH_ROWS, ".month_row");
			}

			$application->getPeriodList();
			for ($i = 0; $i < count($application->periodCode); $i++) {
				$tpl->assign(array(PERIOD_CODE => $application->periodCode[$i],
				                   PERIOD_NAME => stripslashes($application->periodName[$i])));
				$tpl->parse(PERIOD_ROWS, ".period_row");
			}

			$current = "";
			$application->getApplicationInfo($no);
			$name = $application->personLastName . ", " . $application->personFirstName . " " . $application->personMiddleName;
			if ($application->personPreferName) $preferred = "(" . $application->personPreferName . ")";
			else $preferred = "";
			if ($application->applyKind == "L") {
				if ($application->currentResident == "Y") $current = "KLCC Current Resident";
				else if ($application->currentResident == "N") $current = "KLCC Prospect Resident (Deposit of 200,000 Korean won)";
			} else if ($application->applyKind == "U") {
				if ($application->currentResident == "Y") $current = "Current Resident";
				else if ($application->currentResident == "N") $current = "Prospect Resident (Deposit of 200,000 Korean won)";
			}

			$period = $application->linkPeriodCode;
			if ($period) {
				$application->getPreferenceList($no, $period);
				for ($i = 0 ; $i < count($application->preRateCode); $i++) {
					$preference = "";
					if ($application->preRateCode[$i]) {
						$preference = $application->preRateName[$i] . " - " . number_format($application->preRatePrice[$i]) . "KRW";
						if ($application->preRateCode[$i] == $application->linkRateCode) $preference .= " <b>[결정]</b>";
					}
					$tpl->assign(array(PREFERENCE_NUMBER => ($i + 1),
					                   PREFERENCE_RATE   => stripslashes($preference)));
					$tpl->parse(PREFERENCE_ROWS, ".preference_row");
				}
				$period = $application->linkPeriodName . ": " . getEnglishDate($application->linkPeriodSDate) . " - " . getEnglishDate($application->linkPeriodEDate);
			} else $period = "";

			if ($application->roomPrefer) $room_prefer = $application->roomPrefer;
			else $room_prefer = "No Preference";

			if ($application->applyAccount) $account = $application->applyAccount;
			else $account = "391-910012-18304";

			$room_info = "";
			if ($application->linkRoomPhone) $room_info .= "전화번호 : " . $application->linkRoomPhone;
			if ($application->linkRoomIP) {
				$temp_ip = explode(".", $application->linkRoomIP);
				if ($room_info) $room_info .= ", ";
				$room_info .= "IP주소 : " . $application->linkRoomIP;
				$room_info .= ", 서브넷마스크 : 255.255.255.0";
				$room_info .= ", GateWay : " . $temp_ip[0] . "." . $temp_ip[1] . "." . $temp_ip[2] . ".1";
				$room_info .= ", 주 DNS Server : 219.252.0.1";
				$room_info .= ", 보조 DNS server : 219.252.1.100";
			}

			if ($application->applyCheckinDate == "0000-00-00") $checkin = "";
			else $checkin = getFullDate($application->applyCheckinDate);
			if ($application->applyCheckoutDate == "0000-00-00") $checkout = "";
			else $checkout = getFullDate($application->applyCheckoutDate);

			$nation = $application->personNationality;
			if (trim($application->personProvince) != "") $nation .= " - " . $application->personProvince;

			$tpl->assign(array(SEL_PAGE           => $page,
			                   SEARCH_TYPE        => $s_type,
			                   SEARCH_TEXT        => $s_text,
			                   SEARCH_KIND        => $s_kind,
			                   SEARCH_RATE        => $s_rate,
			                   SEARCH_STATE       => $s_state,
			                   SEARCH_GRADE       => $s_grade,
			                   SEARCH_CURRENT     => $s_current,
			                   SEARCH_PERIOD      => $s_period,
			                   SEARCH_YEAR1       => $s_year1,
			                   SEARCH_MONTH1      => $s_month1,
			                   SEARCH_DAY1        => $s_day1,
			                   SEARCH_YEAR2       => $s_year2,
			                   SEARCH_MONTH2      => $s_month2,
			                   SEARCH_DAY2        => $s_day2,
			                   SORT1_VALUE        => $sort1,
			                   SORT2_VALUE        => $sort2,
			                   SEL_RATE           => $application->linkRateCode,
			                   APPLY_NUMBER       => $no,
			                   APPLY_STATE        => $application->getStateValue($application->applyState),
			                   APPLY_ADMIN        => nl2br(stripslashes($application->applyAdmin)),
			                   APPLY_ROOMMATES    => stripslashes($application->applyRoommate),
			                   APPLY_STUDENT      => $application->personStudentID,
			                   APPLY_NAME         => stripslashes($name),
			                   APPLY_PREFERRED    => stripslashes($preferred),
			                   APPLY_KRNAME       => stripslashes($application->personKoreanName),
			                   APPLY_GENDER       => $application->getGenderValue($application->personGender),
			                   APPLY_DOB          => getEnglishDate($application->personBirthDate),
			                   APPLY_NATION       => stripslashes($nation),
			                   APPLY_KGSP         => $application->getKGSPValue($application->personKGSP),
			                   APPLY_HOME_UNI     => stripslashes($application->personHomeUni),
			                   APPLY_HOME_ADDR    => stripslashes($application->personHomeAddress),
			                   APPLY_EMAIL        => $application->personEmail,
			                   APPLY_PHONE        => $application->personPhone,
			                   APPLY_CELL         => $application->personCell,
			                   APPLY_CURRENT      => $current,
			                   APPLY_MAJOR        => stripslashes($application->personMajor),
			                   APPLY_CLASS        => $application->getClassValue($application->personClass),
			                   APPLY_PREFER       => $room_prefer,
			                   APPLY_MATE_NAME    => stripslashes($application->mateName),
			                   APPLY_MATE_ID      => stripslashes($application->mateID),
			                   APPLY_MATE_DOB     => getEnglishDate($application->mateBirthDate),
			                   APPLY_PREFERENCE1  => $application->getPreferenceValue($application->matchNonSmoker),
			                   APPLY_PREFERENCE2  => $application->getPreferenceValue($application->matchBedEarly),
			                   APPLY_PREFERENCE3  => $application->getPreferenceValue($application->matchGetupEarly),
			                   APPLY_PREFERENCE4  => $application->getPreferenceValue($application->matchSilenceStudy),
			                   APPLY_PREFERENCE5  => $application->getPreferenceValue($application->matchDayStudy),
			                   APPLY_PREFERENCE6  => $application->getPreferenceValue($application->matchLocal),
			                   APPLY_CASE_NAME    => stripslashes($application->contactName),
			                   APPLY_CASE_RELATE  => stripslashes($application->contactRelation),
			                   APPLY_CASE_PHONE   => $application->contactPhone,
			                   APPLY_CASE_ADDR    => stripslashes($application->contactAddress),
			                   APPLY_PERIOD       => stripslashes($period),
			                   APPLY_ROOM         => $application->linkRoomCode,
			                   APPLY_ROOM_INFO    => $room_info,
			                   APPLY_DATE         => getEnglishDate(substr($application->applyDate, 0, 10)),
			                   APPLY_CHECKIN      => $checkin,
			                   APPLY_CHECKOUT     => $checkout,
			                   APPLY_SETTLE1      => $application->getSettleValue($application->settleFlag1),
			                   APPLY_SETTLE2      => $application->getSettleValue($application->settleFlag2),
			                   APPLY_SETTLE3      => $application->getSettleValue($application->settleFlag3),
			                   APPLY_SETTLE4      => $application->getSettleValue($application->settleFlag4),
			                   APPLY_PAYMENT_YY   => date("Y"),
			                   APPLY_PAYMENT_MM   => date("m"),
			                   APPLY_PAYMENT_DD   => date("d"),
			                   APPLY_ACCOUNT      => $account,
			                   APPLY_PHOTO        => getOriginalImage($pht_dir."/".$application->personStudentNo.".jpg"),
			                   APPLY_FEE_TRANSFER => getUploadImage("$fee_transfer_dir/$no.jpg"),//getOriginalImage("$fee_transfer_dir/$no.jpg"),
			                   APPLY_FEE_SUPPORT  => getUploadImage("$fee_support_dir/$no.jpg"),//getOriginalImage("$fee_support_dir/$no.jpg"),
			                   APPLY_TB_TEST      => getUploadImage("$tb_test_dir/$no.jpg")));//getOriginalImage("$tb_test_dir/$no.jpg")));

			include("../common/variables_tpl.php");

			$application->getPeriodList1($no, $application->personEmail, $application->linkPeriodSDate);
			for ($i = 0; $i < count($application->periodApply); $i++) {
				$tpl->assign(array(CF_PERIOD_APPLY => $application->periodApply[$i],
				                   CF_PERIOD_NAME  => stripslashes($application->periodName[$i])));
				$tpl->parse(CF_PERIOD_ROWS, ".cf_period_row");
			}

			$pay_total = 0;
			$application->getPaymentList1($no);
			for ($i = 0; $i < count($application->payListNumber); $i++) {
				$pay_total += (int)$application->payListPrice[$i];
				if ($application->payListKind[$i] == "F") $check = "";
				else $check = "<input type=\"checkbox\" name=\"list_no\" value=\"" . $application->payListNumber[$i] . "\">";
				if ($application->payListKind[$i] != "E") $radio = "";
				else $radio = "<input type=\"radio\" name=\"update_no\" value=\"" . $application->payListNumber[$i] . "\" onClick=\"showUpdateInfo(this, '" . substr($application->payListDate[$i], 0, 4) . "', '" . substr($application->payListDate[$i], 5, 2) . "', '" . substr($application->payListDate[$i], 8, 2) . "', '" . $application->payListDetail[$i] . "', '" . $application->payListPrice[$i] . "');\">";
				$tpl->assign(array(PAYMENT1_NUMBER  => $application->payListNumber[$i],
				                   PAYMENT1_DATE    => getFullDate(substr($application->payListDate[$i], 0, 10)),
				                   PAYMENT1_TYPE    => $application->getPaymentValue($application->payListPrice[$i]),
				                   PAYMENT1_PRICE   => number_format($application->payListPrice[$i]),
				                   PAYMENT1_DETAIL  => $application->getDetailValue($application->payListDetail[$i]),
				                   PAYMENT1_CHECK   => $check,
				                   PAYMENT1_RADIO   => $radio));
				$tpl->parse(PAYMENT1_ROWS, ".payment1_row");
			}
			$tpl->assign(PAYMENT1_TOTAL, number_format($pay_total));

			$pay_total = 0;
			$application->getPaymentList2($no);
			for ($i = 0; $i < count($application->payListNumber); $i++) {
				$pay_total += (int)$application->payListPrice[$i];
				if ($application->payListKind[$i] == "F") $check = "";
				else $check = "<input type=\"checkbox\" name=\"list_no\" value=\"" . $application->payListNumber[$i] . "\">";
				if ($application->payListKind[$i] != "E") $radio = "";
				else $radio = "<input type=\"radio\" name=\"update_no\" value=\"" . $application->payListNumber[$i] . "\" onClick=\"showUpdateInfo(this, '" . substr($application->payListDate[$i], 0, 4) . "', '" . substr($application->payListDate[$i], 5, 2) . "', '" . substr($application->payListDate[$i], 8, 2) . "', '" . $application->payListDetail[$i] . "', '" . $application->payListPrice[$i] . "');\">";
				$tpl->assign(array(PAYMENT2_NUMBER  => $application->payListNumber[$i],
				                   PAYMENT2_DATE    => getFullDate(substr($application->payListDate[$i], 0, 10)),
				                   PAYMENT2_TYPE    => $application->getPaymentValue($application->payListPrice[$i]),
				                   PAYMENT2_PRICE   => number_format($application->payListPrice[$i]),
				                   PAYMENT2_DETAIL  => $application->getDetailValue($application->payListDetail[$i]),
				                   PAYMENT2_CHECK   => $check,
				                   PAYMENT2_RADIO   => $radio));
				$tpl->parse(PAYMENT2_ROWS, ".payment2_row");
			}
			$tpl->assign(PAYMENT2_TOTAL, number_format($pay_total));

			$detail = "$no 온라인지원 상세 정보 조회";
			$application->insertHistoryWork("A", "I", $detail);

			$application->closeDatabase();
			unset($application);

			include_once("../common/footer_tpl.php");
		}
	}
?>