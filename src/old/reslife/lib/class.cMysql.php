<?
	class cMysql {
		var $hostName;
		var $userID;
		var $password;
		var $database;
		var $handle;
		var $query;
		var $result;
		var $recordNo;
		var $recordCount;
		var $fieldCount;
		var $EOF;
		var $arrQuery = array();
		var $arrResult = array();
		var $arrRecordNo = array();
		var $arrRecordCount = array();
		var $arrFieldCount = array();
		var $arrEOF = array();

		function cMysql($host, $id, $pw, $db) {
			$this->hostName = $host;
			$this->userID = $id;
			$this->password = $pw;
			$this->database = $db;
			$this->handle = 0;
			$this->result = FALSE;
			$this->query = "";
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

		function clearSQLArray($index) {
			$this->arrQuery[$index] = "";
		}

		function appendSQL($addText) {
			$this->query = $this->query . " " . $addText;
		}

		function appendSQLArray($index, $addText) {
			$this->arrQuery[$index] = $this->arrQuery[$index] . " " . $addText;
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

		function parseQueryArray($index) {
			$this->arrRecordNo[$index] = 0;
			$this->arrEOF[$index] = TRUE;
			if ($this->handle == 0) $this->connectDatabase();
			if ($this->handle != 0) {
				if ($this->arrResult[$index] > 1) $this->freeResultArray($index);
				$this->arrResult[$index] = mysql_query($this->arrQuery[$index], $this->handle);
				if ($this->arrResult[$index]) {
					$this->arrFieldCount[$index] = mysql_num_fields($this->arrResult[$index]);
					$this->arrRecordCount[$index] = mysql_num_rows($this->arrResult[$index]);
					if ($this->arrRecordCount[$index] > 0) $this->arrEOF[$index] = FALSE;
				} else if (!$this->arrResult[$index]) $this->printError();
			}
		}

		function getAffectedRows() {
			return mysql_affected_rows($this->handle);
		}

		function getNumberRows() {
			return $this->recordCount;
		}

		function getNumberRowsArray($index) {
			return $this->arrRecordCount[$index];
		}

		function getNumberFields() {
			return $this->fieldCount;
		}

		function getNumberFieldsArray($index) {
			return $this->arrFieldCount[$index];
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

		function getFieldArray($index, $fieldName) {
			return mysql_result($this->arrResult[$index], $this->arrRecordNo[$index], $fieldName);
		}

		function freeResult() {
			mysql_free_result($this->result);
			$this->result = FALSE;
		}

		function freeResultArray($index) {
			mysql_free_result($this->arrResult[$index]);
			$this->arrResult[$index] = FALSE;
		}

		function closeDatabase() {
			if ($this->handle != 0) mysql_close($this->handle);
		}

		function setFirstRecord() {
			$this->recordNo = 0;
			$this->EOF = FALSE;
		}

		function setFirstRecordArray($index) {
			$this->arrRecordNo[$index] = 0;
			$this->arrEOF[$index] = FALSE;
		}

		function setPriorRecord() {
			if ($this->recordNo > 0) {
				--$this->recordNo;
				$this->EOF = FALSE;
			}
		}

		function setPriorRecordArray($index) {
			if ($this->arrRecordNo[$index] > 0) {
				--$this->arrRecordNo[$index];
				$this->arrEOF[$index] = FALSE;
			}
		}

		function setNextRecord() {
			if ($this->recordNo < $this->getNumberRows()) {
				++$this->recordNo;
				if ($this->recordNo >= $this->getNumberRows()) $this->EOF = TRUE;
			}
		}

		function setNextRecordArray($index) {
			if ($this->arrRecordNo[$index] < $this->getNumberRowsArray($index)) {
				++$this->arrRecordNo[$index];
				if ($this->arrRecordNo[$index] >= $this->getNumberRowsArray($index)) $this->arrEOF[$index] = TRUE;
			}
		}

		function setLastRecord() {
			$this->recordNo = $this->getNumberRows() - 1;
			$this->EOF = TRUE;
		}

		function setLastRecordArray($index) {
			$this->arrRecordNo[$index] = $this->getNumberRowsArray($index) - 1;
			$this->arrEOF[$index] = TRUE;
		}
	}
?>