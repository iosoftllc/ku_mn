<?
	require_once("class.cMysql.php");

	class cCounter extends cMysql {
		var $tableName;

		function cCounter($host, $id, $pw, $db, $tbl) {
			$this->tableName = $tbl;
			$this->cMysql($host, $id, $pw, $db);
		}
		
		function getRecentDate($ip) {
			$this->clearSQL();
			$this->appendSQL("SELECT MAX(ct_date) maxdate FROM $this->tableName WHERE ct_ip='$ip'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("maxdate");
			else $returnValue = "";
			$this->freeResult();
			return $returnValue;
		}
		
		function getTotalCount() {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(ct_date) totalcnt FROM $this->tableName");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("totalcnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getTodayCount() {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(ct_date) todaycnt FROM $this->tableName WHERE TO_DAYS(NOW())-TO_DAYS(ct_date)='0'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("todaycnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getYesterdayCount() {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(ct_date) yesterdaycnt FROM $this->tableName WHERE TO_DAYS(NOW())-TO_DAYS(ct_date)='1'");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("yesterdaycnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}
		
		function insertCounter($agent, $referer, $brow, $os, $ip) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->tableName (ct_date, ct_week, ct_user_agent, ct_referer, ct_browser, ct_os, ct_ip) ");
			$this->appendSQL("VALUES (now(), dayofweek(now()), '$agent', '$referer', '$brow', '$os', '$ip')");
			$returnValue = $this->execQuery();
			return $returnValue;
		}
	}
?>