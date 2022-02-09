<?
	include_once("class.cBoardType.php");

	class cBoard extends cBoardType {
		var $tableName;
		var $commentTableName;
		var $attachTableName;
		var $listNumber = array();
		var $listReference = array();
		var $listLevel = array();
		var $listName = array();
		var $listEmail = array();
		var $listDate = array();
		var $listCount = array();
		var $listFont = array();
		var $listSubject = array();
		var $listCmtComment = array();
		var $boardTypeNo;
		var $boardNo;
		var $boardMember;
		var $boardReference;
		var $boardLevel;
		var $writerName;
		var $writerEmail;
		var $postDate;
		var $postIP;
		var $readCount;
		var $htmlFlag;
		var $fontColor;
		var $topFlag;
		var $boardSubject;
		var $boardContent;
		var $titleNumber;
		var $titleSubject;
		var $commentNo;
		var $listCommentNo = array();
		var $listCommentMember = array();
		var $listCommentName = array();
		var $listCommentDate = array();
		var $listCommentIP = array();
		var $listCommentContent = array();
		var $listAttachNo = array();
		var $listAttachName = array();
		var $listAttachSize = array();
		var $listAttachType = array();
		var $attachNumber;
		var $attachName;
		var $attachSize;
		var $attachType;

		function cBoard($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl4, $tbl5, $no) {
			$this->tableName = $tbl3;
			$this->commentTableName = $tbl4;
			$this->attachTableName = $tbl5;
			$this->boardTypeNo = $no;
			$this->cBoardType($host, $id, $pw, $db, $tbl1, $tbl2);
		}
		
		function hasRepliedBoard($no) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT board_ref, board_level FROM $this->tableName WHERE board_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->clearSQL();
				if ($this->getField("board_level") == "") {
					$this->appendSQL("SELECT board_no FROM $this->tableName WHERE bt_no=$this->boardTypeNo AND board_ref=" . $this->getField("board_ref") . " AND board_level<>''");
				} else {
					$next_level = (int)$this->getField("board_level") + 1;
					$this->appendSQL("SELECT board_no FROM $this->tableName WHERE bt_no=$this->boardTypeNo AND board_ref=" . $this->getField("board_ref") . " AND ");
					$this->appendSQL("board_level>'" . $this->getField("board_level") . "' AND board_level<'" . $next_level . "'");
				}
				$this->parseQuery();
				if ($this->getNumberRows() > 0) $returnValue = true;
			}
			$this->freeResult();
			return $returnValue;
		}

		function getCondition($ref, $reply, $stype, $stext) {
			$returnValue = "";
			if ((int)$ref > 0) $returnValue .= " AND a.board_ref=$ref";
			if ($reply == "N") $returnValue .= " AND board_level=''";
			if (trim($stext) == "") $stype = "0";
			if ($stype == "1") $returnValue .= " AND subject LIKE '%" . trim($stext) . "%'";
			if ($stype == "2") $returnValue .= " AND a.name LIKE '%" . trim($stext) . "%'";
			if ($stype == "3") $returnValue .= " AND a.content LIKE '%" . trim($stext) . "%'";
			return $returnValue;
		}
		
		function getTopCondition() {
			$returnValue = "FROM $this->tableName WHERE bt_no=$this->boardTypeNo AND top='Y'";
			return $returnValue;
		}
		
		function getBoardCount($ref, $reply, $stype, $stext) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(a.board_no) AS cnt FROM $this->tableName a WHERE a.bt_no=$this->boardTypeNo" . $this->getCondition($ref, $reply, $stype, $stext));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getTopCount() {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(board_no) AS cnt " . $this->getTopCondition());
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getBoardList($ref, $reply, $start, $size, $stype, $stext) {
		  $this->listNumber = null;
		  $this->listReference = null;
		  $this->listLevel = null;
		  $this->listName = null;
		  $this->listEmail = null;
		  $this->listFont = null;
		  $this->listDate = null;
		  $this->listCount = null;
		  $this->listSubject = null;
			if ($start != "" || $start == "0") $limit = "LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT a.board_no, a.board_ref, board_level, a.name, email, color, a.post_date, read_count, subject, count(cmt_no) AS cmt_cnt ");
			$this->appendSQL("FROM $this->tableName a LEFT JOIN $this->commentTableName b ON a.board_no=b.board_no WHERE a.bt_no=$this->boardTypeNo ");
			$this->appendSQL($this->getCondition($ref, $reply, $stype, $stext) . " GROUP BY a.board_no ORDER BY a.board_ref DESC, board_level $limit");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
			  $this->listNumber[$cnt] = $this->getField("board_no");
			  $this->listReference[$cnt] = $this->getField("board_ref");
			  $this->listLevel[$cnt] = $this->getField("board_level");
			  $this->listName[$cnt] = $this->getField("name");
			  $this->listEmail[$cnt] = $this->getField("email");
			  $this->listFont[$cnt] = $this->getField("color");
			  $this->listDate[$cnt] = $this->getField("post_date");
			  $this->listCount[$cnt] = $this->getField("read_count");
			  $this->listSubject[$cnt] = $this->getField("subject");
			  $this->listCmtCount[$cnt] = $this->getField("cmt_cnt");
			  $this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getTopList() {
		  $this->listNumber = null;
		  $this->listReference = null;
		  $this->listLevel = null;
		  $this->listName = null;
		  $this->listEmail = null;
		  $this->listFont = null;
		  $this->listDate = null;
		  $this->listCount = null;
		  $this->listSubject = null;
			$this->clearSQL();
			$this->appendSQL("SELECT board_no, board_ref, board_level, name, email, color, post_date, read_count, subject ");
			$this->appendSQL($this->getTopCondition() . " ORDER BY post_date DESC");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
			  $this->listNumber[$cnt] = $this->getField("board_no");
			  $this->listReference[$cnt] = $this->getField("board_ref");
			  $this->listLevel[$cnt] = $this->getField("board_level");
			  $this->listName[$cnt] = $this->getField("name");
			  $this->listEmail[$cnt] = $this->getField("email");
			  $this->listFont[$cnt] = $this->getField("color");
			  $this->listDate[$cnt] = $this->getField("post_date");
			  $this->listCount[$cnt] = $this->getField("read_count");
			  $this->listSubject[$cnt] = $this->getField("subject");
			  $this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getCommentList($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT cmt_no, mem_id, name, post_date, post_ip, content FROM $this->commentTableName WHERE board_no=$no ORDER BY post_date");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
			  $this->listCommentNo[$cnt] = $this->getField("cmt_no");
			  $this->listCommentMember[$cnt] = $this->getField("mem_id");
			  $this->listCommentName[$cnt] = $this->getField("name");
			  $this->listCommentDate[$cnt] = $this->getField("post_date");
			  $this->listCommentIP[$cnt] = $this->getField("post_ip");
			  $this->listCommentContent[$cnt] = $this->getField("content");
			  $this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getBoardInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT mem_id, board_ref, board_level, name, email, color, post_date, post_ip, read_count, html_flag, top, subject, content FROM $this->tableName WHERE board_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->boardMember = $this->getField("mem_id");
				$this->boardReference = $this->getField("board_ref");
				$this->boardLevel = $this->getField("board_level");
				$this->writerName = $this->getField("name");
				$this->writerEmail = $this->getField("email");
				$this->fontColor = $this->getField("color");
				$this->postDate = $this->getField("post_date");
				$this->postIP = $this->getField("post_ip");
				$this->readCount = $this->getField("read_count");
				$this->htmlFlag = $this->getField("html_flag");
				$this->topFlag = $this->getField("top");
				$this->boardSubject = $this->getField("subject");
				$this->boardContent = $this->getField("content");
			}
			$this->freeResult();
		}

		function getPreBoard($ref) {
			$temp_ref = "";
			$this->titleNumber = "";
			$this->titleSubject = "";
			$this->clearSQL();
			$this->appendSQL("SELECT MAX(board_ref) AS ref FROM $this->tableName WHERE bt_no=$this->boardTypeNo AND board_ref<$ref");
			$this->parseQuery();
			if (!$this->EOF) $temp_ref = $this->getField("ref");
			$this->freeResult();
			if ($temp_ref != "") $this->getSimpleInfo($temp_ref);
		}

		function getNextBoard($ref) {
			$temp_ref = "";
			$this->titleNumber = "";
			$this->titleSubject = "";
			$this->clearSQL();
			$this->appendSQL("SELECT MIN(board_ref) AS ref FROM $this->tableName WHERE bt_no=$this->boardTypeNo AND board_ref>$ref");
			$this->parseQuery();
			if (!$this->EOF) $temp_ref = $this->getField("ref");
			$this->freeResult();
			if ($temp_ref != "") $this->getSimpleInfo($temp_ref);
		}
		
		function getSimpleInfo($ref) {
			$this->clearSQL();
			$this->appendSQL("SELECT board_no, subject FROM $this->tableName WHERE bt_no=$this->boardTypeNo AND board_ref=$ref AND board_level=''");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->titleNumber = $this->getField("board_no");
				$this->titleSubject = $this->getField("subject");
			}
			$this->freeResult();
		}

		function getBoardReference($ref, $level) {
			$returnValue = "";
			$this->clearSQL();
			if ($ref == "") {
				$this->appendSQL("SELECT MAX(board_ref) AS ref FROM $this->tableName WHERE bt_no=$this->boardTypeNo");
				$this->parseQuery();
				if (!$this->EOF) {
					if ($this->getField("ref") == NULL) $returnValue = 1;
					else $returnValue = (int)$this->getField("ref") + 1;
				}
			} else {
				$this->appendSQL("SELECT MAX(board_level) AS lev FROM $this->tableName WHERE bt_no=$this->boardTypeNo AND board_ref=$ref AND board_level LIKE '" . $level . "__'");
				$this->parseQuery();
				if (!$this->EOF) {
					if ($this->getField("lev") == NULL) $returnValue = $level . "10";
					else $returnValue = (int)$this->getField("lev") + 1;
				}
			}
			$this->freeResult();
			return $returnValue;
		}

		function getAttachList($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT att_no, filename, filesize, filetype FROM $this->attachTableName WHERE board_no=$no");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
			  $this->listAttachNo[$cnt] = $this->getField("att_no");
			  $this->listAttachName[$cnt] = $this->getField("filename");
			  $this->listAttachSize[$cnt] = $this->getField("filesize");
			  $this->listAttachType[$cnt] = $this->getField("filetype");
			  $this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getAttachInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT att_no, filename, filesize, filetype FROM $this->attachTableName WHERE att_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->attachNumber = $this->getField("att_no");
				$this->attachName = $this->getField("filename");
				$this->attachSize = $this->getField("filesize");
				$this->attachType = $this->getField("filetype");
			}
			$this->freeResult();
		}

		function increaseReadCount($no) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->tableName SET read_count=read_count+1 WHERE board_no=$no");
			$returnValue = $this->execQuery();
			return $returnValue;
		}
		
		function insertBoard($id, $ref, $level, $nm, $email, $ip, $html, $color, $top, $subject, $content) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->tableName (mem_id, board_ref, board_level, name, email, post_date, post_ip, html_flag, color, top, bt_no, subject, content) ");
			$this->appendSQL("VALUES ('$id', $ref, '$level', '$nm', '$email', now(), '$ip', '$html', '$color', '$top', $this->boardTypeNo, '$subject', '$content')");
			$returnValue = $this->execQuery();
			if ($returnValue) $this->boardNo = $this->getInsertID();
			return $returnValue;
		}

		function insertAttach($br_no, $ref, $nm, $size, $type) {
			$this->attachNumber = "";
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->attachTableName (board_no, board_ref, bt_no, filename, filesize, filetype) VALUES ($br_no, $ref, $this->boardTypeNo, '$nm', $size, '$type')");
			$returnValue = $this->execQuery();
			if ($returnValue) $this->attachNumber = $this->getInsertID();
			return $returnValue;
		}

		function insertComment($id, $br_no, $ref, $nm, $ip, $content) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->commentTableName (mem_id, board_no, board_ref, bt_no, name, post_date, post_ip, content) VALUES ('$id', $br_no, $ref, $this->boardTypeNo, '$nm', now(), '$ip', '$content')");
			$returnValue = $this->execQuery();
			if ($returnValue) $this->commentNo = $this->getInsertID();
			return $returnValue;
		}

		function deleteBoard($no) {
			$this->listAttachNo = null;
			$this->clearSQL();
			$this->appendSQL("SELECT att_no FROM $this->attachTableName WHERE board_no=$no");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
		  	$this->listAttachNo[$cnt] = $this->getField("att_no");
			  $this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->attachTableName WHERE board_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->clearSQL();
				$this->appendSQL("DELETE FROM $this->commentTableName WHERE board_no=$no");
				$returnValue = $this->execQuery();
				if ($returnValue) {
					$this->clearSQL();
					$this->appendSQL("DELETE FROM $this->tableName WHERE board_no=$no");
					$returnValue = $this->execQuery();
				}
			}
			return $returnValue;
		}
		
		function deleteAllReference($no) {
			$returnValue = false;
			$this->listAttachNo = null;
			$this->clearSQL();
			$this->appendSQL("SELECT board_ref FROM $this->tableName WHERE board_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
				$ref = $this->getField("board_ref");
				$this->freeResult();
				$this->clearSQL();
				$this->appendSQL("SELECT att_no FROM $this->attachTableName WHERE bt_no=$this->boardTypeNo AND board_ref=$ref");
				$this->parseQuery();
				$cnt = 0;
				while (!$this->EOF) {
			  	$this->listAttachNo[$cnt] = $this->getField("att_no");
				  $this->setNextRecord();
					$cnt++;
				}
				$this->freeResult();
				$this->clearSQL();
				$this->appendSQL("DELETE FROM $this->attachTableName WHERE bt_no=$this->boardTypeNo AND board_ref=$ref");
				$returnValue = $this->execQuery();
				if ($returnValue) {
					$this->clearSQL();
					$this->appendSQL("DELETE FROM $this->commentTableName WHERE bt_no=$this->boardTypeNo AND board_ref=$ref");
					$returnValue = $this->execQuery();
					if ($returnValue) {
						$this->clearSQL();
						$this->appendSQL("DELETE FROM $this->tableName WHERE bt_no=$this->boardTypeNo AND board_ref=$ref");
						$returnValue = $this->execQuery();
					}
				}
			} else $this->freeResult();
			return $returnValue;
		}
		
		function deleteAttach($no) {
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->attachTableName WHERE att_no=$no");
			$returnValue = $this->execQuery();
			return $returnValue;
		}
		
		function deleteComment($no) {
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->commentTableName WHERE cmt_no=$no");
			$returnValue = $this->execQuery();
			return $returnValue;
		}
		
		function updateBoard($no, $nm, $email, $html, $color, $top, $subject, $content) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->tableName SET top='$top', name='$nm', email='$email', html_flag='$html', color='$color', subject='$subject', content='$content' WHERE board_no=$no");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function updateAttach($no, $nm, $size, $type) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->attachTableName SET filename='$nm', filesize=$size, filetype='$type' WHERE att_no=$no");
			$returnValue = $this->execQuery();
			return $returnValue;
		}
	}
?>