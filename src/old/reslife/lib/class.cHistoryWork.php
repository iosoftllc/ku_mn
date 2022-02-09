<?
	include_once("class.cMysql.php");

	class cHistoryWork extends cMysql {
		var $memberTableName;
		var $workTableName;
		var $adminListID = array();
		var $adminListName = array();
		var $workListNumber = array();
		var $workListBuilding = array();
		var $workListMenu = array();
		var $workListKind = array();
		var $workListIP = array();
		var $workListTime = array();
		var $workListDetail = array();
		var $workListID = array();
		var $workListName = array();
		var $workListDepartment = array();

		function cHistoryWork($host, $id, $pw, $db, $tbl1, $tbl2) {
			$this->memberTableName = $tbl1;
			$this->workTableName = $tbl2;
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

		function getWorkBuildingValue($val){
			if ($val == "S") $returnValue = "학생동";
			else if ($val == "F") $returnValue = "교수동";
			else if ($val == "P") $returnValue = "대학원생";
			else $returnValue = "";
			return $returnValue;
		}

		function getWorkMenuValue($val){
			if ($val == "S") $returnValue = "지원자관리";
			else if ($val == "A") $returnValue = "온라인지원관리";
			else if ($val == "G") $returnValue = "일반지원관리";
			else if ($val == "L") $returnValue = "어학당지원관리";
			else if ($val == "O") $returnValue = "과납금관리";
			else if ($val == "P") $returnValue = "납부연기관리";
			else if ($val == "R") $returnValue = "객실예약관리";
			else if ($val == "F") $returnValue = "시설예약관리";
			else $returnValue = "";
			return $returnValue;
		}

		function getWorkKindValue($val){
			if ($val == "L") $returnValue = "리스트열람";
			else if ($val == "I") $returnValue = "상세정보열람";
			else if ($val == "N") $returnValue = "추가";
			else if ($val == "E") $returnValue = "수정";
			else if ($val == "D") $returnValue = "삭제";
			else if ($val == "X") $returnValue = "엑셀다운로드";
			else if ($val == "Z") $returnValue = "기타";
			else $returnValue = "";
			return $returnValue;
		}

		function getWorkCondition($id, $building, $menu, $kind, $sdt, $edt, $stype, $stext) {
			$returnValue = "";
			if (trim($id) != "") {
				if (trim($returnValue) != "") $returnValue .= " AND a.mem_id='$id'";
				else $returnValue .= " WHERE a.mem_id='$id'";
			}
			if (trim($building) != "") {
				if (trim($returnValue) != "") $returnValue .= " AND a.building='$building'";
				else $returnValue .= " WHERE a.building='$building'";
			}
			if (trim($menu) != "") {
				if (trim($returnValue) != "") $returnValue .= " AND a.menu='$menu'";
				else $returnValue .= " WHERE a.menu='$menu'";
			}
			if (trim($kind) != "") {
				if (trim($returnValue) != "") $returnValue .= " AND a.kind='$kind'";
				else $returnValue .= " WHERE a.kind='$kind'";
			}
			if (trim($sdt) != "") {
				if (trim($returnValue) != "") $returnValue .= " AND a.work_time>='$sdt 00:00:00'";
				else $returnValue .= " WHERE a.work_time>='$sdt 00:00:00'";
			}
			if (trim($edt) != "") {
				if (trim($returnValue) != "") $returnValue .= " AND a.work_time<='$edt 23:59:59'";
				else $returnValue .= " WHERE a.work_time<='$edt 23:59:59'";
			}
			if (trim($stext) == "") $stype = "0";
			if ($stype == "1") {
				if (trim($returnValue) != "") $returnValue .= " AND a.detail LIKE '%" . addslashes($stext) . "%'";
				else $returnValue .= " WHERE a.detail LIKE '%" . addslashes($stext) . "%'";
			} else if ($stype == "2") {
				if (trim($returnValue) != "") $returnValue .= " AND a.work_ip LIKE '%" . addslashes($stext) . "%'";
				else $returnValue .= " WHERE a.work_ip LIKE '%" . addslashes($stext) . "%'";
			} else if ($stype == "3") {
				if (trim($returnValue) != "") $returnValue .= " AND b.name LIKE '%" . addslashes($stext) . "%'";
				else $returnValue .= " WHERE b.name LIKE '%" . addslashes($stext) . "%'";
			} else if ($stype == "4") {
				if (trim($returnValue) != "") $returnValue .= " AND a.mem_id LIKE '%" . addslashes($stext) . "%'";
				else $returnValue .= " WHERE a.mem_id LIKE '%" . addslashes($stext) . "%'";
			}
			$returnValue = " FROM $this->workTableName a LEFT JOIN $this->memberTableName b ON a.mem_id=b.admin_id" . $returnValue;
			return $returnValue;
		}

		function getWorkCount($id, $building, $menu, $kind, $sdt, $edt, $stype, $stext) {
			$returnValue = 0;
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(a.mem_id) AS cnt" . $this->getWorkCondition($id, $building, $menu, $kind, $sdt, $edt, $stype, $stext));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			$this->freeResult();
			return $returnValue;
		}

		function getWorkList($start, $size, $id, $building, $menu, $kind, $sdt, $edt, $stype, $stext, $sort) {
			$cnt = 0;
			if (trim($sort) != "") $sort = " ORDER BY $sort";
			else $sort = " ORDER BY work_time DESC";
			if (trim($start) != "" || trim($start) == "0") $limit = " LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT a.*, b.name, b.department" . $this->getWorkCondition($id, $building, $menu, $kind, $sdt, $edt, $stype, $stext) . $sort . $limit);
			$this->parseQuery();
			while (!$this->EOF) {
				$this->workListNumber[$cnt] = $this->getField("a.work_no");
				$this->workListBuilding[$cnt] = $this->getField("a.building");
				$this->workListMenu[$cnt] = $this->getField("a.menu");
				$this->workListKind[$cnt] = $this->getField("a.kind");
				$this->workListIP[$cnt] = $this->getField("a.work_ip");
				$this->workListTime[$cnt] = $this->getField("a.work_time");
				$this->workListDetail[$cnt] = $this->getField("a.detail");
				$this->workListID[$cnt] = $this->getField("a.mem_id");
				$this->workListName[$cnt] = $this->getField("name");
				$this->workListDepartment[$cnt] = $this->getField("b.department");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}
	}
?>