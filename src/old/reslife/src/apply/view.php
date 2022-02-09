<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 7 && (int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/apply_tpl.php");

			$page_name .= " 상세정보 보기";

			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(preference_row => "body",
			                           period_row     => "body",
			                           year_row       => "body",
			                           month_row      => "body",
			                           payment_row    => "body"));

			for ($i = 2005; $i <= date("Y"); $i++) {
				$tpl->assign(YEAR_VALUE, $i);
				$tpl->parse(YEAR_ROWS, ".year_row");
			}
			for ($i = 1; $i <= 12; $i++) {
				$temp = $i;
				if ($temp < 10) $temp = "0" . $temp;
				$tpl->assign(MONTH_VALUE, $temp);
				$tpl->parse(MONTH_ROWS, ".month_row");
			}

			$applicant->getPeriodList($kind);
			for ($i = 0; $i < count($applicant->periodCode); $i++) {
				$tpl->assign(array(PERIOD_CODE => $applicant->periodCode[$i],
				                   PERIOD_NAME => stripslashes($applicant->periodName[$i])));
				$tpl->parse(PERIOD_ROWS, ".period_row");
			}

			$applicant->getApplicantInfo($no);
			$name = $applicant->personLastName . ", " . $applicant->personFirstName . " " . $applicant->personMiddleName;
			if ($s_kind == "L") {
				if ($applicant->currentResident == "Y") $current = "KLCC Current Resident";
				else if ($applicant->currentResident == "N") $current = "KLCC Prospect Resident (Deposit of 200,000 Korean won)";
				else $current = "";
			} else {
				if ($applicant->currentResident == "Y") $current = "Current Resident";
				else if ($applicant->currentResident == "N") $current = "Prospect Resident (Deposit of 200,000 Korean won)";
				else $current = "";
			}

			$period = $applicant->linkPeriodCode;
			if ($period) {
				$applicant->getPreferenceList($no, $period);
				for ($i = 0 ; $i < count($applicant->preRateCode); $i++) {
					$preference = "";
					if ($applicant->preRateCode[$i]) {
						$preference = $applicant->getDormitoryValue($applicant->preRateDormitory[$i]) . ": " . $applicant->preRateName[$i] . " " . number_format($applicant->preRatePrice[$i]) . "KRW";
						if ($applicant->preRateCode[$i] == $applicant->linkRateCode) $preference .= " <b>[결정]</b>";
					}
					$tpl->assign(array(PREFERENCE_NUMBER => ($i + 1),
					                   PREFERENCE_RATE   => stripslashes($preference)));
					$tpl->parse(PREFERENCE_ROWS, ".preference_row");
				}
				$period = $applicant->linkPeriodName . ": " . getEnglishDate($applicant->linkPeriodSDate) . " - " . getEnglishDate($applicant->linkPeriodEDate);
			} else $period = "";

			if ($applicant->roomPrefer) $room_prefer = $applicant->roomPrefer;
			else $room_prefer = "No Preference";

			if ($applicant->applyAccount) $account = $applicant->applyAccount;
			else $account = "391-910004-19204";

			$room_info = "";
			if ($applicant->linkRoomPhone) $room_info .= "전화번호 : " . $applicant->linkRoomPhone;
			if ($applicant->linkRoomIP) {
				$temp_ip = explode(".", $applicant->linkRoomIP);
				if ($room_info) $room_info .= ", ";
				$room_info .= "IP주소 : " . $applicant->linkRoomIP;
				$room_info .= ", 서브넷마스크 : 255.255.255.0";
				$room_info .= ", GateWay : " . $temp_ip[0] . "." . $temp_ip[1] . "." . $temp_ip[2] . ".1";
				$room_info .= ", 주 DNS Server : 219.252.0.1";
				$room_info .= ", 보조 DNS server : 219.252.1.100";
			}

			$tpl->assign(array(SEL_PAGE          => $page,
			                   SEARCH_TYPE       => $s_type,
			                   SEARCH_TEXT       => $s_text,
			                   SEARCH_KIND       => $s_kind,
			                   SEARCH_STATE      => $s_state,
			                   SEARCH_CURRENT    => $s_current,
			                   SEARCH_PERIOD     => $s_period,
			                   SORT1_VALUE       => $sort1,
			                   SORT2_VALUE       => $sort2,
			                   SEL_RATE          => $applicant->linkRateCode,
			                   APPLY_NUMBER      => $no,
			                   APPLY_STATE       => $applicant->getStateValue($applicant->applyState),
			                   APPLY_ADMIN       => nl2br(stripslashes($applicant->applyAdmin)),
			                   APPLY_ROOMMATES   => stripslashes($applicant->applyRoommate),
			                   APPLY_STUDENT     => $applicant->personStudentID,
			                   APPLY_NAME        => stripslashes($name),
			                   APPLY_KRNAME      => stripslashes($applicant->personKoreanName),
			                   APPLY_GENDER      => $applicant->getGenderValue($applicant->personGender),
			                   APPLY_DOB         => getEnglishDate($applicant->personBirthDate),
			                   APPLY_NATION      => stripslashes($applicant->personNationality),
			                   APPLY_HOME_UNI    => stripslashes($applicant->personHomeUni),
			                   APPLY_HOME_ADDR   => stripslashes($applicant->personHomeAddress),
			                   APPLY_NATION      => stripslashes($applicant->personNationality),
			                   APPLY_EMAIL       => $applicant->personEmail,
			                   APPLY_PHONE       => $applicant->personPhone,
			                   APPLY_CELL        => $applicant->personCell,
			                   APPLY_CURRENT     => $current,
			                   APPLY_MAJOR       => stripslashes($applicant->personMajor),
			                   APPLY_CLASS       => $applicant->getClassValue($applicant->personClass),
			                   APPLY_PREFER      => $room_prefer,
			                   APPLY_MATE_NAME   => stripslashes($applicant->mateName),
			                   APPLY_MATE_DOB    => getEnglishDate($applicant->mateBirthDate),
			                   APPLY_PREFERENCE1 => $applicant->getPreferenceValue($applicant->matchNonSmoker),
			                   APPLY_PREFERENCE2 => $applicant->getPreferenceValue($applicant->matchBedEarly),
			                   APPLY_PREFERENCE3 => $applicant->getPreferenceValue($applicant->matchGetupEarly),
			                   APPLY_PREFERENCE4 => $applicant->getPreferenceValue($applicant->matchSilenceStudy),
			                   APPLY_PREFERENCE5 => $applicant->getPreferenceValue($applicant->matchDayStudy),
			                   APPLY_CASE_NAME   => stripslashes($applicant->contactName),
			                   APPLY_CASE_RELATE => stripslashes($applicant->contactRelation),
			                   APPLY_CASE_PHONE  => $applicant->contactPhone,
			                   APPLY_CASE_ADDR   => stripslashes($applicant->contactAddress),
			                   APPLY_PERIOD      => stripslashes($period),
			                   APPLY_ROOM        => $applicant->linkRoomCode,
			                   APPLY_ROOM_INFO   => $room_info,
			                   APPLY_DATE        => getEnglishDate(substr($applicant->applyDate, 0, 10)),
			                   APPLY_SETTLE1     => $applicant->getSettleValue($applicant->settleFlag1),
			                   APPLY_SETTLE2     => $applicant->getSettleValue($applicant->settleFlag2),
			                   APPLY_SETTLE3     => "전결",
			                   APPLY_SETTLE4     => $applicant->getSettleValue($applicant->settleFlag4),
			                   APPLY_PAYMENT_YY  => date("Y"),
			                   APPLY_PAYMENT_MM  => date("m"),
			                   APPLY_PAYMENT_DD  => date("d"),
			                   APPLY_ACCOUNT     => $account,
			                   APPLY_PHOTO       => getOriginalImage("$pht_dir/$no.jpg")));

			$pay_total = 0;
			$applicant->getPaymentList($no);
			for ($i = 0; $i < count($applicant->payListNumber); $i++) {
				$pay_total += (int)$applicant->payListPrice[$i];
				if ($applicant->payListKind[$i] != "E") {
					$check = "";
					$radio = "";
				} else {
					$check = "<input type=\"checkbox\" name=\"list_no\" value=\"" . $applicant->payListNumber[$i] . "\">";
					$radio = "<input type=\"radio\" name=\"update_no\" value=\"" . $applicant->payListNumber[$i] . "\" onClick=\"showUpdateInfo(this, '" . substr($applicant->payListDate[$i], 0, 4) . "', '" . substr($applicant->payListDate[$i], 5, 2) . "', '" . substr($applicant->payListDate[$i], 8, 2) . "', '" . $applicant->payListDetail[$i] . "', '" . $applicant->payListPrice[$i] . "');\">";
				}
				$tpl->assign(array(PAYMENT_NUMBER  => $applicant->payListNumber[$i],
				                   PAYMENT_DATE    => getFullDate(substr($applicant->payListDate[$i], 0, 10)),
				                   PAYMENT_TYPE    => $applicant->getPaymentValue($applicant->payListPrice[$i]),
				                   PAYMENT_PRICE   => number_format($applicant->payListPrice[$i]),
				                   PAYMENT_DETAIL  => $applicant->getDetailValue($applicant->payListDetail[$i]),
				                   PAYMENT_CHECK   => $check,
				                   PAYMENT_RADIO   => $radio));
				$tpl->parse(PAYMENT_ROWS, ".payment_row");
			}
			$tpl->assign(PAYMENT_TOTAL, number_format($pay_total));

			$applicant->closeDatabase();
			unset($applicant);

			include_once("../common/footer_tpl.php");
		}
	}
?>