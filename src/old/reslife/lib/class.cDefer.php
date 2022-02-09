<?
	include_once("class.cStudent.php");

	class cDefer extends cStudent {
		var $periodTableName;
		var $paymentTableName;
		var $deferTableName;
		var $deferListNumber = array();
		var $deferListApprove = array();
		var $deferListApplyNo = array();
		var $deferListStudentNo = array();
		var $deferListStudentID = array();
		var $deferListSurName = array();
		var $deferListGivenName = array();
		var $deferListEmail = array();
		var $deferListEdit = array();
		var $deferListPost = array();
		var $deferListPeriod = array();
		var $deferListExchange = array();
		var $deferListClass = array();
		var $deferListAmount = array();
		var $deferListGrant = array();
		var $deferListAddress = array();
		var $deferListAdmin = array();
		var $periodCode = array();
		var $periodName = array();
		var $periodSDate = array();
		var $periodEDate = array();
		var $deferNumber;
		var $deferApprove;
		var $deferApplyNo;
		var $deferStudentID;
		var $deferSurName;
		var $deferGivenName;
		var $deferMiddleName;
		var $deferEmail;
		var $deferEdit;
		var $deferPost;
		var $deferPeriod;
		var $deferExchange;
		var $deferClass;
		var $deferGrant;
		var $deferAddress;
		var $deferCity;
		var $deferState;
		var $deferCountry;
		var $deferPostal;
		var $deferDate1;
		var $deferDate2;
		var $deferAdmin;
		var $deferAmount;
		var $errorMessage;

		function cDefer($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl4, $tbl5, $tbl6, $tbl7, $tbl8) {
			$this->periodTableName = $tbl4;
			$this->paymentTableName = $tbl5;
			$this->deferTableName = $tbl6;
			$this->cStudent($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl7, $tbl8);
		}

		function getApproveValue($val) {
			if ($val == "Y") $returnValue = "승인";
			else if ($val == "N") $returnValue = "미승인";
			else if ($val == "C") $returnValue = "취소";
			else $returnValue = "";
			return $returnValue;
		}

		function getApproveValue1($val) {
			if ($val == "Y") $returnValue = "Approved";
			else if ($val == "N") $returnValue = "";
			else if ($val == "C") $returnValue = "Canceled";
			else $returnValue = "";
			return $returnValue;
		}

		function getClassValue($val) {
			if ($val == "P") $returnValue = "BACHEOLOR";
			else if ($val == "J") $returnValue = "BACHEOLOR";
			else if ($val == "S") $returnValue = "BACHEOLOR";
			else if ($val == "M") $returnValue = "MASTER";
			else if ($val == "D") $returnValue = "DOCTORATE";
			else $returnValue = "";
			return $returnValue;
		}

		function isDeferExist($apply) {
			$returnValue = false;
			if ($apply) {
				$this->clearSQL();
				$this->appendSQL("SELECT defer_no FROM $this->deferTableName WHERE apply_no='$apply'");
				$this->parseQuery();
				if (!$this->EOF) {
					$returnValue = true;
					$this->deferNumber = $this->getField("defer_no");
				}
				$this->freeResult();
			}
			return $returnValue;
		}

		function getPeriodName($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT name FROM $this->applyTableName a LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("name");
			$this->freeResult();
			return $returnValue;
		}

		function getPaidAmount($no) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT SUM(price) pay_pr FROM $this->paymentTableName WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = (int)$this->getField("pay_pr");
			$this->freeResult();
			return $returnValue;
		}

		function getPaidDate($no) {
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT MAX(pay_dt) paid_dt FROM $this->paymentTableName WHERE pay_kind='RF' AND apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("paid_dt");
			$this->freeResult();
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

		function getDeferCondition($sdate, $edate, $stype, $stext, $approve, $period) {
			$list_period = "";
			if ($period) {
				$arr_temp = explode(",", $period);
				for ($i = 0; $i < count($arr_temp); $i++) {
					$list_period .= "'" . $arr_temp[$i] . "',";
				}
				if ($list_period) $list_period = substr($list_period, 0, strlen($list_period) - 1);
			}
			$returnValue = "";
			if ($approve) {
				if ($returnValue) $returnValue .= " AND a.approve='$kind'";
				else $returnValue .= " WHERE a.approve='$kind'";
			}
			if ($list_period) {
				if ($returnValue) $returnValue .= " AND b.period_code IN ($list_period)";
				else $returnValue .= " WHERE b.period_code IN ($list_period)";
			}
			if ($sdate) {
				if ($returnValue) $returnValue .= " AND a.post_dt>='$sdate 00:00:00'";
				else $returnValue .= " WHERE a.post_dt>='$sdate 00:00:00'";
			}
			if ($edate) {
				if ($returnValue) $returnValue .= " AND a.post_dt<='$edate 23:59:59'";
				else $returnValue .= " WHERE a.post_dt<='$edate 23:59:59'";
			}
			if (trim($stext) == "") $stype = "0";
			switch ($stype) {
				case "1":
					if ($returnValue) $returnValue .= " AND c.email LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE c.email LIKE '%" . $stext . "%'";
					break;
				case "2":
					if ($returnValue) $returnValue .= " AND (c.fname LIKE '%" . $stext . "%' OR c.mname LIKE '%" . $stext . "%' OR c.lname LIKE '%" . $stext . "%')";
					else $returnValue .= " WHERE (c.fname LIKE '%" . $stext . "%' OR c.mname LIKE '%" . $stext . "%' OR c.lname LIKE '%" . $stext . "%')";
					break;
				case "3":
					if ($returnValue) $returnValue .= " AND a.apply_no LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE a.apply_no LIKE '%" . $stext . "%'";
					break;
				case "4":
					if ($returnValue) $returnValue .= " AND c.student_id LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE c.student_id LIKE '%" . $stext . "%'";
					break;
			}
			$temp = "FROM $this->deferTableName a LEFT JOIN $this->applyTableName b ON a.apply_no=b.apply_no LEFT JOIN $this->studentTableName c ON b.email=c.email ";
			$temp .= "LEFT JOIN $this->periodTableName d ON b.period_code=d.period_code LEFT JOIN $this->paymentTableName e ON a.apply_no=e.apply_no";
			$returnValue = $temp . $returnValue . " GROUP BY a.apply_no";
			return $returnValue;
		}

		function getDeferCount($sdate, $edate, $stype, $stext, $approve, $period) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt " . $this->getDeferCondition($sdate, $edate, $stype, $stext, $approve, $period));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getNumberRows();
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getDeferList($sdate, $edate, $start, $size, $stype, $stext, $approve, $period, $sort) {
			if ($sort == "") $sort = " ORDER BY post_dt DESC";
			else $sort = " ORDER BY $sort";
			if ($start != "" || $start == "0") $limit = " LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT a.defer_no, a.approve, a.apply_no, c.info_no, c.student_id, c.fname, c.mname, c.lname, c.email, a.edit_dt, a.post_dt, d.name, a.exchange, ");
			$this->appendSQL("c.class, a.grant_dt, c.home_addr, c.home_addr1, c.home_addr2, c.home_city, c.home_state, c.home_postal, c.home_country, a.admin, ");
			$this->appendSQL("SUM(e.price) pay_pr " . $this->getDeferCondition($sdate, $edate, $stype, $stext, $approve, $period) . $sort . $limit);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->deferListNumber[$cnt] = $this->getField("defer_no");
				$this->deferListApprove[$cnt] = $this->getField("approve");
				$this->deferListApplyNo[$cnt] = $this->getField("apply_no");
				$this->deferListStudentNo[$cnt] = $this->getField("info_no");
				$this->deferListStudentID[$cnt] = $this->getField("student_id");
				$this->deferListSurName[$cnt] = $this->getField("lname");
				$this->deferListGivenName[$cnt] = $this->getField("fname") . " " . $this->getField("mname");
				$this->deferListEmail[$cnt] = $this->getField("email");
				$this->deferListEdit[$cnt] = $this->getField("edit_dt");
				$this->deferListPost[$cnt] = $this->getField("post_dt");
				$this->deferListPeriod[$cnt] = $this->getField("name");
				$this->deferListExchange[$cnt] = $this->getField("exchange");
				$this->deferListClass[$cnt] = $this->getField("class");
				$this->deferListGrant[$cnt] = $this->getField("grant_dt");
				$this->deferListAddress[$cnt] = $this->getField("home_addr");
				if ($this->getField("home_addr1")) $this->deferListAddress[$cnt] .= ", " . $this->getField("home_addr1");
				if ($this->getField("home_addr2")) $this->deferListAddress[$cnt] .= ", " . $this->getField("home_addr2");
				if ($this->getField("home_city")) $this->deferListAddress[$cnt] .= ", " . $this->getField("home_city");
				if ($this->getField("home_state")) $this->deferListAddress[$cnt] .= ", " . $this->getField("home_state");
				if ($this->getField("home_country")) $this->deferListAddress[$cnt] .= ", " . $this->getField("home_country");
				if ($this->getField("home_postal")) $this->deferListAddress[$cnt] .= " [" . $this->getField("home_postal") . "]";
				$this->deferListAdmin[$cnt] = $this->getField("admin");
				$this->deferListAmount[$cnt] = $this->getField("pay_pr");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getDeferInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT a.defer_no, a.approve, a.apply_no, c.student_id, c.fname, c.mname, c.lname, c.email, a.edit_dt, a.post_dt, d.name, a.exchange, c.class, ");
			$this->appendSQL("a.grant_dt, c.home_addr, c.home_addr1, c.home_addr2, c.home_city, c.home_state, c.home_postal, c.home_country, d.defer_dt1, d.defer_dt2, ");
			$this->appendSQL("a.admin, SUM(e.price) pay_pr FROM $this->deferTableName a LEFT JOIN $this->applyTableName b ON a.apply_no=b.apply_no ");
			$this->appendSQL("LEFT JOIN $this->studentTableName c ON b.email=c.email LEFT JOIN $this->periodTableName d ON b.period_code=d.period_code ");
			$this->appendSQL("LEFT JOIN $this->paymentTableName e ON a.apply_no=e.apply_no WHERE defer_no=$no GROUP BY a.apply_no");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->deferNumber = $this->getField("defer_no");
				$this->deferApprove = $this->getField("approve");
				$this->deferApplyNo = $this->getField("apply_no");
				$this->deferStudentID = $this->getField("student_id");
				$this->deferFamilyName = $this->getField("lname");
				$this->deferGivenName = $this->getField("fname");
				$this->deferMiddleName = $this->getField("mname");
				$this->deferEmail = $this->getField("email");
				$this->deferEdit = $this->getField("edit_dt");
				$this->deferPost = $this->getField("post_dt");
				$this->deferPeriod = $this->getField("name");
				$this->deferExchange = $this->getField("exchange");
				$this->deferClass = $this->getField("class");
				$this->deferGrant = $this->getField("grant_dt");
				$this->deferAddress = $this->getField("home_addr");
				if ($this->getField("home_addr1")) $this->deferAddress .= ", " . $this->getField("home_addr1");
				if ($this->getField("home_addr2")) $this->deferAddress .= ", " . $this->getField("home_addr2");
				$this->deferCity = $this->getField("home_city");
				$this->deferState = $this->getField("home_state");
				$this->deferCountry = $this->getField("home_country");
				$this->deferPostal = $this->getField("home_postal");
				$this->deferDate1 = $this->getField("defer_dt1");
				$this->deferDate2 = $this->getField("defer_dt2");
				$this->deferAdmin = $this->getField("admin");
				$this->deferAmount = $this->getField("pay_pr");
			}
			$this->freeResult();
		}

		function getDeferApply($no) {
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no FROM $this->deferTableName WHERE defer_no=$no");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("apply_no");
			$this->freeResult();
			return $returnValue;
		}

		function insertDefer($apply, $approve, $exchange, $grant, $admin) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->deferTableName (apply_no, approve, exchange, grant_dt, edit_dt, post_dt, admin)");
			$this->appendSQL("VALUES ('$apply', '$approve', '$exchange', '$grant', now(), now(), '$admin')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->deferNumber = $this->getInsertID();
				$no = $this->deferNumber;
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$apply 지원번호 납부연기 정보 추가 ($no)";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', 'P', 'N', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function updateDefer($no, $apply, $approve, $exchange, $grant, $admin) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->deferTableName SET apply_no='$apply', approve='$approve', exchange='$exchange', grant_dt='$grant', ");
			$this->appendSQL("edit_dt=now(), admin='$admin' WHERE defer_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$apply 지원번호 납부연기 정보 수정 ($no)";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', 'P', 'E', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function approveDefer($no, $grant, $grade) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->deferTableName SET approve='Y', grant_dt='$grant' WHERE defer_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$apply_no = "";
				$this->clearSQL();
				$this->appendSQL("SELECT apply_no FROM $this->deferTableName WHERE defer_no=$no");
				$this->parseQuery();
				if (!$this->EOF) $apply_no = $this->getField("apply_no");
				$this->freeResult();
				if ($apply_no) {
					$this->clearSQL();
					$this->appendSQL("UPDATE $this->applyTableName SET state='PR' WHERE apply_no=$apply_no");
					$returnValue = $this->execQuery();
					$this->approveApplication($apply_no, $grade, "Y");
				}
			}
			return $returnValue;
		}

		function deleteDefer($no) {
			global $ihouse_admin_info;
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->deferTableName WHERE defer_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$apply = $this->getDeferApply($no);
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$apply 지원번호 납부연기 정보 삭제 ($no)";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', 'P', 'D', '$ip', now(), '$detail')");
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
	}
?>