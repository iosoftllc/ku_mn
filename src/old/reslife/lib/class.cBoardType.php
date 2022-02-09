<?
	include_once("class.cMysql.php");

	class cBoardType extends cMysql {
		var $typeTableName;
		var $paramTableName;
		var $rejectID;
		var $rejectIP;
		var $rejectWord;
		var $listTypeNumber = array();
		var $listTypeName = array();
		var $boardName;
		var $ipFlag;
		var $timeFlag;
		var $replyFlag;
		var $commentFlag;
		var $attachFileSize;
		var $attachFlag;
		var $authList;
		var $authView;
		var $authPost;
		var $noticeNumber;
		var $blistNumber;
		var $newNumber;
		var $hotNumber;

		function cBoardType($host, $id, $pw, $db, $tbl1, $tbl2) {
			$this->typeTableName = $tbl1;
			$this->paramTableName = $tbl2;
			$this->cMysql($host, $id, $pw, $db);
		}
		
		function getRejectInfo() {
			$this->clearSQL();
			$this->appendSQL("SELECT reject_id, reject_ip, reject_word FROM $this->paramTableName");
			$this->parseQuery();
			if (!$this->EOF) {
			  $this->rejectID = $this->getField("reject_id");
			  $this->rejectIP = $this->getField("reject_ip");
			  $this->rejectWord = $this->getField("reject_word");
			}
			$this->freeResult();
		}

		function getBoardTypeList() {
			$this->clearSQL();
			$this->appendSQL("SELECT bt_no, name FROM $this->typeTableName ORDER BY order_no");
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
			  $this->listTypeNumber[$cnt] = $this->getField("bt_no");
			  $this->listTypeName[$cnt] = $this->getField("name");
			  $this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getSettingInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT name, ip_flag, time_flag , reply_flag, comment_flag, attach_size, attach_flag, auth_list, auth_view, auth_post, notice_no, list_no, new_no, hot_no FROM $this->typeTableName WHERE bt_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
			  $this->boardName = $this->getField("name");
			  $this->ipFlag = $this->getField("ip_flag");
			  $this->timeFlag = $this->getField("time_flag");
			  $this->replyFlag = $this->getField("reply_flag");
			  $this->commentFlag = $this->getField("comment_flag");
			  $this->attachFileSize = $this->getField("attach_size");
			  $this->attachFlag = $this->getField("attach_flag");
			  $this->authList = $this->getField("auth_list");
			  $this->authView = $this->getField("auth_view");
			  $this->authPost = $this->getField("auth_post");
			  $this->noticeNumber = $this->getField("notice_no");
			  $this->blistNumber = $this->getField("list_no");
			  $this->newNumber = $this->getField("new_no");
			  $this->hotNumber = $this->getField("hot_no");
			}
			$this->freeResult();
		}

		function updateRejectInfo($id, $ip, $word) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->paramTableName SET reject_id='$id', reject_ip='$ip', reject_word='$word'");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function updateSettingInfo($no, $list, $new, $hot, $ip, $time, $reply, $comment, $size, $attach, $auth_list, $auth_view, $auth_post, $notice) {
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->typeTableName SET list_no=$list, new_no=$new, hot_no=$hot, ip_flag='$ip', time_flag='$time', ");
			$this->appendSQL("reply_flag='$reply', comment_flag='$comment', attach_size=$size, attach_flag='$attach', ");
			$this->appendSQL("auth_list='$auth_list', auth_view='$auth_view', auth_post='$auth_post', notice_no=$notice WHERE bt_no=$no");
			$returnValue = $this->execQuery();
			return $returnValue;
		}
	}
?>