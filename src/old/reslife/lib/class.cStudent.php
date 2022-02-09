<?
	include_once("class.cMysql.php");

	class cStudent extends cMysql {
		var $studentTableName;
		var $applyTableName;
		var $accountTableName;
		var $historyAccessTableName;
		var $historyWorkTableName;
		var $stuListNumber = array();
		var $stuListKind = array();
		var $stuListCurrent = array();
		var $stuListID = array();
		var $stuListFirstName = array();
		var $stuListLastName = array();
		var $stuListPreferName = array();
		var $stuListKoreanName = array();
		var $stuListGender = array();
		var $stuListDOB = array();
		var $stuListNationality = array();
		var $stuListUniversity = array();
		var $stuListAddress = array();
		var $stuListAddress1 = array();
		var $stuListMajor = array();
		var $stuListClass = array();
		var $stuListKGSP = array();
		var $stuListEmail = array();
		var $stuListPhone = array();
		var $stuListMobile = array();
		var $stuListCaseName = array();
		var $stuListCaseRelate = array();
		var $stuListCasePhone = array();
		var $stuListCaseAddress = array();
		var $stuListAccount = array();
		var $stuListDate = array();
		var $stuListAdmin = array();
		var $studentNumber;
		var $studentKind;
		var $studentCurrent;
		var $studentID;
		var $studentFirstName;
		var $studentMiddleName;
		var $studentPreferName;
		var $studentLastName;
		var $studentKoreanName;
		var $studentGender;
		var $studentDOB;
		var $studentNationality;
		var $studentUniversity;
		var $studentAddress;
		var $studentAddr1;
		var $studentAddr2;
		var $studentAddrCity;
		var $studentAddrState;
		var $studentAddrPostal;
		var $studentAddrCountry;
		var $studentAddress1;
		var $studentMajor;
		var $studentClass;
		var $studentKGSP;
		var $studentEmail;
		var $studentPhone;
		var $studentMobile;
		var $studentCaseName;
		var $studentCaseRelate;
		var $studentCasePhone;
		var $studentCaseAddress;
		var $studentAccount;
		var $studentDate;
		var $studentAdmin;

		function cStudent($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl4, $tbl5) {
			$this->studentTableName = $tbl1;
			$this->applyTableName = $tbl2;
			$this->accountTableName = $tbl3;
			$this->historyAccessTableName = $tbl4;
			$this->historyWorkTableName = $tbl5;
			$this->cMysql($host, $id, $pw, $db);
		}

		function getKindValue($val){
			if ($val == "U") $returnValue = "대학부";
			else if ($val == "L") $returnValue = "어학부";
			else $returnValue = "";
			return $returnValue;
		}

		function getCurrentValue($val){
			if ($val == "Y") $returnValue = "재사학생";
			else if ($val == "N") $returnValue = "새학생";
			else $returnValue = "";
			return $returnValue;
		}

		function getClassValue($val){
			if ($val == "F") $returnValue = "Undergraduate - Freshman";
			else if ($val == "P") $returnValue = "Undergraduate - Sophomore";
			else if ($val == "J") $returnValue = "Undergraduate - Junior";
			else if ($val == "S") $returnValue = "Undergraduate - Senior";
			else if ($val == "M") $returnValue = "Graduate - Master's prog";
			else if ($val == "D") $returnValue = "Graduate - Doctorial prog";
			else $returnValue = "";
			return $returnValue;
		}

		function getKGSPValue($val){
			if ($val == "Y") $returnValue = "KGSP";
			else if ($val == "N") $returnValue = "N/A";
			else $returnValue = "";
			return $returnValue;
		}

		function getGenderValue($val){
			if ($val == "M") $returnValue = "Male";
			else if ($val == "F") $returnValue = "Female";
			else $returnValue = "";
			return $returnValue;
		}

		function isEmailExist($email) {
			$returnValue = false;
			if ($email) {
				$this->clearSQL();
				$this->appendSQL("SELECT info_no FROM $this->studentTableName WHERE email='$email'");
				$this->parseQuery();
				if ($this->getNumberRows() > 0) {
					$returnValue = true;
					$this->studentNumber = $this->getField("info_no");
				}
				$this->freeResult();
			}
			return $returnValue;
		}

		function isApplicationExist($no) {
			$returnValue = false;
			$email = "";
			$this->clearSQL();
			$this->appendSQL("SELECT email FROM $this->studentTableName WHERE info_no=$no");
			$this->parseQuery();
			if (!$this->EOF) $email = $this->getField("email");
			$this->freeResult();
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->applyTableName WHERE email='$email'");
			$this->parseQuery();
			if ($this->getNumberRows() > 0) $returnValue = true;
			$this->freeResult();
			return $returnValue;
		}

		function isApplicationExist1($no) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT email FROM $this->applyTableName WHERE apply_no='$no'");
			$this->parseQuery();
			if (!$this->EOF) {
				$returnValue = true;
				$this->studentEmail = $this->getField("email");
			}
			$this->freeResult();
			return $returnValue;
		}

		function getStudentNumber($student) {
			$returnValue = "";
			if (is_numeric($student) && $student > 0) {
				$this->clearSQL();
				$this->appendSQL("SELECT info_no FROM $this->studentTableName WHERE student_id=$student");
				$this->parseQuery();
				if (!$this->EOF) $returnValue = $this->getField("info_no");
				$this->freeResult();
			}
			return $returnValue;
		}

		function getStudentCondition($sdate, $edate, $stype, $stext, $kind, $current) {
			$returnValue = "";
			if ($kind) {
				if ($returnValue) $returnValue .= " AND nationality LIKE '%" . $kind . "%'";
				else $returnValue .= " WHERE nationality LIKE '%" . $kind . "%'";
			}
			if ($current) {
				if ($returnValue) $returnValue .= " AND current='$current'";
				else $returnValue .= " WHERE current='$current'";
			}
			if ($sdate) {
				if ($returnValue) $returnValue .= " AND post_date>='$sdate 00:00:00'";
				else $returnValue .= " WHERE post_date>='$sdate 00:00:00'";
			}
			if ($edate) {
				if ($returnValue) $returnValue .= " AND post_date<='$edate 23:59:59'";
				else $returnValue .= " WHERE post_date<='$edate 23:59:59'";
			}
			if (trim($stext) == "") $stype = "0";
			switch ($stype) {
				case "1":
					if ($returnValue) $returnValue .= " AND (fname LIKE '%" . $stext . "%' OR mname LIKE '%" . $stext . "%' OR lname LIKE '%" . $stext . "%' OR prefer LIKE '%" . $stext . "%')";
					else $returnValue .= " WHERE (fname LIKE '%" . $stext . "%' OR mname LIKE '%" . $stext . "%' OR lname LIKE '%" . $stext . "%' OR prefer LIKE '%" . $stext . "%')";
					break;
				case "2":
					if ($returnValue) $returnValue .= " AND student_id LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE student_id LIKE '%" . $stext . "%'";
					break;
				case "3":
					if ($returnValue) $returnValue .= " AND email LIKE '%" . $stext . "%'";
					else $returnValue .= " WHERE email LIKE '%" . $stext . "%'";
					break;
				case "4":
					if ($returnValue) $returnValue .= " AND REPLACE(account,'-','') LIKE '%" . ereg_replace('-', '', $stext) . "%'";
					else $returnValue .= " WHERE REPLACE(account,'-','') LIKE '%" . ereg_replace('-', '', $stext) . "%'";
					break;
			}
			$returnValue = "FROM $this->studentTableName" . $returnValue;
			return $returnValue;
		}

		function getStudentCount($sdate, $edate, $stype, $stext, $kind, $current) {
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt " . $this->getStudentCondition($sdate, $edate, $stype, $stext, $kind, $current));
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			else $returnValue = "0";
			$this->freeResult();
			return $returnValue;
		}

		function getStudentList($sdate, $edate, $start, $size, $stype, $stext, $kind, $current, $sort) {
			if ($sort == "") $sort = " ORDER BY post_date DESC";
			else $sort = " ORDER BY $sort";
			if ($start != "" || $start == "0") $limit = " LIMIT $start, $size";
			else $limit = "";
			$this->clearSQL();
			$this->appendSQL("SELECT * " . $this->getStudentCondition($sdate, $edate, $stype, $stext, $kind, $current) . $sort . $limit);
			$this->parseQuery();
			$cnt = 0;
			while (!$this->EOF) {
				$this->stuListNumber[$cnt] = $this->getField("info_no");
				$this->stuListKind[$cnt] = $this->getField("kind");
				$this->stuListCurrent[$cnt] = $this->getField("current");
				$this->stuListID[$cnt] = $this->getField("student_id");
				$this->stuListFirstName[$cnt] = $this->getField("fname") . " " . $this->getField("mname");
				$this->stuListLastName[$cnt] = $this->getField("lname");
				$this->stuListPreferName[$cnt] = $this->getField("prefer");
				$this->stuListKoreanName[$cnt] = $this->getField("name_kr");
				$this->stuListGender[$cnt] = $this->getField("gender");
				$this->stuListDOB[$cnt] = $this->getField("dob");
				$this->stuListNationality[$cnt] = $this->getField("nationality");
				$this->stuListUniversity[$cnt] = $this->getField("home_uni");
				$this->stuListAddress[$cnt] = $this->getField("home_addr");
				if ($this->getField("home_addr1")) $this->stuListAddress[$cnt] .= ", " . $this->getField("home_addr1");
				if ($this->getField("home_addr2")) $this->stuListAddress[$cnt] .= ", " . $this->getField("home_addr2");
				if ($this->getField("home_city")) $this->stuListAddress[$cnt] .= ", " . $this->getField("home_city");
				if ($this->getField("home_state")) $this->stuListAddress[$cnt] .= ", " . $this->getField("home_state");
				if ($this->getField("home_country")) $this->stuListAddress[$cnt] .= ", " . $this->getField("home_country");
				if ($this->getField("home_postal")) $this->stuListAddress[$cnt] .= " [" . $this->getField("home_postal") . "]";
				$this->stuListAddress1[$cnt] = $this->getField("res_addr");
				$this->stuListMajor[$cnt] = $this->getField("major");
				$this->stuListClass[$cnt] = $this->getField("class");
				$this->stuListKGSP[$cnt] = $this->getField("kgsp");
				$this->stuListEmail[$cnt] = $this->getField("email");
				$this->stuListPhone[$cnt] = $this->getField("phone");
				$this->stuListMobile[$cnt] = $this->getField("cell");
				$this->stuListCaseName[$cnt] = $this->getField("case_name");
				$this->stuListCaseRelate[$cnt] = $this->getField("case_relate");
				$this->stuListCasePhone[$cnt] = $this->getField("case_phone");
				$this->stuListCaseAddress[$cnt] = $this->getField("case_addr");
				$this->stuListAccount[$cnt] = $this->getField("account");
				$this->stuListDate[$cnt] = $this->getField("post_date");
				$this->stuListAdmin[$cnt] = $this->getField("admin");
				$this->setNextRecord();
				$cnt++;
			}
			$this->freeResult();
		}

		function getStudentInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->studentTableName WHERE info_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->studentNumber = $this->getField("info_no");
				$this->studentKind = $this->getField("kind");
				$this->studentCurrent = $this->getField("current");
				$this->studentID = $this->getField("student_id");
				$this->studentFirstName = $this->getField("fname");
				$this->studentMiddleName = $this->getField("mname");
				$this->studentPreferName = $this->getField("prefer");
				$this->studentLastName = $this->getField("lname");
				$this->studentKoreanName = $this->getField("name_kr");
				$this->studentGender = $this->getField("gender");
				$this->studentDOB = $this->getField("dob");
				$this->studentNationality = $this->getField("nationality");
				$this->studentUniversity = $this->getField("home_uni");
				$this->studentAddress = $this->getField("home_addr");
				$this->studentAddr1 = $this->getField("home_addr1");
				$this->studentAddr2 = $this->getField("home_addr2");
				$this->studentAddrCity = $this->getField("home_city");
				$this->studentAddrState = $this->getField("home_state");
				$this->studentAddrPostal = $this->getField("home_postal");
				$this->studentAddrCountry = $this->getField("home_country");
				$this->studentAddress1 = $this->getField("res_addr");
				$this->studentMajor = $this->getField("major");
				$this->studentClass = $this->getField("class");
				$this->studentKGSP = $this->getField("kgsp");
				$this->studentEmail = $this->getField("email");
				$this->studentPhone = $this->getField("phone");
				$this->studentMobile = $this->getField("cell");
				$this->studentCaseName = $this->getField("case_name");
				$this->studentCaseRelate = $this->getField("case_relate");
				$this->studentCasePhone = $this->getField("case_phone");
				$this->studentCaseAddress = $this->getField("case_addr");
				$this->studentAccount = $this->getField("account");
				$this->studentDate = $this->getField("post_date");
				$this->studentAdmin = $this->getField("admin");
			}
			$this->freeResult();
		}

		function getStudentInfo1($email) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->studentTableName WHERE email='$email'");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->studentNumber = $this->getField("info_no");
				$this->studentKind = $this->getField("kind");
				$this->studentCurrent = $this->getField("current");
				$this->studentID = $this->getField("student_id");
				$this->studentFirstName = $this->getField("fname");
				$this->studentMiddleName = $this->getField("mname");
				$this->studentPreferName = $this->getField("prefer");
				$this->studentLastName = $this->getField("lname");
				$this->studentKoreanName = $this->getField("name_kr");
				$this->studentGender = $this->getField("gender");
				$this->studentDOB = $this->getField("dob");
				$this->studentNationality = $this->getField("nationality");
				$this->studentUniversity = $this->getField("home_uni");
				$this->studentAddress = $this->getField("home_addr");
				$this->studentAddr1 = $this->getField("home_addr1");
				$this->studentAddr2 = $this->getField("home_addr2");
				$this->studentAddrCity = $this->getField("home_city");
				$this->studentAddrState = $this->getField("home_state");
				$this->studentAddrPostal = $this->getField("home_postal");
				$this->studentAddrCountry = $this->getField("home_country");
				$this->studentAddress1 = $this->getField("res_addr");
				$this->studentMajor = $this->getField("major");
				$this->studentClass = $this->getField("class");
				$this->studentKGSP = $this->getField("kgsp");
				$this->studentEmail = $this->getField("email");
				$this->studentPhone = $this->getField("phone");
				$this->studentMobile = $this->getField("cell");
				$this->studentCaseName = $this->getField("case_name");
				$this->studentCaseRelate = $this->getField("case_relate");
				$this->studentCasePhone = $this->getField("case_phone");
				$this->studentCaseAddress = $this->getField("case_addr");
				$this->studentAccount = $this->getField("account");
				$this->studentDate = $this->getField("post_date");
				$this->studentAdmin = $this->getField("admin");
			}
			$this->freeResult();
		}

		function getStudentID($no) {
			$returnValue = "";
			$this->clearSQL();
			$this->appendSQL("SELECT student_id FROM $this->studentTableName WHERE info_no=$no");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("student_id");
			$this->freeResult();
			return $returnValue;
		}

		function updatePassword($no, $pw) {
			global $ihouse_admin_info;
			$pw = crypt($pw);
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->studentTableName SET passwd='$pw' WHERE info_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$serial = $this->getStudentID($no);
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$serial 학번 비밀번호 변경 ($no)";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', 'S', 'E', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			return $returnValue;
		}

		function updatePassword1($email, $pw) {
			global $ihouse_admin_info;
			$returnValue = false;
			if (trim($email) != "") {
				$pw = crypt($pw);
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->studentTableName SET passwd='$pw' WHERE email='$email'");
				$returnValue = $this->execQuery();
				if ($returnValue) {
					$admin_id = $ihouse_admin_info[id];
					if (strtolower($admin_id) != "intia") {
						$ip = $_SERVER["REMOTE_ADDR"];
						$detail = "$email 지원자 비밀번호 변경";
						$this->clearSQL();
						$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', 'S', 'E', '$ip', now(), '$detail')");
						$this->execQuery();
					}
				}
			}
			return $returnValue;
		}

		function insertStudent($pw, $kind, $current, $id, $fnm, $mnm, $lnm, $pr_nm, $nm_kr, $gender, $dob, $nation, $uni, $addr, $addr2, $addr3, $city, $state, $postal, $country, $addr1, $major, $class, $kgsp, $email, $ph, $cell, $case_nm, $case_rel, $case_ph, $case_addr, $admin) {
			global $ihouse_admin_info;
			$pw = crypt($pw);
			$acc = "";
			$this->clearSQL();
			$this->appendSQL("SELECT acc_no FROM $this->accountTableName WHERE use_flag='N' ORDER BY acc_no LIMIT 0, 1");
			$this->parseQuery();
			if (!$this->EOF) $acc = $this->getField("acc_no");
			$this->freeResult();
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->studentTableName (passwd, kind, current, student_id, fname, mname, lname, prefer, name_kr, gender, dob, nationality, home_uni, home_addr, home_addr1, home_addr2, home_city, home_state, home_postal, home_country, res_addr, major, class, kgsp, email, phone, cell, case_name, case_relate, case_phone, case_addr, account, post_date, admin)");
			$this->appendSQL("VALUES ('$pw', '$kind', '$current', '$id', '$fnm', '$mnm', '$lnm', '$pr_nm', '$nm_kr', '$gender', '$dob', '$nation', '$uni', '$addr', '$addr2', '$addr3', '$city', '$state', '$postal', '$country', '$addr1', '$major', '$class', '$kgsp', '$email', '$ph', '$cell', '$case_nm', '$case_rel', '$case_ph', '$case_addr', '$acc', now(), '$admin')");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$this->studentNumber = $this->getInsertID();
				$no = $this->studentNumber;
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$id 학번 정보 추가 ($no)";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', 'S', 'N', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			if ($returnValue && $acc) {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->accountTableName SET use_flag='Y', use_dt=now() WHERE acc_no='$acc'");
				$returnValue = $this->execQuery();
			}
			return $returnValue;
		}

		function updateStudent($no, $kind, $current, $id, $fnm, $mnm, $lnm, $pr_nm, $nm_kr, $gender, $dob, $nation, $uni, $addr, $addr2, $addr3, $city, $state, $postal, $country, $addr1, $major, $class, $kgsp, $email, $ph, $cell, $case_nm, $case_rel, $case_ph, $case_addr, $admin) {
			global $ihouse_admin_info;
			$old = "";
			$this->clearSQL();
			$this->appendSQL("SELECT email FROM $this->studentTableName WHERE info_no=$no");
			$this->parseQuery();
			if (!$this->EOF) $old = $this->getField("email");
			$this->freeResult();
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->studentTableName SET kind='$kind', current='$current', student_id='$id', fname='$fnm', ");
			$this->appendSQL("mname='$mnm', lname='$lnm', prefer='$pr_nm', name_kr='$nm_kr', gender='$gender', dob='$dob', nationality='$nation', home_uni='$uni', ");
			$this->appendSQL("home_addr='$addr', home_addr1='$addr2', home_addr2='$addr3', home_city='$city', home_state='$state', home_postal='$postal', ");
			$this->appendSQL("home_country='$country', res_addr='$addr1', major='$major', class='$class', kgsp='$kgsp', email='$email', phone='$ph', cell='$cell', ");
			$this->appendSQL("case_name='$case_nm', case_relate='$case_rel', case_phone='$case_ph', case_addr='$case_addr', admin='$admin' WHERE info_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$id 학번 정보 수정 ($no)";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', 'S', 'E', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			if ($returnValue && $old != $email) {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->applyTableName SET email='$email' WHERE email='$old'");
				$returnValue = $this->execQuery();
			}
			return $returnValue;
		}

		function deleteStudent($no) {
			global $ihouse_admin_info;
			$acc = "";
			$this->clearSQL();
			$this->appendSQL("SELECT account FROM $this->studentTableName WHERE info_no=$no");
			$this->parseQuery();
			if (!$this->EOF) $acc = $this->getField("account");
			$this->freeResult();
			$this->clearSQL();
			$this->appendSQL("DELETE FROM $this->studentTableName WHERE info_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue) {
				$admin_id = $ihouse_admin_info[id];
				if (strtolower($admin_id) != "intia") {
					$serial = $this->getStudentID($no);
					$ip = $_SERVER["REMOTE_ADDR"];
					$detail = "$serial 학번 정보 삭제 ($no)";
					$this->clearSQL();
					$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', 'S', 'D', '$ip', now(), '$detail')");
					$this->execQuery();
				}
			}
			if ($returnValue && $acc) {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->accountTableName SET use_flag='N', use_dt=now() WHERE acc_no='$acc'");
				$returnValue = $this->execQuery();
			}
 			return $returnValue;
		}

		function insertHistoryWork($menu, $kind, $detail) {
			global $ihouse_admin_info;
			$admin_id = $ihouse_admin_info[id];
			if (strtolower($admin_id) != "intia") {
				$ip = $_SERVER["REMOTE_ADDR"];
				$this->clearSQL();
				$this->appendSQL("INSERT INTO $this->historyWorkTableName (mem_id, building, menu, kind, work_ip, work_time, detail) VALUES ('$admin_id', 'S', '$menu', '$kind', '$ip', now(), '$detail')");
				$this->execQuery();
			}
		}
	}
?>