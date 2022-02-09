<?
	include_once("class.cMysql.php");

	class cFaculty extends cMysql {
		var $facultyTableName;
		var $rateTableName;
		var $paymentTableName;
		var $roomTableName;
		var $bookTableName;
		var $roomCode = array();
		var $roomPhone = array();
		var $roomIP = array();
		var $payListNumber = array();
		var $payListKind = array();
		var $payListDetail = array();
		var $payListDate = array();
		var $payListPrice = array();
		var $rateListCode = array();
		var $rateListDormitory = array();
		var $rateListUnit = array();
		var $facultyNumber;
		var $facultyState;
		var $facultyTitle;
		var $facultyLName;
		var $facultyFName;
		var $facultyMName;
		var $facultyKName;
		var $facultyEmployee;
		var $facultyPurpose;
		var $facultyKDepart;
		var $facultyKPosition;
		var $facultyHDepart;
		var $facultyHPosition;
		var $facultyNationality;
		var $facultyDOB;
		var $facultyCountry;
		var $facultyEmail;
		var $facultyPhone;
		var $facultyArrival;
		var $facultyDeparture;
		var $facultyAffiliate;
		var $facultyNoRoom;
		var $facultyPMethod;
		var $facultyRLName;
		var $facultyRFName;
		var $facultyRMName;
		var $facultyRDepart;
		var $facultyRPosition;
		var $facultyREmail;
		var $facultyRPhone;
		var $facultySettle1;
		var $facultySettle2;
		var $facultySettle3;
		var $facultySettle4;
		var $facultyDate;
		var $facultyRate;
		var $facultyDormitory;
		var $facultyUnit;
		var $facultyPayment;
		var $facultyRequest;
		var $feeType;
		var $feeRate;
		var $feeDeposit;
		var $feeRental;

		function cFaculty($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl4, $tbl5) {
			$this->facultyTableName = $tbl1;
			$this->rateTableName = $tbl2;
			$this->paymentTableName = $tbl3;
			$this->roomTableName = $tbl4;
			$this->bookTableName = $tbl5;
			$this->cMysql($host, $id, $pw, $db);
		}

		function getStateValue($val){
			if ($val == "IW") $returnValue = "Applied";
			else if ($val == "AS") $returnValue = "Assigned";
			else if ($val == "CC") $returnValue = "Cancelled";
			else if ($val == "CF") $returnValue = "Confirmed";
			else if ($val == "PR") $returnValue = "Paid Rental Fee";
			else if ($val == "PD") $returnValue = "Paid Deposit";
			else if ($val == "RF") $returnValue = "Refund";
			else if ($val == "CO") $returnValue = "Checked-out";
			else if ($val == "DR") $returnValue = "Deposit Refunded";
			else if ($val == "PP") $returnValue = "Payment Delayed";
			else if ($val == "WW") $returnValue = "Waiting";
			else $returnValue = "";
			return $returnValue;
		}

		function getDetailValue($val) {
			if ($val == "DB") $returnValue="Deposit Billed";
			else if ($val == "DP") $returnValue="Deposit Partially Paid";
			else if ($val == "DF") $returnValue="Deposit Paid";
			else if ($val == "DW") $returnValue="Deposit Payment Waived";
			else if ($val == "DQ") $returnValue="Deposit Refund Requested";
			else if ($val == "DX") $returnValue="Deposit Carried Forward Requested";
			else if ($val == "DR") $returnValue="Deposit Refunded";
			else if ($val == "DC") $returnValue="Deposit Carried Over";
			else if ($val == "DD") $returnValue="Damage Deduction";
			else if ($val == "RB") $returnValue="Rental Fee Billed";
			else if ($val == "RF") $returnValue="Rental Fee Paid";
			else if ($val == "RP") $returnValue="Rental Fee Partially Paid";
			else if ($val == "RD") $returnValue="Rental Fee Deducted from Deposit";
			else if ($val == "RW") $returnValue="Rental Fee Waived";
			else if ($val == "RQ") $returnValue="Rental Fee Refund Request";
			else if ($val == "RR") $returnValue="Rental Fee Refunded";
			else if ($val == "OR") $returnValue="Overpayment Refunded";
			else if ($val == "OC") $returnValue="Overpayment Carried Over";
			else if ($val == "CF") $returnValue="Cancellation Fee";
			//else if ($val == "RR") $returnValue = "Rental fee reimbursed";
			//else if ($val == "LF") $returnValue = "Late Fee";
			else $returnValue = "Etc.";
			return $returnValue;
		}

		function getDormitoryCode($val) {
			if ($val == "IFRH_CJ") $returnValue = "CJ I-HOUSE";
			else if ($val == "ISRH_CJ") $returnValue = "CJ I-HOUSE";
			else if ($val == "IFRH_FH") $returnValue = "IFH";
			else $returnValue = "";
			return $returnValue;
		}

		function getDormitoryValue($val){
			if ($val == "IFRH_CJ") $returnValue = "CJ Int.House";
			else if ($val == "ISRH_CJ") $returnValue = "CJ Int. House";
			else if ($val == "IFRH_FH") $returnValue = "Int. Fac. Housing";
			else if ($val == "ISRH_AN") $returnValue = "Anam Hall";
			else $returnValue = "";
			return $returnValue;
		}

		function getDormitoryValue1($val){
			if ($val == "IFRH_CJ") $returnValue = "International Faculty Residence Halls - CJ International House";
			else if ($val == "ISRH_CJ") $returnValue = "International Student Residence Halls - CJ International House";
			else if ($val == "IFRH_FH") $returnValue = "International Faculty Residence Halls - International Faculty Housing";
			else $returnValue = "";
			return $returnValue;
		}

		function getSettleValue($val){
			if ($val == "Y") $returnValue = "전결";
			else $returnValue = "";
			return $returnValue;
		}

		function getPaymentMethod($val){
			if ($val == "S") $returnValue = "Self - Wire Transfer (사용인 부담)";
			else if ($val == "R") $returnValue = "Reference - Wire Transfer (추천인 부담)";
			else $returnValue = "";
			return $returnValue;
		}

		function getPaymentValue($val){
			if ((int)$val < 0) $returnValue = "납부";
			else $returnValue = "청구";
			return $returnValue;
		}

		function getAffiliateValue($val){
			if ($val == "Y") $returnValue = "Korea Univ. Affilated";
			else if ($val == "N") $returnValue = "Non-Affilated";
			else $returnValue = "";
			return $returnValue;
		}

		function isExist($no, $fnm, $mnm, $lnm) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no FROM $this->facultyTableName WHERE apply_no='$no' AND fname='$fnm' AND mname='$mnm' AND lname='$lnm'");
			$this->parseQuery();
			if ($this->getNumberRows() > 0) $returnValue = true;
			$this->freeResult();
			return $returnValue;
		}

		function getFacultyNumber($dt) {
			$returnValue = "";
			$where = "";
			if ($dt) $where = "WHERE apply_no>$dt" . "0000";
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt FROM $this->facultyTableName $where");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			$this->freeResult();
			return $returnValue;
		}

		function getRoomValue($no) {
			$cnt = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT a.room_code, ph, ip FROM $this->bookTableName a LEFT JOIN $this->roomTableName b ON a.room_code=b.room_code WHERE apply_no='$no' ORDER BY a.room_code");
			$this->parseQuery();
			while (!$this->EOF) {
				$this->roomCode[$cnt] = $this->getField("room_code");
				$this->roomPhone[$cnt] = $this->getField("ph");
				$this->roomIP[$cnt] = $this->getField("ip");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getRoomDate($no) {
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT MAX(assign_date) AS max_dt FROM $this->bookTableName WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("max_dt");
			$this->freeResult();
			return $returnValue;
		}

		function getRateValue($rate) {
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT unit, dorm_code FROM $this->rateTableName WHERE rate_code='$rate'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getDormitoryValue1($this->getField("dorm_code")) . " - " . $this->getField("unit");
			$this->freeResult();
			return $returnValue;
		}

		function getPaymentList($no, $dt="") {
			$this->payListNumber = null;
			$this->payListKind = null;
			$this->payListDetail = null;
			$this->payListDate = null;
			$this->payListPrice = null;
			if (trim($dt) != "") $dt = "AND DATE_FORMAT(pay_dt, '%Y-%m')='$dt'";
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->paymentTableName WHERE apply_no='$no' $dt ORDER BY pay_dt");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->payListNumber[$cnt] = $this->getField("pay_no");
				$this->payListKind[$cnt] = $this->getField("his_kind");
				$this->payListDetail[$cnt] = $this->getField("pay_kind");
				$this->payListDate[$cnt] = $this->getField("pay_dt");
				$this->payListPrice[$cnt] = $this->getField("price");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getPaymentList1($no) {
			$this->payListNumber = null;
			$this->payListKind = null;
			$this->payListDetail = null;
			$this->payListDate = null;
			$this->payListPrice = null;
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->paymentTableName WHERE apply_no='$no' AND DATE_FORMAT(pay_dt, '%Y-%m-%d')<='" . date("Y-m-d") . "' ORDER BY pay_dt");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->payListNumber[$cnt] = $this->getField("pay_no");
				$this->payListKind[$cnt] = $this->getField("his_kind");
				$this->payListDetail[$cnt] = $this->getField("pay_kind");
				$this->payListDate[$cnt] = $this->getField("pay_dt");
				$this->payListPrice[$cnt] = $this->getField("price");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getRateList() {
			$this->clearSQL();
			$this->appendSQL("SELECT rate_code, dorm_code, unit FROM $this->rateTableName WHERE dorm_code<>'ISRH_CJ' AND rate_code<>'DEPART' ORDER BY order_no");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->rateListCode[$cnt] = $this->getField("rate_code");
				$this->rateListDormitory[$cnt] = $this->getField("dorm_code");
				$this->rateListUnit[$cnt] = $this->getField("unit");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getFacultyInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT a.apply_no, state, title, lname, fname, mname, name_kr, employee, purpose, depart_ku, position_ku, depart_hm, position_hm, ");
			$this->appendSQL("nationality, dob, country, email, phone, arrival, departure, affiliate, no_room, payment, ref_lname, ref_fname, ref_mname, ");
			$this->appendSQL("ref_depart, ref_position, ref_email, ref_phone, settle1, settle2, settle3, settle4, apply_date, a.rate_code, dorm_code, ");
			$this->appendSQL("unit, request, SUM(price) pay_pr FROM $this->facultyTableName a LEFT JOIN $this->rateTableName b ON a.rate_code=b.rate_code ");
			$this->appendSQL("LEFT JOIN $this->paymentTableName c ON a.apply_no=c.apply_no WHERE a.apply_no=$no GROUP BY a.apply_no");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->facultyNumber = $this->getField("apply_no");
				$this->facultyState = $this->getField("state");
				$this->facultyTitle = $this->getField("title");
				$this->facultyLName = $this->getField("lname");
				$this->facultyFName = $this->getField("fname");
				$this->facultyMName = $this->getField("mname");
				$this->facultyKName = $this->getField("name_kr");
				$this->facultyEmployee = $this->getField("employee");
				$this->facultyPurpose = $this->getField("purpose");
				$this->facultyKDepart = $this->getField("depart_ku");
				$this->facultyKPosition = $this->getField("position_ku");
				$this->facultyHDepart = $this->getField("depart_hm");
				$this->facultyHPosition = $this->getField("position_hm");
				$this->facultyNationality = $this->getField("nationality");
				$this->facultyDOB = $this->getField("dob");
				$this->facultyCountry = $this->getField("country");
				$this->facultyEmail = $this->getField("email");
				$this->facultyPhone = $this->getField("phone");
				$this->facultyArrival = $this->getField("arrival");
				$this->facultyDeparture = $this->getField("departure");
				$this->facultyAffiliate = $this->getField("affiliate");
				$this->facultyNoRoom = $this->getField("no_room");
				$this->facultyPMethod = $this->getField("payment");
				$this->facultyRLName = $this->getField("ref_lname");
				$this->facultyRFName = $this->getField("ref_fname");
				$this->facultyRMName = $this->getField("ref_mname");
				$this->facultyRDepart = $this->getField("ref_depart");
				$this->facultyRPosition = $this->getField("ref_position");
				$this->facultyREmail = $this->getField("ref_email");
				$this->facultyRPhone = $this->getField("ref_phone");
				$this->facultySettle1 = $this->getField("settle1");
				$this->facultySettle2 = $this->getField("settle2");
				$this->facultySettle3 = $this->getField("settle3");
				$this->facultySettle4 = $this->getField("settle4");
				$this->facultyDate = $this->getField("apply_date");
				$this->facultyRate = $this->getField("rate_code");
				$this->facultyDormitory = $this->getField("dorm_code");
				$this->facultyUnit = $this->getField("unit");
				$this->facultyPayment = $this->getField("pay_pr");
				$this->facultyRequest = $this->getField("request");
			}
			$this->freeResult();
		}

		function insertFaculty($no, $title, $lnm, $fnm, $mnm, $nm_kr, $employ, $purpose, $kdepart, $kpos, $hdepart, $hpos, $nation, $dob, $country, $email, $ph, $arrival, $departure, $affiliate, $no_room, $pay, $rlnm, $rfnm, $rmnm, $rdepart, $rpos, $remail, $rph, $rate, $request, $admin) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->facultyTableName (apply_no, title, lname, fname, mname, name_kr, employee, purpose, depart_ku, position_ku, ");
			$this->appendSQL("depart_hm, position_hm, nationality, dob, country, email, phone, arrival, departure, affiliate, no_room, payment, ");
			$this->appendSQL("ref_lname, ref_fname, ref_mname, ref_depart, ref_position, ref_email, ref_phone, apply_date, rate_code, request) VALUES ('$no', ");
			$this->appendSQL("'$title', '$lnm', '$fnm', '$mnm', '$nm_kr', '$employ', '$purpose', '$kdepart', '$kpos', '$hdepart', '$hpos', '$nation', ");
			$this->appendSQL("'$dob', '$country', '$email', '$ph', '$arrival', '$departure', '$affiliate', $no_room, '$pay', '$rlnm', '$rfnm', ");
			$this->appendSQL("'$rmnm', '$rdepart', '$rpos', '$remail', '$rph', now(), '$rate', '$request')");
			$returnValue = $this->execQuery();
			if ($returnValue) $this->facultyNumber = $this->getInsertID();
			return $returnValue;
		}

		function insertPayment($apply, $kind, $detail, $dt, $pr) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->paymentTableName (apply_no, his_kind, pay_kind, pay_dt, price) VALUES ('$apply', '$kind', '$detail', '$dt', $pr)");
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

		function deletePayment($no) {
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->paymentTableName WHERE pay_no=$no");
			$returnValue = $this->execQuery();
 			return $returnValue;
		}

		function deletePayment1($no, $kind) {
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->paymentTableName WHERE apply_no=$no AND pay_kind='$kind'");
			$returnValue = $this->execQuery();
 			return $returnValue;
		}

		function calculateFee($rate, $affiliate, $day, $month, $total) {
			$price_mm = 0;
			$price_dd = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT pr_day_ku, pr_day_non, pr_month_ku, pr_month_non FROM $this->rateTableName WHERE rate_code='$rate'");
			$this->parseQuery();
			if (!$this->EOF) {
				if ($affiliate == "Y") {
					$price_mm = (int)$this->getField("pr_month_ku");
					$price_dd = (int)$this->getField("pr_day_ku");
				} else {
					$price_mm = (int)$this->getField("pr_month_non");
					$price_dd = (int)$this->getField("pr_day_non");
				}
			}
			$this->freeResult();
			if ($month > 0) {
				if ($price_mm > 0) {
					$this->feeType = "mm";
					$this->feeRate = $price_mm;
					$this->feeDeposit = $price_mm * 1.5;
					$this->feeRental = $price_mm * $month;
					if ($day > 15) $this->feeRental = $this->feeRental + $price_mm;
					else if ($day > 0) $this->feeRental = $this->feeRental + ($price_mm / 2);
				} else {
					$this->feeType = "dd";
					$this->feeRate = $price_dd;
					$this->feeDeposit = $price_dd * 30 * 1.5;
					$this->feeRental = $price_dd * $total;
				}
			} else {
				$this->feeType = "dd";
				$this->feeRate = $price_dd;
				$this->feeDeposit = 0;
				$this->feeRental = $price_dd * $day;
			}
		}

		function calculateFee1($no, $rate, $checkin, $checkout, $room_cnt) {
			$price_mm = 0;
			$price_dd = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT pr_day_ku, pr_day_non, pr_month_ku, pr_month_non FROM $this->rateTableName WHERE rate_code='$rate'");
			$this->parseQuery();
			if (!$this->EOF) {
				$price_mm = (int)$this->getField("pr_month_ku");
				$price_dd = (int)$this->getField("pr_day_ku");
			}
			$this->freeResult();
			$month_cnt = 1;
			$day = 0;
			$end_day = 0;
			$deposit = 0;
			$rental = 0;
			$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($checkin, 5, 2) + $month_cnt++, substr($checkin, 8, 2), substr($checkin, 0, 4)));
			if ($checkout < $temp_dt) {
				$this->feeType = "dd";
				$this->feeRate = $price_dd;
				if (substr($checkin, 0, 7) < substr($checkout, 0, 7)) {
					$end_day = (int)date("t", mktime(0, 0, 0, substr($checkin, 5, 2), 1, substr($checkin, 0, 4)));
					$day = $end_day - (int)substr($checkin, 8, 2) + (int)substr($checkout, 8, 2);
				} else $day = (int)substr($checkout, 8, 2) - (int)substr($checkin, 8, 2);
				$deposit = 0;
				$rental = $price_dd * $day * $room_cnt;
				if (substr($checkin, 0, 10) >= "2009-08-01") {
					if ($day >= 7 && $day <= 20) $rental = $rental * 0.9;
					else if ($day >= 21) $rental = $rental * 0.8;
				}
				if ($deposit > 100) $deposit = (int)(substr((int)$deposit, 0, -2) . "00");
				$flag = $this->updateDepositFee($no, $deposit);
				$flag = $this->deletePayment1($no, "RB");
				if ($rental > 100) $rental = (int)(substr((int)$rental, 0, -2) . "00");
				if ($rental) $flag = $this->insertPayment($no, "R", "RB", date("Y-m-d"), $rental);
			} else {
				if (substr($checkin, 0, 10) > "2010-02-28") {
					if ($rate == "STUDIO1") $increase = 50000;
					else if ($rate == "DOUBLE") $increase = 70000;
					else if ($rate == "FAMILY") $increase = 70000;
					else if ($rate == "STUDIO2") $increase = 80000;
					else if ($rate == "1BED") $increase = 120000;
					else if ($rate == "2BED") $increase = 170000;
					else $increase = 0;
				} else if (substr($checkin, 0, 10) > "2009-02-28") {
					if ($rate == "STUDIO1") $increase = 50000;
					else if ($rate == "DOUBLE") $increase = 70000;
					else if ($rate == "FAMILY") $increase = 70000;
					else if ($rate == "STUDIO2") $increase = 50000;
					else if ($rate == "1BED") $increase = 80000;
					else if ($rate == "2BED") $increase = 110000;
					else $increase = 0;
				} else if (substr($checkin, 0, 10) > "2008-02-29") {
					if ($rate == "STUDIO1") $increase = 50000;
					else if ($rate == "DOUBLE") $increase = 70000;
					else if ($rate == "FAMILY") $increase = 70000;
					else if ($rate == "STUDIO2") $increase = 20000;
					else if ($rate == "1BED") $increase = 40000;
					else if ($rate == "2BED") $increase = 50000;
					else $increase = 0;
				} else $increase = 0;
				$this->feeType = "mm";
				$this->feeRate = $price_mm + $increase;
				$flag = $this->deletePayment1($no, "RB");
				$deposit = ($price_mm + $increase) * 1.5 * $room_cnt;
				if ($deposit > 100) $deposit = (int)(substr((int)$deposit, 0, -2) . "00");
				$flag = $this->updateDepositFee($no, $deposit);
				$loop_flag = true;
				do {
					if (substr($temp_dt, 0, 10) > "2010-03-31") {
						if ($rate == "STUDIO1") $increase = 50000;
						else if ($rate == "DOUBLE") $increase = 70000;
						else if ($rate == "FAMILY") $increase = 70000;
						else if ($rate == "STUDIO2") $increase = 80000; // 570,000
						else if ($rate == "1BED") $increase = 120000;
						else if ($rate == "2BED") $increase = 170000;
						else $increase = 0;
					} else if (substr($temp_dt, 0, 10) > "2009-03-31") {
						if ($rate == "STUDIO1") $increase = 50000;
						else if ($rate == "DOUBLE") $increase = 70000;
						else if ($rate == "FAMILY") $increase = 70000;
						else if ($rate == "STUDIO2") $increase = 50000; // 540,000
						else if ($rate == "1BED") $increase = 80000;
						else if ($rate == "2BED") $increase = 110000;
						else $increase = 0;
					} else if (substr($temp_dt, 0, 10) > "2008-03-31") {
						if ($rate == "STUDIO1") $increase = 50000;
						else if ($rate == "DOUBLE") $increase = 70000;
						else if ($rate == "FAMILY") $increase = 70000;
						else if ($rate == "STUDIO2") $increase = 20000; // 510,000
						else if ($rate == "1BED") $increase = 40000;
						else if ($rate == "2BED") $increase = 50000;
						else $increase = 0;
					} else $increase = 0;
					if ((int)substr($temp_dt, 8, 2) == 1) $rental = ($price_mm + $increase) * $room_cnt;
					else {
						$end_day = (int)date("t", mktime(0, 0, 0, substr($temp_dt, 5, 2) - 1, 1, substr($temp_dt, 0, 4)));
						$day = $end_day - (int)substr($temp_dt, 8, 2) + 1;
						$rental = ($price_mm + $increase) * ($day / $end_day) * $room_cnt;
					}
					$temp = date("Y-m-d", mktime(0, 0, 0, substr($temp_dt, 5, 2) - 1, 1, substr($temp_dt, 0, 4)));
					if ($temp < $checkin) $temp = $checkin;
					if ($rental > 100) $rental = (int)(substr((int)$rental, 0, -2) . "00");
					if ($rental) $flag = $this->insertPayment($no, "R", "RB", $temp, $rental);
					if (substr($checkout, 0, 7) == substr($temp_dt, 0, 7)) {
						$end_day = (int)date("t", mktime(0, 0, 0, substr($temp_dt, 5, 2), 1, substr($temp_dt, 0, 4)));
						$day = (int)substr($checkout, 8, 2) - 1;
						$rental = ($price_mm + $increase) * ($day / $end_day) * $room_cnt;
						if ($rental > 100) $rental = (int)(substr((int)$rental, 0, -2) . "00");
						if ($rental) $flag = $this->insertPayment($no, "R", "RB", date("Y-m-d", mktime(0, 0, 0, substr($temp_dt, 5, 2), 1, substr($temp_dt, 0, 4))), $rental);
						$loop_flag = false;
					} else $temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($checkin, 5, 2) + $month_cnt++, 1, substr($checkin, 0, 4)));
				} while ($loop_flag);
			}
		}

		function updateDepositFee($apply, $price) {
			$no = "";
			$date = "";
			$detail = "";
			$this->clearSQL();
			$this->appendSQL("SELECT pay_no, pay_dt, pay_kind FROM $this->paymentTableName WHERE apply_no=$apply AND his_kind='D'");
			$this->parseQuery();
			if (!$this->EOF) {
				$no = $this->getField("pay_no");
				$date = $this->getField("pay_dt");
				$detail = $this->getField("pay_kind");
			}
			$this->freeResult();
			if ($no) {
				if ($price) $returnValue = $this->updatePayment($no, $date, $price, $detail);
				else $returnValue = $this->deletePayment($no);
			} else if ($price) $returnValue = $this->insertPayment($apply, "D", "DB", date("Y-m-d"), $price);
			return $returnValue;
		}

		function updateRentalFee($apply, $price) {
			$no = "";
			$date = "";
			$detail = "";
			$this->clearSQL();
			$this->appendSQL("SELECT pay_no, pay_dt, pay_kind FROM $this->paymentTableName WHERE apply_no=$apply AND his_kind='R'");
			$this->parseQuery();
			if (!$this->EOF) {
				$no = $this->getField("pay_no");
				$date = $this->getField("pay_dt");
				$detail = $this->getField("pay_kind");
			}
			$this->freeResult();
			if ($no) {
				if ($price) $returnValue = $this->updatePayment($no, $date, $price, $detail);
				else $returnValue = $this->deletePayment($no);
			} else if ($price) $returnValue = $this->insertPayment($apply, "R", "RB", date("Y-m-d"), $price);
			return $returnValue;
		}
	}
?>