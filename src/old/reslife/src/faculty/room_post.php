<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] == 8 || (int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/faculty_tpl.php");
			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(year_row  => "body",
			                           year1_row => "body",
			                           month_row => "body",
			                           rate_row  => "body"));

			for ($i = 2006; $i <= date("Y") + 3; $i++) {
				$tpl->assign(YEAR_VALUE, $i);
				$tpl->parse(YEAR_ROWS, ".year_row");
			}
			for ($i = 1930; $i <= date("Y"); $i++) {
				$tpl->assign(YEAR1_VALUE, $i);
				$tpl->parse(YEAR1_ROWS, ".year1_row");
			}
			for ($i = 1; $i <= 12; $i++) {
				$temp = $i;
				if ($temp < 10) $temp = "0" . $temp;
				$tpl->assign(MONTH_VALUE, $temp);
				$tpl->parse(MONTH_ROWS, ".month_row");
			}

			$faculty->getRateList("IFRH");
			for ($i = 0; $i < count($faculty->rateListCode); $i++) {
				$tpl->assign(array(RATE_VALUE => $faculty->rateListCode[$i],
				                   RATE_NAME  => $faculty->getDormitoryValue($faculty->rateListDormitory[$i]) . " - " . $faculty->rateListUnit[$i]));
				$tpl->parse(RATE_ROWS, ".rate_row");
			}

			if ($mode == "edit") {
				$page_name .= " 수정";
				$faculty->getFacultyInfo($no);
				$no = $faculty->facultyNumber;
				$state = $faculty->facultyState;
				$title = $faculty->facultyTitle;
				$lname = stripslashes($faculty->facultyLName);
				$fname = stripslashes($faculty->facultyFName);
				$mname = stripslashes($faculty->facultyMName);
				$name_kr = stripslashes($faculty->facultyKName);
				$employ = stripslashes($faculty->facultyEmployee);
				$purpose = stripslashes($faculty->facultyPurpose);
				$kdepart = stripslashes($faculty->facultyKDepart);
				$kpos = stripslashes($faculty->facultyKPosition);
				$hdepart = stripslashes($faculty->facultyHDepart);
				$hpos = stripslashes($faculty->facultyHPosition);
				$nation = stripslashes($faculty->facultyNationality);
				$dob = explode("-", $faculty->facultyDOB);
				$country = stripslashes($faculty->facultyCountry);
				$email = $faculty->facultyEmail;
				$phone = $faculty->facultyPhone;
				$arrival = $faculty->facultyArrival;
				$departure = $faculty->facultyDeparture;
				$affiliate = $faculty->facultyAffiliate;
				$pay = $faculty->facultyPMethod;
				$rlname = stripslashes($faculty->facultyRLName);
				$rfname = stripslashes($faculty->facultyRFName);
				$rmname = stripslashes($faculty->facultyRMName);
				$rdepart = stripslashes($faculty->facultyRDepart);
				$rpos = stripslashes($faculty->facultyRPosition);
				$remail = $faculty->facultyREmail;
				$rphone = $faculty->facultyRPhone;
				$settle1 = $faculty->facultySettle1;
				$settle2 = $faculty->facultySettle2;
				$settle3 = $faculty->facultySettle3;
				$settle4 = $faculty->facultySettle4;
				$rate = $faculty->facultyRate;
				$request = stripslashes($faculty->facultyRequest);
				$admin = stripslashes($faculty->facultyAdmin);
				$no_room = $faculty->facultyNoRoom;
			} else {
				$page_name .= " 추가";
				$no = "";
				$state = "IW";
				$title = "Mr";
				$lname = "";
				$fname = "";
				$mname = "";
				$name_kr = "";
				$employ = "";
				$purpose = "";
				$kdepart = "";
				$kpos = "";
				$hdepart = "";
				$hpos = "";
				$nation = "";
				$dob = array();
				$country = "";
				$email = "";
				$phone = "";
				$arrival = "";
				$departure = "";
				$affiliate = "N";
				$pay = "N";
				$rlname = "";
				$rfname = "";
				$rmname = "";
				$rdepart = "";
				$rpos = "";
				$remail = "";
				$rphone = "";
				$settle1 = "N";
				$settle2 = "N";
				$settle3 = "N";
				$settle4 = "N";
				$rate = "";
				$request = "";
				$admin = "";
				$no_room = "";
			}

			$tpl->assign(array(MODE              => $mode,
			                   SEL_PAGE          => $page,
			                   SEARCH_TYPE       => $s_type,
			                   SEARCH_TEXT       => $s_text,
			                   SEARCH_TERM       => $s_term,
			                   SEARCH_STATE      => $s_state,
			                   SEARCH_GRADE      => $s_grade,
			                   SEARCH_RATE       => $s_rate,
			                   SEARCH_ROOM       => $s_room,
			                   SEARCH_DORM       => $s_dorm,
			                   SORT1_VALUE       => $sort1,
			                   SORT2_VALUE       => $sort2,
			                   FACULTY_NUMBER    => $no,
			                   FACULTY_STATE     => $state,
			                   FACULTY_TITLE     => $title,
			                   FACULTY_LNAME     => $lname,
			                   FACULTY_FNAME     => $fname,
			                   FACULTY_MNAME     => $mname,
			                   FACULTY_KNAME     => $name_kr,
			                   FACULTY_EMPLOY    => $employ,
			                   FACULTY_PURPOSE   => $purpose,
			                   FACULTY_KDEPART   => $kdepart,
			                   FACULTY_KPOS      => $kpos,
			                   FACULTY_HDEPART   => $hdepart,
			                   FACULTY_HPOS      => $hpos,
			                   FACULTY_NATION    => $nation,
			                   FACULTY_DOB_YY    => $dob[0],
			                   FACULTY_DOB_MM    => $dob[1],
			                   FACULTY_DOB_DD    => $dob[2],
			                   FACULTY_COUNTRY   => $country,
			                   FACULTY_EMAIL     => $email,
			                   FACULTY_PHONE     => $phone,
			                   FACULTY_ARRIVAL   => $arrival,
			                   FACULTY_DEPARTURE => $departure,
			                   FACULTY_AFFILIATE => $affiliate,
			                   FACULTY_PAY       => $pay,
			                   FACULTY_RLNAME    => $rlname,
			                   FACULTY_RFNAME    => $rfname,
			                   FACULTY_RMNAME    => $rmname,
			                   FACULTY_RDEPART   => $rdepart,
			                   FACULTY_RPOS      => $rpos,
			                   FACULTY_REMAIL    => $remail,
			                   FACULTY_RPHONE    => $rphone,
			                   FACULTY_SETTLE1   => $settle1,
			                   FACULTY_SETTLE2   => $settle2,
			                   FACULTY_SETTLE3   => $settle3,
			                   FACULTY_SETTLE4   => $settle4,
			                   FACULTY_RATE      => $rate,
			                   FACULTY_REQUEST   => $request,
			                   FACULTY_ADMIN     => $admin,
			                   FACULTY_NO_ROOM   => $no_room));

			$faculty->closeDatabase();
			unset($faculty);

			include_once("../common/footer_tpl.php");
		}
	}
?>