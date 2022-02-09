<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/grad_student_tpl.php");

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
				$email = htmlspecialchars(addslashes($_POST["email"]));
				$nation = htmlspecialchars(addslashes($_POST["nation"]));
				//if (eregi("korea", $nation)) $mode = "no";
				//if ($effectiveness != "Y") $mode = "no_id";
				if ($student->isEmailExist($email)) $mode = "email";
				else if ($student->isStudentIDExist($id)) $mode = "id";
				else {
					$gender = $_POST["gender"];
					$dob_yy = $_POST["dob_yy"];
					$dob_mm = $_POST["dob_mm"];
					$dob_dd = $_POST["dob_dd"];
					$sclass = $_POST["sclass"];
					$phone = $_POST["phone"];
					$cell = $_POST["cell"];
					$case_ph = $_POST["case_ph"];
					$fname = htmlspecialchars(addslashes(strtoupper($_POST["fname"])));
					$mname = htmlspecialchars(addslashes(strtoupper($_POST["mname"])));
					$lname = htmlspecialchars(addslashes(strtoupper($_POST["lname"])));
					$prefer = htmlspecialchars(addslashes(strtoupper($_POST["prefer"])));
					$name_kr = htmlspecialchars(addslashes($_POST["name_kr"]));
					$province = htmlspecialchars(addslashes($_POST["province"]));
					$kgsp = $_POST["kgsp"];
					$home_uni = htmlspecialchars(addslashes($_POST["home_uni"]));
					$home_addr = htmlspecialchars(addslashes($_POST["home_addr"]));
					$home_addr1 = htmlspecialchars(addslashes($_POST["home_addr1"]));
					$home_addr2 = htmlspecialchars(addslashes($_POST["home_addr2"]));
					$home_city = htmlspecialchars(addslashes($_POST["home_city"]));
					$home_state = htmlspecialchars(addslashes($_POST["home_state"]));
					$home_postal = htmlspecialchars(addslashes($_POST["home_postal"]));
					$home_country = htmlspecialchars(addslashes($_POST["home_country"]));
					$res_addr = htmlspecialchars(addslashes($_POST["res_addr"]));
					$major = htmlspecialchars(addslashes($_POST["major"]));
					$case_nm = htmlspecialchars(addslashes($_POST["case_nm"]));
					$case_rel = htmlspecialchars(addslashes($_POST["case_rel"]));
					$case_addr = htmlspecialchars(addslashes($_POST["case_addr"]));
					if ($gender != "F") $gender = "M";
					if ($sclass != "M" && $sclass != "D" && $sclass != "B") $sclass = "N";
					if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
					else $dob = "0000-00-00";
					if ($nation != "South Korea (Republic Of Korea)") $province = "";
					if ($kgsp != "Y") $kgsp = "N";
					$flag = $student->insertStudent($new_pw, $id, $fname, $mname, $lname, $prefer, $name_kr, $gender, $dob, $nation, $province, $kgsp, $home_uni, $home_addr, $home_addr1, $home_addr2, $home_city, $home_state, $home_postal, $home_country, $res_addr, $major, $sclass, $email, $phone, $cell, $case_nm, $case_rel, $case_ph, $case_addr);
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
				$email = htmlspecialchars(addslashes($_POST["email"]));
				$nation = htmlspecialchars(addslashes($_POST["nation"]));
				//if ($effectiveness != "Y") $mode = "no_id";
				if ($student->isEmailExist($email) && $no != $student->studentNumber) $mode = "email";
				else if ($student->isStudentIDExist($id) && $no != $student->studentNumber) $mode = "id";
				else {
					$gender = $_POST["gender"];
					$dob_yy = $_POST["dob_yy"];
					$dob_mm = $_POST["dob_mm"];
					$dob_dd = $_POST["dob_dd"];
					$sclass = $_POST["sclass"];
					$phone = $_POST["phone"];
					$cell = $_POST["cell"];
					$case_ph = $_POST["case_ph"];
					$fname = htmlspecialchars(addslashes(strtoupper($_POST["fname"])));
					$mname = htmlspecialchars(addslashes(strtoupper($_POST["mname"])));
					$lname = htmlspecialchars(addslashes(strtoupper($_POST["lname"])));
					$prefer = htmlspecialchars(addslashes(strtoupper($_POST["prefer"])));
					$name_kr = htmlspecialchars(addslashes($_POST["name_kr"]));
					$province = htmlspecialchars(addslashes($_POST["province"]));
					$kgsp = $_POST["kgsp"];
					$home_uni = htmlspecialchars(addslashes($_POST["home_uni"]));
					$home_addr = htmlspecialchars(addslashes($_POST["home_addr"]));
					$home_addr1 = htmlspecialchars(addslashes($_POST["home_addr1"]));
					$home_addr2 = htmlspecialchars(addslashes($_POST["home_addr2"]));
					$home_city = htmlspecialchars(addslashes($_POST["home_city"]));
					$home_state = htmlspecialchars(addslashes($_POST["home_state"]));
					$home_postal = htmlspecialchars(addslashes($_POST["home_postal"]));
					$home_country = htmlspecialchars(addslashes($_POST["home_country"]));
					$res_addr = htmlspecialchars(addslashes($_POST["res_addr"]));
					$major = htmlspecialchars(addslashes($_POST["major"]));
					$case_nm = htmlspecialchars(addslashes($_POST["case_nm"]));
					$case_rel = htmlspecialchars(addslashes($_POST["case_rel"]));
					$case_addr = htmlspecialchars(addslashes($_POST["case_addr"]));
					if ($gender != "F") $gender = "M";
					if ($sclass != "M" && $sclass != "D" && $sclass != "B") $sclass = "N";
					if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
					else $dob = "0000-00-00";
					if ($nation != "South Korea (Republic Of Korea)") $province = "";
					if ($kgsp != "Y") $kgsp = "N";
					$flag = $student->updateStudent($no, $id, $fname, $mname, $lname, $prefer, $name_kr, $gender, $dob, $nation, $province, $kgsp, $home_uni, $home_addr, $home_addr1, $home_addr2, $home_city, $home_state, $home_postal, $home_country, $res_addr, $major, $sclass, $email, $phone, $cell, $case_nm, $case_rel, $case_ph, $case_addr);
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
		echo "document.location.replace(\"../../src/main/page.php?code=grad_account\");";
		echo "</script>";
	} else if ($mode == "new") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Thank you. Your personal information is successfully registered.\");";
		echo "document.location.replace(\"../../src/main/page.php?code=grad_account\");";
		echo "</script>";
	} else if ($mode == "edit") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Personal information is successfully updated.\");";
		echo "document.location.replace(\"../../src/graduate/list_app.php?email=$email&pw=$pw\");";
		echo "</script>";
	} else if ($mode == "app") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Personal information is successfully updated.\");";
		echo "document.location.replace(\"../../src/graduate/contract.php?email=$email&pw=$pw\");";
		echo "</script>";
	} else header("Location: ../../src/main/page.php?code=grad_account");
?>