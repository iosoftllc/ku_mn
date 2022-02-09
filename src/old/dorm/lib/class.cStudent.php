<?
	include_once("class.cMysql.php");

	class cStudent extends cMysql {
		var $studentTableName;
		var $applyTableName;
		var $periodTableName;
		var $roomTableName;
		var $accountTableName;
		var $studentNumber;
		var $studentKind;
		var $studentCurrent;
		var $studentID;
		var $studentFirstName;
		var $studentMiddleName;
		var $studentLastName;
		var $studentPreferName;
		var $studentKoreanName;
		var $studentGender;
		var $studentDOB;
		var $studentNationality;
		var $studentUniversity;
		var $studentAddress;
		var $studentAddrLine1;
		var $studentAddrLine2;
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
		var $studentDate;
		var $linkRoomCode;
		var $linkRoomPhone;
		var $linkRoomIP;
		var $linkPeriodCode;
		var $linkPeriodName;
		var $linkPeriodSDate;
		var $linkPeriodEDate;

		function cStudent($host, $id, $pw, $db, $tbl1, $tbl2, $tbl3, $tbl4, $tbl5) {
			$this->studentTableName = $tbl1;
			$this->applyTableName = $tbl2;
			$this->periodTableName = $tbl3;
			$this->roomTableName = $tbl4;
			$this->accountTableName = $tbl5;
			$this->cMysql($host, $id, $pw, $db);
		}

		function getKindValue($val){
			if ($val == "U") $returnValue = "Korea University Student";
			else if ($val == "L") $returnValue = "Korean Language & Culture Center Student";
			else $returnValue = "";
			return $returnValue;
		}

		function getCurrentValue($val){
			if ($val == "Y") $returnValue = "Current Resident";
			else if ($val == "N") $returnValue = "Prospect Resident";
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
				if (!$this->EOF) {
					$returnValue = true;
					$this->studentNumber = $this->getField("info_no");
				}
				$this->freeResult();
			}
			return $returnValue;
		}

		function isStudentIDExist($id) {
			$returnValue = false;
			if ($id) {
				$this->clearSQL();
				$this->appendSQL("SELECT info_no FROM $this->studentTableName WHERE student_id='$id'");
				$this->parseQuery();
				if (!$this->EOF) {
					$returnValue = true;
					$this->studentNumber = $this->getField("info_no");
				}
				$this->freeResult();
			}
			return $returnValue;
		}

		function checkPassword($email, $pw) {
			$returnValue = false;
			if ($email) {
				$this->clearSQL();
				$this->appendSQL("SELECT passwd FROM $this->studentTableName WHERE email='$email'");
				$this->parseQuery();
				if ($this->getNumberRows() > 0 && $this->getField("passwd") == crypt($pw, $this->getField("passwd"))) $returnValue = true;
				$this->freeResult();
			}
			//$returnValue = true;
			return $returnValue;
		}

		function getStudentNumber($email) {
			$returnValue = "";
			if ($email) {
				$this->clearSQL();
				$this->appendSQL("SELECT info_no FROM $this->studentTableName WHERE email='$email'");
				$this->parseQuery();
				if (!$this->EOF) $returnValue = $this->getField("info_no");
				$this->freeResult();
			}
			return $returnValue;
		}

		function getStudentBasic($email) {
			if ($email) {
				$this->clearSQL();
				$this->appendSQL("SELECT info_no, nationality, student_id, class FROM $this->studentTableName WHERE email='$email'");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->studentNumber = $this->getField("info_no");
					$this->studentNationality = $this->getField("nationality");
					$this->studentID = $this->getField("student_id");
					$this->studentClass = $this->getField("class");
				}
				$this->freeResult();
			}
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
				$this->studentLastName = $this->getField("lname");
				$this->studentPreferName = $this->getField("prefer");
				$this->studentKoreanName = $this->getField("name_kr");
				$this->studentGender = $this->getField("gender");
				$this->studentDOB = $this->getField("dob");
				$this->studentNationality = $this->getField("nationality");
				$this->studentUniversity = $this->getField("home_uni");
				$this->studentAddress = $this->getField("home_addr");
				$this->studentAddrLine1 = $this->getField("home_addr1");
				$this->studentAddrLine2 = $this->getField("home_addr2");
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
				$this->studentDate = $this->getField("post_date");
			}
			$this->freeResult();
		}

		function getPlacementInfo($email) {
			if ($email) {
				$this->clearSQL();
				$this->appendSQL("SELECT a.room_code, ph, ip, a.period_code, b.name, sdate, edate FROM $this->applyTableName a ");
				$this->appendSQL("LEFT JOIN $this->periodTableName b ON a.period_code=b.period_code ");
				$this->appendSQL("LEFT JOIN $this->roomTableName c ON a.room_code=c.room_code WHERE a.email='$email' ORDER BY edate DESC LIMIT 0, 1");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->linkRoomCode = $this->getField("room_code");
					$this->linkRoomPhone = $this->getField("ph");
					$this->linkRoomIP = $this->getField("ip");
					$this->linkPeriodCode = $this->getField("period_code");
					$this->linkPeriodName = $this->getField("name");
					$this->linkPeriodSDate = $this->getField("sdate");
					$this->linkPeriodEDate = $this->getField("edate");
				}
				$this->freeResult();
			}
		}

		function getCheckInfo($email) {
			$this->clearSQL();
			$this->appendSQL("SELECT kind, current, fname, mname, lname FROM $this->studentTableName WHERE email='$email'");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->studentKind = $this->getField("kind");
				$this->studentCurrent = $this->getField("current");
				$this->studentFirstName = $this->getField("fname");
				$this->studentMiddleName = $this->getField("mname");
				$this->studentLastName = $this->getField("lname");
			}
			$this->freeResult();
		}

		function updatePassword($no, $pw) {
			$pw = crypt($pw);
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->studentTableName SET passwd='$pw' WHERE info_no=$no");
			$returnValue = $this->execQuery();
			return $returnValue;
		}

		function insertStudent($pw, $kind, $current, $id, $fnm, $mnm, $lnm, $pr_nm, $nm_kr, $gender, $dob, $nation, $uni, $addr, $line1, $line2, $city, $state, $postal, $country, $addr1, $major, $class, $kgsp, $email, $ph, $cell, $case_nm, $case_rel, $case_ph, $case_addr) {
			$pw = crypt($pw);
			$acc = "";
			$this->clearSQL();
			$this->appendSQL("SELECT acc_no FROM $this->accountTableName WHERE use_flag='N' ORDER BY acc_no LIMIT 0, 1");
			$this->parseQuery();
			if (!$this->EOF) $acc = $this->getField("acc_no");
			$this->freeResult();
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->studentTableName (passwd, kind, current, student_id, fname, mname, lname, prefer, name_kr, gender, dob, nationality, home_uni, home_addr, home_addr1, home_addr2, home_city, home_state, home_postal, home_country, res_addr, major, class, kgsp, email, phone, cell, case_name, case_relate, case_phone, case_addr, post_date, account)");
			$this->appendSQL("VALUES ('$pw', '$kind', '$current', '$id', '$fnm', '$mnm', '$lnm', '$pr_nm', '$nm_kr', '$gender', '$dob', '$nation', '$uni', '$addr', '$line1', '$line2', '$city', '$state', '$postal', '$country', '$addr1', '$major', '$class', '$kgsp', '$email', '$ph', '$cell', '$case_nm', '$case_rel', '$case_ph', '$case_addr', now(), '$acc')");
			$returnValue = $this->execQuery();
			if ($returnValue) $this->studentNumber = $this->getInsertID();
			if ($returnValue && $acc) {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->accountTableName SET use_flag='Y', use_dt=now() WHERE acc_no='$acc'");
				$returnValue = $this->execQuery();
			}
			return $returnValue;
		}

		function updateStudent($no, $id, $fnm, $mnm, $lnm, $pr_nm, $nm_kr, $gender, $dob, $nation, $uni, $addr, $line1, $line2, $city, $state, $postal, $country, $addr1, $major, $class, $kgsp, $email, $ph, $cell, $case_nm, $case_rel, $case_ph, $case_addr) {
			$old = "";
			$this->clearSQL();
			$this->appendSQL("SELECT email FROM $this->studentTableName WHERE info_no=$no");
			$this->parseQuery();
			if (!$this->EOF) $old = $this->getField("email");
			$this->freeResult();
			$this->clearSQL();
			$this->appendSQL("UPDATE $this->studentTableName SET student_id='$id', fname='$fnm', mname='$mnm', lname='$lnm', prefer='$pr_nm', name_kr='$nm_kr', ");
			$this->appendSQL("gender='$gender', dob='$dob', nationality='$nation', home_uni='$uni', home_addr='$addr', home_addr1='$line1', home_addr2='$line2', ");
			$this->appendSQL("home_city='$city', home_state='$state', home_postal='$postal', home_country='$country', res_addr='$addr1', major='$major', ");
			$this->appendSQL("class='$class', kgsp='$kgsp', email='$email', phone='$ph', cell='$cell', case_name='$case_nm', case_relate='$case_rel', case_phone='$case_ph', ");
			$this->appendSQL("case_addr='$case_addr' WHERE info_no=$no");
			$returnValue = $this->execQuery();
			if ($returnValue && $old != $email) {
				$this->clearSQL();
				$this->appendSQL("UPDATE $this->applyTableName SET email='$email' WHERE email='$old'");
				$returnValue = $this->execQuery();
			}
			return $returnValue;
		}
	}
?>