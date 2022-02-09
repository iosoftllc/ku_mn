<?
	include_once("class.cMysql.php");

	class cRefund extends cMysql {
		var $refundTableName;
		var $periodTableName;
		var $applyTableName;
		var $paymentTableName;
		var $studentTableName;
		var $historyAccessTableName;
		var $historyWorkTableName;
		var $listNumber = array();
		var $listApply = array();
		var $listCFApply = array();
		var $listApprove = array();
		var $listKind = array();
		var $listStudentNo = array();
		var $listStudent = array();
		var $listName1 = array();
		var $listName2 = array();
		var $listBirth = array();
		var $listEmail = array();
		var $listNation = array();
		var $listEdit = array();
		var $listAppDate = array();
		var $listDate = array();
		var $listPeriod = array();
		var $listRoom = array();
		var $listNew = array();
		var $listPayMethod = array();
		var $listVacate = array();
		var $listReason = array();
		var $listMethod = array();
		var $listMethod1 = array();
		var $listMethod2 = array();
		var $listMethod3 = array();
		var $listMethod4 = array();
		var $listMethod5 = array();
		var $listMethod6 = array();
		var $listMethodAddress1 = array();
		var $listMethodAddress2 = array();
		var $listMethodCountry = array();
		var $listDorm = array();
		var $listSession1 = array();
		var $listSession2 = array();
		var $listDeduction = array();
		var $listDeduction1 = array();
		var $listDeduction2 = array();
		var $listDeduction3 = array();
		var $listAdmin = array();
		var $periodCode = array();
		var $periodName = array();
		var $periodSDate = array();
		var $periodEDate = array();
		var $refundNumber;
		var $refundApply;
		var $refundCFApply;
		var $refundApprove;
		var $refundKind;
		var $refundStudent;
		var $refundName1;
		var $refundName2;
		var $refundName3;
		var $refundDOB;
		var $refundEmail;
		var $refundVacate;
		var $refundEdit;
		var $refundAppDate;
		var $refundPost;
		var $refundReason;
		var $refundMethod;
		var $refundMethod1;
		var $refundMethod2;
		var $refundMethod3;
		var $refundMethod4;
		var $refundMethod5;
		var $refundMethod6;
		var $refundMethodAddress1;
		var $refundMethodAddress2;
		var $refundMethodCountry;
		var $refundAddrLine1;
		var $refundAddrLine2;
		var $refundAddrLine3;
		var $refundAddrCity;
		var $refundAddrState;
		var $refundAddrCountry;
		var $refundAddrPostal;
		var $refundDorm;
		var $refundRoom;
		var $refundPeriod1;
		var $refundPeriod2;
		var $refundSesseion1;
		var $refundSesseion2;
		var $refundSDate1;
		var $refundSDate2;
		var $refundEDate1;
		var $refundEDate2;
		var $refundDeduction;
		var $refundDeduction1;
		var $refundDeduction2;
		var $refundDeduction3;
		var $refundAdmin;
		var $errorMessage;

		function cRefund($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl4, $tbl5, $tbl6, $tbl7) {
			$this->refundTableName = $tbl1;
			$this->periodTableName = $tbl2;
			$this->applyTableName = $tbl3;
			$this->paymentTableName = $tbl4;
			$this->studentTableName = $tbl5;
			$this->historyAccessTableName = $tbl6;
			$this->historyWorkTableName = $tbl7;
			$this->cMysql($host, $id, $pw, $db);
		}

		function getApproveValue($val){
			if ($val == "Y") $returnValue = "승인";
			else if ($val == "N") $returnValue = "미승인";
			else if ($val == "C") $returnValue = "취소";
			return $returnValue;
		}

		function getKindValue($val){
			if ($val == "U") $returnValue = "Regular enrolled students including exchange students";
			else if ($val == "L") $returnValue = "KLCC language students";
			return $returnValue;
		}

		function getVacateValue($val){
			if ($val == "0000-00-00") $returnValue = "Vacated";
			else $returnValue = "Will vacate residence unit on $val";
			return $returnValue;
		}

		function getRefundValue($val){
			if ($val) $returnValue = "Change of Semester to $val";
			else $returnValue = "Requesting a Refund";
			return $returnValue;
		}

		function getRefundValue1($new, $type){
			if ($new) $returnValue = "CF";
			else if ($type == "W") $returnValue = "WT";
			else if ($type == "M") $returnValue = "MO";
			else if ($type == "O") $returnValue = "OR";
			else $returnValue = "";
			return $returnValue;
		}

		function getMethodValue($val){
			if ($val == "W") $returnValue = "Wire Transfer";
			else if ($val == "M") $returnValue = "Money Order";
			else if ($val == "O") $returnValue = "Overseas Remittance";
			else $returnValue = "";
			return $returnValue;
		}

		function getDormitoryValue($val){
			if ($val == "IHOUSE") $returnValue = "CJ International House - Student Residence";
			else if ($val == "ANAM2") $returnValue = "Anam 2 Hall";
			else if ($val == "ANAMG") $returnValue = "ANAM Global House";
			else if ($val == "J_IHOUSE") $returnValue = "CJ Int. House/ANAM Int. House";
			else $returnValue = "";
			return $returnValue;
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

		function getWhereCondition($sdate, $edate, $stype, $stext, $kind, $new, $approve, $period) {
			$list_period = "";
			if ($period) {
				$arr_temp = explode(",", $period);
				for ($i = 0; $i < count($arr_temp); $i++) {
					$list_period .= "'" . $arr_temp[$i] . "',";
				}
				if ($list_period) $list_period = substr($list_period, 0, strlen($list_period) - 1);
			}
			$returnValue = "";
			if ($kind) $returnValue = "WHERE a.kind='$kind'";
			if ($new == "C") {
				if ($returnValue) $returnValue .= " AND new_period<>''";
				else $returnValue .= "WHERE new_period<>''";
			} else if ($new == "W") {
				if ($returnValue) $returnValue .= " AND new_period='' AND method_type='W'";
				else $returnValue .= "WHERE new_period='' AND method_type='W'";
			} else if ($new == "M") {
				if ($returnValue) $returnValue .= " AND new_period='' AND method_type='M'";
				else $returnValue .= "WHERE new_period='' AND method_type='M'";
			} else if ($new == "O") {
				if ($returnValue) $returnValue .= " AND new_period='' AND method_type='O'";
				else $returnValue .= "WHERE new_period='' AND method_type='O'";
			}
			if ($approve) {
				if ($returnValue) $returnValue .= " AND approve='$approve'";
				else $returnValue .= "WHERE approve='$approve'";
			}
			if ($list_period) {
				if ($returnValue) $returnValue .= " AND a.old_period IN ($list_period)";
				else $returnValue .= " WHERE a.old_period IN ($list_period)";
			}
			if ($sdate) {
				if ($returnValue) $returnValue .= " AND post_dt>='$sdate 00:00:00'";
				else $returnValue .= "WHERE post_dt>='$sdate 00:00:00'";
			}
			if ($edate) {
				if ($returnValue) $returnValue .= " AND post_dt<='$edate 23:59:59'";
				else $returnValue .= "WHERE post_dt<='$edate 23:59:59'";
			}
			if (trim($stext) == "") $stype = "0";
			switch ($stype) {
				case "1":
					if ($returnValue) $returnValue .= " AND a.email LIKE '%" . $stext . "%'";
					else $returnValue .= "WHERE a.email LIKE '%" . $stext . "%'";
					break;
				case "2":
					if ($returnValue) $returnValue .= " AND a.apply_no LIKE '%" . $stext . "%'";
					else $returnValue .= "WHERE a.apply_no LIKE '%" . $stext . "%'";
					break;
				case "3":
					if ($returnValue) $returnValue .= " AND a.student_id LIKE '%" . $stext . "%'";
					else $returnValue .= "WHERE a.student_id LIKE '%" . $stext . "%'";
					break;
				case "4":
					if ($returnValue) $returnValue .= " AND (a.fname LIKE '%" . $stext . "%' OR a.mname LIKE '%" . $stext . "%' OR a.lname LIKE '%" . $stext . "%')";
					else $returnValue .= "WHERE (a.fname LIKE '%" . $stext . "%' OR a.mname LIKE '%" . $stext . "%' OR a.lname LIKE '%" . $stext . "%')";
					break;
				case "5":
					if ($returnValue) $returnValue .= " AND a.room_code LIKE '%" . $stext . "%'";
					else $returnValue .= "WHERE a.room_code LIKE '%" . $stext . "%'";
					break;
			}
			return $returnValue;
		}

		function getCondition($sdate, $edate, $stype, $stext, $kind, $new, $approve, $period) {
			$returnValue = "FROM $this->refundTableName a LEFT JOIN $this->periodTableName b ON a.old_period=b.period_code LEFT JOIN $this->periodTableName c ON a.new_period=c.period_code ";
			$returnValue .= "LEFT JOIN $this->applyTableName d ON a.apply_no=d.apply_no LEFT JOIN $this->studentTableName e ON d.email=e.email ";
			$returnValue .= $this->getWhereCondition($sdate, $edate, $stype, $stext, $kind, $new, $approve, $period);
			return $returnValue;
		}

		function getRefundCount($sdate, $edate, $stype, $stext, $kind, $new, $approve, $period) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt " . $this->getCondition($sdate, $edate, $stype, $stext, $kind, $new, $approve, $period));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getRefundList($sdate, $edate, $start, $size, $stype, $stext, $kind, $new, $approve, $period, $sort) {
			if ($sort == "") $sort = " ORDER BY post_dt DESC";
			else $sort = " ORDER BY $sort";
			if ($start != "" || $start == "0") $limit = " LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT refund_no, a.apply_no, approve, a.kind, info_no, a.student_id, a.fname, a.mname, a.lname, a.email, vacate_dt, edit_dt, post_dt, approve_dt, b.name, a.room_code, new_period, method_type ");
			$this->appendSQL($this->getCondition($sdate, $edate, $stype, $stext, $kind, $new, $approve, $period) . $sort . $limit);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->listNumber[$cnt] = $this->getField("refund_no");
				$this->listApply[$cnt] = $this->getField("apply_no");
				$this->listApprove[$cnt] = $this->getField("approve");
				$this->listKind[$cnt] = $this->getField("kind");
				$this->listStudentNo[$cnt] = $this->getField("info_no");
				$this->listStudent[$cnt] = $this->getField("student_id");
				$this->listName1[$cnt] = $this->getField("fname") . " " . $this->getField("mname");
				$this->listName2[$cnt] = $this->getField("lname");
				$this->listEmail[$cnt] = $this->getField("email");
				$this->listEdit[$cnt] = $this->getField("edit_dt");
				$this->listAppDate[$cnt] = $this->getField("approve_dt");
				$this->listDate[$cnt] = $this->getField("post_dt");
				$this->listPeriod[$cnt] = $this->getField("name");
				$this->listRoom[$cnt] = $this->getField("a.room_code");
				$this->listVacate[$cnt] = $this->getField("vacate_dt");
				$this->listNew[$cnt] = $this->getField("new_period");
				$this->listPayMethod[$cnt] = $this->getField("method_type");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getExcelList($sdate, $edate, $stype, $stext, $kind, $new, $approve, $period, $sort) {
			if ($sort == "") $sort = " ORDER BY post_dt DESC";
			else $sort = " ORDER BY $sort";
			$this->clearSQL();
			$this->appendSQL("SELECT * " . $this->getCondition($sdate, $edate, $stype, $stext, $kind, $new, $approve, $period) . $sort);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->listNumber[$cnt] = $this->getField("refund_no");
				$this->listApply[$cnt] = $this->getField("a.apply_no");
				$this->listCFApply[$cnt] = $this->getField("cf_apply_no");
				$this->listApprove[$cnt] = $this->getField("approve");
				$this->listKind[$cnt] = $this->getField("a.kind");
				$this->listStudent[$cnt] = $this->getField("a.student_id");
				$this->listName1[$cnt] = $this->getField("a.fname") . " " . $this->getField("a.mname");
				$this->listName2[$cnt] = $this->getField("a.lname");
				$this->listBirth[$cnt] = $this->getField("a.dob");
				$this->listEmail[$cnt] = $this->getField("a.email");
				$this->listNation[$cnt] = $this->getField("d.nationality");
				if (!$this->listNation[$cnt]) $this->listNation[$cnt] = $this->getField("e.nationality");
				$this->listEdit[$cnt] = $this->getField("edit_dt");
				$this->listAppDate[$cnt] = $this->getField("approve_dt");
				$this->listDate[$cnt] = $this->getField("post_dt");
				$this->listRoom[$cnt] = $this->getField("room_code");
				$this->listVacate[$cnt] = $this->getField("vacate_dt");
				$this->listReason[$cnt] = $this->getField("reason");
				$this->listMethod[$cnt] = $this->getField("method_type");
				$this->listMethod1[$cnt] = $this->getField("method_info1");
				$this->listMethod2[$cnt] = $this->getField("method_info2");
				if ($this->getField("method_type") == "O") {
					$this->listMethodAddress1[$cnt] = $this->getField("addr1");
					$this->listMethodAddress2[$cnt] = $this->getField("addr2");
					$this->listMethodCountry[$cnt] = $this->getField("country");
				} else {
					if ($this->getField("addr1")) $this->listMethod2[$cnt] .= ", " . $this->getField("addr1");
					if ($this->getField("addr2")) $this->listMethod2[$cnt] .= ", " . $this->getField("addr2");
					if ($this->getField("city")) $this->listMethod2[$cnt] .= ", " . $this->getField("city");
					if ($this->getField("state")) $this->listMethod2[$cnt] .= ", " . $this->getField("state");
					if ($this->getField("country")) $this->listMethod2[$cnt] .= ", " . $this->getField("country");
					if ($this->getField("postal")) $this->listMethod2[$cnt] .= " [" . $this->getField("postal") . "]";
				}
				$this->listMethod3[$cnt] = $this->getField("method_info3");
				$this->listMethod4[$cnt] = $this->getField("method_info4");
				$this->listMethod5[$cnt] = $this->getField("method_info5");
				$this->listMethod6[$cnt] = $this->getField("method_info6");
				$this->listDorm[$cnt] = $this->getField("dorm_code");
				$this->listSession1[$cnt] = $this->getField("b.name");
				$this->listSession2[$cnt] = $this->getField("c.name");
				$this->listDeduction[$cnt] = $this->getField("deduction");
				$this->listDeduction1[$cnt] = $this->getField("deduction1");
				$this->listDeduction2[$cnt] = $this->getField("deduction2");
				$this->listDeduction3[$cnt] = $this->getField("deduction3");
				$this->listAdmin[$cnt] = $this->getField("a.admin");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getDepositPaid($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) AS val FROM $this->paymentTableName WHERE apply_no=$no AND pay_kind IN ('DP','DF','DO')");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("val");
			$this->freeResult();
			return $returnValue;
		}

		function getOverpayment($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) AS val FROM $this->paymentTableName WHERE apply_no=$no AND pay_kind IN ('OP','OR')");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("val");
			$this->freeResult();
			return $returnValue;
		}

		function getDamageDeduction($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) AS val FROM $this->paymentTableName WHERE apply_no=$no AND pay_kind IN ('DD')");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("val");
			$this->freeResult();
			return $returnValue;
		}

		function getCancellationFee($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) AS val FROM $this->paymentTableName WHERE apply_no=$no AND pay_kind IN ('CF')");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("val");
			$this->freeResult();
			return $returnValue;
		}

		function getLateCheckout($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) AS val FROM $this->paymentTableName WHERE apply_no=$no AND pay_kind IN ('CO')");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("val");
			$this->freeResult();
			return $returnValue;
		}

		function getRefundNumber($apply) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT refund_no FROM $this->refundTableName WHERE apply_no=$apply");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("refund_no");
			$this->freeResult();
			return $returnValue;
		}

		function getRefundApply($no) {
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no FROM $this->refundTableName WHERE refund_no=$no");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("apply_no");
			$this->freeResult();
			return $returnValue;
		}

		function getRefundNumber1($student, $period) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT refund_no FROM $this->refundTableName WHERE student_id='$student' AND old_period='$period'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("refund_no");
			$this->freeResult();
			return $returnValue;
		}

		function getRefundInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->refundTableName a LEFT JOIN $this->periodTableName b ON a.old_period=b.period_code ");
			$this->appendSQL("LEFT JOIN $this->periodTableName c ON a.new_period=c.period_code WHERE refund_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->refundNumber = $this->getField("refund_no");
				$this->refundApply = $this->getField("apply_no");
				$this->refundCFApply = $this->getField("cf_apply_no");
				$this->refundApprove = $this->getField("approve");
				$this->refundKind = $this->getField("a.kind");
				$this->refundStudent = $this->getField("student_id");
				$this->refundName1 = $this->getField("fname");
				$this->refundName2 = $this->getField("mname");
				$this->refundName3 = $this->getField("lname");
				$this->refundDOB = $this->getField("dob");
				$this->refundEmail = $this->getField("email");
				$this->refundVacate = $this->getField("vacate_dt");
				$this->refundEdit = $this->getField("edit_dt");
				$this->refundAppDate = $this->getField("approve_dt");
				$this->refundPost = $this->getField("post_dt");
				$this->refundReason = $this->getField("reason");
				$this->refundMethod = $this->getField("method_type");
				$this->refundMethod1 = $this->getField("method_info1");
				$this->refundMethod2 = $this->getField("method_info2");
				if ($this->getField("method_type") == "O") {
					$this->refundMethodAddress1 = $this->getField("addr1");
					$this->refundMethodAddress2 = $this->getField("addr2");
					$this->refundMethodCountry = $this->getField("country");
				} else {
					if ($this->getField("addr1")) $this->refundMethod2 .= ", " . $this->getField("addr1");
					if ($this->getField("addr2")) $this->refundMethod2 .= ", " . $this->getField("addr2");
					if ($this->getField("city")) $this->refundMethod2 .= ", " . $this->getField("city");
					if ($this->getField("state")) $this->refundMethod2 .= ", " . $this->getField("state");
					if ($this->getField("country")) $this->refundMethod2 .= ", " . $this->getField("country");
					if ($this->getField("postal")) $this->refundMethod2 .= " [" . $this->getField("postal") . "]";
				}
				$this->refundMethod3 = $this->getField("method_info3");
				$this->refundMethod4 = $this->getField("method_info4");
				$this->refundMethod5 = $this->getField("method_info5");
				$this->refundMethod6 = $this->getField("method_info6");
				$this->refundAddrLine1 = $this->getField("method_info2");
				$this->refundAddrLine2 = $this->getField("addr1");
				$this->refundAddrLine3 = $this->getField("addr2");
				$this->refundAddrCity = $this->getField("city");
				$this->refundAddrState = $this->getField("state");
				$this->refundAddrCountry = $this->getField("country");
				$this->refundAddrPostal = $this->getField("postal");
				$this->refundDorm = $this->getField("dorm_code");
				$this->refundRoom = $this->getField("room_code");
				$this->refundPeriod1 = $this->getField("old_period");
				$this->refundPeriod2 = $this->getField("new_period");
				$this->refundSesseion1 = $this->getField("b.name");
				$this->refundSesseion2 = $this->getField("c.name");
				$this->refundSDate1 = $this->getField("b.sdate");
				$this->refundSDate2 = $this->getField("c.sdate");
				$this->refundEDate1 = $this->getField("b.edate");
				$this->refundEDate2 = $this->getField("c.edate");
				$this->refundDeduction = $this->getField("deduction");
				$this->refundDeduction1 = $this->getField("deduction1");
				$this->refundDeduction2 = $this->getField("deduction2");
				$this->refundDeduction3 = $this->getField("deduction3");
				$this->refundAdmin = $this->getField("admin");
			}
			$this->freeResult();
		}

		function insertRefund($apply, $cf_apply, $kind, $student, $fname, $mname, $lname, $dob, $email, $vacate, $reason, $method, $info1, $info2, $info3, $info4, $info5, $info6, $line2, $line3, $city, $state, $postal, $country, $dorm, $room, $old, $new, $admin) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->refundTableName (apply_no, cf_apply_no, kind, student_id, fname, mname, lname, dob, email, vacate_dt, post_dt, reason, method_type, method_info1, method_info2, method_info3, method_info4, method_info5, method_info6, addr1, addr2, city, state, postal, country, dorm_code, room_code, old_period, new_period, admin)");
			$this->appendSQL("VALUES ($apply, $cf_apply, '$kind', '$student', '$fname', '$mname', '$lname', '$dob', '$email', '$vacate', now(), '$reason', '$method', '$info1', '$info2', '$info3', '$info4', '$info5', '$info6', '$line2', '$line3', '$city', '$state', '$postal', '$country', '$dorm', '$room', '$old', '$new', '$admin')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->refundNumber = $this->getInsertID();
				if ($apply) {
					if ($new) {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->applyTableName SET state='TR' WHERE apply_no='$apply'");
						$this->execQuery();
					} else {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->applyTableName SET state='RR' WHERE apply_no='$apply'");
						$this->execQuery();
					}
				}
				$no = $this->refundNumber;
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$apply 지원번호 과납금 정보 추가 ($no)";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', 'O', 'N', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function updateRefund($no, $apply, $cf_apply, $kind, $student, $fname, $mname, $lname, $dob, $email, $vacate, $reason, $method, $info1, $info2, $info3, $info4, $info5, $info6, $line2, $line3, $city, $state, $postal, $country, $dorm, $room, $old, $new, $admin) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->refundTableName SET apply_no=$apply, cf_apply_no=$cf_apply, kind='$kind', student_id='$student', fname='$fname', mname='$mname', lname='$lname', ");
			$this->appendSQL("dob='$dob', email='$email', vacate_dt='$vacate', reason='$reason', method_type='$method', method_info1='$info1', method_info2='$info2', method_info3='$info3', method_info4='$info4', method_info5='$info5', method_info6='$info6', ");
			$this->appendSQL("addr1='$line2', addr2='$line3', city='$city', state='$state', postal='$postal', country='$country', dorm_code='$dorm', room_code='$room', ");
			$this->appendSQL("old_period='$old', new_period='$new', admin='$admin' WHERE refund_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$apply 지원번호 과납금 정보 수정 ($no)";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', 'O', 'E', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function updateApprove($no, $approve, $price, $price1, $price2, $dt, $grade) {
			$deduction = (int)$price + (int)$price1 + (int)$price2;
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->refundTableName SET edit_dt=now(), approve_dt='$dt', approve='$approve', deduction=$deduction, deduction1=$price, deduction2=$price1, deduction3=$price2 WHERE refund_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				// 보증금정보 가져오기
				$period = "";
				$student = "";
				$apply_dt = "";
				$old_no = "";
				$cf_no = "";
				$this->clearSQL();
				$this->appendSQL("SELECT student_id, new_period, post_dt, apply_no, cf_apply_no FROM $this->refundTableName WHERE refund_no=$no");
				$this->parseQuery();
				if (!$this->EOF) {
					$period = $this->getField("new_period");
					$student = $this->getField("student_id");
					$apply_dt = $this->getField("post_dt");
					$old_no = $this->getField("apply_no");
					$cf_no = $this->getField("cf_apply_no");
				}
				$this->freeResult();
				// 지원번호 설정하기
				$apply_no = "";
				if ($cf_no) $apply_no = $cf_no;
				else if ($period && $student) {
					$this->clearSQL();
					$this->appendSQL("SELECT apply_no FROM $this->applyTableName WHERE period_code='$period' AND student_id='$student'");
					$this->parseQuery();
					if (!$this->EOF) $apply_no = $this->getField("apply_no");
					$this->freeResult();
				}
				if ($old_no) {
					// 보증금 승인 시
					if ($approve == "Y") {
						// 납부한 보증금과 납부할 보증금 설정하기

						$paid = 0;
						$this->clearSQL();
						$this->appendSQL("SELECT SUM(price) AS paid FROM $this->paymentTableName WHERE apply_no=$old_no AND pay_kind IN ('DP','DF','DO')");
						$this->parseQuery();
						if (!$this->EOF) $paid = (int)$this->getField("paid");
						$this->freeResult();

						$overpaid = 0;
						$this->clearSQL();
						$this->appendSQL("SELECT SUM(price) AS overpaid FROM $this->paymentTableName WHERE apply_no=$old_no AND pay_kind IN ('OP','OR')");
						$this->parseQuery();
						if (!$this->EOF) $overpaid = (int)$this->getField("overpaid");
						$this->freeResult();

						$overpaid_dt = "0000-00-00";
						$this->clearSQL();
						$this->appendSQL("SELECT pay_dt FROM $this->paymentTableName WHERE apply_no=$old_no AND pay_kind='OP'");
						$this->parseQuery();
						if (!$this->EOF) $overpaid_dt = substr($this->getField("pay_dt"), 0, 10);
						$this->freeResult();

						//$totalpaid = $paid + $overpaid;
						//$refund = abs($totalpaid) - $deduction;
						$refund = abs($paid) - $deduction;
						$transfer = abs($paid) - $deduction;

						// 보증금 신청한 학기에 대한 기록 남기기
						$this->clearSQL();
						$this->appendSQL("DELETE FROM $this->paymentTableName WHERE apply_no=$old_no AND pay_kind IN ('CR','RR','DD','CF','CO','DR','DC','OR','OC')");
						$returnValue = $this->execQuery();
						if ($paid != 0) {
							$this->clearSQL();
							if ($apply_no) $this->appendSQL("INSERT INTO $this->paymentTableName (apply_no,kind,pay_dt,price,pay_kind) VALUES ($old_no,'D','$apply_dt 23:59:55',$paid,'CR')");
							else $this->appendSQL("INSERT INTO $this->paymentTableName (apply_no,kind,pay_dt,price,pay_kind) VALUES ($old_no,'D','$apply_dt 23:59:55',$paid,'RR')");
							$returnValue = $this->execQuery();
						}
						if ($price != 0) {
							$this->clearSQL();
							$this->appendSQL("INSERT INTO $this->paymentTableName (apply_no,kind,pay_dt,price,pay_kind) VALUES ($old_no,'D','$dt 23:59:56',$price,'DD')");
							$returnValue = $this->execQuery();
						}
						if ($price1 != 0) {
							$this->clearSQL();
							$this->appendSQL("INSERT INTO $this->paymentTableName (apply_no,kind,pay_dt,price,pay_kind) VALUES ($old_no,'D','$dt 23:59:57',$price1,'CF')");
							$returnValue = $this->execQuery();
						}
						if ($price2 != 0) {
							$this->clearSQL();
							$this->appendSQL("INSERT INTO $this->paymentTableName (apply_no,kind,pay_dt,price,pay_kind) VALUES ($old_no,'D','$dt 23:59:58',$price2,'CO')");
							$returnValue = $this->execQuery();
						}
						if ($refund != 0) {
							$this->clearSQL();
							if ($apply_no) $this->appendSQL("INSERT INTO $this->paymentTableName (apply_no,kind,pay_dt,price,pay_kind) VALUES ($old_no,'D','$dt 23:59:59',$refund,'DC')");
							else $this->appendSQL("INSERT INTO $this->paymentTableName (apply_no,kind,pay_dt,price,pay_kind) VALUES ($old_no,'D','$dt 23:59:59',$refund,'DR')");
							$returnValue = $this->execQuery();
						}
						if ($overpaid != 0) {
							if ($overpaid > 0) $temp = "-" . $overpaid;
							else if ($overpaid < 0) $temp = abs($overpaid);
							else $temp = 0;
							$this->clearSQL();
							if ($apply_no) $this->appendSQL("INSERT INTO $this->paymentTableName (apply_no,kind,pay_dt,price,pay_kind) VALUES ($old_no,'D','$dt 23:59:59',$temp,'OC')");
							else $this->appendSQL("INSERT INTO $this->paymentTableName (apply_no,kind,pay_dt,price,pay_kind) VALUES ($old_no,'D','$dt 23:59:59',$temp,'OR')");
							$returnValue = $this->execQuery();
						}
						// 보증금 이전 신청일 경우
						if ($apply_no) {
							$this->clearSQL();
							$this->appendSQL("DELETE FROM $this->paymentTableName WHERE apply_no=$apply_no AND pay_kind IN ('DO','OO')");
							$returnValue = $this->execQuery();
							if ($transfer != 0) {
								if ($transfer > 0) $transfer = "-" . $transfer;
								else if ($transfer < 0) $transfer = abs($transfer);
								$this->clearSQL();
								$this->appendSQL("INSERT INTO $this->paymentTableName (apply_no,kind,pay_dt,price,pay_kind) VALUES ($apply_no,'D','$dt 23:59:59',$transfer,'DO')");
								$returnValue = $this->execQuery();
							}
							if ($overpaid != 0) {
								$this->clearSQL();
								$this->appendSQL("INSERT INTO $this->paymentTableName (apply_no,kind,pay_dt,price,pay_kind) VALUES ($apply_no,'D','$dt 23:59:59',$overpaid,'OO')");
								$returnValue = $this->execQuery();
							}
							$this->clearSQL();
							$this->appendSQL("UPDATE $this->applyTableName SET state='CF' WHERE apply_no=$old_no");
							$returnValue = $this->execQuery();
							$this->clearSQL();
							$this->appendSQL("UPDATE $this->applyTableName SET state='DD' WHERE apply_no=$apply_no");
							$returnValue = $this->execQuery();
							$this->approveApplication($apply_no, $grade, "Y");
						// 보증금 반환 신청일 경우
						} else {
							$this->clearSQL();
							$this->appendSQL("UPDATE $this->applyTableName SET state='RD' WHERE apply_no=$old_no");
							$returnValue = $this->execQuery();
						}
						$this->approveApplication($old_no, $grade, "Y");
					// 보증금 미승인 시
					} else if ($approve == "N" || $approve == "C") {
						$this->clearSQL();
						$this->appendSQL("DELETE FROM $this->paymentTableName WHERE apply_no=$old_no AND pay_kind IN ('CR','RR','DD','CF','CO','DR','DC','OR','OC')");
						$returnValue = $this->execQuery();
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->applyTableName SET state='RR' WHERE apply_no=$old_no");
						$returnValue = $this->execQuery();
						// 보증금 이전 신청일 경우
						if ($apply_no) {
							$this->clearSQL();
							$this->appendSQL("DELETE FROM $this->paymentTableName WHERE apply_no=$apply_no AND pay_kind IN ('DO','OO')");
							$returnValue = $this->execQuery();
							$this->clearSQL();
							$this->appendSQL("UPDATE $this->applyTableName SET state='TR' WHERE apply_no=$old_no");
							$returnValue = $this->execQuery();
							$this->clearSQL();
							if ($approve == "C") $this->appendSQL("UPDATE $this->applyTableName SET state='DP' WHERE apply_no=$apply_no");
							else $this->appendSQL("UPDATE $this->applyTableName SET state='FD' WHERE apply_no=$apply_no");
							$returnValue = $this->execQuery();
						}
					}
				}
			}
			return $returnValue;
		}

		function deleteRefund($no) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->refundTableName WHERE refund_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$apply = $this->getRefundApply($no);
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$apply 지원번호 과납금 정보 삭제 ($no)";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', 'O', 'D', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
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

		function insertHistoryWork($menu, $kind, $detail) {
			global $ihouse_admin_info;
			$admin_id = $ihouse_admin_info[id];
			if (strtolower($admin_id) != "intia") {
				$ip = $_SERVER["REMOTE_ADDR"];
				$this->clearSQL();
				$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', '$menu', '$kind', '$ip', now(), '$detail')");
				$this->execQuery();
			}
		}
	}
?>