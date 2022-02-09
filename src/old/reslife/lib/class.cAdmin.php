<?
	include_once("class.cMysql.php");

	class cAdmin extends cMysql {
		var $tableName;
		var $historyAccessTableName;
		var $historyWorkTableName;
		var $adminID;
		var $adminGrade;
		var $adminName;
		var $adminDepartment;
		var $adminEmail;
		var $adminDate;
		var $loginTime;
		var $logoutTime;
		var $logIP;
		var $logCount;
		var $listID = array();
		var $listGrade = array();
		var $listName = array();
		var $listDepartment = array();
		var $listEmail = array();
		var $listCount = array();
		var $listDate = array();

		function cAdmin($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3) {
			$this->tableName = $tbl1;
			$this->historyAccessTableName = $tbl2;
			$this->historyWorkTableName = $tbl3;
			$this->cMysql($host, $id, $pw, $db);
		}

		function isExist($id) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT admin_id FROM $this->tableName WHERE admin_id='$id'");
			$this->parseQuery();
			if ($this->getNumberRows() > 0) {
				$returnValue = true;
				$this->adminID = $this->getField("admin_id");
			}
			$this->freeResult();
			return $returnValue;
		}

		function checkPassword($id, $pw) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT passwd FROM $this->tableName WHERE admin_id='$id'");
			$this->parseQuery();
			if ($this->getNumberRows() > 0 && $this->getField("passwd") == crypt($pw, $this->getField("passwd"))) $returnValue = true;
			$this->freeResult();
			return $returnValue;
		}

		function getSessionInfo($id) {
			$this->clearSQL();
			$this->appendSQL("SELECT grade, name, department, email FROM $this->tableName WHERE admin_id='$id'");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->adminGrade = $this->getField("grade");
				$this->adminName = $this->getField("name");
				$this->adminDepartment = $this->getField("department");
				$this->adminEmail = $this->getField("email");
			}
			$this->freeResult();
		}

		function getLogInfo($id) {
			$this->clearSQL();
			$this->appendSQL("SELECT login_time, logout_time, log_ip, log_count FROM $this->tableName WHERE admin_id='$id'");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->loginTime = $this->getField("login_time");
				$this->logoutTime = $this->getField("logout_time");
				$this->logIP = $this->getField("log_ip");
				$this->logCount = $this->getField("log_count");
			}
			$this->freeResult();
		}

		function login($id, $ip) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->tableName SET login_time=now(), log_exist='Y', log_ip='$ip', log_count=log_count+1 WHERE admin_id='$id'");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				if (strtolower($id) != "intia") {
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyAccessTableName (mem_id, kind, access_ip, access_time) VALUES ('$id', 'I', '$ip', now())");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function logout($id, $ip="") {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->tableName SET logout_time=now(), log_exist='N' WHERE admin_id='$id'");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				if (strtolower($id) != "intia") {
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyAccessTableName (mem_id, kind, access_ip, access_time) VALUES ('$id', 'O', '$ip', now())");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function updateAdmin($id, $nm, $department, $email) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->tableName SET name='$nm', department='$department', email='$email' WHERE admin_id='$id'");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function updatePassword($id, $pw) {
			$pw = crypt($pw);
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->tableName SET passwd='$pw' WHERE admin_id='$id'");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function getAdminCondition($stype, $stext, $grade) {
			$returnValue = "FROM $this->tableName WHERE admin_id not in ('intia','ihouse')";
			if (trim($grade) != "") $returnValue .= " AND grade='$grade'";
			if (!trim($stext)) $stype = "0";
			switch ($stype) {
				case "1":
					$returnValue .= " AND admin_id LIKE '%" . $stext . "%'";
					break;
				case "2":
					$returnValue .= " AND name LIKE '%" . $stext . "%'";
					break;
				case "3":
					$returnValue .= " AND department LIKE '%" . $stext . "%'";
					break;
				case "4":
					$returnValue .= " AND email LIKE '%" . $stext . "%'";
					break;
			}
			return $returnValue;
		}

		function getAdminCount($stype, $stext, $grade) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt " . $this->getAdminCondition($stype, $stext, $grade));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getAdminList($start, $size, $stype, $stext, $grade, $sort) {
			if ($sort) $sort = " ORDER BY $sort";
			else $sort = " ORDER BY regist_dt DESC";
			if ($start || $start == "0") $limit = " LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT admin_id, grade, name, department, email, log_count, regist_dt " . $this->getAdminCondition($stype, $stext, $grade) . $sort . $limit);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
			  $this->listID[$cnt] = $this->getField("admin_id");
			  $this->listGrade[$cnt] = $this->getField("grade");
			  $this->listName[$cnt] = $this->getField("name");
			  $this->listDepartment[$cnt] = $this->getField("department");
			  $this->listEmail[$cnt] = $this->getField("email");
			  $this->listCount[$cnt] = $this->getField("log_count");
			  $this->listDate[$cnt] = $this->getField("regist_dt");
			  $this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getAdminInfo($id) {
			$this->clearSQL();
			$this->appendSQL("SELECT admin_id, grade, name, department, email, regist_dt, login_time, logout_time, log_ip, log_count FROM $this->tableName WHERE admin_id='$id'");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->adminID = $this->getField("admin_id");
				$this->adminGrade = $this->getField("grade");
				$this->adminName = $this->getField("name");
				$this->adminDepartment = $this->getField("department");
				$this->adminEmail = $this->getField("email");
				$this->adminDate = $this->getField("regist_dt");
				$this->loginTime = $this->getField("login_time");
				$this->logoutTime = $this->getField("logout_time");
				$this->logIP = $this->getField("log_ip");
				$this->logCount = $this->getField("log_count");
			}
			$this->freeResult();
		}


		function insertAdmin($id, $grade, $pw, $nm, $department, $email) {
			$pw = crypt($pw);
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->tableName (admin_id, grade, passwd, name, department, email, regist_dt) VALUES ('$id', '$grade', '$pw', '$nm', '$department', '$email', now())");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function updateAdmin1($id, $grade, $nm, $department, $email) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->tableName SET grade='$grade', name='$nm', department='$department', email='$email' WHERE admin_id='$id'");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function deleteAdmin($id) {
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->tableName WHERE admin_id='$id'");
			$returnValue = $this->execQuery();
			return $returnValue;
		}
	}
?>