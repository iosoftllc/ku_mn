<?
	include_once("class.cMysql.php");

	class cFaculty extends cMysql {
		var $facultyTableName;
		var $facultyAttachTableName;
		var $rateTableName;
		var $paymentTableName;
		var $roomTableName;
		var $bookTableName;
		var $applyTableName;
		var $historyAccessTableName;
		var $historyWorkTableName;
		var $calendarApply = array();
		var $calendarRoom = array();
		var $calendarName = array();
		var $calendarArrival = array();
		var $calendarDeparture = array();
		var $calendarRateCode = array();
		var $dormListCode = array();
		var $rateListCode = array();
		var $rateListDormitory = array();
		var $rateListUnit = array();
		var $roomListCode = array();
		var $roomListRate = array();
		var $roomListPhone = array();
		var $roomListIP = array();
		var $facListNumber = array();
		var $facListState = array();
		var $facListTitle = array();
		var $facListFName = array();
		var $facListLName = array();
		var $facListKName = array();
		var $facListEmployee = array();
		var $facListPurpose = array();
		var $facListKDepart = array();
		var $facListKPosition = array();
		var $facListHDepart = array();
		var $facListHPosition = array();
		var $facListNationality = array();
		var $facListDOB = array();
		var $facListCountry = array();
		var $facListEmail = array();
		var $facListPhone = array();
		var $facListArrival = array();
		var $facListDeparture = array();
		var $facListAffiliate = array();
		var $facListNoRoom = array();
		var $facListPMethod = array();
		var $facListRFName = array();
		var $facListRLName = array();
		var $facListRDepart = array();
		var $facListRPosition = array();
		var $facListREmail = array();
		var $facListRPhone = array();
		var $facListDiscount = array();
		var $facListDate = array();
		var $facListDormitory = array();
		var $facListUnit = array();
		var $facListTerm = array();
		var $attachListNumber = array();
		var $attachListDate = array();
		var $attachListName = array();
		var $attachListSize = array();
		var $attachListType = array();
		var $payListNumber = array();
		var $payListName = array();
		var $payListKind = array();
		var $payListDetail = array();
		var $payListDate = array();
		var $payListPrice = array();
		var $temp1ListRoom = array();
		var $temp1ListOccupant = array();
		var $temp1ListCount = array();
		var $temp2ListRoom = array();
		var $dateListInvoice = array();
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
		var $facultySettleDate1;
		var $facultySettleDate2;
		var $facultySettleDate3;
		var $facultySettleDate4;
		var $facultyDiscount;
		var $facultyDate;
		var $facultyRate;
		var $facultyDormitory;
		var $facultyUnit;
		var $facultyPayment;
		var $facultyRequest;
		var $facultyAdmin;
		var $feeDeposit;
		var $feeRental;
		var $roomPhone;
		var $roomIP;
		var $errorMessage;
		var $attachmentNumber;

		function cFaculty($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl4, $tbl5, $tbl6, $tbl7, $tbl8, $tbl9) {
			$this->facultyTableName = $tbl1;
			$this->facultyAttachTableName = $tbl2;
			$this->rateTableName = $tbl3;
			$this->paymentTableName = $tbl4;
			$this->roomTableName = $tbl5;
			$this->bookTableName = $tbl6;
			$this->applyTableName = $tbl7;
			$this->historyAccessTableName = $tbl8;
			$this->historyWorkTableName = $tbl9;
			$this->cMysql($host, $id, $pw, $db);
		}

		function getDiscountValue($val) {
			if ($val == "Y") $returnValue = "할인";
			else $returnValue = "미할인";
			return $returnValue;
		}

		function getStateValue($val) {
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

		function getDetailValue($val, $dt="", $checkin="", $checkout="") {
			if ($val == "DB") $returnValue="Deposit Billed";
			else if ($val == "DP") $returnValue="Deposit Partially Paid";
			else if ($val == "DF") $returnValue="Deposit Paid";
			else if ($val == "DW") $returnValue="Deposit Payment Waived";
			else if ($val == "DQ") $returnValue="Deposit Refund Requested";
			else if ($val == "DX") $returnValue="Deposit Carried Forward Requested";
			else if ($val == "DR") $returnValue="Deposit Refunded";
			else if ($val == "DC") $returnValue="Deposit Carried Over";
			else if ($val == "DD") $returnValue="Damage Deduction";
			else if ($val == "RB") {
				$returnValue="Rental Fee Billed";
				if (trim($dt) != "" && trim($checkin) != "" && trim($checkout) != "") {
					$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($checkin, 5, 2) + 1, substr($checkin, 8, 2), substr($checkin, 0, 4)));
					if ($checkout < $temp_dt) $returnValue .= " ($checkin~$checkout)";
					else {
						if (substr($dt, 0, 7) == substr($checkin, 0, 7)) $returnValue .= " ($checkin~";
						else $returnValue .= " ($dt~";
						if (substr($dt, 0, 7) == substr($checkout, 0, 7)) $returnValue .= "$checkout)";
						else $returnValue .= substr($dt, 0, 7) . "-" . date("t", mktime(0, 0, 0, substr($dt, 5, 2), 1, substr($dt, 0, 4))) . ")";
					}
				}
			} else if ($val == "RF") $returnValue="Rental Fee Paid";
			else if ($val == "RP") $returnValue="Rental Fee Partially Paid";
			else if ($val == "RD") $returnValue="Rental Fee Deducted from Deposit";
			else if ($val == "RW") $returnValue="Rental Fee Waived";
			else if ($val == "RQ") $returnValue="Rental Fee Refund Request";
			else if ($val == "RR") $returnValue="Rental Fee Refunded";
			else if ($val == "OR") $returnValue="Overpayment Refunded";
			else if ($val == "OC") $returnValue="Overpayment Carried Over";
			else if ($val == "LB") $returnValue = "Late Fee Billed";
			else if ($val == "LP") $returnValue = "Late Fee Paid";
			else if ($val == "CF") $returnValue = "Cancellation Fee";
			//else if ($val == "RR") $returnValue = "Rental fee reimbursed";
			//else if ($val == "LF") $returnValue = "Late Fee";
			else $returnValue = "Etc.";
			return $returnValue;
		}

		function getDormitoryCode($val) {
			if ($val == "IFRH_CJ") $returnValue = "CJ International House";
			else if ($val == "IFRH_FH") $returnValue = "International Faculty Housing";
			else if ($val == "IFRH_ANAM") $returnValue = "Anam International Housing";
			else $returnValue = "";
			return $returnValue;
		}

		function getDormitoryValue($val) {
			if ($val == "IFRH_CJ") $returnValue = "CJ International House";
			else if ($val == "IFRH_FH") $returnValue = "International Faculty Housing";
			else if ($val == "IFRH_ANAM") $returnValue = "Anam International Housing";
			else $returnValue = "";
			return $returnValue;
		}

		function getDormitoryValue1($val) {
			if ($val == "IFRH_CJ") $returnValue = "International Faculty Residence Halls - CJ International House";
			else if ($val == "IFRH_FH") $returnValue = "International Faculty Residence Halls - International Faculty Housing";
			else if ($val == "IFRH_ANAM") $returnValue = "International Faculty Residence Halls - Anam International Housing";
			else $returnValue = "";
			return $returnValue;
		}

		function getDormitoryValue2($val) {
			if ($val == "IFRH_CJ") $returnValue = "CJ";
			else if ($val == "IFRH_FH") $returnValue = "IFH";
			else if ($val == "IFRH_ANAM") $returnValue = "ANAM";
			else $returnValue = "";
			return $returnValue;
		}

		function getSettleValue($val, $dt="0000-00-00") {
			if ($val == "Y") {
				$returnValue = "결재";
				if (trim($dt) != "" && trim($dt) != "0000-00-00") $returnValue .= "<br>" . substr(trim($dt), 2, 8);
			} else $returnValue = "";
			return $returnValue;
		}

		function getPaymentMethod($val) {
			if ($val == "S") $returnValue = "Self - Wire Transfer";
			else if ($val == "R") $returnValue = "Reference - Wire Transfer";
			else $returnValue = "";
			return $returnValue;
		}

		function getPaymentValue($val) {
			if ((int)$val < 0) $returnValue = "납부";
			else $returnValue = "청구";
			return $returnValue;
		}

		function getAffiliateValue($val) {
			if ($val == "Y") $returnValue = "Korea Univ. Affilated";
			else if ($val == "N") $returnValue = "Non-Affilated";
			else $returnValue = "";
			return $returnValue;
		}

		function isRoomCodeExist($code) {
			$returnValue = false;
			if ($code) {
				$this->clearSQL();
				$this->appendSQL("SELECT room_code FROM $this->roomTableName WHERE room_code='$code'");
				$this->parseQuery();
				if (!$this->EOF) $returnValue = true;
				$this->freeResult();
			}
			return $returnValue;
		}

		function isRoomExist($no, $room) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->bookTableName WHERE apply_no='$no' AND room_code='$room'");
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
			$this->appendSQL("SELECT arrival, departure FROM $this->facultyTableName WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) {
				$arrival = $this->getField("arrival");
				$departure = $this->getField("departure");
			}
			$this->freeResult();
			if ($arrival && $departure) {
				$this->clearSQL();
				$this->appendSQL("SELECT occupants, COUNT(a.room_code) AS room_cnt FROM $this->bookTableName a ");
				$this->appendSQL("LEFT JOIN $this->facultyTableName b ON a.apply_no=b.apply_no LEFT JOIN $this->rateTableName c ON b.rate_code=c.rate_code ");
				$this->appendSQL("WHERE a.apply_no<>'$no' AND a.room_code='$room' AND ((arrival<='$arrival' AND departure>'$arrival') OR ");
				$this->appendSQL("(arrival<'$departure' AND departure>='$departure') OR (arrival>'$arrival' AND departure<'$departure')) GROUP BY a.room_code");
				$this->parseQuery();
				//if (!$this->EOF && (int)$this->getField("occupants") <= (int)$this->getField("room_cnt")) $returnValue = false;
				if (!$this->EOF) $returnValue = false;
				$this->freeResult();
				if ($returnValue) {
					$this->clearSQL();
					$this->appendSQL("SELECT apply_no FROM $this->applyTableName WHERE apply_no<>'$no' AND room_code='$room' AND ");
					$this->appendSQL("((checkin_dt<='$arrival' AND checkout_dt>'$arrival') OR (checkin_dt<'$departure' AND checkout_dt>='$departure') OR ");
					$this->appendSQL("(checkin_dt>'$arrival' AND checkout_dt<'$departure'))");
					$this->parseQuery();
					if (!$this->EOF) $returnValue = false;
					$this->freeResult();
				}
			} else $returnValue = false;
			return $returnValue;
		}

		function getCalendarList($rate, $sdt, $edt, $dorm="") {
			$this->clearSQL();
			$this->appendSQL("SELECT a.apply_no, a.room_code, b.title, b.lname, b.fname, b.mname, b.arrival, b.departure, b.rate_code FROM $this->bookTableName a ");
			$this->appendSQL("LEFT JOIN $this->facultyTableName b ON a.apply_no=b.apply_no LEFT JOIN $this->rateTableName c ON b.rate_code=c.rate_code ");
			$this->appendSQL("WHERE b.state NOT IN ('IW','CC') AND ((b.arrival>='$sdt' AND b.arrival<='$edt') OR (b.departure>'$sdt' AND b.departure<='$edt') OR (b.arrival<'$sdt' AND b.departure>'$edt')) ");
			if ($rate) $this->appendSQL("AND b.rate_code='$rate' ");
			if ($dorm) $this->appendSQL("AND c.dorm_code LIKE '" . $dorm . "%' ");
			$this->appendSQL("ORDER BY a.room_code, b.arrival");
			$this->parseQuery();
			$cnt = 0; 
			while (!$this->EOF) {
				$this->calendarApply[$cnt] = $this->getField("apply_no");
				$this->calendarRoom[$cnt] = $this->getField("room_code");
				$this->calendarName[$cnt] = "";
				if ($this->getField("title")) $this->calendarName[$cnt] .= $this->getField("title") . ". ";
				$this->calendarName[$cnt] .= $this->getField("lname");
				if (trim($this->getField("fname"))) $this->calendarName[$cnt] .= ", " . $this->getField("fname");
				if (trim($this->getField("mname"))) $this->calendarName[$cnt] .= " " . $this->getField("mname");
				$this->calendarArrival[$cnt] = $this->getField("arrival");
				$this->calendarDeparture[$cnt] = $this->getField("departure");
				$this->calendarRateCode[$cnt] = $this->getField("rate_code");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
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

		function getFacultyPrice($rate, $type) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT $type FROM $this->rateTableName WHERE rate_code='$rate'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("$type");
			$this->freeResult();
			return $returnValue;
		}

		function getDormList($dorm="") {
			if ($dorm) $dorm = "WHERE dorm_code LIKE '" . $dorm . "%'";
			$this->clearSQL();
			$this->appendSQL("SELECT DISTINCT dorm_code FROM $this->rateTableName $dorm ORDER BY order_no");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->dormListCode[$cnt] = $this->getField("dorm_code");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getRateList($dorm="") {
			if ($dorm) $dorm = "WHERE dorm_code LIKE '" . $dorm . "%'";
			$this->clearSQL();
			$this->appendSQL("SELECT rate_code, dorm_code, unit FROM $this->rateTableName $dorm ORDER BY order_no");
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

		function getRoomList($rate, $arrival, $departure) {
			$this->roomListCode = null;
			$this->clearSQL();
			$this->appendSQL("SELECT a.room_code, occupants, COUNT(a.room_code) AS room_cnt FROM $this->bookTableName a ");
			$this->appendSQL("LEFT JOIN $this->facultyTableName b ON a.apply_no=b.apply_no LEFT JOIN $this->rateTableName c ON b.rate_code=c.rate_code ");
			$this->appendSQL("WHERE b.rate_code='$rate' AND ");
			$this->appendSQL("((arrival<='$arrival' AND departure>'$arrival') OR (arrival<'$departure' AND departure>='$departure') OR (arrival>'$arrival' AND departure<'$departure')) GROUP BY a.room_code ORDER BY a.room_code");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->temp1ListRoom[$cnt] = $this->getField("room_code");
				$this->temp1ListOccupant[$cnt] = $this->getField("occupants");
				$this->temp1ListCount[$cnt] = $this->getField("room_cnt");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
			$this->clearSQL();
			$this->appendSQL("SELECT room_code FROM $this->applyTableName WHERE rate_code='$rate' AND TRIM(room_code)<>'' AND ");
			$this->appendSQL("((checkin_dt<='$arrival' AND checkout_dt>'$arrival') OR (checkin_dt<'$departure' AND checkout_dt>='$departure') OR (checkin_dt>'$arrival' AND checkout_dt<'$departure')) ORDER BY room_code");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->temp2ListRoom[$cnt] = $this->getField("room_code");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
			$temp1_cnt = 0;
			$temp2_cnt = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT room_code FROM $this->roomTableName WHERE rate_code='$rate' ORDER BY room_code");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$flag = true;
				//if ($this->getField("room_code") == $this->temp1ListRoom[$temp1_cnt] && (int)$this->temp1ListOccupant[$temp1_cnt] <= (int)$this->temp1ListCount[$temp1_cnt]) {
				if ($this->getField("room_code") == $this->temp1ListRoom[$temp1_cnt]) {
					$temp1_cnt++;
					$flag = false;
				}
				if ($this->getField("room_code") == $this->temp2ListRoom[$temp2_cnt]) {
					$temp2_cnt++;
					$flag = false;
				}
				if ($flag) {
					$this->roomListCode[$cnt] = $this->getField("room_code");
					$cnt++;
				}
				$this->setNextRecord();
			}
			$this->freeResult();
		}

		function getRoomList1($rate, $dorm="") {
			$where = "";
			if ($rate) $where .= "WHERE a.rate_code='$rate'";
			if ($dorm) {
				if ($where) $where .= " AND dorm_code LIKE '" . $dorm . "%'";
				else $where .= "WHERE dorm_code LIKE '" . $dorm . "%'";
			}
			$this->clearSQL();
			$this->appendSQL("SELECT room_code, a.rate_code FROM $this->roomTableName a LEFT JOIN $this->rateTableName b ON a.rate_code=b.rate_code $where ORDER BY room_code");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->roomListCode[$cnt] = $this->getField("room_code");
				$this->roomListRate[$cnt] = $this->getField("rate_code");
				$cnt++;
				$this->setNextRecord();
			}
			$this->freeResult();
		}

		function getInvoiceDateList($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT DISTINCT DATE_FORMAT(pay_dt, '%Y-%m') AS yy_mm FROM $this->paymentTableName WHERE apply_no=$no AND price>0 ORDER BY yy_mm");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->dateListInvoice[$cnt] = $this->getField("yy_mm");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getFacultyCondition($flag, $dorm, $sdate, $edate, $stype, $stext, $term, $state, $grade, $rate, $room) {
			$returnValue = "";
			$list_dorm = "";
			if ($dorm) {
				$arr_temp = explode(",", $dorm);
				for ($i = 0; $i < count($arr_temp); $i++) {
					$list_dorm .= "'" . $arr_temp[$i] . "',";
				}
				if ($list_dorm) $list_dorm = substr($list_dorm, 0, strlen($list_dorm) - 1);
			}
			if ($list_dorm) {
				if ($returnValue) $returnValue .= " AND b.dorm_code IN ($list_dorm)";
				else $returnValue .= " WHERE b.dorm_code IN ($list_dorm)";
			}
			if ($term == "S") {
				if ($returnValue) $returnValue .= " AND departure<DATE_ADD(arrival, INTERVAL 1 MONTH)";
				else $returnValue .= " WHERE departure<DATE_ADD(arrival, INTERVAL 1 MONTH)";
			} else if ($term == "L") {
				if ($returnValue) $returnValue .= " AND departure>=DATE_ADD(arrival, INTERVAL 1 MONTH)";
				else $returnValue .= " WHERE departure>=DATE_ADD(arrival, INTERVAL 1 MONTH)";
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
			if ($rate) {
				if ($returnValue) $returnValue .= " AND a.rate_code='$rate'";
				else $returnValue .= " WHERE a.rate_code='$rate'";
			}
			if ($room) {
				if ($returnValue) $returnValue .= " AND c.room_code='$room'";
				else $returnValue .= " WHERE c.room_code='$room'";
			}
			if ($sdate && $edate) {
				if ($returnValue) $returnValue .= " AND ((arrival<='$sdate 00:00:00' AND departure>'$sdate 00:00:00') OR (arrival<'$edate 23:59:59' AND departure>='$edate 23:59:59') OR (arrival>'$sdate 00:00:00' AND departure<'$edate 23:59:59'))";
				else $returnValue .= " WHERE ((arrival<='$sdate 00:00:00' AND departure>'$sdate 00:00:00') OR (arrival<'$edate 23:59:59' AND departure>='$edate 23:59:59') OR (arrival>'$sdate 00:00:00' AND departure<'$edate 23:59:59'))";
			} else if ($sdate && !$edate) {
				if ($returnValue) $returnValue .= " AND ((arrival<='$sdate 00:00:00' AND departure>'$sdate 00:00:00') OR (arrival<'2100-12-31 23:59:59' AND departure>='2100-12-31 23:59:59') OR (arrival>'$sdate 00:00:00' AND departure<'2100-12-31 23:59:59'))";
				else $returnValue .= " WHERE ((arrival<='$sdate 00:00:00' AND departure>'$sdate 00:00:00') OR (arrival<'2100-12-31 23:59:59' AND departure>='2100-12-31 23:59:59') OR (arrival>'$sdate 00:00:00' AND departure<'2100-12-31 23:59:59'))";
			} else if (!$sdate && $edate) {
				if ($returnValue) $returnValue .= " AND ((arrival<='1900-01-01 00:00:00' AND departure>'1900-01-01 00:00:00') OR (arrival<'$edate 23:59:59' AND departure>='$edate 23:59:59') OR (arrival>'1900-01-01 00:00:00' AND departure<'$edate 23:59:59'))";
				else $returnValue .= " WHERE ((arrival<='1900-01-01 00:00:00' AND departure>'1900-01-01 00:00:00') OR (arrival<'$edate 23:59:59' AND departure>='$edate 23:59:59') OR (arrival>'1900-01-01 00:00:00' AND departure<'$edate 23:59:59'))";
			}
			if (trim($stext) == "") $stype = "0";
			switch ($stype) {
				case "1":
					if ($returnValue) $returnValue .= " AND (fname LIKE '%" . $stext . "%' OR mname LIKE '%" . $stext . "%' OR lname LIKE '%" . $stext . "%')";
					else $returnValue .= " WHERE (fname LIKE '%" . $stext . "%' OR mname LIKE '%" . $stext . "%' OR lname LIKE '%" . $stext . "%')";
					break;
				case "2":
					if ($returnValue) $returnValue .= " AND a.purpose LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE a.purpose LIKE '%" . $stext . "%'";
					break;
				case "3":
					if ($returnValue) $returnValue .= " AND a.apply_no LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE a.apply_no LIKE '%" . $stext . "%'";
					break;
				case "4":
					if ($returnValue) $returnValue .= " AND c.room_code LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE c.room_code LIKE '%" . $stext . "%'";
					break;
				case "5":
					if ($returnValue) $returnValue .= " AND a.email LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE a.email LIKE '%" . $stext . "%'";
					break;
				case "6":
					if ($returnValue) $returnValue .= " AND a.ref_email LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE a.ref_email LIKE '%" . $stext . "%'";
					break;
			}
			if ($flag) {
				if ($returnValue) $returnValue = "FROM $this->facultyTableName a LEFT JOIN $this->rateTableName b ON a.rate_code=b.rate_code LEFT JOIN $this->bookTableName c ON a.apply_no=c.apply_no LEFT JOIN $this->paymentTableName d ON a.apply_no=d.apply_no" . $returnValue . " AND price IS NOT NULL GROUP BY d.pay_no";
				else $returnValue = "FROM $this->facultyTableName a LEFT JOIN $this->rateTableName b ON a.rate_code=b.rate_code LEFT JOIN $this->bookTableName c ON a.apply_no=c.apply_no LEFT JOIN $this->paymentTableName d ON a.apply_no=d.apply_no" . $returnValue . " WHERE price IS NOT NULL GROUP BY d.pay_no";
			} else $returnValue = "FROM $this->facultyTableName a LEFT JOIN $this->rateTableName b ON a.rate_code=b.rate_code LEFT JOIN $this->bookTableName c ON a.apply_no=c.apply_no" . $returnValue . " GROUP BY a.apply_no";
			return $returnValue;
		}

		function getFacultyCount($dorm, $sdate, $edate, $stype, $stext, $term, $state, $grade, $rate, $room) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt " . $this->getFacultyCondition("0", $dorm, $sdate, $edate, $stype, $stext, $term, $state, $grade, $rate, $room));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getNumberRows();
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getFacultyList($start, $size, $dorm, $sdate, $edate, $stype, $stext, $term, $state, $grade, $rate, $room, $sort) {
			if ($sort == "") $sort = " ORDER BY apply_date DESC";
			else $sort = " ORDER BY $sort";
			if ($start != "" || $start == "0") $limit = " LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT a.apply_no, state, title, fname, mname, lname, email, ref_email, arrival, departure, affiliate, apply_date, dorm_code, ");
			$this->appendSQL("unit, no_room " . $this->getFacultyCondition("0", $dorm, $sdate, $edate, $stype, $stext, $term, $state, $grade, $rate, $room) . $sort . $limit);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->facListNumber[$cnt] = $this->getField("apply_no");
				$this->facListState[$cnt] = $this->getField("state");
				$this->facListTitle[$cnt] = $this->getField("title");
				$this->facListFName[$cnt] = $this->getField("fname") . " " . $this->getField("mname");
				$this->facListLName[$cnt] = $this->getField("lname");
				$this->facListEmail[$cnt] = $this->getField("email");
				$this->facListREmail[$cnt] = $this->getField("ref_email");
				$this->facListArrival[$cnt] = $this->getField("arrival");
				$this->facListDeparture[$cnt] = $this->getField("departure");
				$this->facListAffiliate[$cnt] = $this->getField("affiliate");
				$this->facListDate[$cnt] = $this->getField("apply_date");
				$this->facListDormitory[$cnt] = $this->getField("dorm_code");
				$this->facListUnit[$cnt] = $this->getField("unit");
				$this->facListNoRoom[$cnt] = $this->getField("no_room");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getFacultyExcel($dorm, $sdate, $edate, $stype, $stext, $term, $state, $grade, $rate, $room, $sort) {
			if ($sort == "") $sort = " ORDER BY lname, fname, mname";
			else $sort = " ORDER BY $sort";
			$this->clearSQL();
			$this->appendSQL("SELECT a.apply_no, state, title, lname, fname, mname, name_kr, employee, purpose, depart_ku, position_ku, depart_hm, ");
			$this->appendSQL("position_hm, nationality, dob, country, email, phone, arrival, departure, affiliate, no_room, payment, ref_lname, ");
			$this->appendSQL("ref_fname, ref_mname, ref_depart, ref_position, ref_email, ref_phone, discount, apply_date, dorm_code, unit, ");
			$this->appendSQL("DATE_ADD(arrival, INTERVAL 1 MONTH) AS term_dt ");
			$this->appendSQL($this->getFacultyCondition("0", $dorm, $sdate, $edate, $stype, $stext, $term, $state, $grade, $rate, $room) . $sort);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->facListNumber[$cnt] = $this->getField("apply_no");
				$this->facListState[$cnt] = $this->getField("state");
				$this->facListTitle[$cnt] = $this->getField("title");
				$this->facListFName[$cnt] = $this->getField("fname") . " " . $this->getField("mname");
				$this->facListLName[$cnt] = $this->getField("lname");
				$this->facListKName[$cnt] = $this->getField("name_kr");
				$this->facListEmployee[$cnt] = $this->getField("employee");
				$this->facListPurpose[$cnt] = $this->getField("purpose");
				$this->facListKDepart[$cnt] = $this->getField("depart_ku");
				$this->facListKPosition[$cnt] = $this->getField("position_ku");
				$this->facListHDepart[$cnt] = $this->getField("depart_hm");
				$this->facListHPosition[$cnt] = $this->getField("position_hm");
				$this->facListNationality[$cnt] = $this->getField("nationality");
				$this->facListDOB[$cnt] = $this->getField("dob");
				$this->facListCountry[$cnt] = $this->getField("country");
				$this->facListEmail[$cnt] = $this->getField("email");
				$this->facListPhone[$cnt] = $this->getField("phone");
				$this->facListArrival[$cnt] = $this->getField("arrival");
				$this->facListDeparture[$cnt] = $this->getField("departure");
				$this->facListAffiliate[$cnt] = $this->getField("affiliate");
				$this->facListNoRoom[$cnt] = $this->getField("no_room");
				$this->facListPMethod[$cnt] = $this->getField("payment");
				$this->facListRFName[$cnt] = $this->getField("ref_fname") . " " . $this->getField("ref_mname");
				$this->facListRLName[$cnt] = $this->getField("ref_lname");
				$this->facListRDepart[$cnt] = $this->getField("ref_depart");
				$this->facListRPosition[$cnt] = $this->getField("ref_position");
				$this->facListREmail[$cnt] = $this->getField("ref_email");
				$this->facListRPhone[$cnt] = $this->getField("ref_phone");
				$this->facListDiscount[$cnt] = $this->getField("discount");
				$this->facListDate[$cnt] = $this->getField("apply_date");
				$this->facListDormitory[$cnt] = $this->getField("dorm_code");
				$this->facListUnit[$cnt] = $this->getField("unit");
				if ($this->getField("departure") < $this->getField("term_dt")) $this->facListTerm[$cnt] = "단기";
				else if ($this->getField("departure") >= $this->getField("term_dt")) $this->facListTerm[$cnt] = "장기";
				else $this->facListTerm[$cnt] = "";
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getFacultyInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT a.apply_no, state, title, lname, fname, mname, name_kr, employee, purpose, depart_ku, position_ku, depart_hm, position_hm, ");
			$this->appendSQL("nationality, dob, country, email, phone, arrival, departure, affiliate, no_room, payment, ref_lname, ref_fname, ref_mname, ");
			$this->appendSQL("ref_depart, ref_position, ref_email, ref_phone, settle1, settle2, settle3, settle4, settle1_dt, settle2_dt, settle3_dt, settle4_dt, discount, apply_date, a.rate_code, dorm_code, ");
			$this->appendSQL("unit, request, admin, SUM(price) pay_pr FROM $this->facultyTableName a LEFT JOIN $this->rateTableName b ON a.rate_code=b.rate_code ");
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
				$this->facultySettleDate1 = $this->getField("settle1_dt");
				$this->facultySettleDate2 = $this->getField("settle2_dt");
				$this->facultySettleDate3 = $this->getField("settle3_dt");
				$this->facultySettleDate4 = $this->getField("settle4_dt");
				$this->facultyDiscount = $this->getField("discount");
				$this->facultyDate = $this->getField("apply_date");
				$this->facultyRate = $this->getField("rate_code");
				$this->facultyDormitory = $this->getField("dorm_code");
				$this->facultyUnit = $this->getField("unit");
				$this->facultyPayment = $this->getField("pay_pr");
				$this->facultyRequest = $this->getField("request");
				$this->facultyAdmin = $this->getField("admin");
			}
			$this->freeResult();
		}

		function insertFaculty($no, $state, $title, $lnm, $fnm, $mnm, $nm_kr, $employ, $purpose, $kdepart, $kpos, $hdepart, $hpos, $nation, $dob, $country, $email, $ph, $arrival, $departure, $affiliate, $no_room, $pay, $rlnm, $rfnm, $rmnm, $rdepart, $rpos, $remail, $rph, $settle1, $settle2, $settle3, $settle4, $rate, $request, $admin) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->facultyTableName (apply_no, state, title, lname, fname, mname, name_kr, employee, purpose, depart_ku, ");
			$this->appendSQL("position_ku, depart_hm, position_hm, nationality, dob, country, email, phone, arrival, departure, affiliate, no_room, payment, ");
			$this->appendSQL("ref_lname, ref_fname, ref_mname, ref_depart, ref_position, ref_email, ref_phone, settle1, settle2, settle3, settle4, apply_date, ");
			$this->appendSQL("rate_code, request, admin) VALUES ('$no', '$state', '$title', '$lnm', '$fnm', '$mnm', '$nm_kr', '$employ', '$purpose', ");
			$this->appendSQL("'$kdepart', '$kpos', '$hdepart', '$hpos', '$nation', '$dob', '$country', '$email', '$ph', '$arrival', '$departure', ");
			$this->appendSQL("'$affiliate', $no_room, '$pay', '$rlnm', '$rfnm', '$rmnm', '$rdepart', '$rpos', '$remail', '$rph', '$settle1', '$settle2', '$settle3', ");
			$this->appendSQL("'$settle4', now(), '$rate', '$request', '$admin')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->facultyNumber = $this->getInsertID();
				$no = $this->facultyNumber;
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$no 객실예약 정보 추가";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'F', 'R', 'N', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function copyFaculty($no, $rate) {
			global $ihouse_admin_info;
			$returnValue = false;
			$this->getFacultyInfo($no);
			if ($this->facultyNumber) {
				if (!$this->getFacultyNumber(date("Y").date("m"))) $faculty_no = date("Y"). date("m") . "0001";
				else $faculty_no = "";
				$this->clearSQL();
				$this->appendSQL("INSERT INTO $this->facultyTableName (apply_no, state, title, lname, fname, mname, name_kr, employee, purpose, depart_ku, ");
				$this->appendSQL("position_ku, depart_hm, position_hm, nationality, dob, country, email, phone, arrival, departure, affiliate, no_room, payment, ");
				$this->appendSQL("ref_lname, ref_fname, ref_mname, ref_depart, ref_position, ref_email, ref_phone, settle1, settle2, settle3, settle4, apply_date, ");
				$this->appendSQL("rate_code) VALUES ('$faculty_no', '$this->facultyState', '$this->facultyTitle', '$this->facultyLName', '$this->facultyFName', '$this->facultyMName', '$this->facultyKName', '$this->facultyEmployee', '$this->facultyPurpose', ");
				$this->appendSQL("'$this->facultyKDepart', '$this->facultyKPosition', '$this->facultyHDepart', '$this->facultyHPosition', '$this->facultyNationality', '$this->facultyDOB', '$this->facultyCountry', '$this->facultyEmail', '$this->facultyPhone', '$this->facultyArrival', '$this->facultyDeparture', ");
				$this->appendSQL("'$this->facultyAffiliate', $this->facultyNoRoom, '$this->facultyPMethod', '$this->facultyRLName', '$this->facultyRFName', '$this->facultyRMName', '$this->facultyRDepart', '$this->facultyRPosition', '$this->facultyREmail', '$this->facultyRPhone', '$this->facultySettle1', '$this->facultySettle2', '$this->facultySettle3', ");
				$this->appendSQL("'$this->facultySettle4', now(), '$rate')");
				$returnValue = $this->execQuery();
				if ($returnValue) {
					$this->facultyNumber = $this->getInsertID();
					$new_no = $this->facultyNumber;
					$admin_id = $ihouse_admin_info[id];
					if (strtolower($admin_id) != "intia") {
						$ip = $_SERVER["REMOTE_ADDR"];
						$detail = "$new_no 객실예약 정보 추가 ($no 객실예약 복사)";
						$this->clearSQL();
						$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'F', 'R', 'N', '$ip', now(), '$detail')");
						$this->execQuery();
					}
				}
			}
			return $returnValue;
		}

		function insertUpload($no, $state, $lnm, $fnm, $mnm, $kdepart, $arrival, $departure, $rate, $request, $admin) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->facultyTableName (apply_no, state, lname, fname, mname, depart_ku, arrival, departure, apply_date, rate_code, request, admin) ");
			$this->appendSQL("VALUES ('$no', '$state', '$lnm', '$fnm', '$mnm', '$kdepart', '$arrival', '$departure', now(), '$rate', '$request', '$admin')");
			$returnValue = $this->execQuery();
			if ($returnValue) $this->facultyNumber = $this->getInsertID();
			return $returnValue;
		}

		function updateFaculty($no, $state, $title, $lnm, $fnm, $mnm, $nm_kr, $employ, $purpose, $kdepart, $kpos, $hdepart, $hpos, $nation, $dob, $country, $email, $ph, $arrival, $departure, $affiliate, $no_room, $pay, $rlnm, $rfnm, $rmnm, $rdepart, $rpos, $remail, $rph, $settle1, $settle2, $settle3, $settle4, $rate, $request, $admin) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->facultyTableName SET state='$state', title='$title', lname='$lnm', fname='$fnm', mname='$mnm', name_kr='$nm_kr', ");
			$this->appendSQL("employee='$employ', purpose='$purpose', depart_ku='$kdepart', position_ku='$kpos', depart_hm='$hdepart', position_hm='$hpos', ");
			$this->appendSQL("nationality='$nation', dob='$dob', country='$country', email='$email', phone='$ph', arrival='$arrival', ");
			$this->appendSQL("departure='$departure', affiliate='$affiliate', no_room=$no_room, payment='$pay', ref_lname='$rlnm', ref_fname='$rfnm', ref_mname='$rmnm', ");
			$this->appendSQL("ref_depart='$rdepart', ref_position='$rpos', ref_email='$remail', ref_phone='$rph', settle1='$settle1', settle2='$settle2', ");
			$this->appendSQL("settle3='$settle3', settle4='$settle4', rate_code='$rate', request='$request', admin='$admin' WHERE apply_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$no 객실예약 정보 수정";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'F', 'R', 'E', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function updateFacultyState($no, $state) {
			if ($state) {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->facultyTableName SET state='$state' WHERE apply_no=$no");
				$returnValue = $this->execQuery();
				return $returnValue;
			}
		}

		function setDiscount($no, $discount) {
			if ($discount == "Y" || $discount == "N") {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->facultyTableName SET discount='$discount' WHERE apply_no=$no");
				$returnValue = $this->execQuery();
				return $returnValue;
			}
		}

		function deleteFaculty($no) {
			global $ihouse_admin_info;
 			$returnValue = false;
			if (is_numeric($no) && $no > 0) {
				$this->clearSQL();
				$this->appendSQL("DELETE FROM $this->facultyAttachTableName WHERE apply_no=$no");
				$returnValue = $this->execQuery();
				if ($returnValue) {
					$this->clearSQL();
					$this->appendSQL("DELETE FROM $this->paymentTableName WHERE apply_no=$no");
					$returnValue = $this->execQuery();
					if ($returnValue) {
						$this->clearSQL();
						$this->appendSQL("DELETE FROM $this->facultyTableName WHERE apply_no=$no");
						$returnValue = $this->execQuery();
						if ($returnValue) {
							$admin_id = $ihouse_admin_info[id];
							if (strtolower($admin_id) != "intia") {
								$ip = $_SERVER["REMOTE_ADDR"];
								$detail = "$no 객실예약 정보 삭제";
								$this->clearSQL();
								$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'F', 'R', 'D', '$ip', now(), '$detail')");
								$this->execQuery();
							}
						}
					}
				}
			}
 			return $returnValue;
		}

		function getAttachmentList($no) {
			if (is_numeric($no) && $no > 0) {
				$cnt = 0;
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->facultyAttachTableName WHERE apply_no='$no' ORDER BY post_dt DESC");
				$this->parseQuery();
				while (!$this->EOF) {
					$this->attachListNumber[$cnt] = $this->getField("att_no");
					$this->attachListDate[$cnt] = $this->getField("post_dt");
					$this->attachListName[$cnt] = $this->getField("filename");
					$this->attachListSize[$cnt] = $this->getField("filesize");
					$this->attachListType[$cnt] = $this->getField("filetype");
					$this->setNextRecord();
					$cnt++;
				}
				$this->freeResult();
			}
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

		function getPaymentList1($no, $receipt) {
			$this->payListNumber = null;
			$this->payListKind = null;
			$this->payListDetail = null;
			$this->payListDate = null;
			$this->payListPrice = null;
			if ($receipt) {
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->paymentTableName WHERE apply_no='$no' AND pay_no IN ($receipt) ORDER BY pay_dt");
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
		}

		function getDepositFee($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT price FROM $this->paymentTableName WHERE apply_no='$no' AND pay_kind='DB'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("price");
			$this->freeResult();
			return $returnValue;
		}

		function getRentalFee($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) total_pr FROM $this->paymentTableName WHERE apply_no='$no' AND pay_kind='RB'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("total_pr");
			$this->freeResult();
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
					$this->feeDeposit = $price_mm * 1.5;
					$this->feeRental = $price_mm * $month;
					if ($day > 15) $this->feeRental = $this->feeRental + $price_mm;
					else if ($day > 0) $this->feeRental = $this->feeRental + ($price_mm / 2);
				} else {
					$this->feeDeposit = $price_dd * 30 * 1.5;
					$this->feeRental = $price_dd * $total;
				}
			} else {
				$this->feeDeposit = 0;
				$this->feeRental = $price_dd * $day;
			}
		}

		function calculateFee1($no, $rate, $checkin, $checkout, $discount) {
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
			$room_cnt = $this->getRoomCount($no);
			$month_cnt = 1;
			$day = 0;
			$end_day = 0;
			$deposit = 0;
			$rental = 0;
			$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($checkin, 5, 2) + $month_cnt++, substr($checkin, 8, 2), substr($checkin, 0, 4)));
			if ($checkout < $temp_dt) { // 단기 - 한달 이내
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
				if ($discount == "Y") $rental = $rental * 0.8;
				if ($deposit > 100) $deposit = (int)(substr((int)$deposit, 0, -2) . "00");
				$flag = $this->updateDepositFee($no, $deposit);
				$flag = $this->deletePayment1($no, "RB");
				if ($rental > 100) $rental = (int)(substr((int)$rental, 0, -2) . "00");
				if ($rental) $flag = $this->insertPayment($no, "R", "RB", date("Y-m-d"), $rental);
			} else { // 장기 - 한달 이상
				if (substr($checkin, 8, 2) != substr($temp_dt, 8, 2)) $temp_dt = $checkin;
				//if ((int)date("t", mktime(0, 0, 0, substr($checkin, 5, 2), 1, substr($checkin, 0, 4))) == (int)substr($checkin, 8, 2)) $temp_dt = $checkin;
				$flag = $this->deletePayment1($no, "RB");
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
				$deposit = ($price_mm + $increase) * 1.5 * $room_cnt;
				if ($deposit > 100) $deposit = (int)(substr((int)$deposit, 0, -2) . "00");
				$flag = $this->updateDepositFee($no, $deposit);
				$loop_flag = true;
				do {
					if (substr($temp_dt, 0, 10) > "2010-03-31") {
						if ($rate == "STUDIO1") $increase = 50000;
						else if ($rate == "DOUBLE") $increase = 70000;
						else if ($rate == "FAMILY") $increase = 70000;
						else if ($rate == "STUDIO2") $increase = 80000;
						else if ($rate == "1BED") $increase = 120000;
						else if ($rate == "2BED") $increase = 170000;
						else $increase = 0;
					} else if (substr($temp_dt, 0, 10) > "2009-03-31") {
						if ($rate == "STUDIO1") $increase = 50000;
						else if ($rate == "DOUBLE") $increase = 70000;
						else if ($rate == "FAMILY") $increase = 70000;
						else if ($rate == "STUDIO2") $increase = 50000;
						else if ($rate == "1BED") $increase = 80000;
						else if ($rate == "2BED") $increase = 110000;
						else $increase = 0;
					} else if (substr($temp_dt, 0, 10) > "2008-03-31") {
						if ($rate == "STUDIO1") $increase = 50000;
						else if ($rate == "DOUBLE") $increase = 70000;
						else if ($rate == "FAMILY") $increase = 70000;
						else if ($rate == "STUDIO2") $increase = 20000;
						else if ($rate == "1BED") $increase = 40000;
						else if ($rate == "2BED") $increase = 50000;
						else $increase = 0;
					} else $increase = 0;
					if ((int)substr($temp_dt, 8, 2) == 1) $rental = ($price_mm + $increase) * $room_cnt;
					else {
						if ($temp_dt == $checkin) $end_day = (int)date("t", mktime(0, 0, 0, substr($temp_dt, 5, 2), 1, substr($temp_dt, 0, 4)));
						else $end_day = (int)date("t", mktime(0, 0, 0, substr($temp_dt, 5, 2) - 1, 1, substr($temp_dt, 0, 4)));
						$day = $end_day - (int)substr($temp_dt, 8, 2) + 1;
						$rental = ($price_mm + $increase) * ($day / $end_day) * $room_cnt;
					}
					$temp = date("Y-m-d", mktime(0, 0, 0, substr($temp_dt, 5, 2) - 1, 1, substr($temp_dt, 0, 4)));
					if ($temp < $checkin) $temp = $checkin;
					if ($discount == "Y") $rental = $rental * 0.8;
					if ($rental > 100) $rental = (int)(substr((int)$rental, 0, -2) . "00");
					if ($rental) $flag = $this->insertPayment($no, "R", "RB", $temp, $rental);
					if (substr($checkout, 0, 7) == substr($temp_dt, 0, 7)) {
						$end_day = (int)date("t", mktime(0, 0, 0, substr($temp_dt, 5, 2), 1, substr($temp_dt, 0, 4)));
						$day = (int)substr($checkout, 8, 2) - 1;
						$rental = ($price_mm + $increase) * ($day / $end_day) * $room_cnt;
						if ($discount == "Y") $rental = $rental * 0.8;
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

		function insertAttachment($no, $name, $size, $type) {
 			$returnValue = false;
			if (is_numeric($no) && $no > 0) {
				$this->clearSQL();
				$this->appendSQL("INSERT INTO $this->facultyAttachTableName (apply_no, post_dt, filename, filesize, filetype) VALUES ('$no', now(), '$name', '$size', '$type')");
				$returnValue = $this->execQuery();
				if ($returnValue) $this->attachmentNumber = $this->getInsertID();
			}
			return $returnValue;
		}

		function deleteAttachment($no) {
 			$returnValue = false;
			if (is_numeric($no) && $no > 0) {
				$this->clearSQL();
				$this->appendSQL("DELETE FROM $this->facultyAttachTableName WHERE att_no=$no");
				$returnValue = $this->execQuery();
			}
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

		function getPaymentExcel($dorm, $sdate, $edate, $stype, $stext, $term, $state, $grade, $rate, $room, $sort) {
			if ($sort == "") $sort = " ORDER BY lname, fname, mname";
			else $sort = " ORDER BY $sort";
			$this->clearSQL();
			$this->appendSQL("SELECT a.apply_no, lname, fname, mname, pay_dt, pay_kind, price " . $this->getFacultyCondition("1", $dorm, $sdate, $edate, $stype, $stext, $term, $state, $grade, $rate, $room) . $sort);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->payListNumber[$cnt] = $this->getField("apply_no");
				$this->payListName[$cnt] = $this->getField("lname") . ", " . $this->getField("fname") . " " . $this->getField("mname");
				$this->payListDate[$cnt] = $this->getField("pay_dt");
				$this->payListPrice[$cnt] = $this->getField("price");
				$this->payListDetail[$cnt] = $this->getField("pay_kind");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getTotalPayment($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) AS total FROM $this->paymentTableName WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("total");
			$this->freeResult();
			return $returnValue;
		}

		function getDepositPayment($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) AS total FROM $this->paymentTableName WHERE apply_no='$no' AND pay_kind IN ('DB','DP','DF','DW','DQ','DX','DR','DC','DD')");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("total");
			$this->freeResult();
			return $returnValue;
		}

		function getRentalPayment($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) AS total FROM $this->paymentTableName WHERE apply_no='$no' AND pay_kind NOT IN ('DB','DP','DF','DW','DQ','DX','DR','DC','DD')");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("total");
			$this->freeResult();
			return $returnValue;
		}

		function getRoomCount($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt FROM $this->bookTableName WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("cnt");
			$this->freeResult();
			return $returnValue;
		}

		function getRoomValue($no) {
			$returnValue = "";
			$this->roomPhone = "";
			$this->roomIP = "";
			$this->roomListCode = null;
			$this->roomListPhone = null;
			$this->roomListIP = null;
			$this->clearSQL();
			$this->appendSQL("SELECT a.room_code, ph, ip FROM $this->bookTableName a LEFT JOIN $this->roomTableName b on a.room_code=b.room_code WHERE a.apply_no='$no' ORDER BY a.room_code");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->roomListCode[$cnt] = $this->getField("room_code");
				$this->roomListPhone[$cnt] = $this->getField("ph");
				$this->roomListIP[$cnt] = $this->getField("ip");
				$returnValue .= $this->getField("room_code") . ", ";
				$this->roomPhone .= $this->getField("ph") . ", ";
				$this->roomIP .= $this->getField("ip") . ", ";
				$this->setNextRecord();
				$cnt++;
			}
			if ($returnValue) $returnValue = substr($returnValue, 0, -2);
			if ($this->roomPhone) $this->roomPhone = substr($this->roomPhone, 0, -2);
			if ($this->roomIP) $this->roomIP = substr($this->roomIP, 0, -2);
			$this->freeResult();
			return $returnValue;
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

		function insertRoom($no, $room) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->bookTableName (apply_no, room_code, assign_date) VALUES ('$no', '$room', now())");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function deleteRoom($no, $room) {
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->bookTableName WHERE apply_no='$no' AND room_code='$room'");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function getRateCode($room) {
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT rate_code FROM $this->roomTableName WHERE room_code='$room'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("rate_code");
			$this->freeResult();
			return $returnValue;
		}

		function insertFaculty1($no, $lnm, $fnm, $purpose, $arrival, $departure, $rate) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->facultyTableName (apply_no, lname, fname, purpose, arrival, departure, apply_date, rate_code) VALUES ");
			$this->appendSQL("('$no', '$lnm', '$fnm', '$purpose', '$arrival', '$departure', now(), '$rate')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->facultyNumber = $this->getInsertID();
				$no = $this->facultyNumber;
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$no 객실예약 정보 추가";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'F', 'R', 'N', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function updateRoom($room, $rate) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->roomTableName SET rate_code='$rate' WHERE room_code='$room'");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function approveFaculty($no, $grade, $flag) {
			$returnValue = true;
			if (is_numeric($no) && $no > 0 && ($grade == "9" || $grade == "7" || $grade == "2" || $grade == "1" || $grade == "0") && ($flag == "Y" || $flag == "N")) {
				if ($flag == "Y") $this->errorMessage = "결재 승인이 성공적으로 이루어졌습니다.";
				else $this->errorMessage = "결재 취소가 성공적으로 이루어졌습니다.";
				$settle1 = "";
				$settle2 = "";
				$settle3 = "";
				$settle4 = "";
				$this->clearSQL();
				$this->appendSQL("SELECT settle1, settle2, settle3, settle4 FROM $this->facultyTableName WHERE apply_no=$no;");
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
				if ($grade == "9" || $grade == "7") {
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->facultyTableName SET settle2='N', settle2_dt='0000-00-00' WHERE apply_no=$no;");
					$returnValue = $this->execQuery();
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->facultyTableName SET settle3='N', settle3_dt='0000-00-00' WHERE apply_no=$no;");
					$returnValue = $this->execQuery();
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->facultyTableName SET settle4='N', settle4_dt='0000-00-00' WHERE apply_no=$no;");
					$returnValue = $this->execQuery();
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->facultyTableName SET settle1='$flag', settle1_dt=$cur_date WHERE apply_no=$no");
					$returnValue = $this->execQuery();
				} else if ($grade == "2") {
					if ($flag == "Y" && $settle3 != "Y") $this->errorMessage = "팀장 미결 상태이므로 결재할 수 없습니다.";
					else {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->facultyTableName SET settle4='$flag', settle4_dt=$cur_date WHERE apply_no=$no");
						$returnValue = $this->execQuery();
					}
				} else if ($grade == "1") {
					if ($flag == "Y" && $settle2 != "Y") $this->errorMessage = "과장 미결 상태이므로 결재할 수 없습니다.";
					else if ($flag == "N" && $settle4 != "N") $this->errorMessage = "이미 사감장님의 결재가 이루어져 결재취소를 할 수 없습니다.";
					else {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->facultyTableName SET settle3='$flag', settle3_dt=$cur_date WHERE apply_no=$no");
						$returnValue = $this->execQuery();
					}
				} else if ($grade == "0") {
					if ($flag == "Y" && $settle1 != "Y") $this->errorMessage = "담당자의 결재가 이루어지지 않아 결재승인을 할 수 없습니다.";
					else if ($flag == "N" && $settle3 != "N") $this->errorMessage = "이미 팀장님의 결재가 이루어져 결재취소를 할 수 없습니다.";
					else {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->facultyTableName SET settle2='$flag', settle2_dt=$cur_date WHERE apply_no=$no");
						$returnValue = $this->execQuery();
					}
				}
			}
			if (!$returnValue) $this->errorMessage = "작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.";
			return $returnValue;
		}

		function insertHistoryWork($menu, $kind, $detail) {
			global $ihouse_admin_info;
			$admin_id = $ihouse_admin_info[id];
			if (strtolower($admin_id) != "intia") {
				$ip = $_SERVER["REMOTE_ADDR"];
				$this->clearSQL();
				$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'F', '$menu', '$kind', '$ip', now(), '$detail')");
				$this->execQuery();
			}
		}
	}
?>