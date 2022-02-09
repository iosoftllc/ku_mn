<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/student_tpl.php");

	switch ($mode) {
		case "new":
			$photo_name = $HTTP_POST_FILES['photo']['name'];
			$photo_size = $HTTP_POST_FILES['photo']['size'];
			$photo_type = $HTTP_POST_FILES['photo']['type'];
			$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
			if ($photo_size <= $max_attach) {
				$id_year = $_POST["id_year"];
				$id_term = $_POST["id_term"];
				$id = $_POST["id"];
				$id = strtoupper($id);
				// 토큰 생성
				$url = "https://openapi.korea.ac.kr/oauth/token?client_id=ku_dorm_service&client_secret=kudorm1234&grant_type=client_credentials";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url); //접속할 URL 주소
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 인증서 체크같은데 true 시 안되는 경우가 많다.
				curl_setopt($ch, CURLOPT_SSLVERSION, 1); // SSL 버젼 (https 접속시에 필요)
				curl_setopt($ch, CURLOPT_HEADER, 0); // 헤더 출력 여부
				curl_setopt($ch, CURLOPT_TIMEOUT, 30); // TimeOut 값
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 결과값을 받을것인지
				$result = curl_exec($ch);
				curl_close($ch);
				$data = json_decode($result);
				$token = trim($data->{"access_token"});
				// 유효성 검사
				$url = "https://openapi.korea.ac.kr/api/dorm?format=json&access_token=$token&ex_no=$id&term=$id_term&year=$id_year";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url); //접속할 URL 주소
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 인증서 체크같은데 true 시 안되는 경우가 많다.
				curl_setopt($ch, CURLOPT_SSLVERSION, 1); // SSL 버젼 (https 접속시에 필요)
				curl_setopt($ch, CURLOPT_HEADER, 0); // 헤더 출력 여부
				curl_setopt($ch, CURLOPT_TIMEOUT, 30); // TimeOut 값
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 결과값을 받을것인지
				$result = curl_exec($ch);
				curl_close($ch);
				$data = json_decode($result);
				$effectiveness = trim($data->{"response"}->{"data"}[0]->{"effectiveness"});
				$pass = trim($data->{"response"}->{"data"}[0]->{"pass"});
				$email = $_POST["email"];
				$email = addslashes($email);
				$email = htmlspecialchars($email);
				$nation = $_POST["nation"];
				$nation = addslashes($nation);
				$nation = htmlspecialchars($nation);
				//if (eregi("korea", $nation)) $mode = "no";
				//if ($effectiveness != "Y") $mode = "no_id";
				if ($student->isEmailExist($email)) $mode = "email";
				else if ($student->isStudentIDExist($id)) $mode = "id";
				else {
					$kind = $_POST["kind"];
					$current = $_POST["current"];
					$gender = $_POST["gender"];
					$dob_yy = $_POST["dob_yy"];
					$dob_mm = $_POST["dob_mm"];
					$dob_dd = $_POST["dob_dd"];
					$sclass = $_POST["sclass"];
					$kgsp = $_POST["kgsp"];
					$phone = $_POST["phone"];
					$cell = $_POST["cell"];
					$case_ph = $_POST["case_ph"];
					$fname = strtoupper($_POST["fname"]);
					$fname = addslashes($fname);
					$fname = htmlspecialchars($fname);
					$mname = strtoupper($_POST["mname"]);
					$mname = addslashes($mname);
					$mname = htmlspecialchars($mname);
					$lname = strtoupper($_POST["lname"]);
					$lname = addslashes($lname);
					$lname = htmlspecialchars($lname);
					$prefer = strtoupper($_POST["prefer"]);
					$prefer = addslashes($prefer);
					$prefer = htmlspecialchars($prefer);
					$name_kr = $_POST["name_kr"];
					$name_kr = addslashes($name_kr);
					$name_kr = htmlspecialchars($name_kr);
					$home_uni = $_POST["home_uni"];
					$home_uni = addslashes($home_uni);
					$home_uni = htmlspecialchars($home_uni);
					$home_addr = $_POST["home_addr"];
					$home_addr = addslashes($home_addr);
					$home_addr = htmlspecialchars($home_addr);
					$home_addr1 = $_POST["home_addr1"];
					$home_addr1 = addslashes($home_addr1);
					$home_addr1 = htmlspecialchars($home_addr1);
					$home_addr2 = $_POST["home_addr2"];
					$home_addr2 = addslashes($home_addr2);
					$home_addr2 = htmlspecialchars($home_addr2);
					$home_city = $_POST["home_city"];
					$home_city = addslashes($home_city);
					$home_city = htmlspecialchars($home_city);
					$home_state = $_POST["home_state"];
					$home_state = addslashes($home_state);
					$home_state = htmlspecialchars($home_state);
					$home_postal = $_POST["home_postal"];
					$home_postal = addslashes($home_postal);
					$home_postal = htmlspecialchars($home_postal);
					$home_country = $_POST["home_country"];
					$home_country = addslashes($home_country);
					$home_country = htmlspecialchars($home_country);
					$res_addr = $_POST["res_addr"];
					$res_addr = addslashes($res_addr);
					$res_addr = htmlspecialchars($res_addr);
					$major = $_POST["major"];
					$major = addslashes($major);
					$major = htmlspecialchars($major);
					$case_nm = $_POST["case_nm"];
					$case_nm = addslashes($case_nm);
					$case_nm = htmlspecialchars($case_nm);
					$case_rel = $_POST["case_rel"];
					$case_rel = addslashes($case_rel);
					$case_rel = htmlspecialchars($case_rel);
					$case_addr = $_POST["case_addr"];
					$case_addr = addslashes($case_addr);
					$case_addr = htmlspecialchars($case_addr);
					if ($kind != "L") $kind = "U";
					if ($current != "Y") $current = "N";
					if ($gender != "F") $gender = "M";
					if ($sclass != "F" && $sclass != "P" && $sclass != "J" && $sclass != "S" && $sclass != "M" && $sclass != "D") $sclass = "N";
					if ($kgsp != "Y") $kgsp = "N";
					if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
					else $dob = "0000-00-00";
					$flag = $student->insertStudent($new_pw, $kind, $current, $id, $fname, $mname, $lname, $prefer, $name_kr, $gender, $dob, $nation, $home_uni, $home_addr, $home_addr1, $home_addr2, $home_city, $home_state, $home_postal, $home_country, $res_addr, $major, $sclass, $kgsp, $email, $phone, $cell, $case_nm, $case_rel, $case_ph, $case_addr);
					if ($flag) {
						if (is_uploaded_file($photo)) {
							$flag = move_uploaded_file($photo_tmp, $pht_dir."/".$student->studentNumber.".jpg");
							if ($flag) resizeImage($pht_width, $pht_height, $pht_dir."/".$student->studentNumber.".jpg", $pht_dir."/".$student->studentNumber.".jpg");
						}
					} else $mode = "error";
				}
			} else $mode = "over";
			break;
		case "app":
		case "edit":
			$photo_name = $HTTP_POST_FILES['photo']['name'];
			$photo_size = $HTTP_POST_FILES['photo']['size'];
			$photo_type = $HTTP_POST_FILES['photo']['type'];
			$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
			if ($photo_size <= $max_attach) {
				$id_year = $_POST["id_year"];
				$id_term = $_POST["id_term"];
				$id = $_POST["id"];
				$id = strtoupper($id);
				// 토큰 생성
				$url = "https://openapi.korea.ac.kr/oauth/token?client_id=ku_dorm_service&client_secret=kudorm1234&grant_type=client_credentials";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url); //접속할 URL 주소
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 인증서 체크같은데 true 시 안되는 경우가 많다.
				curl_setopt($ch, CURLOPT_SSLVERSION, 1); // SSL 버젼 (https 접속시에 필요)
				curl_setopt($ch, CURLOPT_HEADER, 0); // 헤더 출력 여부
				curl_setopt($ch, CURLOPT_TIMEOUT, 30); // TimeOut 값
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 결과값을 받을것인지
				$result = curl_exec($ch);
				curl_close($ch);
				$data = json_decode($result);
				$token = trim($data->{"access_token"});
				// 유효성 검사
				$url = "https://openapi.korea.ac.kr/api/dorm?format=json&access_token=$token&ex_no=$id&term=$id_term&year=$id_year";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url); //접속할 URL 주소
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 인증서 체크같은데 true 시 안되는 경우가 많다.
				curl_setopt($ch, CURLOPT_SSLVERSION, 1); // SSL 버젼 (https 접속시에 필요)
				curl_setopt($ch, CURLOPT_HEADER, 0); // 헤더 출력 여부
				curl_setopt($ch, CURLOPT_TIMEOUT, 30); // TimeOut 값
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 결과값을 받을것인지
				$result = curl_exec($ch);
				curl_close($ch);
				$data = json_decode($result);
				$effectiveness = trim($data->{"response"}->{"data"}[0]->{"effectiveness"});
				$pass = trim($data->{"response"}->{"data"}[0]->{"pass"});
				$email = $_POST["email"];
				$email = addslashes($email);
				$email = htmlspecialchars($email);
				//if ($effectiveness != "Y") $mode = "no_id";
				if ($student->isEmailExist($email) && $no != $student->studentNumber) $mode = "email";
				else if ($student->isStudentIDExist($id) && $no != $student->studentNumber) $mode = "id";
				else {
					$gender = $_POST["gender"];
					$dob_yy = $_POST["dob_yy"];
					$dob_mm = $_POST["dob_mm"];
					$dob_dd = $_POST["dob_dd"];
					$sclass = $_POST["sclass"];
					$kgsp = $_POST["kgsp"];
					$phone = $_POST["phone"];
					$cell = $_POST["cell"];
					$case_ph = $_POST["case_ph"];
					$fname = strtoupper($_POST["fname"]);
					$fname = addslashes($fname);
					$fname = htmlspecialchars($fname);
					$mname = strtoupper($_POST["mname"]);
					$mname = addslashes($mname);
					$mname = htmlspecialchars($mname);
					$lname = strtoupper($_POST["lname"]);
					$lname = addslashes($lname);
					$lname = htmlspecialchars($lname);
					$prefer = strtoupper($_POST["prefer"]);
					$prefer = addslashes($prefer);
					$prefer = htmlspecialchars($prefer);
					$name_kr = $_POST["name_kr"];
					$name_kr = addslashes($name_kr);
					$name_kr = htmlspecialchars($name_kr);
					$home_uni = $_POST["home_uni"];
					$home_uni = addslashes($home_uni);
					$home_uni = htmlspecialchars($home_uni);
					$home_addr = $_POST["home_addr"];
					$home_addr = addslashes($home_addr);
					$home_addr = htmlspecialchars($home_addr);
					$home_addr1 = $_POST["home_addr1"];
					$home_addr1 = addslashes($home_addr1);
					$home_addr1 = htmlspecialchars($home_addr1);
					$home_addr2 = $_POST["home_addr2"];
					$home_addr2 = addslashes($home_addr2);
					$home_addr2 = htmlspecialchars($home_addr2);
					$home_city = $_POST["home_city"];
					$home_city = addslashes($home_city);
					$home_city = htmlspecialchars($home_city);
					$home_state = $_POST["home_state"];
					$home_state = addslashes($home_state);
					$home_state = htmlspecialchars($home_state);
					$home_postal = $_POST["home_postal"];
					$home_postal = addslashes($home_postal);
					$home_postal = htmlspecialchars($home_postal);
					$home_country = $_POST["home_country"];
					$home_country = addslashes($home_country);
					$home_country = htmlspecialchars($home_country);
					$res_addr = $_POST["res_addr"];
					$res_addr = addslashes($res_addr);
					$res_addr = htmlspecialchars($res_addr);
					$major = $_POST["major"];
					$major = addslashes($major);
					$major = htmlspecialchars($major);
					$case_nm = $_POST["case_nm"];
					$case_nm = addslashes($case_nm);
					$case_nm = htmlspecialchars($case_nm);
					$case_rel = $_POST["case_rel"];
					$case_rel = addslashes($case_rel);
					$case_rel = htmlspecialchars($case_rel);
					$case_addr = $_POST["case_addr"];
					$case_addr = addslashes($case_addr);
					$case_addr = htmlspecialchars($case_addr);
					if ($gender != "F") $gender = "M";
					if ($sclass != "F" && $sclass != "P" && $sclass != "J" && $sclass != "S" && $sclass != "M" && $sclass != "D") $sclass = "N";
					if ($kgsp != "Y") $kgsp = "N";
					if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
					else $dob = "0000-00-00";
					echo $res_addr;
					$flag = $student->updateStudent($no, $id, $fname, $mname, $lname, $prefer, $name_kr, $gender, $dob, $nation, $home_uni, $home_addr, $home_addr1, $home_addr2, $home_city, $home_state, $home_postal, $home_country, $res_addr, $major, $sclass, $kgsp, $email, $phone, $cell, $case_nm, $case_rel, $case_ph, $case_addr);
					if ($flag) {
						if (is_uploaded_file($photo)) {
							$flag = move_uploaded_file($photo_tmp, $pht_dir."/".$no.".jpg");
							if ($flag) resizeImage($pht_width, $pht_height, $pht_dir."/".$no.".jpg", $pht_dir."/".$no.".jpg");
						}
					} else $mode = "error";
				}
			} else $mode = "over";
			break;
		case "pw":
			$cur_pw = $_POST["cur_pw"];
			$new_pw = $_POST["new_pw"];
			$flag = $student->checkPassword($email, $cur_pw);
			if ($flag) {
				$flag = $student->updatePassword($no, $new_pw);
				if (!$flag) $mode = "error";
			} else $mode = "no_pw";
			break;
	}

	$student->closeDatabase();
	unset($student);
		
	if ($mode == "error") {
		echo "<script language=\"javascript\">";
		echo "alert(\"Unexpected error is occured.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "over") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The maximum size of photo file is " . round($max_attach / 1024 / 1024, 0) . " M.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "no") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry. Your personal information cannot be registered.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "no_id") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry. The student number you input is not valid.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "no_pw") {
		echo "<script language=\"javascript\">";
		echo "alert(\"Sorry. The password you input is not correct.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "email") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry. " . $email . " is already registered email.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "id") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry. " . $id . " is already registered student number.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "pw") {
		echo "<script language=\"javascript\">";
		echo "alert(\"Your password is successfully changed.\");";
		echo "document.location.replace(\"../../src/main/page.php?code=status_stu\");";
		echo "</script>";
	} else if ($mode == "new") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Thank you. Your personal information is successfully registered.\");";
		echo "document.location.replace(\"../../src/main/page.php?code=status_stu\");";
		echo "</script>";
	} else if ($mode == "edit") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Personal information is successfully updated.\");";
		echo "document.location.replace(\"../../src/apply/list_app.php?email=$email&pw=$pw\");";
		echo "</script>";
	} else if ($mode == "app") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Personal information is successfully updated.\");";
		echo "document.location.replace(\"../../src/apply/contract_app.php?email=$email&pw=$pw\");";
		echo "</script>";
	} else header("Location: ../../src/main/page.php?code=status_stu");
?>