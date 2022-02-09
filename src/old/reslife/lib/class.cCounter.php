<?
	include_once("class.cMysql.php");

	class cCounter extends cMysql {
		var $tableName;
		var $listYear = array();
		var $listCount = array();
		var $listType = array();
		var $listDate = array();
		var $listIP = array();
		var $listReferer = array();
		var $listBrowser = array();
		var $listOS = array();

		function cCounter($host, $id, $pw, $db, $tbl) {
			$this->tableName = $tbl;
			$this->cMysql($host, $id, $pw, $db);
		}

		function getCount($type, $dt) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(ct_date) cnt FROM $this->tableName ");
			if ($type == "year_month" || $type == "year_hour" || $type == "year_os" || $type == "year_brow" || $type == "year_week") {
				$this->appendSQL("WHERE EXTRACT(YEAR FROM ct_date)-EXTRACT(YEAR FROM '$dt')='0'");
			} else if ($type == "month_day" || $type == "month_week" || $type == "month_hour" || $type == "month_os" || $type == "month_brow") {
				$this->appendSQL("WHERE EXTRACT(YEAR_MONTH FROM ct_date)-EXTRACT(YEAR_MONTH FROM '$dt')='0'");
			}
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getYearList() {
			$this->clearSQL();
			$this->appendSQL("SELECT DATE_FORMAT(ct_date, '%Y') yearlist FROM $this->tableName GROUP BY DATE_FORMAT(ct_date, '%Y')");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->listYear[$cnt] = $this->getField("yearlist");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}
		
		function getConnectionCount($dt) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(ct_key) AS cnt FROM $this->tableName  WHERE TO_DAYS(ct_date)-TO_DAYS('$dt')='0'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getConnectionInfo($start, $size, $dt) {
			if ($start != "" || $start == "0") $limit = "LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->tableName WHERE TO_DAYS(ct_date)-TO_DAYS('$dt')='0' ORDER BY ct_date DESC $limit");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->listType[$cnt] = $this->getField("ct_key");
				$this->listDate[$cnt] = $this->getField("ct_date");
				$this->listIP[$cnt] = $this->getField("ct_ip");
				$this->listReferer[$cnt] = $this->getField("ct_referer");
				$this->listBrowser[$cnt] = $this->getField("ct_browser");
				$this->listOS[$cnt] = $this->getField("ct_os");
			  $this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getInformation($type, $yr, $mth, $day) {
			$this->clearSQL();
			if ($type == "year_month") {
				$this->appendSQL("SELECT COUNT(ct_date) cnt, DATE_FORMAT(ct_date, '%c') ct_list FROM $this->tableName ");
				$this->appendSQL("WHERE DATE_FORMAT(ct_date, '%Y')=$yr GROUP BY DATE_FORMAT(ct_date, '%c') ORDER BY DATE_FORMAT(ct_date, '%m')");
			} else if ($type == "year_hour") {
				$this->appendSQL("SELECT COUNT(ct_date) cnt, DATE_FORMAT(ct_date, '%k') ct_list FROM $this->tableName ");
				$this->appendSQL("WHERE DATE_FORMAT(ct_date, '%Y')=$yr GROUP BY DATE_FORMAT(ct_date, '%k') ORDER BY DATE_FORMAT(ct_date, '%H')");
			} else if ($type == "year_os") {
				$this->appendSQL("SELECT COUNT(ct_os) cnt, ct_os ct_list FROM $this->tableName ");
				$this->appendSQL("WHERE DATE_FORMAT(ct_date, '%Y')=$yr GROUP BY ct_os ORDER BY cnt DESC");
			} else if ($type == "year_brow") {
				$this->appendSQL("SELECT COUNT(ct_browser) cnt, ct_browser ct_list FROM $this->tableName ");
				$this->appendSQL("WHERE DATE_FORMAT(ct_date, '%Y')=$yr GROUP BY ct_browser ORDER BY cnt DESC");
			} else if ($type == "year_week") {
				$this->appendSQL("SELECT COUNT(ct_week) cnt, ct_week ct_list FROM $this->tableName ");
				$this->appendSQL("WHERE DATE_FORMAT(ct_date, '%Y')=$yr GROUP BY ct_week");
			} else if ($type == "month_day") {
				$this->appendSQL("SELECT COUNT(ct_date) cnt, DATE_FORMAT(ct_date, '%e') ct_list FROM $this->tableName ");
				$this->appendSQL("WHERE DATE_FORMAT(ct_date, '%Y')=$yr AND DATE_FORMAT(ct_date, '%m')=$mth GROUP BY DATE_FORMAT(ct_date, '%e') ORDER BY DATE_FORMAT(ct_date, '%d')");
			} else if ($type == "month_week") {
				$this->appendSQL("SELECT COUNT(ct_week) cnt, ct_week ct_list FROM $this->tableName ");
				$this->appendSQL("WHERE DATE_FORMAT(ct_date, '%Y')=$yr AND DATE_FORMAT(ct_date, '%m')=$mth GROUP BY ct_week");
			} else if ($type == "month_hour") {
				$this->appendSQL("SELECT COUNT(ct_date) cnt, DATE_FORMAT(ct_date, '%k') ct_list FROM $this->tableName ");
				$this->appendSQL("WHERE DATE_FORMAT(ct_date, '%Y')=$yr AND DATE_FORMAT(ct_date, '%m')=$mth ");
				$this->appendSQL("GROUP BY DATE_FORMAT(ct_date, '%k') ORDER BY DATE_FORMAT(ct_date, '%H')");
			} else if ($type == "month_os") {
				$this->appendSQL("SELECT COUNT(ct_os) cnt, ct_os ct_list FROM $this->tableName ");
				$this->appendSQL("WHERE DATE_FORMAT(ct_date, '%Y')=$yr AND DATE_FORMAT(ct_date, '%m')=$mth GROUP BY ct_os ORDER BY cnt DESC");
			} else if ($type == "month_brow") {
				$this->appendSQL("SELECT COUNT(ct_browser) cnt, ct_browser ct_list FROM $this->tableName ");
				$this->appendSQL("WHERE DATE_FORMAT(ct_date, '%Y')=$yr AND DATE_FORMAT(ct_date, '%m')=$mth GROUP BY ct_browser ORDER BY cnt DESC");
			} else if ($type == "hour") {
				$this->appendSQL("SELECT COUNT(ct_ip) cnt, DATE_FORMAT(ct_date, '%k') ct_list FROM $this->tableName ");
				$this->appendSQL("GROUP BY DATE_FORMAT(ct_date, '%k') ORDER BY DATE_FORMAT(ct_date, '%H')");
			} else if ($type == "week") {
				$this->appendSQL("SELECT COUNT(ct_week) cnt, ct_week ct_list FROM $this->tableName GROUP BY ct_week");
			} else if ($type == "os") {
				$this->appendSQL("SELECT COUNT(ct_os) cnt, ct_os ct_list FROM $this->tableName GROUP BY ct_os ORDER BY cnt DESC");
			} else if ($type == "brow") {
				$this->appendSQL("SELECT COUNT(ct_browser) cnt, ct_browser ct_list FROM $this->tableName GROUP BY ct_browser ORDER BY cnt DESC");
			}
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->listCount[$cnt] = $this->getField("cnt");
				$this->listType[$cnt] = $this->getField("ct_list");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}
	}
?>