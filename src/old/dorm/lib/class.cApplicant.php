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
		var $refundTableName;
		var $periodCode = array();
		var $periodName = array();
		var $periodSDate = array();
		var $periodEDate = array();
		var $rateCode = array();
		var $rateName = array();
		var $rateDormitory = array();
		var $ratePeriod = array();
		var $ratePrice = array();
		var $applyNumber;
		var $applyState;
		var $applyKind;
		var $applyDate;
		var $personStudentID;
		var $personClass;
		var $personFirstName;
		var $personMiddleName;
		var $personLastName;
		var $personKoreanName;
		var $personGender;
		var $personBirthDate;
		var $personNationality;
		var $personHomeUni;
		var $personHomeAddr;
		var $personEmail;
		var $personPhone;
		var $personCell;
		var $personMajor;
		var $personPhotoName;
		var $personPhotoSize;
		var $personPhotoType;
		var $currentResident;
		var $roomPrefer;
		var $mateName;
		var $mateBirthDate;
		var $matchNonSmoker;
		var $matchBedEarly;
		var $matchGetupEarly;
		var $matchSilenceStudy;
		var $matchDayStudy;
		var $contactName;
		var $contactRelation;
		var $contactPhone;
		var $contactAddress;
		var $linkRoomCode;
		var $linkRoomPhone;
		var $linkRoomIP;
		var $linkRateCode;
		var $linkPeriodCode;
		var $linkRateName;
		var $linkPeriodName;
		var $linkPeriodSDate;
		var $linkPeriodEDate;
		var $linkDormitory;
		var $applyRoommate;
		var $applyAccount;
		var $refundApprove;
		var $refundApply;
		var $refundCFApply;
		var $refundDate;
		var $refundPeriod;
		var $refundMethodType;
		var $refundMethodInfo1;
		var $refundMethodInfo2;
		var $refundMethodInfo3;

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

		function getStateValue($val, $current){
			if ($val == "IW") $returnValue = "Application registered; Deposit billed";
			else if ($val == "DP") $returnValue = "Deposit paid, partial";
			else if ($val == "DD") $returnValue = "Deposit paid; Processing room assignment";
			else if ($val == "RA") $returnValue = "Room Assigned; Residence hall fee billed";
			else if ($val == "PR") $returnValue = "Residence hall fee deferred";
			else if ($val == "FP") $returnValue = "Residence hall fee paid, partial";
			else if ($val == "FD") $returnValue = "Residence hall fee paid";
			else if ($val == "FS") $returnValue = "Residence hall fee scholarship";
			else if ($val == "RR") $returnValue = "Deposit refund requested";
			else if ($val == "TR") $returnValue = "Deposit transfer requested";
			else if ($val == "RD") $returnValue = "Deposit processed";
			else if ($val == "CF") $returnValue = "Deposit carried forward";
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

		function getDormitoryValue($val, $rate=""){
			if ($rate == "DOUBLE1") $returnValue = "CJ Int. House/ANAM Global House";
			else if ($val == "IHOUSE") $returnValue = "CJ Int. House";
			else if ($val == "ANAM2") $returnValue = "ANAM 2";
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

		function getResidentValue($kind, $cur){
			$returnValue = "";
			if ($kind == "U") {
				if ($cur == "Y") $returnValue = "Current Resident";
				else if ($cur == "N") $returnValue = "Prospect Resident";
			} else if ($kind == "L") {
				if ($cur == "Y") $returnValue = "KLCC Current Resident";
				else if ($cur == "N") $returnValue = "KLCC Prospect Resident";
			}
			return $returnValue;
		}

		function getSettleValue($val){
			if ($val == "Y") $returnValue = "Àü°á";
			else $returnValue = "";
			return $returnValue;
		}

		function isExist($no, $fnm, $mnm, $lnm) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no FROM $this->tableName WHERE apply_no='$no' AND TRIM(fname)='$fnm' AND TRIM(mname)='$mnm' AND TRIM(lname)='$lnm'");
			$this->parseQuery();
			if ($this->getNumberRows() > 0) $returnValue = true;
			$this->freeResult();
			return $returnValue;
		}

		function isRefundExist($no) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no FROM $this->refundTableName WHERE apply_no='$no'");
			$this->parseQuery();
			if ($this->getNumberRows() > 0) $returnValue = true;
			$this->freeResult();
			return $returnValue;
		}

		function getApplicantNumber($no, $fnm, $mnm, $lnm) {
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no FROM $this->tableName WHERE student_id='$no' AND TRIM(fname)='$fnm' AND TRIM(mname)='$mnm' AND TRIM(lname)='$lnm'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("apply_no");
			$this->freeResult();
			return $returnValue;
		}

		function getApplicantState($no, $state, $fnm, $mnm, $lnm) {
			if ($state) $state = "period_code IN ($state) AND";
			else $state = "";
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT state FROM $this->tableName WHERE $state student_id='$no' AND TRIM(fname)='$fnm' AND TRIM(mname)='$mnm' AND TRIM(lname)='$lnm'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("state");
			$this->freeResult();
			return $returnValue;
		}

		function checkApplicantState($no, $state, $fnm, $mnm, $lnm) {
			if ($state) $state = "period_code IN ($state) AND";
			else $state = "";
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT state FROM $this->tableName WHERE $state state IN ('FD', 'FS') AND student_id='$no' AND TRIM(fname)='$fnm' AND TRIM(mname)='$mnm' AND TRIM(lname)='$lnm'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("state");
			$this->freeResult();
			return $returnValue;
		}

		function checkApplicantState1($no, $state) {
			if ($state) $state = "period_code IN ($state) AND";
			else $state = "";
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT state FROM $this->tableName WHERE $state state IN ('FD', 'FS') AND apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("state");
			$this->freeResult();
			return $returnValue;
		}

		function getApplicantCount($dt) {
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

		function getPeriodList($kind, $current) {
			if ($kind == "GEN") {
				if ($current == "Y") $where = "WHERE display='Y' AND (general='A' OR general='C') AND kind='$kind'";
				else $where = "WHERE display='Y' AND (general='A' OR general='P') AND kind='$kind'";
			} else if ($kind) $where = "WHERE display='Y' AND kind='$kind'";
			else $where = "WHERE display='Y'";
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->periodTableName $where ORDER BY order_no");
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
			$this->appendSQL("LEFT JOIN $this->periodTableName c ON b.period_code=c.period_code WHERE c.period_code='$period' ORDER BY price DESC");
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
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->paymentTableName WHERE apply_no='$no' ORDER BY pay_dt");
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

		function getPaymentAmount($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) pr_sum FROM $this->paymentTableName WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("pr_sum");
			$this->freeResult();
			return $returnValue;
		}

		function getApplicantInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->tableName a LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code ");
			$this->appendSQL("LEFT JOIN $this->roomTableName c ON a.room_code=c.room_code LEFT JOIN $this->rateTableName d ON a.rate_code=d.rate_code WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->applyNumber = $this->getField("apply_no");
				$this->applyState = $this->getField("state");
				$this->applyKind = $this->getField("kind");
				$this->applyDate = $this->getField("apply_date");
				$this->personStudentID = $this->getField("student_id");
				$this->personClass = $this->getField("class");
				$this->personFirstName = $this->getField("fname");
				$this->personMiddleName = $this->getField("mname");
				$this->personLastName = $this->getField("lname");
				$this->personKoreanName = $this->getField("name_kr");
				$this->personGender = $this->getField("gender");
				$this->personBirthDate = $this->getField("dob");
				$this->personNationality = $this->getField("nationality");
				$this->personHomeUni = $this->getField("home_uni");
				$this->personHomeAddr = $this->getField("home_addr");
				$this->personEmail = $this->getField("email");
				$this->personPhone = $this->getField("phone");
				$this->personCell = $this->getField("cell");
				$this->personMajor = $this->getField("major");
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
				$this->linkDormitory = $this->getField("dorm_code");
				$this->applyRoommate = $this->getField("roommate");
				$this->applyAccount = $this->getField("account");
			}
			$this->freeResult();
		}

		function insertApplicant($no, $kind, $id, $class, $fnm, $mnm, $lnm, $nm_kr, $gender, $dob, $nation, $major, $uni, $addr, $email, $ph, $cell, $room_prefer, $current, $mate_nm, $mate_dob, $pre1, $pre2, $pre3, $pre4, $pre5, $case_nm, $case_rel, $case_ph, $case_addr, $room, $period) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->tableName (apply_no, kind, student_id, class, fname, mname, lname, name_kr, gender, dob, nationality, major, home_uni, home_addr, email, phone, cell, room_prefer, current, mate_name, mate_dob, match_nosmoke, match_bed, match_getup, match_silence, match_study, case_name, case_relate, case_phone, case_addr, apply_date, room_code, period_code)");
			$this->appendSQL("VALUES ('$no', '$kind', '$id', '$class', '$fnm', '$mnm', '$lnm', '$nm_kr', '$gender', '$dob', '$nation', '$major', '$uni', '$addr', '$email', '$ph', '$cell', '$room_prefer', '$current', '$mate_nm', '$mate_dob', '$pre1', '$pre2', '$pre3', '$pre4', '$pre5', '$case_nm', '$case_rel', '$case_ph', '$case_addr', now(), '$room', '$period')");
			$returnValue = $this->execQuery();
			if ($returnValue) $this->applyNumber = $this->getInsertID();
			return $returnValue;
		}

		function insertPreference($rate, $apply) {
			$temp_rate = explode(",", $rate);
			for ($i = 0; $i < count($temp_rate); $i++) {
				if (trim($temp_rate[$i])) {
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->preferenceTableName (rate_code, apply_no, pre_no)");
					$this->appendSQL("VALUES ('" . $temp_rate[$i] . "', '$apply', " . ($i + 1) . ")");
					$returnValue = $this->execQuery();
					//if (!$returnValue) break;
				}
			}
			$returnValue = true;
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

		function insertPayment($apply, $kind, $dt, $pr, $detail) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->paymentTableName (apply_no, kind, pay_dt, price, pay_kind) VALUES ('$apply', '$kind', '$dt', $pr, '$detail')");
			$returnValue = $this->execQuery();
			if ($returnValue) $this->paymentNumber = $this->getInsertID();
			return $returnValue;
		}

		function insertRefund1($no, $cf_no, $kind, $student, $fname, $mname, $lname, $dob, $email, $vacate, $method, $info1, $info2, $info3, $dorm, $room, $old, $new) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->refundTableName (apply_no, cf_apply_no, kind, student_id, fname, mname, lname, dob, email, vacate_dt, post_dt, method_type, method_info1, method_info2, method_info3, dorm_code, room_code, old_period, new_period)");
			$this->appendSQL("VALUES ('$no', '$cf_no', '$kind', '$student', '$fname', '$mname', '$lname', '$dob', '$email', '$vacate', now(), '$method', '$info1', '$info2', '$info3', '$dorm', '$room', '$old', '$new')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->applyNumber = $this->getInsertID();
				if ($new) {
					if ($no) {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->tableName SET state='TR' WHERE apply_no='$no'");
						$this->execQuery();
					}
					if ($cf_no) {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->tableName SET state='CF' WHERE apply_no='$cf_no'");
						$this->execQuery();
						$this->clearSQL();
						$this->appendSQL("DELETE FROM $this->paymentTableName WHERE apply_no='$cf_no' AND pay_kind='DC'");
						$returnValue = $this->execQuery();
						$this->clearSQL();
						$this->appendSQL("INSERT INTO $this->paymentTableName (apply_no, kind, pay_dt, price, pay_kind) VALUES ('$cf_no', 'E', now(), -200000, 'DC')");
						$returnValue = $this->execQuery();
					}
				} else {
					if ($no) {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->tableName SET state='RR' WHERE apply_no='$no'");
						$this->execQuery();
					}
				}
			}
			return $returnValue;
		}

		function getRefundInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->refundTableName a LEFT JOIN $this->periodTableName b ON a.new_period=b.period_code WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->refundApprove = $this->getField("approve");
				$this->refundApply = $this->getField("apply_no");
				$this->refundCFApply = $this->getField("cf_apply_no");
				$this->refundDate = $this->getField("post_dt");
				$this->refundPeriod = $this->getField("b.name");
				$this->refundMethodType = $this->getField("method_type");
				$this->refundMethodInfo1 = $this->getField("method_info1");
				$this->refundMethodInfo2 = $this->getField("method_info2");
				$this->refundMethodInfo3 = $this->getField("method_info3");
			}
			$this->freeResult();
		}
	}
?>