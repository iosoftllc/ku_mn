<?
	include_once("class.GraduateStudent.php");

	class GraduateApplication extends GraduateStudent {
		var $preferenceTableName;
		var $paymentTableName;
		var $refundTableName;
		var $periodCode = array();
		var $periodName = array();
		var $periodSDate = array();
		var $periodEDate = array();
		var $periodApplyNo = array();
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
		var $personHomeUni;
		var $personHomeAddr;
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
		var $matchLocal;
		var $matchNonSmoker;
		var $matchBedEarly;
		var $matchGetupEarly;
		var $matchSilenceStudy;
		var $matchDayStudy;
		var $applyRoommate;
		var $paymentNumber;
		var $refundApprove;
		var $refundApply;
		var $refundCFApply;
		var $refundDeduction;
		var $refundDate;
		var $refundPeriod;
		var $refundMethodType;
		var $refundMethodInfo1;
		var $refundMethodInfo2;
		var $refundMethodInfo3;
		var $refundMethodInfo4;
		var $refundMethodInfo5;
		var $refundMethodInfo6;
		var $refundMethodAddress1;
		var $refundMethodAddress2;
		var $refundMethodCountry;
		var $refundNumber;

		function GraduateApplication($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl4, $tbl5, $tbl6, $tbl7, $tbl8, $tbl9, $tbl10) {
			$this->preferenceTableName = $tbl8;
			$this->paymentTableName = $tbl9;
			$this->refundTableName = $tbl10;
			$this->GraduateStudent($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl4, $tbl5, $tbl6, $tbl7);
		}

		function getStateValue($val) {
			if ($val == "IW") $returnValue = "Application registered";
			else if ($val == "DP") $returnValue = "Deposit paid, partial";
			else if ($val == "DD") $returnValue = "Deposit paid; Processing room assignment";
			else if ($val == "RA") $returnValue = "Room Assigned; Residence hall fee billed";
			else if ($val == "RN") $returnValue = "Room Not Assigned";
			else if ($val == "PR") $returnValue = "Residence hall fee deferred";
			else if ($val == "FP") $returnValue = "Residence hall fee paid, partial";
			else if ($val == "FD") $returnValue = "Residence hall fee paid";
			else if ($val == "FS") $returnValue = "Residence hall fee scholarship";
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

		function getSettleValue($val) {
			if ($val == "Y") $returnValue = "전결";
			else $returnValue = "";
			return $returnValue;
		}

		function getPreferenceValue($val) {
			if ($val == "Y") $returnValue = "Yes";
			else if ($val == "N") $returnValue = "No";
			else if ($val == "M") $returnValue = "No Preference";
			else $returnValue = "";
			return $returnValue;
		}

		function hasSamePeriod($email, $period) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no FROM $this->applyTableName WHERE email='$email' AND period_code='$period'");
			$this->parseQuery();
			if (!$this->EOF) {
				$returnValue = true;
				$this->applyNumber = $this->getField("apply_no");
			}
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

		function getPeriodList($email="") {
			if (trim($email) != "") $where = "WHERE email='$email'";
			else $where = "WHERE a.display='Y'";
			$this->clearSQL();
			$this->appendSQL("SELECT a.period_code, a.name, a.sdate, a.edate, b.apply_no FROM $this->periodTableName a LEFT JOIN $this->applyTableName b ON a.period_code=b.period_code ");
			$this->appendSQL("$where GROUP BY a.period_code ORDER BY a.order_no");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->periodCode[$cnt] = $this->getField("period_code");
				$this->periodName[$cnt] = $this->getField("name");
				$this->periodSDate[$cnt] = $this->getField("sdate");
				$this->periodEDate[$cnt] = $this->getField("edate");
				$this->periodApplyNo[$cnt] = $this->getField("apply_no");
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

		function getRateList($period) {
			$this->clearSQL();
			$this->appendSQL("SELECT a.rate_code, a.name rate_nm, price FROM $this->rateTableName a ");
			$this->appendSQL("LEFT JOIN $this->priceTableName b ON a.rate_code=b.rate_code ");
			$this->appendSQL("LEFT JOIN $this->periodTableName c ON b.period_code=c.period_code WHERE c.period_code='$period' ORDER BY price DESC");
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

		function getDepositAmount($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) AS deposit_amt FROM $this->paymentTableName WHERE pay_kind IN ('DB','DI','DP','DF','DD','DC','DR','CO','DO','CF','RR','CR','OP','OR') AND apply_no='$no' ORDER BY pay_dt");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("deposit_amt");
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
			$this->appendSQL("SELECT * FROM $this->paymentTableName WHERE pay_kind IN ('DB','DI','DP','DF','DD','DC','DR','DW','CO','DO','CF','RR','CR','OP','OR','OC') AND apply_no='$no' ORDER BY pay_dt");
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
			$this->appendSQL("SELECT * FROM $this->paymentTableName WHERE pay_kind NOT IN ('DB','DI','DP','DF','DD','DC','DR','DW','CO','DO','CF','RR','CR','OP','OR','OC') AND apply_no='$no' ORDER BY pay_dt");
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

		function getPaymentAmount($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) AS pr_sum FROM $this->paymentTableName WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("pr_sum");
			$this->freeResult();
			return $returnValue;
		}

		function getApplicationInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->applyTableName a LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code ");
			$this->appendSQL("LEFT JOIN $this->roomTableName c ON a.room_code=c.room_code LEFT JOIN $this->rateTableName d ON a.rate_code=d.rate_code ");
			$this->appendSQL("LEFT JOIN $this->studentTableName e ON a.email=e.email LEFT JOIN $this->priceTableName f ON a.period_code=f.period_code AND a.rate_code=f.rate_code WHERE a.apply_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->applyNumber = $this->getField("a.apply_no");
				$this->applyState = $this->getField("state");
				$this->applyKind = $this->getField("e.kind");
				$this->applyDate = $this->getField("apply_date");
				$this->applyAccount = $this->getField("a.account");//$this->getField("e.account");
				$this->personStudentNo = $this->getField("info_no");
				$this->personStudentID = $this->getField("e.student_id");
				$this->personFirstName = $this->getField("e.fname");
				$this->personMiddleName = $this->getField("e.mname");
				$this->personLastName = $this->getField("e.lname");
				$this->personPreferName = $this->getField("e.prefer");
				$this->personKoreanName = $this->getField("e.name_kr");
				$this->personGender = $this->getField("e.gender");
				$this->personBirthDate = $this->getField("e.dob");
				$this->personNationality = $this->getField("e.nationality");
				$this->personProvince = $this->getField("e.province");
				$this->personHomeUni = $this->getField("e.home_uni");
				$this->personHomeAddr = $this->getField("e.home_addr");
				if ($this->getField("home_addr1")) $this->personHomeAddr .= ", " . $this->getField("e.home_addr1");
				if ($this->getField("home_addr2")) $this->personHomeAddr .= ", " . $this->getField("e.home_addr2");
				if ($this->getField("home_city")) $this->personHomeAddr .= ", " . $this->getField("e.home_city");
				if ($this->getField("home_state")) $this->personHomeAddr .= ", " . $this->getField("e.home_state");
				if ($this->getField("home_country")) $this->personHomeAddr .= ", " . $this->getField("e.home_country");
				if ($this->getField("home_postal")) $this->personHomeAddr .= " [" . $this->getField("e.home_postal") . "]";
				$this->personEmail = $this->getField("e.email");
				$this->personPhone = $this->getField("e.phone");
				$this->personCell = $this->getField("e.cell");
				$this->personMajor = $this->getField("e.major");
				$this->personClass = $this->getField("e.class");
				$this->currentResident = $this->getField("e.current");
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
				$this->contactName = $this->getField("e.case_name");
				$this->contactRelation = $this->getField("e.case_relate");
				$this->contactPhone = $this->getField("e.case_phone");
				$this->contactAddress = $this->getField("e.case_addr");
				$this->linkRoomCode = $this->getField("a.room_code");
				$this->linkRoomPhone = $this->getField("ph");
				$this->linkRoomIP = $this->getField("ip");
				$this->linkRateCode = $this->getField("a.rate_code");
				$this->linkPeriodCode = $this->getField("a.period_code");
				$this->linkPeriodName = $this->getField("b.name");
				$this->linkPeriodSDate = $this->getField("b.sdate");
				$this->linkPeriodEDate = $this->getField("b.edate");
				$this->settleFlag1 = $this->getField("settle1");
				$this->settleFlag2 = $this->getField("settle2");
				$this->settleFlag3 = $this->getField("settle3");
				$this->settleFlag4 = $this->getField("settle4");
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

		function insertApplication($no, $email, $room_prefer, $mate_nm, $mate_id, $mate_dob, $pre1, $pre2, $pre3, $pre4, $pre5, $pre6, $room, $period) {
			$checkin = $this->getCheckinDate($period);
			$checkout = $this->getCheckoutDate($period);
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->applyTableName (apply_no, email, room_prefer, mate_name, mate_id, mate_dob, match_nosmoke, match_bed, match_getup, match_silence, match_study, match_local, apply_date, room_code, checkin_dt, checkout_dt, period_code)");
			$this->appendSQL("VALUES ('$no', '$email', '$room_prefer', '$mate_nm', '$mate_id', '$mate_dob', '$pre1', '$pre2', '$pre3', '$pre4', '$pre5', '$pre6', now(), '$room', '$checkin', '$checkout', '$period')");
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
			}
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
				}
			}
			$returnValue = true;
			return $returnValue;
		}

		function updateApplication($no, $email, $room_prefer, $mate_nm, $mate_id, $mate_dob, $pre1, $pre2, $pre3, $pre4, $pre5, $pre6, $room, $period) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->applyTableName SET email='$email', room_prefer='$room_prefer', mate_name='$mate_nm', mate_id='$mate_id', ");
			$this->appendSQL("mate_dob='$mate_dob', match_nosmoke='$pre1', match_bed='$pre2', match_getup='$pre3', match_silence='$pre4', match_study='$pre5', ");
			$this->appendSQL("match_local='$pre6', period_code='$period', room_code='$room' WHERE apply_no=$no");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function deletePreference($no) {
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->preferenceTableName WHERE apply_no=$no");
			$returnValue = $this->execQuery();
 			return $returnValue;
		}

		function deleteApplication($no) {
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

		function getRefundInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->refundTableName a LEFT JOIN $this->periodTableName b ON a.new_period=b.period_code WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->refundApprove = $this->getField("approve");
				$this->refundApply = $this->getField("apply_no");
				$this->refundCFApply = $this->getField("cf_apply_no");
				$this->refundDeduction = $this->getField("deduction");
				$this->refundDate = $this->getField("post_dt");
				$this->refundPeriod = $this->getField("b.name");
				$this->refundMethodType = $this->getField("method_type");
				$this->refundMethodInfo1 = $this->getField("method_info1");
				$this->refundMethodInfo2 = $this->getField("method_info2");
				if ($this->getField("method_type") == "O") {
					$this->refundMethodAddress1 = $this->getField("addr1");
					$this->refundMethodAddress2 = $this->getField("addr2");
					$this->refundMethodCountry = $this->getField("country");
				} else {
					if ($this->getField("addr1")) $this->refundMethodInfo2 .= ", " . $this->getField("addr1");
					if ($this->getField("addr2")) $this->refundMethodInfo2 .= ", " . $this->getField("addr2");
					if ($this->getField("city")) $this->refundMethodInfo2 .= ", " . $this->getField("city");
					if ($this->getField("state")) $this->refundMethodInfo2 .= ", " . $this->getField("state");
					if ($this->getField("country")) $this->refundMethodInfo2 .= ", " . $this->getField("country");
					if ($this->getField("postal")) $this->refundMethodInfo2 .= " [" . $this->getField("postal") . "]";
				}
				$this->refundMethodInfo3 = $this->getField("method_info3");
				$this->refundMethodInfo4 = $this->getField("method_info4");
				$this->refundMethodInfo5 = $this->getField("method_info5");
				$this->refundMethodInfo6 = $this->getField("method_info6");
			}
			$this->freeResult();
		}

		function insertRefund($no, $cf_no, $student, $fname, $mname, $lname, $dob, $email, $vacate, $method, $info1, $info2, $info3, $info4, $info5, $info6, $addr1, $addr2, $city, $state, $postal, $country, $room, $old, $new) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->refundTableName (apply_no, cf_apply_no, student_id, fname, mname, lname, dob, email, vacate_dt, post_dt, method_type, method_info1, method_info2, method_info3, method_info4, method_info5, method_info6, addr1, addr2, city, state, postal, country, room_code, old_period, new_period)");
			$this->appendSQL("VALUES ('$no', '$cf_no', '$student', '$fname', '$mname', '$lname', '$dob', '$email', '$vacate', now(), '$method', '$info1', '$info2', '$info3', '$info4', '$info5', '$info6', '$addr1', '$addr2', '$city', '$state', '$postal', '$country', '$room', '$old', '$new')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->refundNumber = $this->getInsertID();
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