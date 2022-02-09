<?
	include_once("class.cMysql.php");

	class cRoom extends cMysql {
		var $roomTableName;
		var $roomListCode = array();
		var $roomListRate = array();
		var $roomListPhone = array();
		var $roomListIP = array();
		var $roomCode;
		var $roomRate;
		var $roomPhone;
		var $roomIP;

		function cRoom($host, $id, $pw, $db, $tbl) {
			$this->roomTableName = $tbl;
			$this->cMysql($host, $id, $pw, $db);
		}

		function getRateName($rate) {
			$returnValue = "";
			if (trim($rate) == "J_SINGLE") $returnValue = "Single";
			else if (trim($rate) == "J_DOUBLE") $returnValue = "Double";
			return $returnValue;
		}

		function getRoomCondition($rate, $stype, $stext) {
			$returnValue = "FROM $this->roomTableName WHERE rate_code IN ('J_SINGLE','J_DOUBLE')";
			if (trim($rate) != "") $returnValue .= " AND rate_code='$rate'";
			if (trim($stext) == "") $stype = "0";
			if ($stype == "1") $returnValue .= " AND room_code LIKE '%" . $stext . "%'";
			else if ($stype == "2") $returnValue .= " AND ph LIKE '%" . $stext . "%'";
			else if ($stype == "3") $returnValue .= " AND ip LIKE '%" . $stext . "%'";
			return $returnValue;
		}

		function getRoomCount($rate, $stype, $stext) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt " . $this->getRoomCondition($rate, $stype, $stext));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getRoomList($rate, $start, $size, $stype, $stext, $sort) {
			if ($sort == "") $sort = " ORDER BY room_code";
			else $sort = " ORDER BY $sort";
			if ($start != "" || $start == "0") $limit = " LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT * " . $this->getRoomCondition($rate, $stype, $stext) . $sort . $limit);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->roomListCode[$cnt] = $this->getField("room_code");
				$this->roomListRate[$cnt] = $this->getField("rate_code");
				$this->roomListPhone[$cnt] = $this->getField("ph");
				$this->roomListIP[$cnt] = $this->getField("ip");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getRoomInfo($code) {
			if (trim($code) != "") {
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->roomTableName WHERE room_code='$code'");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->roomCode = $this->getField("room_code");
					$this->roomRate = $this->getField("rate_code");
					$this->roomPhone = $this->getField("ph");
					$this->roomIP = $this->getField("ip");
				}
				$this->freeResult();
			}
		}

		function updateRoom($code, $ph, $ip) {
			$returnValue = false;
			if (trim($code) != "") {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->roomTableName SET ph='$ph', ip='$ip' WHERE room_code='$code'");
				$returnValue = $this->execQuery();
			}
			return $returnValue;
		}
	}
?>