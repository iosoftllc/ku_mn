<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 6 || (int)$ihouse_admin_info[grade] == 7 || (int)$ihouse_admin_info[grade] == 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/grad_student_tpl.php");
			
			switch ($mode) {
				case "new":
					$photo_name = $HTTP_POST_FILES['photo']['name'];
					$photo_size = $HTTP_POST_FILES['photo']['size'];
					$photo_type = $HTTP_POST_FILES['photo']['type'];
					$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
					if ($photo_size <= $max_attach) {
						$email = htmlspecialchars(addslashes($_POST["email"]));
						if ($student->isEmailExist($email)) $mode = "email";
						else {
							$pw = $_POST["pw"];
							$kind = $_POST["kind"];
							$current = $_POST["current"];
							$id = $_POST["id"];
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
							$nation = htmlspecialchars(addslashes($_POST["nation"]));
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
							$admin = htmlspecialchars(addslashes($_POST["admin"]));
							if ($kind != "S") $kind = "G";
							if ($current != "Y") $current = "N";
							if ($gender != "F") $gender = "M";
							if ($sclass != "M" && $sclass != "D" && $sclass != "B") $sclass = "N";
							if ($nation != "South Korea (Republic Of Korea)") $province = "";
							if ($kgsp != "Y") $kgsp = "N";
							if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
							else $dob = "0000-00-00";
							$flag = $student->insertStudent($pw, $kind, $current, $id, $fname, $mname, $lname, $prefer, $name_kr, $gender, $dob, $nation, $province, $kgsp, $home_uni, $home_addr, $home_addr1, $home_addr2, $home_city, $home_state, $home_postal, $home_country, $res_addr, $major, $sclass, $email, $phone, $cell, $case_nm, $case_rel, $case_ph, $case_addr, $admin);
							if ($flag) {
								if (is_uploaded_file($photo)) {
									$flag = move_uploaded_file($photo_tmp, $pht_dir."/".$student->studentNumber.".jpg");
									if ($flag) resizeImage($pht_width, $pht_height, $pht_dir."/".$student->studentNumber.".jpg", $pht_dir."/".$student->studentNumber.".jpg");
								}
							} else $mode = "error";
						}
					} else $mode = "over";
					break;
				case "edit":
					$photo_name = $HTTP_POST_FILES['photo']['name'];
					$photo_size = $HTTP_POST_FILES['photo']['size'];
					$photo_type = $HTTP_POST_FILES['photo']['type'];
					$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
					if ($photo_size <= $max_attach) {
						$email = htmlspecialchars(addslashes($_POST["email"]));
						if ($student->isEmailExist($email) && $no != $student->studentNumber) $mode = "email";
						else {
							$kind = $_POST["kind"];
							$current = $_POST["current"];
							$id = $_POST["id"];
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
							$nation = htmlspecialchars(addslashes($_POST["nation"]));
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
							$admin = htmlspecialchars(addslashes($_POST["admin"]));
							if ($kind != "S") $kind = "G";
							if ($current != "Y") $current = "N";
							if ($gender != "F") $gender = "M";
							if ($sclass != "M" && $sclass != "D" && $sclass != "B") $sclass = "N";
							if ($nation != "South Korea (Republic Of Korea)") $province = "";
							if ($kgsp != "Y") $kgsp = "N";
							if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
							else $dob = "0000-00-00";
							$flag = $student->updateStudent($no, $kind, $current, $id, $fname, $mname, $lname, $prefer, $name_kr, $gender, $dob, $nation, $province, $kgsp, $home_uni, $home_addr, $home_addr1, $home_addr2, $home_city, $home_state, $home_postal, $home_country, $res_addr, $major, $sclass, $email, $phone, $cell, $case_nm, $case_rel, $case_ph, $case_addr, $admin);
							if ($flag) {
								if (is_uploaded_file($photo)) {
									$flag = move_uploaded_file($photo_tmp, $pht_dir."/".$no.".jpg");
									if ($flag) resizeImage($pht_width, $pht_height, $pht_dir."/".$no.".jpg", $pht_dir."/".$no.".jpg");
								} else if ($no && $pht_del == "Y" && file_exists($pht_dir."/".$no.".jpg")) unlink($pht_dir."/".$no.".jpg");
							} else $mode = "error";
						}
					} else $mode = "over";
					break;
				case "del":
					$no = $_POST["no"];
					$arr_no = explode(",", $no);
					for ($i = 0; $i < count($arr_no); $i++) {
						if ($student->isApplicationExist($arr_no[$i])) $mode = "apply";
						else {
							$flag = $student->deleteStudent($arr_no[$i]);
							if ($flag) {
								if (file_exists($pht_dir."/".$arr_no[$i].".jpg")) unlink($pht_dir."/".$arr_no[$i].".jpg");
							} else $mode = "error";
						}
						if ($mode != "del") break;
					}
					break;
				case "pw":
					$pw = $_POST["pw"];
					$flag = $student->updatePassword($no, $pw);
					if (!$flag) $mode = "error";
					break;
			}

			$student->closeDatabase();
			unset($student);
			
			if ($mode == "error") {
				echo "<script language=\"javascript\">";
				echo "alert(\"작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "over") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"사진 파일 용량은 " . round($max_attach / 1024 / 1024, 0) . "M이하여야 합니다.\\n\\n확인 후 다시 시도해 주세요.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "email") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"" . $email . "은(는) 이미 등록되어 있는 이메일입니다.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "apply") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"해당 개인정보에 지원정보가 연결되어 있어 삭제할 수 없습니다.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "pw") {
				echo "<script language=\"javascript\">";
				echo "alert(\"비밀번호 변경이 정상적으로 처리 되었습니다.\");";
				echo "document.location.replace(\"../../src/graduate/stu_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_nation=$s_nation&s_current=$s_current&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else if ($mode == "edit") header("Location: stu_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_nation=$s_nation&s_current=$s_current&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else if ($mode == "del") header("Location: stu_list.php?page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_nation=$s_nation&s_current=$s_current&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else header("Location: stu_list.php");
		}
	}
?>