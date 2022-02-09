<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/student_tpl.php");
			
			switch ($mode) {
				case "new":
					$photo_name = $HTTP_POST_FILES['photo']['name'];
					$photo_size = $HTTP_POST_FILES['photo']['size'];
					$photo_type = $HTTP_POST_FILES['photo']['type'];
					$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
					if ($photo_size <= $max_attach) {
						$email = $_POST["email"];
						$email = addslashes($email);
						$email = htmlspecialchars($email);
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
							$nation = $_POST["nation"];
							$nation = addslashes($nation);
							$nation = htmlspecialchars($nation);
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
							$admin = $_POST["admin"];
							$admin = addslashes($admin);
							$admin = htmlspecialchars($admin);
							if ($kind != "L") $kind = "U";
							if ($current != "Y") $current = "N";
							if ($gender != "F") $gender = "M";
							if ($sclass != "F" && $sclass != "P" && $sclass != "J" && $sclass != "S" && $sclass != "M" && $sclass != "D") $sclass = "N";
							if ($kgsp != "Y") $kgsp = "N";
							if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
							else $dob = "0000-00-00";
							$flag = $student->insertStudent($pw, $kind, $current, $id, $fname, $mname, $lname, $prefer, $name_kr, $gender, $dob, $nation, $home_uni, $home_addr, $home_addr1, $home_addr2, $home_city, $home_state, $home_postal, $home_country, $res_addr, $major, $sclass, $kgsp, $email, $phone, $cell, $case_nm, $case_rel, $case_ph, $case_addr, $admin);
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
						$email = $_POST["email"];
						$email = addslashes($email);
						$email = htmlspecialchars($email);
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
							$nation = $_POST["nation"];
							$nation = addslashes($nation);
							$nation = htmlspecialchars($nation);
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
							$admin = $_POST["admin"];
							$admin = addslashes($admin);
							$admin = htmlspecialchars($admin);
							if ($kind != "L") $kind = "U";
							if ($current != "Y") $current = "N";
							if ($gender != "F") $gender = "M";
							if ($sclass != "F" && $sclass != "P" && $sclass != "J" && $sclass != "S" && $sclass != "M" && $sclass != "D") $sclass = "N";
							if ($kgsp != "Y") $kgsp = "N";
							if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
							else $dob = "0000-00-00";
							$flag = $student->updateStudent($no, $kind, $current, $id, $fname, $mname, $lname, $prefer, $name_kr, $gender, $dob, $nation, $home_uni, $home_addr, $home_addr1, $home_addr2, $home_city, $home_state, $home_postal, $home_country, $res_addr, $major, $sclass, $kgsp, $email, $phone, $cell, $case_nm, $case_rel, $case_ph, $case_addr, $admin);
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
				case "upload";
					$attach_name = $HTTP_POST_FILES['attach']['name'];
					$attach_type = $HTTP_POST_FILES['attach']['type'];
					$attach_size = $HTTP_POST_FILES['attach']['size'];
					$attach_tmp = $HTTP_POST_FILES['attach']['tmp_name'];
					if (is_uploaded_file($attach)) {
						$row = 0;
						$insert = 0;
						$update = 0;
						$fp = fopen ("$attach_tmp", "r");
						while ($data = fgetcsv($fp, 1000, ",")) {
							if (!$row) {
								$row++;
								continue;
							}
							$row++;
							$kind = trim(addslashes($data[0])); // �л����� (D:���к�, L:���к�)
							$current = trim(addslashes($data[1])); // �� I House �л� ����
							$id = trim(addslashes($data[2])); // �л����̵��ȣ
							$fname = trim(addslashes($data[3])); // �����ڿ����̸�
							$mname = trim(addslashes($data[4])); // �����ڿ����̸�
							$lname = trim(addslashes($data[5])); // �����ڿ����̸�
							$prefer = trim(addslashes($data[6])); // �����ھ�Ī
							$name_kr = trim(addslashes($data[7])); // �������ѱ��̸�
							$gender = trim(addslashes($data[8])); // ȸ������ (M:����, F:����)
							$dob = trim(addslashes($data[9])); // �������
							$nation = trim(addslashes($data[10])); // ����
							$home_uni = trim(addslashes($data[11])); // ��
							$home_addr = trim(addslashes($data[12])); // �����ּ�
							$home_addr1 = trim(addslashes($data[13])); // �����ּ�
							$home_addr2 = trim(addslashes($data[14])); // �����ּ�
							$home_city = trim(addslashes($data[15])); // �����ּ�
							$home_state = trim(addslashes($data[16])); // �����ּ�
							$home_postal = trim(addslashes($data[17])); // �����ּ�
							$home_country = trim(addslashes($data[18])); // �����ּ�
							$res_addr = trim(addslashes($data[19])); // �����ּ�
							$major = trim(addslashes($data[20])); // �а�
							$sclass = trim(addslashes($data[21])); // �г� (P:sophomore, J:junior, S:senior, M:master, D:doctor, N:None)
							$kgsp = trim(addslashes($data[22])); // KGSP or N/A
							$email = trim(addslashes($data[23])); // �̸���
							$phone = trim(addslashes($data[24])); // ��ȭ��ȣ
							$cell = trim(addslashes($data[25])); // �ڵ�����ȣ
							$case_nm = trim(addslashes($data[26])); // ��޿���ó �̸�
							$case_rel = trim(addslashes($data[27])); // ��޿���ó ����
							$case_ph = trim(addslashes($data[28])); // ��޿���ó ��ȭ��ȣ
							$case_addr = trim(addslashes($data[29])); // ��޿���ó �ּ�
							$account = trim(addslashes($data[30])); // �������
							$admin = trim(addslashes($data[31])); // �����ڳ�Ʈ
							if ($kind != "L") $kind = "U";
							if ($current != "N") $current = "Y";
							if ($gender != "F") $gender = "M";
							if ($sclass != "F" && $sclass != "P" && $sclass != "J" && $sclass != "S" && $sclass != "M" && $sclass != "D") $sclass = "N";
							if ($kgsp != "N") $kgsp = "Y";
							if ($student->isEmailExist($email)) {
								echo "$fname $email <br>";
								//$flag = $student->updateStudent($student->studentNumber, $kind, $current, $id, $fname, $mname, $lname, $prefer, $name_kr, $gender, $dob, $nation, $home_uni, $home_addr, $home_addr1, $home_addr2, $home_city, $home_state, $home_postal, $home_country, $res_addr, $major, $sclass, $kgsp, $email, $phone, $cell, $case_nm, $case_rel, $case_ph, $case_addr, $admin);
								if ($flag) $update++;
							} else {
								$flag = $student->insertStudent($id, $kind, $current, $id, $fname, $mname, $lname, $prefer, $name_kr, $gender, $dob, $nation, $home_uni, $home_addr, $home_addr1, $home_addr2, $home_city, $home_state, $home_postal, $home_country, $res_addr, $major, $sclass, $kgsp, $email, $phone, $cell, $case_nm, $case_rel, $case_ph, $case_addr, $admin);
								if ($flag) $insert++;
							}
						}
						fclose ($fp);
					} else $mode = "no_attach";
					break;
			}

			$student->closeDatabase();
			unset($student);
			
			if ($mode == "error") {
				echo "<script language=\"javascript\">";
				echo "alert(\"�۾����� �� ������ �߻��Ͽ����ϴ�.\\n\\n���߿� �ٽ� �õ��� �ּ���.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "over") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"���� ���� �뷮�� " . round($max_attach / 1024 / 1024, 0) . "M���Ͽ��� �մϴ�.\\n\\nȮ�� �� �ٽ� �õ��� �ּ���.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "email") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"" . $email . "��(��) �̹� ��ϵǾ� �ִ� �̸����Դϴ�.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "apply") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"�ش� ���������� ���������� ����Ǿ� �־� ������ �� �����ϴ�.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "pw") {
				echo "<script language=\"javascript\">";
				echo "alert(\"��й�ȣ ������ ���������� ó�� �Ǿ����ϴ�.\");";
				echo "document.location.replace(\"../../src/apply/stu_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_current=$s_current&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else if ($mode == "upload") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"�� " . ($row - 1) . "�� �� " . $insert . "���� �߰��ϰ� " . $update . "���� ���������� " . ($row - 1 - $insert - $update) . "���� �����߽��ϴ�.\");";
				echo "document.location.replace('stu_list.php');";
				echo "</script>";
			} else if ($mode == "edit") header("Location: stu_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_current=$s_current&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else if ($mode == "del") header("Location: stu_list.php?page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_current=$s_current&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else header("Location: stu_list.php");
		}
	}
?>