<?
	include_once("../../lib/conf.common.php");
	include_once("../../lib/func.common.php");
	include_once("../../lib/spam.common.php");
	include_once("../common/board_tpl.php");

	$mode = $_POST["mode"];
	$page = $_POST["page"];
	$s_type = $_POST["s_type"];
	$s_text = $_POST["s_text"];
	if ($mode == "") $mode = $_GET["mode"];
	if ($page == "") $page = $_GET["page"];
	if ($s_type == "") $s_type = $_GET["s_type"];
	if ($s_text == "") $s_text = $_GET["s_text"];

	$max_attach = 1024 * 1024 * (int)$param_size;
	$photo_dir = $rootdir . "/upload/board";
	$thumbnail_dir = $rootdir . "/upload/board/thumbnail";
	$photo_width = "800";
	$photo_height = "0";
	$thumbnail_width = "200";
	$thumbnail_height = "0";

	switch ($mode) {
		case "new":
		case "reply":
			if ($param_auth_post == "N") $mode = "no_auth";
			else if ($param_auth_post == "M" && !$log_flag) $mode = "no_auth";
			else if ($mode == "reply" && $param_reply != "Y") $mode = "no_reply";
			else {
				$photo_name = $HTTP_POST_FILES['photo']['name'];
				$photo_type = $HTTP_POST_FILES['photo']['type'];
				$photo_size = $HTTP_POST_FILES['photo']['size'];
				$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
				if (is_uploaded_file($photo) && $param_attach != "Y") $mode = "no_attach";
				else if ($photo_size <= $max_attach) {
					$pw = $_POST["pw"];
					$ref = $_POST["ref"];
					$level = $_POST["level"];
					$color = $_POST["color"];
					$html = $_POST["html"];
					$name = $_POST["name"];
					$name = addslashes($name);
					$name = htmlspecialchars($name);
					$email = $_POST["email"];
					$email = addslashes($email);
					$subject = $_POST["subject"];
					$subject = addslashes($subject);
					$subject = htmlspecialchars($subject);
					$content = $_POST["content"];
					$content = addslashes($content);
					$ip = $_SERVER["REMOTE_ADDR"];
					if (isRejectedID($reject_id, $name)) $mode = "reject_id";
					else if (isRejectedIP($reject_ip, $ip)) $mode = "reject_ip";
					else if (isRejectedWord($reject_word, $subject)) $mode = "reject_word";
					else if (isRejectedWord($reject_word, $content)) $mode = "reject_word";
					else {
						if ($mode == "new") $ref = $board->getBoardReference("", "");
						else if ($mode == "reply") $level = $board->getBoardReference($ref, $level);
						if ($ref == "") $ref = "0";
						$flag = $board->insertBoard("", $pw, $ref, $level, $name, $email, $ip, $html, $color, $subject, $content);
						if ($flag) {
							if (is_uploaded_file($photo)) {
								if ($photo_size == "") $photo_size = 0;
								$flag = $board->insertAttach($board->boardNo, $ref, $photo_name, $photo_size, $photo_type);
								if ($flag) {
									$flag = move_uploaded_file($photo_tmp, $photo_dir."/".$board->attachNumber.".jpg");
									if ($flag) {
										resizeImage($photo_width, $photo_height, $photo_dir."/".$board->attachNumber.".jpg", $photo_dir."/".$board->attachNumber.".jpg");
										resizeImage($thumbnail_width, $thumbnail_height, $thumbnail_dir."/".$board->attachNumber.".jpg", $photo_dir."/".$board->attachNumber.".jpg");
										if (!file_exists($thumbnail_dir."/".$board->attachNumber.".jpg")) copy($photo_dir."/".$board->attachNumber.".jpg", $thumbnail_dir."/".$board->attachNumber.".jpg");
									}
								}
							}
							if (!$flag) {
								$flag = $board->deleteBoard($board->boardNo);
								if ($flag) {
									for ($i = 0; $i < count($board->listAttachNo); $i++) {
										if ($board->listAttachNo[$i] != "" && file_exists($photo_dir."/".$board->listAttachNo[$i].".jpg")) unlink($photo_dir."/".$board->listAttachNo[$i].".jpg");
										if ($board->listAttachNo[$i] != "" && file_exists($thumbnail_dir."/".$board->listAttachNo[$i].".jpg")) unlink($thumbnail_dir."/".$board->listAttachNo[$i].".jpg");
									}
								}
								$mode = "error";
							}
						} else $mode = "error";
					}
				} else $mode = "over";
			}
			break;
		case "edit":
			if ($param_auth_post == "N") $mode = "no_auth";
			else if ($param_auth_post == "M" && !$log_flag) $mode = "no_auth";
			else {
				$no = $_POST["no"];
				$pw = $_POST["pw"];
				if ($board->checkPassword($no, $pw)) {
					$photo_name = $HTTP_POST_FILES['photo']['name'];
					$photo_type = $HTTP_POST_FILES['photo']['type'];
					$photo_size = $HTTP_POST_FILES['photo']['size'];
					$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
					if (is_uploaded_file($photo) && $param_attach != "Y") $mode = "no_attach";
					else if ($photo_size <= $max_attach) {
						$att_no = $_POST["att_no"];
						$color = $_POST["color"];
						$html = $_POST["html"];
						$att_del = $_POST["att_del"];
						$name = $_POST["name"];
						$name = addslashes($name);
						$name = htmlspecialchars($name);
						$email = $_POST["email"];
						$email = addslashes($email);
						$subject = $_POST["subject"];
						$subject = addslashes($subject);
						$subject = htmlspecialchars($subject);
						$content = $_POST["content"];
						$content = addslashes($content);
						$ip = $_SERVER["REMOTE_ADDR"];
						if (isRejectedID($reject_id, $name)) $mode = "reject_id";
						else if (isRejectedIP($reject_ip, $ip)) $mode = "reject_ip";
						else if (isRejectedWord($reject_word, $subject)) $mode = "reject_word";
						else if (isRejectedWord($reject_word, $content)) $mode = "reject_word";
						else {
							$flag = $board->updateBoard($no, $name, $email, $html, $color, $subject, $content);
							if ($flag) {
								if (is_uploaded_file($photo)) {
									if ($photo_size == "") $photo_size = 0;
									if ($att_no) $flag = $board->updateAttach($att_no, $photo_name, $photo_size, $photo_type);
									else {
										$flag = $board->insertAttach($no, $ref, $photo_name, $photo_size, $photo_type);
										$att_no = $board->attachNumber;
									}
									if ($flag) {
										$flag = move_uploaded_file($photo_tmp, $photo_dir."/".$att_no.".jpg");
										if ($flag) {
											if (file_exists($thumbnail_dir."/".$att_no.".jpg")) unlink($thumbnail_dir."/".$att_no.".jpg");
											resizeImage($photo_width, $photo_height, $photo_dir."/".$att_no.".jpg", $photo_dir."/".$att_no.".jpg");
											resizeImage($thumbnail_width, $thumbnail_height, $thumbnail_dir."/".$att_no.".jpg", $photo_dir."/".$att_no.".jpg");
											if (!file_exists($thumbnail_dir."/".$att_no.".jpg")) copy($photo_dir."/".$att_no.".jpg", $thumbnail_dir."/".$att_no.".jpg");
										}
									}
								} else if ($att_no && $att_del == "Y") {
									$flag = $board->deleteAttach($att_no);
									if ($flag) {
										if (file_exists($photo_dir."/".$att_no.".jpg")) unlink($photo_dir."/".$att_no.".jpg");
										if (file_exists($thumbnail_dir."/".$att_no.".jpg")) unlink($thumbnail_dir."/".$att_no.".jpg");
									}
								}
								if (!$flag) $mode = "error";
							} else $mode = "error";
						}
					} else $mode = "over";
				} else $mode = "no_pw";
			}
			break;
		case "del":
			if ($param_auth_post == "N") $mode = "no_auth";
			else if ($param_auth_post == "M" && !$log_flag) $mode = "no_auth";
			else {
				$no = $_POST["no"];
				$pw = $_POST["pw"];
				if ($board->checkPassword($no, $pw)) {
					if ($param_reply == "N") {
						$flag = $board->deleteAllReference($no);
						if ($flag) {
							for ($j = 0; $j < count($board->listAttachNo); $j++) {
								if ($board->listAttachNo[$j] != "" && file_exists($photo_dir."/".$board->listAttachNo[$j])) unlink($photo_dir."/".$board->listAttachNo[$j]);
								if ($board->listAttachNo[$j] != "" && file_exists($thumbnail_dir."/".$board->listAttachNo[$j])) unlink($thumbnail_dir."/".$board->listAttachNo[$j]);
							}
						} else $mode = "error";
					} else {
						if ($board->hasRepliedBoard($no)) $mode = "has";
						else {
							$flag = $board->deleteBoard($no);
							if ($flag) {
								for ($j = 0; $j < count($board->listAttachNo); $j++) {
									if ($board->listAttachNo[$j] != "" && file_exists($photo_dir."/".$board->listAttachNo[$j].".jpg")) unlink($photo_dir."/".$board->listAttachNo[$j].".jpg");
									if ($board->listAttachNo[$j] != "" && file_exists($thumbnail_dir."/".$board->listAttachNo[$j].".jpg")) unlink($thumbnail_dir."/".$board->listAttachNo[$j].".jpg");
								}
							} else $mode = "error";
						}
					}
				} else $mode = "no_pw";
			}
			break;
		case "cmt_new":
			if ($param_comment != "Y") $mode = "no_cmt";
			else {
				$no = $_POST["no"];
				$br_ref = $_POST["br_ref"];
				$cmt_pw = $_POST["cmt_pw"];
				$name = $_POST["cmt_name"];
				$comment = $_POST["comment"];
				if ($no == "") $no = $_GET["no"];
				if ($br_ref == "") $br_ref = $_GET["br_ref"];
				if ($cmt_pw == "") $cmt_pw = $_GET["cmt_pw"];
				if ($name == "") $name = $_GET["cmt_name"];
				if ($comment == "") $comment = $_GET["comment"];
				$name = addslashes($name);
				$name = htmlspecialchars($name);
				$comment = addslashes($comment);
				$ip = $_SERVER["REMOTE_ADDR"];
				if (isRejectedID($reject_id, $name)) $mode = "reject_id";
				else if (isRejectedIP($reject_ip, $ip)) $mode = "reject_ip";
				else if (isRejectedWord($reject_word, $comment)) $mode = "reject_word";
				else {
					$flag = $board->insertComment("", $no, $br_ref, $cmt_pw, $name, $ip, $comment);
					if (!$flag) $mode = "error";
				}
			}
			break;
		case "cmt_del":
			if ($param_comment != "Y") $mode = "no_cmt";
			else {
				$no = $_POST["no"];
				$cmt_no = $_POST["cmt_no"];
				$pw = $_POST["pw"];
				if ($board->checkCommentPassword($cmt_no, $pw)) {
					$flag = $board->deleteComment($cmt_no);
					if (!$flag) $mode = "error";
				} else $mode = "no_pw";
			}
			break;
	}
	$board->closeDatabase();
	unset($board);

	if ($mode == "error") {
		echo "<script language=\"javascript\">";
		echo "alert(\"Unexpected error is occured.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "reject_id") {
		echo "<script langauage=javascript>";
		echo "alert(\"" . $name . " is rejected ID or name.\\n\\nPlease try again.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "reject_ip") {
		echo "<script langauage=javascript>";
		echo "alert(\"" . $ip . " is rejected IP address.\\n\\nPlease try again.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "reject_word") {
		echo "<script langauage=javascript>";
		echo "alert(\"There is a rejected word.\\n\\nPlease try again.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "over") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The maximum size of a file is " . round($max_attach / 1024 / 1024, 0) . "MB.\\n\\nPlease try again.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "has") {
		echo "<script langauage=javascript>";
		echo "alert(\"Cannot delete due to a replied board.\\n\\nPlease try again.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "no_auth") {
		echo "<script langauage=javascript>";
		echo "alert(\"You do not have an authority.\\n\\nPlease try again.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "no_reply") {
		echo "<script langauage=javascript>";
		echo "alert(\"This board does not allow reply.\\n\\nPlease try again.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "no_cmt") {
		echo "<script langauage=javascript>";
		echo "alert(\"This board does not allow comment.\\n\\nPlease try again.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "no_attach") {
		echo "<script langauage=javascript>";
		echo "alert(\"This board does not allow attachment.\\n\\nPlease try again.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "no_pw") {
		echo "<script langauage=javascript>";
		echo "alert(\"A password is invalid.\\n\\nPlease try again.\");";
		echo "history.go(-1);";
		echo "</script>";
  } else if ($mode == "edit" || $mode == "cmt_new" || $mode == "cmt_del") header("Location: view.php?type=$type&page=$page&s_type=$s_type&s_text=$s_text&no=$no");
  else if ($mode == "del" || $mode == "reply") header("Location: list.php?type=$type&page=$page&s_type=$s_type&s_text=$s_text");
	else header("Location: list.php?type=$type");
?>