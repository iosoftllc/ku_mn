<?
	include_once("class.cMysql.php");

	class cMailbox extends cMysql {
		var $tableName;
		var $applyTableName;
		var $listEmail = array();
		var $listNumber = array();
		var $listDate = array();
		var $listReceiver = array();
		var $listSubject = array();
		var $mailNumber;
		var $mailSendDate;
		var $mailReceiver;
		var $mailSubject;
		var $mailContent;
		var $mailFileName;
		var $mailFileSize;
		var $mailFileType;

		function cMailbox($host, $id, $pw, $db, $tbl1, $tbl2) {
			$this->tableName = $tbl1;
			$this->applyTableName = $tbl2;
			$this->cMysql($host, $id, $pw, $db);
		}
		
		function getEmailList() {
			$this->clearSQL();
			$this->appendSQL("SELECT email FROM $this->applyTableName");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
			  $this->listEmail[$cnt] = $this->getField("email");
			  $this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}
		
		function getCondition($stype, $stext) {
			$returnValue = "FROM $this->tableName";
			if (trim($stext) == "") $stype = "0";
			switch ($stype) {
				case "1":
					$returnValue .= " WHERE receiver LIKE '%" . $stext . "%'";
					break;
				case "2":
					$returnValue .= " WHERE subject LIKE '%" . $stext . "%'";
					break;
			}
			return $returnValue;
		}
		
		function getMailCount($stype, $stext) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(mail_no) AS cnt " . $this->getCondition($stype, $stext));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getMailList($start, $size, $stype, $stext, $sort) {
			if ($sort == "") $sort = "ORDER BY send_date DESC";
			else $sort = "ORDER BY $sort";
			if ($start != "" || $start == "0") $limit = "LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT mail_no, send_date, receiver, subject " . $this->getCondition($stype, $stext) . " $sort $limit");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
			  $this->listNumber[$cnt] = $this->getField("mail_no");
			  $this->listDate[$cnt] = $this->getField("send_date");
			  $this->listReceiver[$cnt] = $this->getField("receiver");
			  $this->listSubject[$cnt] = $this->getField("subject");
			  $this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}
		
		function getMailInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->tableName WHERE mail_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->mailSendDate = $this->getField("send_date");
				$this->mailReceiver = $this->getField("receiver");
				$this->mailSubject = $this->getField("subject");
				$this->mailContent = $this->getField("content");
				$this->mailFileName = $this->getField("filename");
				$this->mailFileSize = $this->getField("filesize");
				$this->mailFileType = $this->getField("filetype");
			}
			$this->freeResult();
		}

		function insertMail($receiver, $subject, $content, $nm, $size, $type) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->tableName (send_date, receiver, subject, content, filename, filesize, filetype) ");
			$this->appendSQL("VALUES (now(), '$receiver', '$subject', '$content', '$nm', $size, '$type')");
			$returnValue = $this->execQuery();
			if ($returnValue) $this->mailNumber = $this->getInsertID();
			return $returnValue;
		}

		function deleteMail($no) {
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->tableName WHERE mail_no=$no");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function copyAttachInfo($dest, $src) {
			$this->clearSQL();
			$this->appendSQL("SELECT filename, filesize, filetype FROM $this->tableName WHERE mail_no=$dest");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->tableName SET filename='" . $this->getField("filename") . "', filesize=" . $this->getField("filesize") . ", filetype='" . $this->getField("filetype") . "' WHERE mail_no=$src");
				$returnValue = $this->execQuery();
			} else $this->freeResult();
		}
	}
?>