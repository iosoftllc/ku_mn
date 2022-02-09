<?
	class cMysql {
		var $handle;
		var $database;
		var $hostName;
		var $userID;
		var $password;
		var $query;
		var $result;
		var $recordNo;
		var $recordCount;
		var $fieldCount;
		var $EOF;

		function cMysql($host, $id, $pw, $db) {
			$this->handle = 0;
			$this->result = FALSE;
			$this->query = "";
			$this->hostName = $host;
			$this->userID = $id;
			$this->password = $pw;
			$this->database = $db;
			$this->EOF = FALSE;
			$this->recordNo = 0;
		}
		
		function printError() {
			echo "작업도중 오류가 발생하였습니다!<br>";
			echo mysql_errno() . " : " . mysql_error();
		}
		
		function getErrorNo() {
			return mysql_errno();
		}

		function getErrorMsg() {
			return mysql_error();
		}
		
		function connectDatabase() {
			$this->handle = mysql_connect($this->hostName, $this->userID, $this->password);
			if ($this->handle == 0) $this->printError();
			else mysql_select_db($this->database, $this->handle);
		}
		
		function setDatabase($database) {
			$this->database = $database;
			if ($this->handle == 0) $this->connectDatabase();
			if ($this->handle != 0) mysql_select_db($this->database, $this->handle);
		}
		
		function clearSQL() {
			$this->query = "";
		}

		function appendSQL($addText) {
			$this->query = $this->query . " " . $addText;
		}
		
		function execQuery() {
			$this->result = FALSE;
			if ($this->handle == 0) $this->connectDatabase();
			if ($this->handle != 0) $this->result = mysql_query($this->query, $this->handle);
			return $this->result;
		}
		
		function parseQuery() {
			$this->recordNo = 0;
			$this->EOF = TRUE;
			if ($this->handle == 0) $this->connectDatabase();
			if ($this->handle != 0) {
				if ($this->result > 1) $this->freeResult();
				$this->result = mysql_query($this->query, $this->handle);
				if ($this->result) {
					$this->fieldCount = mysql_num_fields($this->result);
					$this->recordCount = mysql_num_rows($this->result);
					if ($this->recordCount > 0) $this->EOF = FALSE;
				}
				else if (!$this->result) $this->printError();
			}
		}
		
		function getAffectedRows() {
			return mysql_affected_rows($this->handle);
		}
		
		function getNumberRows() {
			return $this->recordCount;
		}
		
		function getNumberFields() {
			return $this->fieldCount;
		}
		
		function getInsertID() {
			return mysql_insert_id($this->handle);
		}
		
		function getFieldName($fieldID) {
			return mysql_field_name($this->result, $fieldID);
		}

		function getFieldID($fieldName) {
			for ($i = 0; $i < $this->getNumberFields(); ++$i) {
				if ($this->getFieldName($i) == $fieldName) return $i;
			}
			return FALSE;
		}

		function getFieldType($fieldID) {
			if (gettype($fieldID) != "integer") return mysql_field_type($this->result, $this->getFieldID($fieldID));
			else return mysql_field_type($this->result, $fieldID);
		}

		function getFieldLength($fieldID) {
			if (gettype($fieldID) != "integer") return mysql_field_len($this->result, $this->getFieldID($fieldID));
			else return mysql_field_len($this->result, $fieldID);
		}

		function getField($fieldName) {
			return mysql_result($this->result, $this->recordNo, $fieldName);
		}
		
		function freeResult() {
			mysql_free_result($this->result);
			$this->result = FALSE;
		}
		
		function closeDatabase() {
			if ($this->handle != 0) mysql_close($this->handle);
		}
		
		function setFirstRecord() {
			$this->recordNo = 0;
			$this->EOF = FALSE;
		}
		
		function setPriorRecord() {
			if ($this->recordNo > 0) {
				--$this->recordNo;
				$this->EOF = FALSE;
			}
		}
		
		function setNextRecord() {
			if ($this->recordNo < $this->getNumberRows()) {
				++$this->recordNo;
				if ($this->recordNo >= $this->getNumberRows()) $this->EOF = TRUE;
			}
		}
		
		function setLastRecord() {
			$this->recordNo = $this->getNumberRows() - 1;
			$this->EOF = TRUE;
		}
	}
?>