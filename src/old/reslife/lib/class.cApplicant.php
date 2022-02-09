<?
	include_once("class.cMysql.php");

	class cApplicant extends cMysql {
		var $tableName;
		var $rateTableName;
		var $periodTableName;
		var $roomTableName;
		var $priceTableName;
		var $preferenceTableName;
		var $paymentTableName;
		var $listNumber = array();
		var $listState = array();
		var $listAccount = array();
		var $listFirstName = array();
		var $listLastName = array();
		var $listKoreanName = array();
		var $listGender = array();
		var $listBirth = array();
		var $listNation = array();
		var $listEmail = array();
		var $listPhone = array();
		var $listMobile = array();
		var $listDate = array();
		var $listStudentID = array();
		var $listMajor = array();
		var $listClass = array();
		var $listHomeUni = array();
		var $listHomeAddress = array();
		var $listCurrent = array();
		var $listMateName = array();
		var $listMateDOB = array();
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
		var $listRateCode = array();
		var $listPeriodCode = array();
		var $listPeriodName = array();
		var $listPeriodSDate = array();
		var $listPeriodEDate = array();
		var $listRoommate = array();
		var $listRoomPrefer = array();
		var $periodCode = array();
		var $periodName = array();
		var $periodSDate = array();
		var $periodEDate = array();
		var $rateCode = array();
		var $rateDormitory = array();
		var $rateName = array();
		var $ratePrice = array();
		var $preRateCode = array();
		var $preRateName = array();
		var $preRateDormitory = array();
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
		var $applyAdmin;
		var $applyAccount;
		var $personStudentID;
		var $personFirstName;
		var $personMiddleName;
		var $personLastName;
		var $personKoreanName;
		var $personGender;
		var $personBirthDate;
		var $personNationality;
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
		var $matchNonSmoker;
		var $matchBedEarly;
		var $matchGetupEarly;
		var $matchSilenceStudy;
		var $matchDayStudy;
		var $applyRoommate;
		var $paymentNumber;

		function cApplicant($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl4, $tbl5, $tbl6, $tbl7) {
			$this->tableName = $tbl1;
			$this->rateTableName = $tbl2;
			$this->periodTableName = $tbl3;
			$this->roomTableName = $tbl4;
			$this->priceTableName = $tbl5;
			$this->preferenceTableName = $tbl6;
			$this->paymentTableName = $tbl7;
			$this->cMysql($host, $id, $pw, $db);
		}

		function getStateValue($val){
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
			else $returnValue = "";
			return $returnValue;
		}

		function getDetailValue($val){
			if ($val == "DB") $returnValue = "Deposit Billed";
			else if ($val == "DC") $returnValue = "Deposit carried forward";
			else if ($val == "DD") $returnValue = "Damage deduction";
			else if ($val == "DP") $returnValue = "Deposit payment, partial";
			else if ($val == "DF") $returnValue = "Deposit payment";
			else if ($val == "RB") $returnValue = "Residence Hall Fee Billed";
			else if ($val == "RP") $returnValue = "Residence hall fee payment, partial";
			else if ($val == "RF") $returnValue = "Residence hall fee payment";
			else if ($val == "RW") $returnValue = "Residence hall fee waived, HR";
			else if ($val == "RS") $returnValue = "Residence hall fee scholarship";
			else if ($val == "LF") $returnValue = "Late Fee";
			else if ($val == "CC") $returnValue = "Credit carried forward";
			else if ($val == "CA") $returnValue = "Credit adjustment";
			else $returnValue = "Etc.";
			return $returnValue;
		}

		function getClassValue($val){
			if ($val == "P") $returnValue = "Undergraduate - Sophomore";
			else if ($val == "J") $returnValue = "Undergraduate - Junior";
			else if ($val == "S") $returnValue = "Undergraduate - Senior";
			else if ($val == "M") $returnValue = "Graduate - Master's prog";
			else if ($val == "D") $returnValue = "Graduate - Doctorial prog";
			else $returnValue = "";
			return $returnValue;
		}

		function getGenderValue($val){
			if ($val == "M") $returnValue = "Male";
			else if ($val == "F") $returnValue = "Female";
			else $returnValue = "";
			return $returnValue;
		}

		function getDormitoryValue($val){
			if ($val == "IHOUSE") $returnValue = "CJ Int. House";
			else if ($val == "ANAM2") $returnValue = "ANAM 2";
			else $returnValue = "";
			return $returnValue;
		}

		function getSettleValue($val){
			if ($val == "Y") $returnValue = "전결";
			else $returnValue = "";
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

		function getResidentValue($val){
			if ($val == "Y") $returnValue = "재사학생";
			else if ($val == "N") $returnValue = "새학생";
			else $returnValue = "";
			return $returnValue;
		}

		function getApplicantNumber($dt) {
			$returnValue = "";
			$where = "";
			if ($dt) $where = "WHERE apply_no>$dt" . "0000";
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt FROM $this->tableName $where");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			$this->freeResult();
			return $returnValue;
		}

		function getApplicantPrice($rate, $period) {
			$returnValue = "0";
			$this->clearSQL();
			$this->appendSQL("SELECT price FROM $this->priceTableName WHERE rate_code='$rate' AND period_code='$period'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("price");
			$this->freeResult();
			return $returnValue;
		}

		function getWhereCondition($sdate, $edate, $stype, $stext, $state, $kind, $current, $period) {
			$list_period = "";
			if ($period) {
				$arr_temp = explode(",", $period);
				for ($i = 0; $i < count($arr_temp); $i++) {
					$list_period .= "'" . $arr_temp[$i] . "',";
				}
				if ($list_period) $list_period = substr($list_period, 0, strlen($list_period) - 1);
			}
			$returnValue = "WHERE a.kind='$kind'";
			if ($state) $returnValue .= " AND state='$state'";
			if ($current) $returnValue .= " AND current='$current'";
			if ($list_period) $returnValue .= " AND a.period_code IN ($list_period)";
			if ($sdate) $returnValue .= " AND apply_date>='$sdate 00:00:00'";
			if ($edate) $returnValue .= " AND apply_date<='$edate 23:59:59'";
			if (trim($stext) == "") $stype = "0";
			switch ($stype) {
				case "1":
					$returnValue .= " AND (fname LIKE '%" . $stext . "%' OR mname LIKE '%" . $stext . "%' OR lname LIKE '%" . $stext . "%')";
					break;
				case "2":
					$returnValue .= " AND a.apply_no LIKE '%" . $stext . "%'";
					break;
				case "3":
					$returnValue .= " AND student_id LIKE '%" . $stext . "%'";
					break;
				case "4":
					$returnValue .= " AND a.room_code LIKE '%" . $stext . "%'";
					break;
			}
			return $returnValue;
		}

		function getCondition($sdate, $edate, $stype, $stext, $state, $kind, $current, $period) {
			$returnValue = "FROM $this->tableName a LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code ";
			$returnValue .= "LEFT JOIN $this->roomTableName c ON a.room_code=c.room_code LEFT JOIN $this->paymentTableName d ON a.apply_no=d.apply_no ";
			$returnValue .= $this->getWhereCondition($sdate, $edate, $stype, $stext, $state, $kind, $current, $period);
			$returnValue .= " GROUP BY a.apply_no";
			return $returnValue;
		}

		function getApplicantCount($sdate, $edate, $stype, $stext, $state, $kind, $current, $period) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt " . $this->getCondition($sdate, $edate, $stype, $stext, $state, $kind, $current, $period));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getNumberRows();
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getApplicantList($sdate, $edate, $start, $size, $stype, $stext, $state, $kind, $current, $period, $sort) {
			if ($sort == "") $sort = " ORDER BY lname, fname, student_id";
			else $sort = " ORDER BY $sort";
			if ($start != "" || $start == "0") $limit = " LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT a.apply_no, student_id, fname, mname, lname, gender, dob, email, apply_date, current, state, b.name, a.room_code, ");
			$this->appendSQL("SUM(price) pay_pr " . $this->getCondition($sdate, $edate, $stype, $stext, $state, $kind, $current, $period) . $sort . $limit);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->listNumber[$cnt] = $this->getField("apply_no");
				$this->listStudentID[$cnt] = $this->getField("student_id");
				$this->listFirstName[$cnt] = $this->getField("fname") . " " . $this->getField("mname");
				$this->listLastName[$cnt] = $this->getField("lname");
				$this->listGender[$cnt] = $this->getField("gender");
				$this->listBirth[$cnt] = $this->getField("dob");
				$this->listEmail[$cnt] = $this->getField("email");
				$this->listDate[$cnt] = $this->getField("apply_date");
				$this->listCurrent[$cnt] = $this->getField("current");
				$this->listState[$cnt] = $this->getField("state");
				$this->listPeriodName[$cnt] = $this->getField("name");
				$this->listRoomCode[$cnt] = $this->getField("a.room_code");
				$this->listPayment[$cnt] = $this->getField("pay_pr");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getPeriodList($kind) {
			if ($kind) $where = "WHERE kind='$kind'";
			else $where = "";
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->periodTableName $where ORDER BY kind, order_no");
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

		function getRateList($period) {
			$this->clearSQL();
			$this->appendSQL("SELECT a.rate_code, a.dorm_code, a.name rate_nm, price FROM $this->rateTableName a ");
			$this->appendSQL("LEFT JOIN $this->priceTableName b ON a.rate_code=b.rate_code ");
			$this->appendSQL("LEFT JOIN $this->periodTableName c ON b.period_code=c.period_code WHERE c.period_code='$period' ORDER BY a.order_no");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->rateCode[$cnt] = $this->getField("rate_code");
				$this->rateDormitory[$cnt] = $this->getField("dorm_code");
				$this->rateName[$cnt] = $this->getField("rate_nm");
				$this->ratePrice[$cnt] = $this->getField("price");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getPreferenceList($no, $period) {
			$this->preRateCode = null;
			$this->preRateName = null;
			$this->preRateDormitory = null;
			$this->preRatePrice = null;
			$this->clearSQL();
			$this->appendSQL("SELECT a.rate_code, b.name, b.dorm_code, c.price FROM $this->preferenceTableName a ");
			$this->appendSQL("LEFT JOIN $this->rateTableName b ON a.rate_code=b.rate_code LEFT JOIN $this->priceTableName c ");
			$this->appendSQL("ON a.rate_code=c.rate_code AND c.period_code='$period' WHERE apply_no='$no' ORDER BY pre_no");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->preRateCode[$cnt] = $this->getField("rate_code");
				$this->preRateName[$cnt] = $this->getField("name");
				$this->preRateDormitory[$cnt] = $this->getField("dorm_code");
				$this->preRatePrice[$cnt] = $this->getField("price");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
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

		function getExcelList($sdate, $edate, $stype, $stext, $state, $kind, $current, $period, $sort) {
			if ($sort == "") $sort = " ORDER BY apply_date DESC";
			else $sort = " ORDER BY $sort";
			$this->clearSQL();
			$this->appendSQL("SELECT a.apply_no, state, account, fname, mname, lname, name_kr, gender, dob, nationality, email, phone, cell, apply_date, student_id, ");
			$this->appendSQL("major, class, home_uni, home_addr, current, mate_name, mate_dob, match_nosmoke, match_bed, match_getup, match_silence, ");
			$this->appendSQL("match_study, case_name, case_relate, case_phone, case_addr, a.room_code, ph, ip, a.period_code, b.name, sdate, edate, roommate, ");
			$this->appendSQL("room_prefer, a.rate_code, SUM(price) pay_pr ");
			$this->appendSQL($this->getCondition($sdate, $edate, $stype, $stext, $state, $kind, $current, $period) . $sort);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->listNumber[$cnt] = $this->getField("apply_no");
				$this->listState[$cnt] = $this->getField("state");
				$this->listAccount[$cnt] = $this->getField("account");
				$this->listFirstName[$cnt] = $this->getField("fname") . " " . $this->getField("mname");
				$this->listLastName[$cnt] = $this->getField("lname");
				$this->listKoreanName[$cnt] = $this->getField("name_kr");
				$this->listGender[$cnt] = $this->getField("gender");
				$this->listBirth[$cnt] = $this->getField("dob");
				$this->listNation[$cnt] = $this->getField("nationality");
				$this->listEmail[$cnt] = $this->getField("email");
				$this->listPhone[$cnt] = $this->getField("phone");
				$this->listMobile[$cnt] = $this->getField("cell");
				$this->listDate[$cnt] = $this->getField("apply_date");
				$this->listStudentID[$cnt] = $this->getField("student_id");
				$this->listMajor[$cnt] = $this->getField("major");
				$this->listClass[$cnt] = $this->getField("class");
				$this->listHomeUni[$cnt] = $this->getField("home_uni");
				$this->listHomeAddress[$cnt] = $this->getField("home_addr");
				$this->listCurrent[$cnt] = $this->getField("current");
				$this->listMateName[$cnt] = $this->getField("mate_name");
				$this->listMateDOB[$cnt] = $this->getField("mate_dob");
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
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getExcelList1($sdate, $edate, $stype, $stext, $state, $kind, $current, $period, $sort) {
			if ($sort == "") $sort = " ORDER BY apply_date DESC, pay_dt";
			else $sort = " ORDER BY $sort, pay_dt";
			$this->clearSQL();
			$this->appendSQL("SELECT a.apply_no, a.period_code, a.rate_code, a.room_code, student_id, lname, fname, mname, pay_dt, pay_kind, price FROM $this->tableName a, $this->paymentTableName d ");
			$this->appendSQL("LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code LEFT JOIN $this->roomTableName c ON a.room_code=c.room_code ");
			$this->appendSQL($this->getWhereCondition($sdate, $edate, $stype, $stext, $state, $kind, $current, $period) . " AND a.apply_no=d.apply_no " . $sort);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->payListNumber[$cnt] = $this->getField("apply_no");
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

		function getApplicantInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->tableName a LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code ");
			$this->appendSQL("LEFT JOIN $this->roomTableName c ON a.room_code=c.room_code WHERE apply_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->applyNumber = $this->getField("apply_no");
				$this->applyState = $this->getField("state");
				$this->applyKind = $this->getField("kind");
				$this->applyDate = $this->getField("apply_date");
				$this->applyAccount = $this->getField("account");
				$this->applyAdmin = $this->getField("admin");
				$this->personStudentID = $this->getField("student_id");
				$this->personFirstName = $this->getField("fname");
				$this->personMiddleName = $this->getField("mname");
				$this->personLastName = $this->getField("lname");
				$this->personKoreanName = $this->getField("name_kr");
				$this->personGender = $this->getField("gender");
				$this->personBirthDate = $this->getField("dob");
				$this->personNationality = $this->getField("nationality");
				$this->personHomeUni = $this->getField("home_uni");
				$this->personHomeAddress = $this->getField("home_addr");
				$this->personEmail = $this->getField("email");
				$this->personPhone = $this->getField("phone");
				$this->personCell = $this->getField("cell");
				$this->personMajor = $this->getField("major");
				$this->personClass = $this->getField("class");
				$this->currentResident = $this->getField("current");
				$this->roomPrefer = $this->getField("room_prefer");
				$this->mateName = $this->getField("mate_name");
				$this->mateBirthDate = $this->getField("mate_dob");
				$this->matchNonSmoker = $this->getField("match_nosmoke");
				$this->matchBedEarly = $this->getField("match_bed");
				$this->matchGetupEarly = $this->getField("match_getup");
				$this->matchSilenceStudy = $this->getField("match_silence");
				$this->matchDayStudy = $this->getField("match_study");
				$this->contactName = $this->getField("case_name");
				$this->contactRelation = $this->getField("case_relate");
				$this->contactPhone = $this->getField("case_phone");
				$this->contactAddress = $this->getField("case_addr");
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
				$this->applyRoommate = $this->getField("roommate");
			}
			$this->freeResult();
		}

		function getApplicantInfo1($student) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->tableName a LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code ");
			$this->appendSQL("LEFT JOIN $this->roomTableName c ON a.room_code=c.room_code ");
			$this->appendSQL("WHERE student_id='$student' and (a.period_code='2006SA' or a.period_code='2006SB')");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->applyNumber = $this->getField("apply_no");
				$this->applyState = $this->getField("state");
				$this->applyKind = $this->getField("kind");
				$this->applyDate = $this->getField("apply_date");
				$this->applyAccount = $this->getField("account");
				$this->applyAdmin = $this->getField("admin");
				$this->personStudentID = $this->getField("student_id");
				$this->personFirstName = $this->getField("fname");
				$this->personMiddleName = $this->getField("mname");
				$this->personLastName = $this->getField("lname");
				$this->personKoreanName = $this->getField("name_kr");
				$this->personGender = $this->getField("gender");
				$this->personBirthDate = $this->getField("dob");
				$this->personNationality = $this->getField("nationality");
				$this->personHomeUni = $this->getField("home_uni");
				$this->personHomeAddress = $this->getField("home_addr");
				$this->personEmail = $this->getField("email");
				$this->personPhone = $this->getField("phone");
				$this->personCell = $this->getField("cell");
				$this->personMajor = $this->getField("major");
				$this->personClass = $this->getField("class");
				$this->currentResident = $this->getField("current");
				$this->roomPrefer = $this->getField("room_prefer");
				$this->mateName = $this->getField("mate_name");
				$this->mateBirthDate = $this->getField("mate_dob");
				$this->matchNonSmoker = $this->getField("match_nosmoke");
				$this->matchBedEarly = $this->getField("match_bed");
				$this->matchGetupEarly = $this->getField("match_getup");
				$this->matchSilenceStudy = $this->getField("match_silence");
				$this->matchDayStudy = $this->getField("match_study");
				$this->contactName = $this->getField("case_name");
				$this->contactRelation = $this->getField("case_relate");
				$this->contactPhone = $this->getField("case_phone");
				$this->contactAddress = $this->getField("case_addr");
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
				$this->applyRoommate = $this->getField("roommate");
			}
			$this->freeResult();
		}

		function insertApplicant($no, $state, $kind, $acc, $id, $class, $fnm, $mnm, $lnm, $nm_kr, $gender, $dob, $nation, $major, $uni, $addr, $email, $ph, $cell, $room_prefer, $current, $mate_nm, $mate_dob, $pre1, $pre2, $pre3, $pre4, $pre5, $case_nm, $case_rel, $case_ph, $case_addr, $period, $stt1, $stt2, $stt3, $stt4, $roommate, $admin) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->tableName (apply_no, state, kind, account, student_id, class, fname, mname, lname, name_kr, gender, dob, nationality, major, home_uni, home_addr, email, phone, cell, room_prefer, current, mate_name, mate_dob, match_nosmoke, match_bed, match_getup, match_silence, match_study, case_name, case_relate, case_phone, case_addr, apply_date, period_code, settle1, settle2, settle3, settle4, roommate, admin)");
			$this->appendSQL("VALUES ('$no', '$state', '$kind', '$acc', '$id', '$class', '$fnm', '$mnm', '$lnm', '$nm_kr', '$gender', '$dob', '$nation', '$major', '$uni', '$addr', '$email', '$ph', '$cell', '$room_prefer', '$current', '$mate_nm', '$mate_dob', '$pre1', '$pre2', '$pre3', '$pre4', '$pre5', '$case_nm', '$case_rel', '$case_ph', '$case_addr', now(), '$period', '$stt1', '$stt2', '$stt3', '$stt4', '$roommate', '$admin')");
			$returnValue = $this->execQuery();
			if ($returnValue) $this->applyNumber = $this->getInsertID();
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

		function copyApplicant($no, $period) {
			if (!$this->getApplicantNumber(date("Y").date("m"))) $app_no = date("Y"). date("m") . "0001";
			else $app_no = "";
			$this->getApplicantInfo($no);
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->tableName (apply_no, kind, student_id, class, fname, mname, lname, name_kr, gender, dob, nationality, major, home_uni, home_addr, email, phone, cell, room_prefer, current, mate_name, mate_dob, match_nosmoke, match_bed, match_getup, match_silence, match_study, case_name, case_relate, case_phone, case_addr, apply_date, room_code, period_code, roommate)");
			$this->appendSQL("VALUES ('$app_no', '" . $this->applyKind . "', '" . $this->personStudentID . "', '" . $this->personClass . "', '" . $this->personFirstName . "', '" . $this->personMiddleName . "', '" . $this->personLastName . "', '" . $this->personKoreanName . "', '" . $this->personGender . "', '" . $this->personBirthDate . "', '" . $this->personNationality . "', '" . $this->personMajor . "', '" . $this->personHomeUni . "', '" . $this->personHomeAddress . "', '" . $this->personEmail . "', '" . $this->personPhone . "', '" . $this->personCell . "', '" . $this->roomPrefer . "', 'Y', '" . $this->mateName . "', '" . $this->mateBirthDate . "', '" . $this->matchNonSmoker . "', '" . $this->matchBedEarly . "', '" . $this->matchGetupEarly . "', '" . $this->matchSilenceStudy . "', '" . $this->matchDayStudy . "', '" . $this->contactName . "', '" . $this->contactRelation . "', '" . $this->contactPhone . "', '" . $this->contactAddress . "', now(), '" . $this->linkRoomCode . "', '$period', '" . $this->applyRoommate . "')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->applyNumber = $this->getInsertID();
				$returnValue = $this->insertPayment($this->applyNumber, "D", date("Y-m-d"), "200000", "DB");
			}
			return $returnValue;
		}

		function updateApplicant($no, $rate, $state, $acc, $id, $class, $fnm, $mnm, $lnm, $nm_kr, $gender, $dob, $nation, $major, $uni, $addr, $email, $ph, $cell, $room_prefer, $current, $mate_nm, $mate_dob, $pre1, $pre2, $pre3, $pre4, $pre5, $case_nm, $case_rel, $case_ph, $case_addr, $period, $stt1, $stt2, $stt3, $stt4, $roommate, $admin) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->tableName SET rate_code='$rate', state='$state', account='$acc', student_id='$id', class='$class', fname='$fnm', mname='$mnm', lname='$lnm', ");
			$this->appendSQL("name_kr='$nm_kr', gender='$gender', dob='$dob', nationality='$nation', major='$major', home_uni='$uni', home_addr='$addr', email='$email', phone='$ph', ");
			$this->appendSQL("current='$current', mate_name='$mate_nm', mate_dob='$mate_dob', match_nosmoke='$pre1', match_bed='$pre2', ");
			$this->appendSQL("match_getup='$pre3', match_silence='$pre4', match_study='$pre5', case_name='$case_nm', cell='$cell', room_prefer='$room_prefer', ");
			$this->appendSQL("case_relate='$case_rel', case_phone='$case_ph', case_addr='$case_addr', ");
			$this->appendSQL("period_code='$period', admin='$admin', settle1='$stt1', settle2='$stt2', settle3='$stt3', ");
			$this->appendSQL("settle4='$stt4', roommate='$roommate' WHERE apply_no=$no");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function updateApplicantState($no, $state) {
			$returnValue = false;
			if ($state) {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->tableName SET state='$state' WHERE apply_no=$no");
				$returnValue = $this->execQuery();
			}
			return $returnValue;
		}

		function assignRoom($no, $room) {
			$returnValue = false;
			if ($room) {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->tableName SET assign_date=now(), room_code='$room' WHERE apply_no=$no");
				$returnValue = $this->execQuery();
			}
			return $returnValue;
		}

		function deleteApplicant($no) {
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->paymentTableName WHERE apply_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->clearSQL();
				$this->appendSQL("DELETE FROM $this->preferenceTableName WHERE apply_no=$no");
				$returnValue = $this->execQuery();
				if ($returnValue) {
					$this->clearSQL();
					$this->appendSQL("DELETE FROM $this->tableName WHERE apply_no=$no");
					$returnValue = $this->execQuery();
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

		function updateAccountFee($student, $amount, $dt) {
			$apply = "";
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no FROM $this->tableName WHERE student_id='$student' AND (period_code='2006SA' OR period_code='2006SB')");
			$this->parseQuery();
			if (!$this->EOF) $apply = $this->getField("apply_no");
			$this->freeResult();
			if ($apply) $returnValue = $this->insertPayment($apply, "E", $dt, "-".$amount, "RF");
			else $returnValue = false;
			if ($returnValue) $this->updateApplicantState($apply, "PW");
			return $returnValue;
		}

		function updateAccountFlag($student) {
			$apply = "";
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no FROM $this->tableName WHERE student_id='$student' AND (period_code='2006SA' OR period_code='2006SB')");
			$this->parseQuery();
			if (!$this->EOF) $apply = $this->getField("apply_no");
			$this->freeResult();
			if ($apply) $returnValue = $this->updateApplicantState($apply, "PW");
			else $returnValue = false;
			return $returnValue;
		}

		function deletePayment($no) {
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->paymentTableName WHERE kind='E' AND pay_no=$no");
			$returnValue = $this->execQuery();
 			return $returnValue;
		}

		function insertPayment1($student, $kind, $dt, $pr, $detail) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no FROM $this->tableName WHERE student_id='$student' and period_code='2006FA'");
			$this->parseQuery();
			if (!$this->EOF) {
				$apply = $this->getField("apply_no");
				$this->freeResult();
				$this->clearSQL();
				$this->appendSQL("INSERT INTO $this->paymentTableName (apply_no, kind, pay_dt, price, pay_kind) VALUES ('$apply', '$kind', '$dt', $pr, '$detail')");
				$returnValue = $this->execQuery();
			}
			return $returnValue;
		}
	}
?>