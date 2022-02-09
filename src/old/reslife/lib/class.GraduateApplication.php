<?
	include_once("class.GraduateStudent.php");

	class GraduateApplication extends GraduateStudent {
		var $rateTableName;
		var $periodTableName;
		var $roomTableName;
		var $priceTableName;
		var $preferenceTableName;
		var $paymentTableName;
		var $refundTableName;
		var $listNumber = array();
		var $listState = array();
		var $listAccount = array();
		var $listKind = array();
		var $listFirstName = array();
		var $listLastName = array();
		var $listPreferName = array();
		var $listKoreanName = array();
		var $listGender = array();
		var $listBirth = array();
		var $listNation = array();
		var $listProvince = array();
		var $listKGSP = array();
		var $listEmail = array();
		var $listPhone = array();
		var $listMobile = array();
		var $listDate = array();
		var $listCheckinDate = array();
		var $listCheckoutDate = array();
		var $listStudentNo = array();
		var $listStudentID = array();
		var $listMajor = array();
		var $listClass = array();
		var $listHomeUni = array();
		var $listHomeAddress = array();
		var $listCurrent = array();
		var $listMateName = array();
		var $listMateID = array();
		var $listMateDOB = array();
		var $listMatchLocal = array();
		var $listMatchNonSmoker = array();
		var $listMatchBedEarly = array();
		var $listMatchGetupEarly = array();
		var $listMatchSilenceStudy = array();
		var $listMatchDayStudy = array();
		var $listCaseName = array();
		var $listCaseRelate = array();
		var $listCasePhone = array();
		var $listCaseAddress = array();
		var $listRoomCode = array();
		var $listRoomPhone = array();
		var $listRoomIP = array();
		var $listPayment = array();
		var $listPreRateCode = array();
		var $listPreRateName = array();
		var $listRateCode = array();
		var $listAdmin = array();
		var $listPeriodCode = array();
		var $listPeriodName = array();
		var $listPeriodSDate = array();
		var $listPeriodEDate = array();
		var $listRoommate = array();
		var $listRoomPrefer = array();
		var $periodApply = array();
		var $periodCode = array();
		var $periodName = array();
		var $periodSDate = array();
		var $periodEDate = array();
		var $rateCode = array();
		var $rateName = array();
		var $ratePrice = array();
		var $preRateCode = array();
		var $preRateName = array();
		var $preRatePrice = array();
		var $payListNumber = array();
		var $payListPeriod = array();
		var $payListRate = array();
		var $payListRoom = array();
		var $payListStudent = array();
		var $payListName = array();
		var $payListKind = array();
		var $payListDate = array();
		var $payListPrice = array();
		var $payListDetail = array();
		var $applyNumber;
		var $applyState;
		var $applyKind;
		var $applyDate;
		var $applyCheckinDate;
		var $applyCheckoutDate;
		var $applyAdmin;
		var $applyAccount;
		var $personStudentNo;
		var $personStudentID;
		var $personFirstName;
		var $personMiddleName;
		var $personLastName;
		var $personPreferName;
		var $personKoreanName;
		var $personGender;
		var $personBirthDate;
		var $personNationality;
		var $personProvince;
		var $personKGSP;
		var $personHomeUni;
		var $personHomeAddress;
		var $personEmail;
		var $personPhone;
		var $personCell;
		var $personMajor;
		var $personClass;
		var $currentResident;
		var $roomPrefer;
		var $mateName;
		var $mateID;
		var $mateBirthDate;
		var $contactName;
		var $contactRelation;
		var $contactPhone;
		var $contactAddress;
		var $linkRoomCode;
		var $linkRoomPhone;
		var $linkRoomIP;
		var $linkRateCode;
		var $linkPeriodCode;
		var $linkPeriodName;
		var $linkPeriodSDate;
		var $linkPeriodEDate;
		var $settleFlag1;
		var $settleFlag2;
		var $settleFlag3;
		var $settleFlag4;
		var $settleDate1;
		var $settleDate2;
		var $settleDate3;
		var $settleDate4;
		var $matchLocal;
		var $matchNonSmoker;
		var $matchBedEarly;
		var $matchGetupEarly;
		var $matchSilenceStudy;
		var $matchDayStudy;
		var $applyRoommate;
		var $paymentNumber;
		var $roomListCode = array();
		var $calendarApply = array();
		var $calendarKind = array();
		var $calendarRoom = array();
		var $calendarCheckin = array();
		var $calendarCheckout = array();
		var $calendarApply1= array();
		var $calendarRoom1 = array();
		var $calendarCheckin1 = array();
		var $calendarCheckout1 = array();
		var $errorMessage;

		function GraduateApplication($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl4, $tbl5, $tbl6, $tbl7, $tbl8, $tbl9, $tbl10, $tbl11, $tbl12) {
			$this->rateTableName = $tbl4;
			$this->periodTableName = $tbl5;
			$this->roomTableName = $tbl6;
			$this->priceTableName = $tbl7;
			$this->preferenceTableName = $tbl8;
			$this->paymentTableName = $tbl9;
			$this->refundTableName = $tbl10;
			$this->GraduateStudent($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl11, $tbl12);
		}

		function getStateValue($val) {
			if ($val == "IW") $returnValue = "Application registered";
			else if ($val == "DP") $returnValue = "Deposit paid, partial";
			else if ($val == "DD") $returnValue = "Deposit paid; Processing room assignment";
			else if ($val == "RA") $returnValue = "Room Assigned; Anam Global House fee billed";
			else if ($val == "RN") $returnValue = "Room Not Assigned";
			else if ($val == "PR") $returnValue = "Anam Global House fee deferred";
			else if ($val == "FP") $returnValue = "Anam Global House fee paid, partial";
			else if ($val == "FD") $returnValue = "Anam Global House fee paid";
			else if ($val == "FS") $returnValue = "Anam Global House fee scholarship";
			else if ($val == "RR") $returnValue = "Deposit refund requested";
			else if ($val == "TR") $returnValue = "Deposit carry-forward requested";
			else if ($val == "RD") $returnValue = "Deposit refunded/processed";
			else if ($val == "CF") $returnValue = "Deposit carried forward";
			else if ($val == "CC") $returnValue = "Cancelled";
			else if ($val == "CR") $returnValue = "Cancellation Form Received - Deposit Refund Requested";
			else if ($val == "CA") $returnValue = "Cancellation Approved - Deposit Refund Processed";
			else if ($val == "ET") $returnValue = "Early Termination";
			else if ($val == "ER") $returnValue = "Early Termination - Deposit Refund Requested";
			else if ($val == "EA") $returnValue = "Early Termination Approved - Deposit Refund Processed";
			else $returnValue = "";
			return $returnValue;
		}

		function getStateValue1($val){
			if ($val == "IW") $returnValue = "입사신청";
			else if ($val == "DP") $returnValue = "보증금부분납부";
			else if ($val == "DD") $returnValue = "보증금납부";
			else if ($val == "RA") $returnValue = "호실배정";
			else if ($val == "PR") $returnValue = "납부기간연장신청";
			else if ($val == "FP") $returnValue = "기숙사비부분납부";
			else if ($val == "FD") $returnValue = "기숙사비";
			else if ($val == "FS") $returnValue = "기숙사비장학금";
			else if ($val == "RR") $returnValue = "보증금반환신청";
			else if ($val == "TR") $returnValue = "보증금이전신청";
			else if ($val == "RD") $returnValue = "보증금반환";
			else if ($val == "CF") $returnValue = "보증금이전";
			else if ($val == "CC") $returnValue = "Cancelled";
			else if ($val == "ET") $returnValue = "Early Termination";
			else $returnValue = "";
			return $returnValue;
		}

		function getDetailValue($val){
			if ($val == "DB") $returnValue = "Deposit Billed"; // +
			else if ($val == "DD") $returnValue = "Damage Deduction"; // +
			else if ($val == "DR") $returnValue = "Deposit Refund"; // +
			else if ($val == "RB") $returnValue = "Anam Global House Fee Billed"; // +
			else if ($val == "LF") $returnValue = "Late Fee"; // +
			else if ($val == "OR") $returnValue = "Overpayment Refund"; // +
			else if ($val == "OC") $returnValue = "Overpayment Carried Forward"; // +
			else if ($val == "DC") $returnValue = "Deposit Carried Forward"; // +
			else if ($val == "CF") $returnValue = "Cancellation Fee"; // +
			else if ($val == "TR") $returnValue = "Contract Cancellation - Anam Global House Fee Refund"; // +
			else if ($val == "TF") $returnValue = "Contract Cancellation Fee"; // +
			else if ($val == "BB") $returnValue = "Blanket Rental Billed"; // +
			else if ($val == "DI") $returnValue = "Initial Deposit Paid"; // -
			else if ($val == "DP") $returnValue = "Deposit Partially Paid"; // -
			else if ($val == "DF") $returnValue = "Deposit Paid"; // -
			else if ($val == "DW") $returnValue = "Deposit Payment Waived"; // -
			else if ($val == "RP") $returnValue = "Anam Global House Fee Partially Paid"; // -
			else if ($val == "RF") $returnValue = "Anam Global House Fee Paid"; // -
			else if ($val == "RW") $returnValue = "Anam Global House Fee waived"; // -
			else if ($val == "RS") $returnValue = "Anam Global House Fee Scholarship"; // -
			else if ($val == "OP") $returnValue = "Overpayment"; // -
			else if ($val == "DO") $returnValue = "Deposit Carried Over"; // -
			else if ($val == "RR") $returnValue = "Deposit Refund Requested"; // -
			else if ($val == "CR") $returnValue = "Deposit Carried Forward Requested"; // -
			else if ($val == "TQ") $returnValue = "Contract Cancellation Requested"; // -
			else if ($val == "BP") $returnValue = "Blanket Rental Paid"; // -
			else if ($val == "CI") $returnValue = "Early Check-in";
			else if ($val == "CO") $returnValue = "Late Check-out";
			else if ($val == "OO") $returnValue = "Credit Carried Over";
			else if ($val == "CC") $returnValue = "Credit Carried Forward";
			else if ($val == "CA") $returnValue = "Credit Adjustment";
			else $returnValue = "Etc.";
			return $returnValue;
		}

		function getSettleValue($val, $dt="0000-00-00") {
			if ($val == "Y") {
				$returnValue = "결재";
				if (trim($dt) != "" && trim($dt) != "0000-00-00") $returnValue .= "<br>" . substr(trim($dt), 2, 8);
			} else $returnValue = "";
			return $returnValue;
		}

		function getPreferenceValue($val){
			if ($val == "Y") $returnValue = "Yes";
			else if ($val == "N") $returnValue = "No";
			else if ($val == "M") $returnValue = "No Preference";
			else $returnValue = "";
			return $returnValue;
		}

		function getPaymentValue($val){
			if ((int)$val < 0) $returnValue = "납부";
			else $returnValue = "청구";
			return $returnValue;
		}

		function getApplicationNumber($dt) {
			$returnValue = "";
			$where = "";
			if ($dt) $where = "WHERE apply_no>$dt" . "0000";
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt FROM $this->applyTableName $where");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			$this->freeResult();
			return $returnValue;
		}

		function getApplicationPrice($rate, $period) {
			$returnValue = "0";
			$this->clearSQL();
			$this->appendSQL("SELECT price FROM $this->priceTableName WHERE rate_code='$rate' AND period_code='$period'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("price");
			$this->freeResult();
			return $returnValue;
		}

		function getWhereCondition($sdate, $edate, $stype, $stext, $rate, $state, $grade, $kind, $current, $period) {
			$list_period = "";
			if ($period) {
				$arr_temp = explode(",", $period);
				for ($i = 0; $i < count($arr_temp); $i++) {
					$list_period .= "'" . $arr_temp[$i] . "',";
				}
				if ($list_period) $list_period = substr($list_period, 0, strlen($list_period) - 1);
			}
			$returnValue = "";
			if ($kind) {
				if ($returnValue) $returnValue .= " AND e.kind='$kind'";
				else $returnValue .= " WHERE e.kind='$kind'";
			}
			if ($rate) {
				if ($returnValue) $returnValue .= " AND (a.rate_code='$rate' OR f.rate_code='$rate')";
				else $returnValue .= " WHERE (a.rate_code='$rate' OR f.rate_code='$rate')";
			}
			if ($state) {
				if ($returnValue) $returnValue .= " AND state='$state'";
				else $returnValue .= " WHERE state='$state'";
			}
			if ($grade == "0") {
				if ($returnValue) $returnValue .= " AND settle1='N' AND settle2='N' AND settle3='N' AND settle4='N'";
				else $returnValue .= " WHERE settle1='N' AND settle2='N' AND settle3='N' AND settle4='N'";
			} else if ($grade == "1") {
				if ($returnValue) $returnValue .= " AND settle1='Y' AND settle2='N' AND settle3='N' AND settle4='N'";
				else $returnValue .= " WHERE settle1='Y' AND settle2='N' AND settle3='N' AND settle4='N'";
			} else if ($grade == "2") {
				if ($returnValue) $returnValue .= " AND settle1='Y' AND settle2='Y' AND settle3='N' AND settle4='N'";
				else $returnValue .= " WHERE settle1='Y' AND settle2='Y' AND settle3='N' AND settle4='N'";
			} else if ($grade == "3") {
				if ($returnValue) $returnValue .= " AND settle1='Y' AND settle2='Y' AND settle3='Y' AND settle4='N'";
				else $returnValue .= " WHERE settle1='Y' AND settle2='Y' AND settle3='Y' AND settle4='N'";
			} else if ($grade == "4") {
				if ($returnValue) $returnValue .= " AND settle1='Y' AND settle2='Y' AND settle3='Y' AND settle4='Y'";
				else $returnValue .= " WHERE settle1='Y' AND settle2='Y' AND settle3='Y' AND settle4='Y'";
			}
			if ($current) {
				if ($returnValue) $returnValue .= " AND e.current='$current'";
				else $returnValue .= " WHERE e.current='$current'";
			}
			if ($list_period) {
				if ($returnValue) $returnValue .= " AND a.period_code IN ($list_period)";
				else $returnValue .= " WHERE a.period_code IN ($list_period)";
			}
			if ($sdate && $edate) {
				if ($returnValue) $returnValue .= " AND ((checkin_dt>='$sdate' AND checkin_dt<='$edate') OR (checkout_dt>'$sdate' AND checkout_dt<='$edate') OR (checkin_dt<'$sdate' AND checkout_dt>'$edate'))";
				else $returnValue .= " WHERE ((checkin_dt>='$sdate' AND checkin_dt<='$edate') OR (checkout_dt>'$sdate' AND checkout_dt<='$edate') OR (checkin_dt<'$sdate' AND checkout_dt>'$edate'))";
			} else if ($sdate) {
				if ($returnValue) $returnValue .= " AND ((checkin_dt>='$sdate' AND checkin_dt<='2100-12-31') OR (checkout_dt>'$sdate' AND checkout_dt<='2100-12-31') OR (checkin_dt<'$sdate' AND checkout_dt>'2100-12-31'))";
				else $returnValue .= " WHERE ((checkin_dt>='$sdate' AND checkin_dt<='2100-12-31') OR (checkout_dt>'$sdate' AND checkout_dt<='2100-12-31') OR (checkin_dt<'$sdate' AND checkout_dt>'2100-12-31'))";
			} else if ($edate) {
				if ($returnValue) $returnValue .= " AND ((checkin_dt>='1900-01-01' AND checkin_dt<='$edate') OR (checkout_dt>'1900-01-01' AND checkout_dt<='$edate') OR (checkin_dt<'1900-01-01' AND checkout_dt>'$edate'))";
				else $returnValue .= " WHERE ((checkin_dt>='1900-01-01' AND checkin_dt<='$edate') OR (checkout_dt>'1900-01-01' AND checkout_dt<='$edate') OR (checkin_dt<'1900-01-01' AND checkout_dt>'$edate'))";
			}
			if (trim($stext) == "") $stype = "0";
			switch ($stype) {
				case "1":
					if ($returnValue) $returnValue .= " AND a.email LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE a.email LIKE '%" . $stext . "%'";
					break;
				case "2":
					if ($returnValue) $returnValue .= " AND (e.fname LIKE '%" . $stext . "%' OR e.mname LIKE '%" . $stext . "%' OR e.lname LIKE '%" . $stext . "%' OR e.prefer LIKE '%" . $stext . "%')";
					else $returnValue .= " WHERE (e.fname LIKE '%" . $stext . "%' OR e.mname LIKE '%" . $stext . "%' OR e.lname LIKE '%" . $stext . "%' OR e.prefer LIKE '%" . $stext . "%')";
					break;
				case "3":
					if ($returnValue) $returnValue .= " AND a.apply_no LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE a.apply_no LIKE '%" . $stext . "%'";
					break;
				case "4":
					if ($returnValue) $returnValue .= " AND e.student_id LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE e.student_id LIKE '%" . $stext . "%'";
					break;
				case "5":
					if ($returnValue) $returnValue .= " AND a.room_code LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE a.room_code LIKE '%" . $stext . "%'";
					break;
				case "6":
					if ($returnValue) $returnValue .= " AND REPLACE(e.account,'-','') LIKE '%" . ereg_replace('-', '', $stext) . "%'";
					else $returnValue .= " WHERE REPLACE(e.account,'-','') LIKE '%" . ereg_replace('-', '', $stext) . "%'";
					break;
			}
			return $returnValue;
		}

		function getApplicationCondition($sdate, $edate, $stype, $stext, $rate, $state, $grade, $kind, $current, $period) {
			$returnValue = "FROM $this->applyTableName a LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code ";
			$returnValue .= "LEFT JOIN $this->roomTableName c ON a.room_code=c.room_code LEFT JOIN $this->paymentTableName d ON a.apply_no=d.apply_no ";
			$returnValue .= "LEFT JOIN $this->studentTableName e ON a.email=e.email ";
			$returnValue .= "LEFT JOIN $this->preferenceTableName f ON a.apply_no=f.apply_no AND pre_no=1 ";
			$returnValue .= "LEFT JOIN $this->rateTableName g ON f.rate_code=g.rate_code ";
			$returnValue .= "LEFT JOIN $this->priceTableName h ON a.rate_code=h.rate_code AND a.period_code=h.period_code";
			$returnValue .= $this->getWhereCondition($sdate, $edate, $stype, $stext, $rate, $state, $grade, $kind, $current, $period);
			$returnValue .= " GROUP BY a.apply_no";
			return $returnValue;
		}

		function getApplicationCount($sdate, $edate, $stype, $stext, $rate, $state, $grade, $kind, $current, $period) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(a.apply_no) AS cnt " . $this->getApplicationCondition($sdate, $edate, $stype, $stext, $rate, $state, $grade, $kind, $current, $period));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getNumberRows();
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getApplicationList($sdate, $edate, $start, $size, $stype, $stext, $rate, $state, $grade, $kind, $current, $period, $sort) {
			if ($sort == "") $sort = " ORDER BY apply_date DESC";
			else $sort = " ORDER BY $sort";
			if ($start != "" || $start == "0") $limit = " LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT a.apply_no, info_no, e.student_id, e.fname, e.mname, e.lname, e.gender, e.dob, e.email, apply_date, e.nationality, e.province, e.kgsp, e.current, state, b.name, ");
			$this->appendSQL("a.room_code, f.rate_code, g.name, SUM(d.price) pay_pr " . $this->getApplicationCondition($sdate, $edate, $stype, $stext, $rate, $state, $grade, $kind, $current, $period) . $sort . $limit);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->listNumber[$cnt] = $this->getField("apply_no");
				$this->listStudentNo[$cnt] = $this->getField("info_no");
				$this->listStudentID[$cnt] = $this->getField("student_id");
				$this->listFirstName[$cnt] = $this->getField("fname") . " " . $this->getField("mname");
				$this->listLastName[$cnt] = $this->getField("lname");
				$this->listGender[$cnt] = $this->getField("gender");
				$this->listBirth[$cnt] = $this->getField("dob");
				$this->listEmail[$cnt] = $this->getField("email");
				$this->listDate[$cnt] = $this->getField("apply_date");
				$this->listCurrent[$cnt] = $this->getField("current");
				$this->listNation[$cnt] = $this->getField("nationality");
				$this->listProvince[$cnt] = $this->getField("province");
				$this->listKGSP[$cnt] = $this->getField("kgsp");
				$this->listState[$cnt] = $this->getField("state");
				$this->listPeriodName[$cnt] = $this->getField("name");
				$this->listRoomCode[$cnt] = $this->getField("a.room_code");
				$this->listPayment[$cnt] = $this->getField("pay_pr");
				$this->listPreRateCode[$cnt] = $this->getField("f.rate_code");
				$this->listPreRateName[$cnt] = $this->getField("g.name");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getPeriodList() {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->periodTableName ORDER BY order_no");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->periodCode[$cnt] = $this->getField("period_code");
				$this->periodName[$cnt] = $this->getField("name");
				$this->periodSDate[$cnt] = $this->getField("sdate");
				$this->periodEDate[$cnt] = $this->getField("edate");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getPeriodList1($no, $email, $date) {
			$this->periodApply = null;
			$this->periodName = null;
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no, name FROM $this->applyTableName a LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code ");
			$this->appendSQL("WHERE apply_no<>'$no' AND email='$email' AND sdate>='$date' ORDER BY apply_no DESC");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->periodApply[$cnt] = $this->getField("apply_no");
				$this->periodName[$cnt] = $this->getField("name");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getRateList($period) {
			$this->clearSQL();
			$this->appendSQL("SELECT a.rate_code, a.name rate_nm, b.price FROM $this->rateTableName a LEFT JOIN $this->priceTableName b ON a.rate_code=b.rate_code ");
			$this->appendSQL("LEFT JOIN $this->periodTableName c ON b.period_code=c.period_code WHERE c.period_code='$period' ORDER BY a.order_no");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->rateCode[$cnt] = $this->getField("rate_code");
				$this->rateName[$cnt] = $this->getField("rate_nm");
				$this->ratePrice[$cnt] = $this->getField("price");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getRateList1() {
			$this->clearSQL();
			$this->appendSQL("SELECT rate_code, name FROM $this->rateTableName ORDER BY order_no");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->rateCode[$cnt] = $this->getField("rate_code");
				$this->rateName[$cnt] = $this->getField("name");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getPreferenceList($no, $period) {
			$this->preRateCode = null;
			$this->preRateName = null;
			$this->preRatePrice = null;
			$this->clearSQL();
			$this->appendSQL("SELECT a.rate_code, b.name, c.price FROM $this->preferenceTableName a ");
			$this->appendSQL("LEFT JOIN $this->rateTableName b ON a.rate_code=b.rate_code LEFT JOIN $this->priceTableName c ");
			$this->appendSQL("ON a.rate_code=c.rate_code AND c.period_code='$period' WHERE apply_no='$no' ORDER BY pre_no");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->preRateCode[$cnt] = $this->getField("rate_code");
				$this->preRateName[$cnt] = $this->getField("name");
				$this->preRatePrice[$cnt] = $this->getField("price");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getRoomList($rate="") {
			$this->clearSQL();
			$this->appendSQL("SELECT room_code FROM $this->roomTableName WHERE rate_code LIKE 'G_%' ");
			if ($rate) $this->appendSQL("AND rate_code='$rate' ");
			$this->appendSQL("ORDER BY room_code");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->roomListCode[$cnt] = $this->getField("room_code");
				$cnt++;
				$this->setNextRecord();
			}
			$this->freeResult();
		}

		function getCalendarList($rate, $sdt, $edt) {
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no, room_code, checkin_dt, checkout_dt FROM $this->applyTableName WHERE state NOT IN ('CC','CR','CA') AND room_code<>'' AND ");
			$this->appendSQL("((checkin_dt>='$sdt' AND checkin_dt<='$edt') OR (checkout_dt>'$sdt' AND checkout_dt<='$edt') OR (checkin_dt<'$sdt' AND checkout_dt>'$edt')) ");
			if ($rate) $this->appendSQL("AND rate_code='$rate' ");
			$this->appendSQL("ORDER BY room_code, checkin_dt");
			$this->parseQuery();
			$cnt = 0; 
			while (!$this->EOF) {
				$this->calendarApply[$cnt] = $this->getField("apply_no");
				$this->calendarKind[$cnt] = "graduate";
				$this->calendarRoom[$cnt] = $this->getField("room_code");
				$this->calendarCheckin[$cnt] = $this->getField("checkin_dt");
				$this->calendarCheckout[$cnt] = $this->getField("checkout_dt");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getDepositPaidDate($no) {
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT MIN(pay_dt) paid_dt FROM $this->paymentTableName WHERE pay_kind IN ('DP','DF','DO') AND apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("paid_dt");
			$this->freeResult();
			return $returnValue;
		}

		function getDepositPaidAmount($no) {
			$returnValue = "0";
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) AS paid FROM $this->paymentTableName WHERE pay_kind IN ('DF','DP','DW','DO','OP','OR','OC','DC','DR','DD','CF','CO') AND apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = abs($this->getField("paid"));
			$this->freeResult();
			return $returnValue;
		}

		function getResidencePaidAmount($no) {
			$returnValue = "0";
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) AS paid FROM $this->paymentTableName WHERE pay_kind IN ('RB','CI','LF','BB','RF','RP','RS','RW','BP','OO','CC','CA') AND apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("paid");
			$this->freeResult();
			return $returnValue;
		}

		function getPaymentList($no) {
			$this->payListNumber = null;
			$this->payListKind = null;
			$this->payListDate = null;
			$this->payListPrice = null;
			$this->payListDetail = null;
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->paymentTableName WHERE apply_no='$no' ORDER BY pay_dt");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->payListNumber[$cnt] = $this->getField("pay_no");
				$this->payListKind[$cnt] = $this->getField("kind");
				$this->payListDate[$cnt] = $this->getField("pay_dt");
				$this->payListPrice[$cnt] = $this->getField("price");
				$this->payListDetail[$cnt] = $this->getField("pay_kind");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getPaymentList1($no) {
			$this->payListNumber = null;
			$this->payListKind = null;
			$this->payListDate = null;
			$this->payListPrice = null;
			$this->payListDetail = null;
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->paymentTableName WHERE pay_kind IN ('DB','DI','DP','DF','DW','OP','OR','OC','CR','RR','DD','CF','CO','DC','DR','DO') AND apply_no='$no' ORDER BY pay_dt");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->payListNumber[$cnt] = $this->getField("pay_no");
				$this->payListKind[$cnt] = $this->getField("kind");
				$this->payListDate[$cnt] = $this->getField("pay_dt");
				$this->payListPrice[$cnt] = $this->getField("price");
				$this->payListDetail[$cnt] = $this->getField("pay_kind");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getPaymentList2($no) {
			$this->payListNumber = null;
			$this->payListKind = null;
			$this->payListDate = null;
			$this->payListPrice = null;
			$this->payListDetail = null;
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->paymentTableName WHERE pay_kind NOT IN ('DB','DI','DP','DF','DW','OP','OR','OC','CR','RR','DD','CF','CO','DC','DR','DO') AND apply_no='$no' ORDER BY pay_dt");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->payListNumber[$cnt] = $this->getField("pay_no");
				$this->payListKind[$cnt] = $this->getField("kind");
				$this->payListDate[$cnt] = $this->getField("pay_dt");
				$this->payListPrice[$cnt] = $this->getField("price");
				$this->payListDetail[$cnt] = $this->getField("pay_kind");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getDepositReceipt($no) {
			$this->payListNumber = null;
			$this->payListDate = null;
			$this->payListPrice = null;
			$this->payListDetail = null;
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->paymentTableName WHERE pay_kind IN ('DB','DI','DP','DF','DW','OP','OR','OC','CR','RR','DD','CF','CO','DC','DR','DO') AND apply_no='$no' ORDER BY pay_dt");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->payListNumber[$cnt] = $this->getField("pay_no");
				$this->payListDate[$cnt] = $this->getField("pay_dt");
				$this->payListPrice[$cnt] = $this->getField("price");
				$this->payListDetail[$cnt] = $this->getField("pay_kind");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getHallReceipt($no) {
			$this->payListNumber = null;
			$this->payListDate = null;
			$this->payListPrice = null;
			$this->payListDetail = null;
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->paymentTableName WHERE pay_kind NOT IN ('DB','DI','DP','DF','DW','OP','OR','OC','CR','RR','DD','CF','CO','DC','DR','DO') AND apply_no='$no' ORDER BY pay_dt");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->payListNumber[$cnt] = $this->getField("pay_no");
				$this->payListDate[$cnt] = $this->getField("pay_dt");
				$this->payListPrice[$cnt] = $this->getField("price");
				$this->payListDetail[$cnt] = $this->getField("pay_kind");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getExcelList($sdate, $edate, $stype, $stext, $rate, $state, $grade, $kind, $current, $period, $sort) {
			if ($sort == "") $sort = " ORDER BY apply_date DESC";
			else $sort = " ORDER BY $sort";
			$this->clearSQL();
			$this->appendSQL("SELECT a.apply_no, info_no, state, e.account, e.kind, e.fname, e.mname, e.lname, e.prefer, e.name_kr, e.gender, e.dob, e.nationality, e.province, e.kgsp, e.email, e.phone, e.cell, ");
			$this->appendSQL("apply_date, checkin_dt, checkout_dt, e.student_id, e.major, e.class, e.home_uni, e.home_addr, e.home_addr1, e.home_addr2, e.home_city, e.home_state, e.home_postal, e.home_country, e.current, mate_name, mate_id, mate_dob, match_local, match_nosmoke, ");
			$this->appendSQL("match_bed, match_getup, match_silence, match_study, e.case_name, e.case_relate, e.case_phone, e.case_addr, a.room_code, ph, ip, ");
			$this->appendSQL("a.period_code, b.name, b.sdate, b.edate, roommate, room_prefer, a.rate_code, a.admin, SUM(d.price) pay_pr ");
			$this->appendSQL($this->getApplicationCondition($sdate, $edate, $stype, $stext, $rate, $state, $grade, $kind, $current, $period) . $sort);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->listNumber[$cnt] = $this->getField("apply_no");
				$this->listStudentNo[$cnt] = $this->getField("info_no");
				$this->listState[$cnt] = $this->getField("state");
				$this->listAccount[$cnt] = $this->getField("account");
				$this->listKind[$cnt] = $this->getField("kind");
				$this->listFirstName[$cnt] = $this->getField("fname") . " " . $this->getField("mname");
				$this->listLastName[$cnt] = $this->getField("lname");
				$this->listPreferName[$cnt] = $this->getField("prefer");
				$this->listKoreanName[$cnt] = $this->getField("name_kr");
				$this->listGender[$cnt] = $this->getField("gender");
				$this->listBirth[$cnt] = $this->getField("dob");
				$this->listNation[$cnt] = $this->getField("nationality");
				$this->listProvince[$cnt] = $this->getField("province");
				$this->listKGSP[$cnt] = $this->getField("kgsp");
				$this->listEmail[$cnt] = $this->getField("email");
				$this->listPhone[$cnt] = $this->getField("phone");
				$this->listMobile[$cnt] = $this->getField("cell");
				$this->listDate[$cnt] = $this->getField("apply_date");
				$this->listCheckinDate[$cnt] = $this->getField("checkin_dt");
				$this->listCheckoutDate[$cnt] = $this->getField("checkout_dt");
				$this->listStudentID[$cnt] = $this->getField("student_id");
				$this->listMajor[$cnt] = $this->getField("major");
				$this->listClass[$cnt] = $this->getField("class");
				$this->listHomeUni[$cnt] = $this->getField("home_uni");
				$this->listHomeAddress[$cnt] = $this->getField("home_addr");
				if ($this->getField("home_addr1")) $this->listHomeAddress[$cnt] .= ", " . $this->getField("home_addr1");
				if ($this->getField("home_addr2")) $this->listHomeAddress[$cnt] .= ", " . $this->getField("home_addr2");
				if ($this->getField("home_city")) $this->listHomeAddress[$cnt] .= ", " . $this->getField("home_city");
				if ($this->getField("home_state")) $this->listHomeAddress[$cnt] .= ", " . $this->getField("home_state");
				if ($this->getField("home_country")) $this->listHomeAddress[$cnt] .= ", " . $this->getField("home_country");
				if ($this->getField("home_postal")) $this->listHomeAddress[$cnt] .= " [" . $this->getField("home_postal") . "]";
				$this->listCurrent[$cnt] = $this->getField("current");
				$this->listMateName[$cnt] = $this->getField("mate_name");
				$this->listMateID[$cnt] = $this->getField("mate_id");
				$this->listMateDOB[$cnt] = $this->getField("mate_dob");
				$this->listMatchLocal[$cnt] = $this->getField("match_local");
				$this->listMatchNonSmoker[$cnt] = $this->getField("match_nosmoke");
				$this->listMatchBedEarly[$cnt] = $this->getField("match_bed");
				$this->listMatchGetupEarly[$cnt] = $this->getField("match_getup");
				$this->listMatchSilenceStudy[$cnt] = $this->getField("match_silence");
				$this->listMatchDayStudy[$cnt] = $this->getField("match_study");
				$this->listCaseName[$cnt] = $this->getField("case_name");
				$this->listCaseRelate[$cnt] = $this->getField("case_relate");
				$this->listCasePhone[$cnt] = $this->getField("case_phone");
				$this->listCaseAddress[$cnt] = $this->getField("case_addr");
				$this->listRoomCode[$cnt] = $this->getField("a.room_code");
				$this->listRoomPhone[$cnt] = $this->getField("ph");
				$this->listRoomIP[$cnt] = $this->getField("ip");
				$this->listPeriodCode[$cnt] = $this->getField("a.period_code");
				$this->listPeriodName[$cnt] = $this->getField("b.name");
				$this->listPeriodSDate[$cnt] = $this->getField("sdate");
				$this->listPeriodEDate[$cnt] = $this->getField("edate");
				$this->listRoommate[$cnt] = $this->getField("roommate");
				$this->listRoomPrefer[$cnt] = $this->getField("room_prefer");
				$this->listPayment[$cnt] = $this->getField("pay_pr");
				$this->listRateCode[$cnt] = $this->getField("a.rate_code");
				$this->listAdmin[$cnt] = $this->getField("a.admin");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getExcelList1($sdate, $edate, $stype, $stext, $rate, $state, $grade, $kind, $current, $period, $sort) {
			if ($sort == "") $sort = " ORDER BY apply_date DESC, pay_dt";
			else $sort = " ORDER BY $sort, pay_dt";
			$this->clearSQL();
			$this->appendSQL("SELECT a.apply_no, e.account, a.period_code, a.rate_code, a.room_code, e.student_id, e.lname, e.fname, e.mname, pay_dt, pay_kind, d.price ");
			$this->appendSQL("FROM $this->applyTableName a, $this->paymentTableName d LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code ");
			$this->appendSQL("LEFT JOIN $this->roomTableName c ON a.room_code=c.room_code LEFT JOIN $this->studentTableName e ON a.email=e.email ");
			$this->appendSQL("LEFT JOIN $this->preferenceTableName f ON a.apply_no=f.apply_no AND pre_no=1 ");
			$this->appendSQL("LEFT JOIN $this->rateTableName g ON f.rate_code=g.rate_code");
			$this->appendSQL($this->getWhereCondition($sdate, $edate, $stype, $stext, $rate, $state, $grade, $kind, $current, $period) . " AND a.apply_no=d.apply_no " . $sort);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->payListNumber[$cnt] = $this->getField("apply_no");
				$this->listAccount[$cnt] = $this->getField("account");
				$this->payListPeriod[$cnt] = $this->getField("period_code");
				$this->payListRate[$cnt] = $this->getField("rate_code");
				$this->payListRoom[$cnt] = $this->getField("room_code");
				$this->payListStudent[$cnt] = $this->getField("student_id");
				$this->payListName[$cnt] = $this->getField("lname") . ", " . $this->getField("fname") . " " . $this->getField("mname");
				$this->payListDate[$cnt] = $this->getField("pay_dt");
				$this->payListPrice[$cnt] = $this->getField("price");
				$this->payListDetail[$cnt] = $this->getField("pay_kind");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getApplicationInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->applyTableName a LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code ");
			$this->appendSQL("LEFT JOIN $this->roomTableName c ON a.room_code=c.room_code LEFT JOIN $this->studentTableName d ON a.email=d.email LEFT JOIN $this->rateTableName e ON a.rate_code=e.rate_code LEFT JOIN $this->priceTableName f ON a.rate_code=f.rate_code AND a.period_code=f.period_code WHERE apply_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->applyNumber = $this->getField("apply_no");
				$this->applyState = $this->getField("state");
				$this->applyKind = $this->getField("d.kind");
				$this->applyDate = $this->getField("apply_date");
				$this->applyCheckinDate = $this->getField("checkin_dt");
				$this->applyCheckoutDate = $this->getField("checkout_dt");
				$this->applyAccount = $this->getField("d.account");
				$this->applyAdmin = $this->getField("a.admin");
				$this->personStudentNo = $this->getField("info_no");
				$this->personStudentID = $this->getField("d.student_id");
				$this->personFirstName = $this->getField("d.fname");
				$this->personMiddleName = $this->getField("d.mname");
				$this->personLastName = $this->getField("d.lname");
				$this->personPreferName = $this->getField("d.prefer");
				$this->personKoreanName = $this->getField("d.name_kr");
				$this->personGender = $this->getField("d.gender");
				$this->personBirthDate = $this->getField("d.dob");
				$this->personNationality = $this->getField("d.nationality");
				$this->personProvince = $this->getField("d.province");
				$this->personKGSP = $this->getField("d.kgsp");
				$this->personHomeUni = $this->getField("d.home_uni");
				$this->personHomeAddress = $this->getField("d.home_addr");
				if ($this->getField("d.home_addr1")) $this->personHomeAddress .= ", " . $this->getField("d.home_addr1");
				if ($this->getField("d.home_addr2")) $this->personHomeAddress .= ", " . $this->getField("d.home_addr2");
				if ($this->getField("d.home_city")) $this->personHomeAddress .= ", " . $this->getField("d.home_city");
				if ($this->getField("d.home_state")) $this->personHomeAddress .= ", " . $this->getField("d.home_state");
				if ($this->getField("d.home_country")) $this->personHomeAddress .= ", " . $this->getField("d.home_country");
				if ($this->getField("d.home_postal")) $this->personHomeAddress .= " [" . $this->getField("d.home_postal") . "]";
				$this->personEmail = $this->getField("d.email");
				$this->personPhone = $this->getField("d.phone");
				$this->personCell = $this->getField("d.cell");
				$this->personMajor = $this->getField("d.major");
				$this->personClass = $this->getField("d.class");
				$this->currentResident = $this->getField("d.current");
				$this->roomPrefer = $this->getField("room_prefer");
				$this->mateName = $this->getField("mate_name");
				$this->mateID = $this->getField("mate_id");
				$this->mateBirthDate = $this->getField("mate_dob");
				$this->matchLocal = $this->getField("match_local");
				$this->matchNonSmoker = $this->getField("match_nosmoke");
				$this->matchBedEarly = $this->getField("match_bed");
				$this->matchGetupEarly = $this->getField("match_getup");
				$this->matchSilenceStudy = $this->getField("match_silence");
				$this->matchDayStudy = $this->getField("match_study");
				$this->contactName = $this->getField("d.case_name");
				$this->contactRelation = $this->getField("d.case_relate");
				$this->contactPhone = $this->getField("d.case_phone");
				$this->contactAddress = $this->getField("d.case_addr");
				$this->linkRoomCode = $this->getField("a.room_code");
				$this->linkRoomPhone = $this->getField("ph");
				$this->linkRoomIP = $this->getField("ip");
				$this->linkRateCode = $this->getField("a.rate_code");
				$this->linkPeriodCode = $this->getField("a.period_code");
				$this->linkPeriodName = $this->getField("b.name");
				$this->linkPeriodSDate = $this->getField("sdate");
				$this->linkPeriodEDate = $this->getField("edate");
				$this->settleFlag1 = $this->getField("settle1");
				$this->settleFlag2 = $this->getField("settle2");
				$this->settleFlag3 = $this->getField("settle3");
				$this->settleFlag4 = $this->getField("settle4");
				$this->settleDate1 = $this->getField("settle1_dt");
				$this->settleDate2 = $this->getField("settle2_dt");
				$this->settleDate3 = $this->getField("settle3_dt");
				$this->settleDate4 = $this->getField("settle4_dt");
				$this->applyRoommate = $this->getField("roommate");
			}
			$this->freeResult();
		}

		function getCheckinDate($period) {
			$returnValue = "0000-00-00";
			$this->clearSQL();
			$this->appendSQL("SELECT sdate FROM $this->periodTableName WHERE period_code='$period'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("sdate");
			$this->freeResult();
			return $returnValue;
		}

		function getCheckoutDate($period) {
			$returnValue = "0000-00-00";
			$this->clearSQL();
			$this->appendSQL("SELECT edate FROM $this->periodTableName WHERE period_code='$period'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("edate");
			$this->freeResult();
			return $returnValue;
		}

		function insertApplication($no, $email, $state, $acc, $room_prefer, $mate_nm, $mate_id, $mate_dob, $pre1, $pre2, $pre3, $pre4, $pre5, $pre6, $checkin, $checkout, $period, $stt1, $stt2, $stt3, $stt4, $roommate, $admin) {
			global $ihouse_admin_info;
			if (!checkdate((int)substr($checkin, 5, 2), (int)substr($checkin, 8, 2), (int)substr($checkin, 0, 4))) $checkin = $this->getCheckinDate($period);
			if (!checkdate((int)substr($checkout, 5, 2), (int)substr($checkout, 8, 2), (int)substr($checkout, 0, 4))) $checkout = $this->getCheckoutDate($period);
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->applyTableName (apply_no, email, state, account, room_prefer, mate_name, mate_id, mate_dob, match_nosmoke, match_bed, match_getup, match_silence, match_study, match_local, apply_date, checkin_dt, checkout_dt, period_code, settle1, settle2, settle3, settle4, roommate, admin)");
			$this->appendSQL("VALUES ('$no', '$email', '$state', '$acc', '$room_prefer', '$mate_nm', '$mate_id', '$mate_dob', '$pre1', '$pre2', '$pre3', '$pre4', '$pre5', '$pre6', now(), '$checkin', '$checkout', '$period', '$stt1', '$stt2', '$stt3', '$stt4', '$roommate', '$admin')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->applyNumber = $this->getInsertID();
				/*
				$acc_no = "";
				$this->clearSQL();
				$this->appendSQL("SELECT acc_no FROM $this->accountTableName WHERE use_flag='N' LIMIT 0, 1");
				$this->parseQuery();
				if (!$this->EOF) $acc_no = $this->getField("acc_no");
				$this->freeResult();
				$acc_flag = true;
				$this->clearSQL();
				$this->appendSQL("SELECT account FROM $this->studentTableName WHERE email='$email'");
				$this->parseQuery();
				if (!$this->EOF && $this->getField("account")) $acc_flag = false;
				$this->freeResult();
				if ($acc_flag && $acc_no) {
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->studentTableName SET account='$acc_no' WHERE email='$email'");
					$returnValue = $this->execQuery();
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->accountTableName SET use_flag='Y', use_dt=now() WHERE acc_no='$acc_no'");
					$returnValue = $this->execQuery();
				}
				*/
				$no = $this->applyNumber;
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$no 온라인지원 정보 추가";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'P', 'A', 'N', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function insertApplication1($no, $email, $state, $acc, $room_prefer, $mate_nm, $mate_id, $mate_dob, $pre1, $pre2, $pre3, $pre4, $pre5, $pre6, $checkin, $checkout, $period, $rate, $room, $roommate, $admin) {
			global $ihouse_admin_info;
			if (!checkdate((int)substr($checkin, 5, 2), (int)substr($checkin, 8, 2), (int)substr($checkin, 0, 4))) $checkin = $this->getCheckinDate($period);
			if (!checkdate((int)substr($checkout, 5, 2), (int)substr($checkout, 8, 2), (int)substr($checkout, 0, 4))) $checkout = $this->getCheckoutDate($period);
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->applyTableName (apply_no, email, state, account, room_prefer, mate_name, mate_id, mate_dob, match_nosmoke, match_bed, match_getup, match_silence, match_study, match_local, apply_date, assign_date, checkin_dt, checkout_dt, period_code, rate_code, room_code, roommate, admin)");
			$this->appendSQL("VALUES ('$no', '$email', '$state', '$acc', '$room_prefer', '$mate_nm', '$mate_id', '$mate_dob', '$pre1', '$pre2', '$pre3', '$pre4', '$pre5', '$pre6', now(), now(), '$checkin', '$checkout', '$period', '$rate', '$room', '$roommate', '$admin')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->applyNumber = $this->getInsertID();
				$no = $this->applyNumber;
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$no 온라인지원 정보 추가";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'P', 'A', 'N', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function insertPreference($rate, $apply) {
			$returnValue = true;
			$temp_rate = explode(",", $rate);
			for ($i = 0; $i < count($temp_rate); $i++) {
				if (trim($temp_rate[$i])) {
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->preferenceTableName (rate_code, apply_no, pre_no) VALUES ('" . $temp_rate[$i] . "', '$apply', " . ($i + 1) . ")");
					$returnValue = $this->execQuery();
					if (!$returnValue) break;
				}
			}
			return $returnValue;
		}

		function copyApplication($no, $checkin, $checkout, $period) {
			global $ihouse_admin_info;
			if (!checkdate((int)substr($checkin, 5, 2), (int)substr($checkin, 8, 2), (int)substr($checkin, 0, 4))) $checkin = $this->getCheckinDate($period);
			if (!checkdate((int)substr($checkout, 5, 2), (int)substr($checkout, 8, 2), (int)substr($checkout, 0, 4))) $checkout = $this->getCheckoutDate($period);
			if (!$this->getApplicationNumber(date("Y").date("m"))) $app_no = date("Y"). date("m") . "0001";
			else $app_no = "";
			$this->getApplicationInfo($no);
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->applyTableName (apply_no, email, room_prefer, mate_name, mate_id, mate_dob, match_nosmoke, match_bed, match_getup, match_silence, match_study, match_local, apply_date, room_code, checkin_dt, checkout_dt, period_code, roommate)");
			$this->appendSQL("VALUES ('$app_no', '" . $this->personEmail . "', '" . $this->roomPrefer . "', '" . $this->mateName . "', '" . $this->mateID . "', '" . $this->mateBirthDate . "', '" . $this->matchNonSmoker . "', '" . $this->matchBedEarly . "', '" . $this->matchGetupEarly . "', '" . $this->matchSilenceStudy . "', '" . $this->matchDayStudy . "', '" . $this->matchLocal . "', now(), '" . $this->linkRoomCode . "', '$checkin', '$checkout', '$period', '" . $this->applyRoommate . "')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->applyNumber = $this->getInsertID();
				$new_no = $this->applyNumber;
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$new_no 온라인지원 정보 추가 ($no 지원 복사)";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'P', 'A', 'N', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function updateApplication($no, $email, $rate, $state, $acc, $room_prefer, $mate_nm, $mate_id, $mate_dob, $pre1, $pre2, $pre3, $pre4, $pre5, $pre6, $checkin, $checkout, $period, $stt1, $stt2, $stt3, $stt4, $roommate, $admin) {
			global $ihouse_admin_info;
			if (!checkdate((int)substr($checkin, 5, 2), (int)substr($checkin, 8, 2), (int)substr($checkin, 0, 4))) $checkin = $this->getCheckinDate($period);
			if (!checkdate((int)substr($checkout, 5, 2), (int)substr($checkout, 8, 2), (int)substr($checkout, 0, 4))) $checkout = $this->getCheckoutDate($period);
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->applyTableName SET email='$email', rate_code='$rate', state='$state', account='$acc', room_prefer='$room_prefer', ");
			$this->appendSQL("mate_name='$mate_nm', mate_id='$mate_id', mate_dob='$mate_dob', match_nosmoke='$pre1', match_bed='$pre2', match_getup='$pre3', match_silence='$pre4', ");
			$this->appendSQL("match_study='$pre5', match_local='$pre6', checkin_dt='$checkin', checkout_dt='$checkout', period_code='$period', settle1='$stt1', settle2='$stt2', settle3='$stt3', settle4='$stt4', ");
			$this->appendSQL("roommate='$roommate', admin='$admin' WHERE apply_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$no 온라인지원 정보 수정";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'P', 'A', 'E', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function updateApplicationState($no, $state) {
			$returnValue = false;
			if ($state) {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->applyTableName SET state='$state' WHERE apply_no=$no");
				$returnValue = $this->execQuery();
			}
			return $returnValue;
		}

		function isRoomExist($no, $room) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->applyTableName WHERE apply_no='$no' AND room_code='$room'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = true;
			$this->freeResult();
			return $returnValue;
		}

		function isRoomAvailable($no, $room) {
			$returnValue = true;
			$arrival = "";
			$departure = "";
			$this->clearSQL();
			$this->appendSQL("SELECT checkin_dt, checkout_dt FROM $this->applyTableName WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) {
				$arrival = $this->getField("checkin_dt");
				$departure = $this->getField("checkout_dt");
			}
			$this->freeResult();
			if ($arrival && $departure) {
				$this->clearSQL();
				$this->appendSQL("SELECT apply_no FROM $this->applyTableName a WHERE a.apply_no<>'$no' AND a.room_code='$room' AND ");
				$this->appendSQL("((checkin_dt<='$arrival' AND checkout_dt>'$arrival') OR (checkin_dt<'$departure' AND checkout_dt>='$departure') OR ");
				$this->appendSQL("(checkin_dt>'$arrival' AND checkout_dt<'$departure'))");
				$this->parseQuery();
				if (!$this->EOF) $returnValue = false;
				$this->freeResult();
			} else $returnValue = false;
			return $returnValue;
		}

		function assignRoom($no, $room) {
			$returnValue = false;
			$this->linkRateCode = "";
			if ($room) {
				$this->clearSQL();
				$this->appendSQL("SELECT rate_code FROM $this->roomTableName WHERE room_code='$room'");
				$this->parseQuery();
				if (!$this->EOF) $this->linkRateCode = $this->getField("rate_code");
				$this->freeResult();
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->applyTableName SET assign_date=now(), state='RA', rate_code='" . $this->linkRateCode . "', room_code='$room' WHERE apply_no=$no");
				$returnValue = $this->execQuery();
			}
			return $returnValue;
		}

		function cancelRoom($no) {
			$returnValue = false;
			if ($no) {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->applyTableName SET assign_date='0000-00-00 00:00:00', room_code='' WHERE apply_no=$no");
				$returnValue = $this->execQuery();
			}
			return $returnValue;
		}

		function deleteApplication($no) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->paymentTableName WHERE apply_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->clearSQL();
				$this->appendSQL("DELETE FROM $this->preferenceTableName WHERE apply_no=$no");
				$returnValue = $this->execQuery();
				if ($returnValue) {
					$this->clearSQL();
					$this->appendSQL("DELETE FROM $this->applyTableName WHERE apply_no=$no");
					$returnValue = $this->execQuery();
					if ($returnValue) {
						$admin_id = $ihouse_admin_info[id];
						if (strtolower($admin_id) != "intia") {
							$ip = $_SERVER["REMOTE_ADDR"];
							$detail = "$no 온라인지원 정보 삭제";
							$this->clearSQL();
							$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'P', 'A', 'D', '$ip', now(), '$detail')");
							$this->execQuery();
						}
					}
				}
			}
 			return $returnValue;
		}

		function deletePreference($no) {
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->preferenceTableName WHERE apply_no=$no");
			$returnValue = $this->execQuery();
 			return $returnValue;
		}

		function isDepositBilled($no) {
			$returnValue = false;
			if ($no) {
				$this->clearSQL();
				$this->appendSQL("SELECT apply_no FROM $this->paymentTableName WHERE kind='D' AND pay_kind='DB' and apply_no='$no'");
				$this->parseQuery();
				if (!$this->EOF) $returnValue = true;
				$this->freeResult();
			}
			return $returnValue;
		}

		function insertPayment($apply, $kind, $dt, $pr, $detail) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->paymentTableName (apply_no, kind, pay_dt, price, pay_kind) VALUES ('$apply', '$kind', '$dt', $pr, '$detail')");
			$returnValue = $this->execQuery();
			if ($returnValue) $this->paymentNumber = $this->getInsertID();
			return $returnValue;
		}

		function updatePayment($no, $dt, $pr, $detail) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->paymentTableName SET pay_dt='$dt', price=$pr, pay_kind='$detail' WHERE pay_no=$no");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function updateResidenceFee($apply, $rate, $period) {
			$returnValue = true;
			if ($rate && $period) {
				$pay_no = "";
				$pay_dt = "";
				$pay_detail = "";
				$pay_price = 0;
				$this->clearSQL();
				$this->appendSQL("SELECT pay_no, pay_dt, pay_kind FROM $this->paymentTableName WHERE apply_no=$apply AND kind='R'");
				$this->parseQuery();
				if (!$this->EOF) {
					$pay_no = $this->getField("pay_no");
					$pay_dt = $this->getField("pay_dt");
					$pay_detail = $this->getField("pay_kind");
				}
				$this->freeResult();
				$this->clearSQL();
				$this->appendSQL("SELECT price FROM $this->priceTableName WHERE rate_code='$rate' AND period_code='$period'");
				$this->parseQuery();
				if (!$this->EOF) $pay_price = $this->getField("price");
				$this->freeResult();
				if ($pay_no) $returnValue = $this->updatePayment($pay_no, $pay_dt, $pay_price, $pay_detail);
				else $returnValue = $this->insertPayment($apply, "R", date("Y-m-d"), $pay_price, "RB");
			}
			return $returnValue;
		}

		function updateResidenceFee1($apply, $rate) {
			$returnValue = false;
			$period = "";
			$this->clearSQL();
			$this->appendSQL("SELECT period_code FROM $this->applyTableName WHERE apply_no=$apply");
			$this->parseQuery();
			if (!$this->EOF) $period = $this->getField("period_code");
			$this->freeResult();
			if ($rate && $period) {
				$pay_no = "";
				$pay_dt = "";
				$pay_detail = "";
				$pay_price = 0;
				$this->clearSQL();
				$this->appendSQL("SELECT pay_no, pay_dt, pay_kind FROM $this->paymentTableName WHERE apply_no=$apply AND kind='R'");
				$this->parseQuery();
				if (!$this->EOF) {
					$pay_no = $this->getField("pay_no");
					$pay_dt = $this->getField("pay_dt");
					$pay_detail = $this->getField("pay_kind");
				}
				$this->freeResult();
				$this->clearSQL();
				$this->appendSQL("SELECT price FROM $this->priceTableName WHERE rate_code='$rate' AND period_code='$period'");
				$this->parseQuery();
				if (!$this->EOF) $pay_price = $this->getField("price");
				$this->freeResult();
				//echo "$pay_no | $pay_price";
				if ($pay_no) $returnValue = $this->updatePayment($pay_no, $pay_dt, $pay_price, $pay_detail);
				else $returnValue = $this->insertPayment($apply, "R", date("Y-m-d"), $pay_price, "RB");
			}
			return $returnValue;
		}

		function deletePayment($no) {
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->paymentTableName WHERE kind<>'F' AND pay_no=$no");
			$returnValue = $this->execQuery();
 			return $returnValue;
		}

		function approveApplication($no, $grade, $flag) {
			$returnValue = true;
			if (is_numeric($no) && $no > 0 && ($grade == "9" || $grade == "8" || $grade == "2" || $grade == "1" || $grade == "0") && ($flag == "Y" || $flag == "N")) {
				if ($flag == "Y") $this->errorMessage = "결재 승인이 성공적으로 이루어졌습니다.";
				else $this->errorMessage = "결재 취소가 성공적으로 이루어졌습니다.";
				$settle1 = "";
				$settle2 = "";
				$settle3 = "";
				$settle4 = "";
				$this->clearSQL();
				$this->appendSQL("SELECT settle1, settle2, settle3, settle4 FROM $this->applyTableName WHERE apply_no=$no;");
				$this->parseQuery();
				if (!$this->EOF) {
					$settle1 = $this->getField("settle1");
					$settle2 = $this->getField("settle2");
					$settle3 = $this->getField("settle3");
					$settle4 = $this->getField("settle4");
				}
				$this->freeResult();
				if (strtoupper($flag) == "Y") $cur_date = "now()";
				else $cur_date = "'0000-00-00'";
				if ($grade == "9" || $grade == "8") {
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->applyTableName SET settle2='N', settle2_dt='0000-00-00' WHERE apply_no=$no;");
					$returnValue = $this->execQuery();
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->applyTableName SET settle3='N', settle3_dt='0000-00-00' WHERE apply_no=$no;");
					$returnValue = $this->execQuery();
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->applyTableName SET settle4='N', settle4_dt='0000-00-00' WHERE apply_no=$no;");
					$returnValue = $this->execQuery();
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->applyTableName SET settle1='$flag', settle1_dt=$cur_date WHERE apply_no=$no;");
					$returnValue = $this->execQuery();
				} else if ($grade == "2") {
					if ($flag == "Y" && $settle3 != "Y") $this->errorMessage = "팀장 미결 상태이므로 결재할 수 없습니다.";
					else {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->applyTableName SET settle4='$flag', settle4_dt=$cur_date WHERE apply_no=$no");
						$returnValue = $this->execQuery();
					}
				} else if ($grade == "1") {
					if ($flag == "Y" && $settle2 != "Y") $this->errorMessage = "과장 미결 상태이므로 결재할 수 없습니다.";
					else if ($flag == "N" && $settle4 != "N") $this->errorMessage = "이미 사감장님의 결재가 이루어져 결재취소를 할 수 없습니다.";
					else {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->applyTableName SET settle3='$flag', settle3_dt=$cur_date WHERE apply_no=$no");
						$returnValue = $this->execQuery();
					}
				} else if ($grade == "0") {
					if ($flag == "Y" && $settle1 != "Y") $this->errorMessage = "담당자의 결재가 이루어지지 않아 결재승인을 할 수 없습니다.";
					else if ($flag == "N" && $settle3 != "N") $this->errorMessage = "이미 팀장님의 결재가 이루어져 결재취소를 할 수 없습니다.";
					else {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->applyTableName SET settle2='$flag', settle2_dt=$cur_date WHERE apply_no=$no");
						$returnValue = $this->execQuery();
					}
				}
			}
			if (!$returnValue) $this->errorMessage = "작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.";
			return $returnValue;
		}

		function getApplicationPeriod($no) {
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT period_code FROM $this->applyTableName WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("period_code");
			$this->freeResult();
			return $returnValue;
		}

		function isRefundExist($no) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no FROM $this->refundTableName WHERE approve IN ('Y','N') AND apply_no='$no'");
			$this->parseQuery();
			if ($this->getNumberRows() > 0) $returnValue = true;
			$this->freeResult();
			return $returnValue;
		}

		function insertRefund($no, $cf_no, $student, $fname, $mname, $lname, $dob, $email, $room, $old, $new) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->refundTableName (apply_no, cf_apply_no, student_id, fname, mname, lname, dob, email, post_dt, room_code, old_period, new_period)");
			$this->appendSQL("VALUES ('$no', '$cf_no', '$student', '$fname', '$mname', '$lname', '$dob', '$email', now(), '$room', '$old', '$new')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->applyNumber = $this->getInsertID();
				if ($no) {
					if ($new) { // 보증금 이전 신청일 경우
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->applyTableName SET state='TR' WHERE apply_no='$no'");
						$this->execQuery();
					} else { // 보증금 반환 신청일 경우
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->applyTableName SET state='RR' WHERE apply_no='$no'");
						$this->execQuery();
					}
				}
			}
			return $returnValue;
		}
	}
?>