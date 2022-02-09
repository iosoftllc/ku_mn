<?
	include_once("class.cMysql.php");

	class GraduateRefund extends cMysql {
		var $refundTableName;
		var $periodTableName;
		var $applyTableName;
		var $rateTableName;
		var $paymentTableName;
		var $appListNumber = array();
		var $appListPeriod = array();
		var $periodCode = array();
		var $periodOld = array();
		var $periodNew = array();
		var $periodName = array();
		var $periodSDate = array();
		var $periodEDate = array();
		var $refundNumber;
		var $applyNumber;
		var $applyState;
		var $applyStudent;
		var $applyFName;
		var $applyMName;
		var $applyLName;
		var $applyDOB;
		var $applyEmail;
		var $applyRoom;
		var $applyRate;
		var $applyPeriod;
		var $applyEndDate;

		function GraduateRefund($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3) {
			$this->refundTableName = $tbl1;
			$this->periodTableName = $tbl2;
			$this->applyTableName = $tbl3;
			$this->cMysql($host, $id, $pw, $db);
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

		function getApplicantInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->applyTableName a LEFT JOIN $this->rateTableName b ON a.rate_code=b.rate_code ");
			$this->appendSQL("LEFT JOIN $this->periodTableName c ON a.period_code=c.period_code WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->applyNumber = $this->getField("apply_no");
				$this->applyState = $this->getField("state");
				$this->applyStudent = $this->getField("student_id");
				$this->applyFName = $this->getField("fname");
				$this->applyMName = $this->getField("mname");
				$this->applyLName = $this->getField("lname");
				$this->applyDOB = $this->getField("dob");
				$this->applyEmail = $this->getField("email");
				$this->applyRoom = $this->getField("room_code");
				$this->applyRate = $this->getField("a.rate_code");
				$this->applyPeriod = $this->getField("period_code");
				$this->applyEndDate = $this->getField("edate");
			}
			$this->freeResult();
		}

		function getPeriodCode($no) {
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT period_code FROM $this->applyTableName WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("period_code");
			$this->freeResult();
			return $returnValue;
		}

		function getPeriodList($no, $student, $edate) {
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no, name FROM $this->applyTableName a LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code ");
			$this->appendSQL("WHERE apply_no<>'$no' AND student_id='$student' AND sdate>='$edate' ORDER BY apply_no DESC");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->appListNumber[$cnt] = $this->getField("apply_no");
				$this->appListPeriod[$cnt] = $this->getField("name");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function insertRefund($student, $fname, $mname, $lname, $dob, $email, $vacate, $method, $info1, $info2, $info3, $info4, $info5, $info6, $room, $old, $new) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->refundTableName (student_id, fname, mname, lname, dob, email, vacate_dt, post_dt, method_type, method_info1, method_info2, method_info3, method_info4, method_info5, method_info6, room_code, old_period, new_period)");
			$this->appendSQL("VALUES ('$student', '$fname', '$mname', '$lname', '$dob', '$email', '$vacate', now(), '$method', '$info1', '$info2', '$info3', '$info4', '$info5', '$info6', '$room', '$old', '$new')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->applyNumber = $this->getInsertID();
				if (!$new) {
					$apply_no = "";
					if ($old && $student) {
						$this->clearSQL();
						$this->appendSQL("SELECT apply_no FROM $this->applyTableName WHERE period_code='$old' AND student_id='$student'");
						$this->parseQuery();
						if (!$this->EOF) $apply_no = $this->getField("apply_no");
						$this->freeResult();
					}
					if ($apply_no) {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->applyTableName SET state='RR' WHERE apply_no=$apply_no");
						$this->execQuery();
					}
				}
			}
			return $returnValue;
		}

		function insertRefund1($no, $cf_no, $student, $fname, $mname, $lname, $dob, $email, $vacate, $method, $info1, $info2, $info3, $info4, $info5, $info6, $room, $old, $new) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->refundTableName (apply_no, cf_apply_no, student_id, fname, mname, lname, dob, email, vacate_dt, post_dt, method_type, method_info1, method_info2, method_info3, method_info4, method_info5, method_info6, room_code, old_period, new_period)");
			$this->appendSQL("VALUES ('$no', '$cf_no', '$student', '$fname', '$mname', '$lname', '$dob', '$email', '$vacate', now(), '$method', '$info1', '$info2', '$info3', '$info4', '$info5', '$info6', '$room', '$old', '$new')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->applyNumber = $this->getInsertID();
				if ($new) {
					if ($no) {
						$this->clearSQL();
						$this->appendSQL("UPDATE $this->applyTableName SET state='TR' WHERE apply_no='$no'");
						$this->execQuery();
					}
					if ($cf_no) {
						//$this->clearSQL();
						//$this->appendSQL("UPDATE $this->applyTableName SET state='CF' WHERE apply_no='$cf_no'");
						//$this->execQuery();
						//$this->clearSQL();
						//$this->appendSQL("DELETE FROM $this->paymentTableName WHERE apply_no='$cf_no' AND pay_kind='DC'");
						//$returnValue = $this->execQuery();
						//$this->clearSQL();
						//$this->appendSQL("INSERT INTO $this->paymentTableName (apply_no, kind, pay_dt, price, pay_kind) VALUES ('$cf_no', 'E', now(), -200000, 'DC')");
						//$returnValue = $this->execQuery();
					}
				} else {
					if ($no) {
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