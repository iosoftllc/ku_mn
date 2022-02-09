<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 3) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../../lib/class.cMailbox.php");

			$max_attach = 1024 * 1024 * 1;
			$img_dir = $webdir . "/upload/mail";

			$mode = $_POST["mode"];
			if ($mode == "") $mode = $_GET["mode"];
			$mailbox = new cMailbox($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $mailboxTable, $applicantTable);
			$mailbox->connectDatabase();
			switch ($mode) {
				case "mail":
					$attach_name = $HTTP_POST_FILES['attach']['name'];
					$attach_type = $HTTP_POST_FILES['attach']['type'];
					$attach_size = $HTTP_POST_FILES['attach']['size'];
					$attach_tmp = $HTTP_POST_FILES['attach']['tmp_name'];
					if ($attach_size <= $max_attach) {
						include_once("../../lib/class.rFastTemplate.php");
						include_once("../../lib/func.common.php");
						$mail_no = $_POST["mail_no"];
						$to = $_POST["to"];
						$subject = $_POST["subject"];
						$msg = $_POST["msg"];
						if ($attach_size == "") $attach_size = 0;
						$flag = $mailbox->insertMail($to, addslashes($subject), addslashes($msg), $attach_name, $attach_size, $attach_type);
						if ($flag) {
							$email = $_POST["email"];
							$img_tag = "";
							$img_no = $mailbox->mailNumber;
							if (is_uploaded_file($attach) && move_uploaded_file($attach_tmp, "$img_dir/$img_no.jpg")) {
								$img_size = getimagesize("$img_dir/$img_no.jpg");
								$img_width = $img_size[0];
								$img_height = $img_size[1];
								$img_tag = "<center><img src=\"http://$web_http_url/upload/mail/$img_no.jpg\" width=\"$img_width\" height=\"$img_height\"></center><br><br>";
							} else if (file_exists("$img_dir/$mail_no.jpg")) {
								copy("$img_dir/$mail_no.jpg", "$img_dir/$img_no.jpg");
								$mailbox->copyAttachInfo($mail_no, $img_no);
								$img_size = getimagesize("$img_dir/$img_no.jpg");
								$img_width = $img_size[0];
								$img_height = $img_size[1];
								$img_tag = "<center><img src=\"http://$web_http_url/upload/mail/$img_no.jpg\" width=\"$img_width\" height=\"$img_height\"></center><br><br>";
							}
							$msg = $img_tag . getContents($msg, "N");
							$msg .= "<br><br>Korea University<br>Anam Residence Life<br>International Residence<br>Anam-dong Seongbuk-gu<br>Seoul 136 701 Korea<br>Email: reslife@korea.ac.kr<br>Fax: 82-2-926-3464<br>Web: http://reslife.korea.ac.kr";
							$from = $ihouse_admin_info[name] . "<" . $ihouse_admin_info[email] . ">";
							if ($email == "grad_mem") {
								include_once("../common/grad_student_tpl.php");
								$student->getStudentList($sdate, $edate, "", "", $s_type, $s_text, $s_kind, $s_current, "");
								for ($i = 0; $i < count($student->stuListEmail); $i++) {
									if ($student->stuListEmail[$i]) {
										$flag = sendEmail($student->stuListEmail[$i], $from, $subject, $msg);
										if (!$flag) {
											$mode = "error";
											break;
										}
									}
								}
								unset($student);
							} else if ($email == "grad_app") {
								include_once("../common/grad_application_tpl.php");
								$application->getApplicationList($sdate, $edate, "", "", $s_type, $s_text, $s_rate, $s_state, $s_grade, $s_kind, $s_current, $s_period, "");
								for ($i = 0; $i < count($application->listEmail); $i++) {
									if ($application->listEmail[$i]) {
										$flag = sendEmail($application->listEmail[$i], $from, $subject, $msg);
										if (!$flag) {
											$mode = "error";
											break;
										}
									}
								}
								unset($application);
							} else if ($email == "mem") {
								include_once("../common/student_tpl.php");
								$student->getStudentList($sdate, $edate, "", "", $s_type, $s_text, $s_kind, $s_current, "");
								for ($i = 0; $i < count($student->stuListEmail); $i++) {
									if ($student->stuListEmail[$i]) {
										$flag = sendEmail($student->stuListEmail[$i], $from, $subject, $msg);
										if (!$flag) {
											$mode = "error";
											break;
										}
									}
								}
								unset($student);
							} else if ($email == "app") {
								include_once("../common/application_tpl.php");
								$application->getApplicationList($sdate, $edate, "", "", $s_type, $s_text, $s_rate, $s_state, $s_grade, $s_kind, $s_current, $s_period, "");
								for ($i = 0; $i < count($application->listEmail); $i++) {
									if ($application->listEmail[$i]) {
										$flag = sendEmail($application->listEmail[$i], $from, $subject, $msg);
										if (!$flag) {
											$mode = "error";
											break;
										}
									}
								}
								unset($application);
							} else if ($email == "defer") {
								include_once("../common/defer_tpl.php");
								$defer->getDeferList($sdate, $edate, "", "", $s_type, $s_text, $s_approve, $s_period, "");
								for ($i = 0; $i < count($defer->deferListEmail); $i++) {
									if ($defer->deferListEmail[$i]) {
										$flag = sendEmail($defer->deferListEmail[$i], $from, $subject, $msg);
										if (!$flag) {
											$mode = "error";
											break;
										}
									}
								}
								unset($defer);
							} else if ($email == "stu" || $email == "lan") {
								include_once("../common/apply_tpl.php");
								$applicant->getApplicantList($sdate, $edate, "", "", $s_type, $s_text, $s_state, $s_kind, $s_current, $s_period, "");
								for ($i = 0; $i < count($applicant->listEmail); $i++) {
									if ($applicant->listEmail[$i]) {
										$flag = sendEmail($applicant->listEmail[$i], $from, $subject, $msg);
										if (!$flag) {
											$mode = "error";
											break;
										}
									}
								}
								unset($applicant);
							} else if ($email == "fac") {
								include_once("../common/faculty_tpl.php");
								$faculty->getFacultyList("", "", $s_dorm, $sdate, $edate, $s_type, $s_text, $s_term, $s_state, $s_rate, $s_room, "");
								for ($i = 0; $i < count($faculty->facListEmail); $i++) {
									if ($faculty->facListEmail[$i]) {
										$flag = sendEmail($faculty->facListEmail[$i], $from, $subject, $msg);
										if (!$flag) {
											$mode = "error";
											break;
										}
									}
								}
								unset($faculty);
							} else if ($email == "hall") {
								include_once("../common/facility_tpl.php");
								$facility->getFacilityList("", "", $s_room, $s_state, $sdate, $edate, $s_type, $s_text, "");
								for ($i = 0; $i < count($facility->facListEmail); $i++) {
									if ($facility->facListEmail[$i]) {
										$flag = sendEmail($facility->facListEmail[$i], $from, $subject, $msg);
										if (!$flag) {
											$mode = "error";
											break;
										}
									}
								}
								unset($facility);
							} else {
								$to = explode(";", $to);
								for ($i = 0; $i < count($to); $i++) {
									$flag = sendEmail($to[$i], $from, $subject, $msg);
									if (!$flag) {
										$mode = "error";
										break;
									}
								}
							}
							if ($mode == "error") $flag = $mailbox->deleteMail($mailbox->mailNumber);
						} else $mode = "error";
					} else $mode = "over";
					break;
				case "del":
					$no = $_POST["no"];
					$arr_no = explode(",", $no);
					for ($i = 0; $i < count($arr_no); $i++) {
						$flag = $mailbox->deleteMail($arr_no[$i]);
						if ($flag) {
							if (file_exists($img_dir."/".$arr_no[$i].".jpg")) unlink($img_dir."/".$arr_no[$i].".jpg");
						} else {
							$mode = "error";
							break;
						}
					}
					break;
			}
			$mailbox->closeDatabase();
			unset($mailbox);
		
			if ($mode == "error") {
				echo "<script language=\"javascript\">";
				echo "alert(\"작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "over") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"이미지 파일 용량은 " . round($max_attach / 1024 / 1024, 0) . "M이하여야 합니다.\\n\\n확인 후 다시 시도해 주세요.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "mail") {
				echo "<script language=\"javascript\">";
				echo "alert(\"공지메일을 성공적으로 발송하였습니다.\");";
				echo "document.location.replace(\"mailbox.php\");";
				echo "</script>";
			} else if ($mode == "del") header("Location: mailbox.php?page=$page&s_type=$s_type&s_text=$s_text&sort1=$sort1&sort2=$sort2");
			else header("Location: mailbox.php");
		}
	}
?>