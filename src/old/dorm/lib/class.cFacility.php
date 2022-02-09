<?
	include_once("class.cMysql.php");

	class cFacility extends cMysql {
		var $facilityTableName;
		var $facilityNumber;
		var $facilityState;
		var $facilityEventName;
		var $facilityApplicant;
		var $facilityResident;
		var $facilityDepartment;
		var $facilityPosition;
		var $facilityEmail;
		var $facilityPhone;
		var $facilityEventDate;
		var $facilityEventHour;
		var $facilityAttendee;
		var $facilityRequest;
		var $facilityBreakfast;
		var $facilityFee;
		var $facilitySettle1;
		var $facilitySettle2;
		var $facilitySettle3;
		var $facilitySettle4;
		var $facilityApply;
		var $facilityAssign;
		var $facilityConfirm;
		var $facilityBilled;
		var $facilityPaid;

		function cFacility($host, $id, $pw, $db, $tbl) {
			$this->facilityTableName = $tbl;
			$this->cMysql($host, $id, $pw, $db);
		}

		function getStateValue($val){
			if ($val == "IW") $returnValue = "Applied";
			else if ($val == "AS") $returnValue = "Assigned";
			else if ($val == "CC") $returnValue = "Cancelled";
			else if ($val == "CF") $returnValue = "Confirmed";
			else if ($val == "PR") $returnValue = "Paid Rental Fee";
			else if ($val == "PB") $returnValue = "Paid Breakfast";
			else if ($val == "PD") $returnValue = "Paid Deposit";
			else if ($val == "RF") $returnValue = "Refund";
			else $returnValue = "";
			return $returnValue;
		}

		function getRoomValue($val) {
			$returnValue = "";
			$val = explode("|", $val);
			if ($val[0] == "C1") $returnValue .= "Korea University Alumni Association Conference Hall with beam projector - Seat 23<br>";
			if ($val[1] == "S1") $returnValue .= "Kang Hyun Suk Seminar Room with white board - Seat 8<br>";
			if ($val[2] == "S2") $returnValue .= "Korea University Alumni Association of Southern California Seminar Room with white board - Seat 8<br>";
			if ($val[3] == "R1") $returnValue .= "Koryo Lions Club Study Room - Seat 30<br>";
			if ($val[4] == "R2") $returnValue .= "Choi, Sang Yong Study Room - Seat 25<br>";
			if ($returnValue) $returnValue = substr($returnValue, 0, strlen($returnValue) - 4);
			return $returnValue;
		}

		function getUnitValue($val) {
			$returnValue = "";
			$val = explode("|", $val);
			if ($val[0] == "C1") $returnValue .= "B113 Conference, ";
			if ($val[1] == "S1") $returnValue .= "B105 Seminar, ";
			if ($val[2] == "S2") $returnValue .= "B104 Seminar, ";
			if ($val[3] == "R1") $returnValue .= "441 Study Room, ";
			if ($val[4] == "R2") $returnValue .= "641 Study Room, ";
			if ($returnValue) $returnValue = substr($returnValue, 0, strlen($returnValue) - 2);
			return $returnValue;
		}

		function getSettleValue($val){
			if ($val == "Y") $returnValue = "전결";
			else $returnValue = "";
			return $returnValue;
		}

		function getBreakfastValue($val){
			if ($val == "Y") $returnValue = "Yes";
			else $returnValue = "No";
			return $returnValue;
		}

		function getResidentValue($val){
			if ($val == "Y") $returnValue = "CJ International House Resident (거주자)";
			else if ($val == "N") $returnValue = "Non Resident (비거주자)";
			else $returnValue = "";
			return $returnValue;
		}

		function isExist($no, $name) {
			$returnValue = false;
			$this->clearSQL();
			$this->appendSQL("SELECT apply_no FROM $this->facilityTableName WHERE apply_no='$no' AND event='$name'");
			$this->parseQuery();
			if ($this->getNumberRows() > 0) $returnValue = true;
			$this->freeResult();
			return $returnValue;
		}

		function getFacilityNumber($dt) {
			$returnValue = "";
			$where = "";
			if ($dt) $where = "WHERE apply_no>$dt" . "0000";
			$this->clearSQL();
			$this->appendSQL("SELECT COUNT(*) AS cnt FROM $this->facilityTableName $where");
			$this->parseQuery();
			if (!$this->EOF) $returnValue = $this->getField("cnt");
			$this->freeResult();
			return $returnValue;
		}

		function getFacilityInfo($no) {
			$this->clearSQL();
			$this->appendSQL("SELECT * FROM $this->facilityTableName WHERE apply_no=$no");
			$this->parseQuery();
			if (!$this->EOF) {
				$this->facilityNumber = $this->getField("apply_no");
				$this->facilityState = $this->getField("state");
				$this->facilityEventName = $this->getField("event");
				$this->facilityApplicant = $this->getField("applicant");
				$this->facilityResident = $this->getField("resident");
				$this->facilityDepartment = $this->getField("department");
				$this->facilityPosition = $this->getField("position");
				$this->facilityEmail = $this->getField("email");
				$this->facilityPhone = $this->getField("phone");
				$this->facilityEventDate = $this->getField("event_dt");
				$this->facilityEventHour = $this->getField("event_hr");
				$this->facilityAttendee = $this->getField("attendee");
				$this->facilityRequest = $this->getField("request");
				$this->facilityBreakfast = $this->getField("breakfast");
				$this->facilityFee = $this->getField("fee");
				$this->facilityMeal = $this->getField("meal");
				$this->facilitySettle1 = $this->getField("settle1");
				$this->facilitySettle2 = $this->getField("settle2");
				$this->facilitySettle3 = $this->getField("settle3");
				$this->facilitySettle4 = $this->getField("settle4");
				$this->facilityApply = $this->getField("apply_date");
				$this->facilityAssign = $this->getField("assign_date");
				$this->facilityConfirm = $this->getField("confirm_date");
				$this->facilityBilled = $this->getField("billed_date");
				$this->facilityPaid = $this->getField("paid_date");
			}
			$this->freeResult();
		}

		function insertFacility($no, $event, $applicant, $resident, $department, $position, $email, $phone, $event_dt, $event_hr, $attendee, $request, $breakfast, $fee, $meal) {
			$this->clearSQL();
			$this->appendSQL("INSERT INTO $this->facilityTableName (apply_no, event, applicant, resident, department, position, email, phone, event_dt, ");
			$this->appendSQL("event_hr, attendee, request, breakfast, fee, meal, apply_date) VALUES (");
			$this->appendSQL("'$no', '$event', '$applicant', '$resident', '$department', '$position', '$email', '$phone', '$event_dt', '$event_hr', ");
			$this->appendSQL("'$attendee', '$request', '$breakfast', '$fee', '$meal', now())");
			$returnValue = $this->execQuery();
			if ($returnValue) $this->facilityNumber = $this->getInsertID();
			return $returnValue;
		}

		function isRoomAvailable($rm1, $rm2, $rm3, $rm4, $rm5, $dt, $start, $end) {
			$returnValue = true;
			if ($dt && $rm1) {
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->facilityTableName WHERE state IN ('AS', 'CF', 'PR', 'PD') AND request LIKE '%" . $rm1 . "%' AND event_dt='$dt' AND ");
				$this->appendSQL("((SUBSTRING(event_hr, 1, 5)<='$start' AND SUBSTRING(event_hr, 7, 5)>'$start') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)<'$end' AND SUBSTRING(event_hr, 7, 5)>='$end') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)>'$start' AND SUBSTRING(event_hr, 7, 5)<'$end'))");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->facilityNumber = $this->getField("apply_no");
					$returnValue = false;
				}
			}
			if ($dt && $rm2) {
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->facilityTableName WHERE state IN ('AS', 'CF', 'PR', 'PD') AND request LIKE '%" . $rm2 . "%' AND event_dt='$dt' AND ");
				$this->appendSQL("((SUBSTRING(event_hr, 1, 5)<='$start' AND SUBSTRING(event_hr, 7, 5)>'$start') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)<'$end' AND SUBSTRING(event_hr, 7, 5)>='$end') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)>'$start' AND SUBSTRING(event_hr, 7, 5)<'$end'))");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->facilityNumber = $this->getField("apply_no");
					$returnValue = false;
				}
			}
			if ($dt && $rm3) {
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->facilityTableName WHERE state IN ('AS', 'CF', 'PR', 'PD') AND request LIKE '%" . $rm3 . "%' AND event_dt='$dt' AND ");
				$this->appendSQL("((SUBSTRING(event_hr, 1, 5)<='$start' AND SUBSTRING(event_hr, 7, 5)>'$start') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)<'$end' AND SUBSTRING(event_hr, 7, 5)>='$end') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)>'$start' AND SUBSTRING(event_hr, 7, 5)<'$end'))");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->facilityNumber = $this->getField("apply_no");
					$returnValue = false;
				}
			}
			if ($dt && $rm4) {
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->facilityTableName WHERE state IN ('AS', 'CF', 'PR', 'PD') AND request LIKE '%" . $rm4 . "%' AND event_dt='$dt' AND ");
				$this->appendSQL("((SUBSTRING(event_hr, 1, 5)<='$start' AND SUBSTRING(event_hr, 7, 5)>'$start') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)<'$end' AND SUBSTRING(event_hr, 7, 5)>='$end') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)>'$start' AND SUBSTRING(event_hr, 7, 5)<'$end'))");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->facilityNumber = $this->getField("apply_no");
					$returnValue = false;
				}
			}
			if ($dt && $rm5) {
				$this->clearSQL();
				$this->appendSQL("SELECT * FROM $this->facilityTableName WHERE state IN ('AS', 'CF', 'PR', 'PD') AND request LIKE '%" . $rm5 . "%' AND event_dt='$dt' AND ");
				$this->appendSQL("((SUBSTRING(event_hr, 1, 5)<='$start' AND SUBSTRING(event_hr, 7, 5)>'$start') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)<'$end' AND SUBSTRING(event_hr, 7, 5)>='$end') OR ");
				$this->appendSQL("(SUBSTRING(event_hr, 1, 5)>'$start' AND SUBSTRING(event_hr, 7, 5)<'$end'))");
				$this->parseQuery();
				if (!$this->EOF) {
					$this->facilityNumber = $this->getField("apply_no");
					$returnValue = false;
				}
			}
			$this->freeResult();
			return $returnValue;
		}

		function calculateTime($h1, $m1, $h2, $m2) {
			$hour = (int)$h2 - (int)$h1;
			$minute = (int)$m2 - (int)$m1;
			if ($minute > 0) $hour++;
			return $hour;
		}

		function calculateFee($rm1, $rm2, $rm3, $rm4, $rm5, $h1, $m1, $h2, $m2, $breakfast) {
			$returnValue = 0;
			$hour = $this->calculateTime($h1, $m1, $h2, $m2);
			if ($rm1) {
				if ($hour > 2) $returnValue += 50000 + (($hour - 2) * 20000);
				else $returnValue += 50000;
			}
			if ($rm2) {
				if ($breakfast == "Y") $base_rent = 50000;
				else $base_rent = 30000;
				if ($hour > 2) $returnValue += $base_rent + (($hour - 2) * 10000);
				else $returnValue += $base_rent;
			}
			if ($rm3) {
				if ($breakfast == "Y") $base_rent = 50000;
				else $base_rent = 30000;
				if ($hour > 2) $returnValue += $base_rent + (($hour - 2) * 10000);
				else $returnValue += $base_rent;
			}
			if ($rm4) {
				if ($hour > 2) $returnValue += 50000 + (($hour - 2) * 20000);
				else $returnValue += 50000;
			}
			if ($rm5) {
				if ($hour > 2) $returnValue += 50000 + (($hour - 2) * 20000);
				else $returnValue += 50000;
			}
			return $returnValue;
		}

		function calculateMeal($attendee, $breakfast) {
			$returnValue = 0;
			if (is_numeric($attendee) && (int)$attendee > 10 && $breakfast == "Y") $returnValue = ((int)$attendee - 10) * 5000;
			return $returnValue;
		}
	}
?>