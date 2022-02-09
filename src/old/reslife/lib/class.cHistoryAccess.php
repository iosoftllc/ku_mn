<?
	include_once("class.cMysql.php");

	class cHistoryAccess extends cMysql {
		var $memberTableName;
		var $accessTableName;
		var $adminListID = array();
		var $adminListName = array();
		var $accessListNumber = array();
		var $accessListKind = array();
		var $accessListIP = array();
		var $accessListTime = array();
		var $accessListID = array();
		var $accessListName = array();
		var $accessListDepartment = array();

		function cHistoryAccess($host, $id, $pw, $db, $tbl1, $tbl2) {
			$this->memberTableName = $tbl1;
			$this->accessTableName = $tbl2;
			$this->cMysql($host, $id, $pw, $db);
		}

		function getAdminList() {
			$cnt = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT admin_id, name FROM $this->memberTableName WHERE admin_id<>'intia'");
			$this->parseQuery();
			while (!$this->EOF) {
				$this->adminListID[$cnt] = $this->getField("admin_id");
				$this->adminListName[$cnt] = $this->getField("name");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getAccessKindValue($val){
			if ($val == "I") $returnValue = "로그인";
			else if ($val == "O") $returnValue = "로그아웃";
			else $returnValue = "";
			return $returnValue;
		}

		function getAccessCondition($id, $kind, $sdt, $edt, $stype, $stext) {
			$returnValue = "";
			if (trim($id) != "") {
				if (trim($returnValue) != "") $returnValue .= " AND a.mem_id='$id'";
				else $returnValue .= " WHERE a.mem_id='$id'";
			}
			if (trim($kind) != "") {
				if (trim($returnValue) != "") $returnValue .= " AND a.kind='$kind'";
				else $returnValue .= " WHERE a.kind='$kind'";
			}
			if (trim($sdt) != "") {
				if (trim($returnValue) != "") $returnValue .= " AND a.access_time>='$sdt 00:00:00'";
				else $returnValue .= " WHERE a.access_time>='$sdt 00:00:00'";
			}
			if (trim($edt) != "") {
				if (trim($returnValue) != "") $returnValue .= " AND a.access_time<='$edt 23:59:59'";
				else $returnValue .= " WHERE a.access_time<='$edt 23:59:59'";
			}
			if (trim($stext) == "") $stype = "0";
			if ($stype == "1") {
				if (trim($returnValue) != "") $returnValue .= " AND a.access_ip LIKE '%" . addslashes($stext) . "%'";
				else $returnValue .= " WHERE a.access_ip LIKE '%" . addslashes($stext) . "%'";
			} else if ($stype == "2") {
				if (trim($returnValue) != "") $returnValue .= " AND b.name LIKE '%" . addslashes($stext) . "%'";
				else $returnValue .= " WHERE b.name LIKE '%" . addslashes($stext) . "%'";
			} else if ($stype == "3") {
				if (trim($returnValue) != "") $returnValue .= " AND a.mem_id LIKE '%" . addslashes($stext) . "%'";
				else $returnValue .= " WHERE a.mem_id LIKE '%" . addslashes($stext) . "%'";
			}
			$returnValue = " FROM $this->accessTableName a LEFT JOIN $this->memberTableName b ON a.mem_id=b.admin_id" . $returnValue;
			return $returnValue;
		}

		function getAccessCount($id, $kind, $sdt, $edt, $stype, $stext) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(a.mem_id) AS cnt" . $this->getAccessCondition($id, $kind, $sdt, $edt, $stype, $stext));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			$this->freeResult();
			return $returnValue;
		}

		function getAccessList($start, $size, $id, $kind, $sdt, $edt, $stype, $stext, $sort) {
			$cnt = 0;
			if (trim($sort) != "") $sort = " ORDER BY $sort";
			else $sort = " ORDER BY access_time DESC";
			if (trim($start) != "" || trim($start) == "0") $limit = " LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT a.*, b.name, b.department" . $this->getAccessCondition($id, $kind, $sdt, $edt, $stype, $stext) . $sort . $limit);
			$this->parseQuery();
			while (!$this->EOF) {
				$this->accessListNumber[$cnt] = $this->getField("a.access_no");
				$this->accessListKind[$cnt] = $this->getField("a.kind");
				$this->accessListIP[$cnt] = $this->getField("a.access_ip");
				$this->accessListTime[$cnt] = $this->getField("a.access_time");
				$this->accessListID[$cnt] = $this->getField("a.mem_id");
				$this->accessListName[$cnt] = $this->getField("name");
				$this->accessListDepartment[$cnt] = $this->getField("b.department");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}
	}
?>