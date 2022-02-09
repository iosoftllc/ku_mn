<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		$board_mem_id = "SU";
		$mode = $_POST["mode"];
		if ($mode == "") $mode = $_GET["mode"];
		if ($mode == "spam" || $mode == "setting") {
			include_once("../../lib/class.cBoardType.php");
			$bt = new cBoardType($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $boardTypeTable, $spamTable);
			$bt->connectDatabase();
			switch ($mode) {
				case "spam":
					$reject_id = $_POST["reject_id"];
					$reject_ip= $_POST["reject_ip"];
					$reject_word = $_POST["reject_word"];
					$reject_id  = addslashes($reject_id );
					$reject_ip = addslashes($reject_ip);
					$reject_word = addslashes($reject_word);
					$reject_id  = htmlspecialchars($reject_id );
					$reject_ip = htmlspecialchars($reject_ip);
					$reject_word = htmlspecialchars($reject_word);
					$flag = $bt->updateRejectInfo($reject_id, $reject_ip, $reject_word);
					if (!$flag) $mode = "error";
					break;
				case "setting":
					$no = $_POST["no"];
					$list_no = $_POST["list_no"];
					$new_no = $_POST["new_no"];
					$hot_no = $_POST["hot_no"];
					$ip = $_POST["ip"];
					$time = $_POST["time"];
					$reply = $_POST["reply"];
					$comment = $_POST["comment"];
					$att_size = $_POST["att_size"];
					$attach = $_POST["attach"];
					$auth_list = $_POST["auth_list"];
					$auth_view = $_POST["auth_view"];
					$auth_post = $_POST["auth_post"];
					$notice_no = $_POST["notice_no"];
					if (!$att_size) $att_size = "0";
					$flag = $bt->updateSettingInfo($no, $list_no, $new_no, $hot_no, $ip, $time, $reply, $comment, $att_size, $attach, $auth_list, $auth_view, $auth_post, $notice_no);
					if (!$flag) $mode = "error";
					break;
			}
			$bt->closeDatabase();
			unset($bt);
		} else {
			include_once("../../lib/func.common.php");
			include_once("../common/board_tpl.php");
			$max_attach = 1024 * 1024 * (int)$param_size;
			$photo_dir = $webdir . "/upload/board";
			$thumbnail_dir = $webdir . "/upload/board/thumbnail";
			$photo_width = "800";
			$photo_height = "0";
			$thumbnail_width = "200";
			$thumbnail_height = "0";
			switch ($mode) {
				case "new":
				case "reply":
					if ($mode == "reply" && $param_reply != "Y") $mode = "no_reply";
					else {
						$top = $_POST["top"];
						if ($top == "Y" && (int)$param_notice <= (int)$board->getTopCount()) $mode = "top_over";
						else {
							$photo_name = $HTTP_POST_FILES['photo']['name'];
							$photo_type = $HTTP_POST_FILES['photo']['type'];
							$photo_size = $HTTP_POST_FILES['photo']['size'];
							$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
							if (is_uploaded_file($photo) && $param_attach != "Y") $mode = "no_attach";
							else {
								if ($photo_size <= $max_attach) {
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
									if ($mode == "new") $ref = $board->getBoardReference("", "");
									else if ($mode == "reply") {
										$top = "N";
										$level = $board->getBoardReference($ref, $level);
									}
									if ($ref == "") $ref = "0";
									if ($top == "") $top = "N";
									$flag = $board->insertBoard($board_mem_id, $ref, $level, $name, $email, $_SERVER["REMOTE_ADDR"], $html, $color, $top, $subject, $content);
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
								} else $mode = "over";
							}
						}
					}
					break;
				case "edit":
					$top = $_POST["top"];
					if ($top == "Y" && (int)$param_notice <= (int)$board->getTopCount()) $mode = "top_over";
					else {
						$photo_name = $HTTP_POST_FILES['photo']['name'];
						$photo_type = $HTTP_POST_FILES['photo']['type'];
						$photo_size = $HTTP_POST_FILES['photo']['size'];
						$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
						if (is_uploaded_file($photo) && $param_attach != "Y") $mode = "no_attach";
						else {
							if ($photo_size <= $max_attach) {
								$no = $_POST["no"];
								$ref = $_POST["ref"];
								$att_no = $_POST["att_no"];
								$att_del = $_POST["att_del"];
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
								if ($top == "") $top = "N";
								$flag = $board->updateBoard($no, $name, $email, $html, $color, $top, $subject, $content);
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
							} else $mode = "over";
						}
					}
					break;
				case "del":
					$no = $_POST["no"];
					$no = explode(",", $no);
					for ($i = 0; $i < count($no); $i++) {
						if ($param_reply == "N") {
							$flag = $board->deleteAllReference($no[$i]);
							if ($flag) {
								for ($j = 0; $j < count($board->listAttachNo); $j++) {
									if ($board->listAttachNo[$j] != "" && file_exists($photo_dir."/".$board->listAttachNo[$j].".jpg")) unlink($photo_dir."/".$board->listAttachNo[$j].".jpg");
									if ($board->listAttachNo[$j] != "" && file_exists($thumbnail_dir."/".$board->listAttachNo[$j].".jpg")) unlink($thumbnail_dir."/".$board->listAttachNo[$j].".jpg");
								}
							} else $mode = "error";
						} else {
							if ($board->hasRepliedBoard($no[$i])) $mode = "has";
							else {
								$flag = $board->deleteBoard($no[$i]);
								if ($flag) {
									for ($j = 0; $j < count($board->listAttachNo); $j++) {
										if ($board->listAttachNo[$j] != "" && file_exists($photo_dir."/".$board->listAttachNo[$j].".jpg")) unlink($photo_dir."/".$board->listAttachNo[$j].".jpg");
										if ($board->listAttachNo[$j] != "" && file_exists($thumbnail_dir."/".$board->listAttachNo[$j].".jpg")) unlink($thumbnail_dir."/".$board->listAttachNo[$j].".jpg");
									}
								} else $mode = "error";
							}
						}
						if ($mode != "del") break;
					}
					break;
				case "cmt_new":
					if ($param_comment != "Y") $mode = "no_cmt";
					else {
						$no = $_POST["no"];
						$br_ref = $_POST["br_ref"];
						$cmt_name = $_POST["cmt_name"];
						$cmt_name = addslashes($cmt_name);
						$cmt_name = htmlspecialchars($cmt_name);
						$comment = $_POST["comment"];
						$comment = addslashes($comment);
						$flag = $board->insertComment($board_mem_id, $no, $br_ref, $cmt_name, $_SERVER["REMOTE_ADDR"], $comment);
						if (!$flag) $mode = "error";
					}
					break;
				case "cmt_del":
					$no = $_POST["no"];
					$cmt_no = $_POST["cmt_no"];
					$flag = $board->deleteComment($cmt_no);
					if (!$flag) $mode = "error";
					break;
			}
			$board->closeDatabase();
			unset($board);
		}
	
		if ($mode == "error") {
			echo "<script language=\"javascript\">";
			echo "alert(\"작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else if ($mode == "spam") {
			echo "<script language=\"javascript\">";
			echo "alert(\"게시판 스팸정보를 성공적으로 설정하였습니다.\");";
			echo "document.location.href = \"../../src/board/spam.php\";";
			echo "</script>";
		} else if ($mode == "setting") {
			echo "<script language=\"javascript\">";
			echo "alert(\"게시판 정보를 성공적으로 설정하였습니다.\");";
			echo "document.location.href = \"../../src/board/setting.php?no=$no\";";
			echo "</script>";
		} else if ($mode == "over") {
			echo "<script langauage=\"javascript\">";
			echo "alert(\"사진 파일 용량은 " . round($max_attach / 1024 / 1024, 0) . "M이하여야 합니다.\\n\\n확인 후 다시 시도해 주세요.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else if ($mode == "has") {
			echo "<script langauage=javascript>";
			echo "alert(\"답글이 존재하여 삭제할 수 없습니다.\\n\\n확인 후 재시도 하십시오.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else if ($mode == "top_over") {
			echo "<script langauage=javascript>";
			echo "alert(\"공지글 개수가 설정을 초과 하였습니다.\\n\\n확인 후 재시도 하십시오.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else if ($mode == "no_reply") {
			echo "<script langauage=javascript>";
			echo "alert(\"답글이 허용되지 않는 게시판입니다.\\n\\n확인 후 재시도 하십시오.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else if ($mode == "no_attach") {
			echo "<script langauage=javascript>";
			echo "alert(\"사진 첨부가 허용되지 않는 게시판입니다.\\n\\n확인 후 재시도 하십시오.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else if ($mode == "no_cmt") {
			echo "<script langauage=javascript>";
			echo "alert(\"댓글이 허용되지 않는 게시판입니다.\\n\\n확인 후 재시도 하십시오.\");";
			echo "history.go(-1);";
			echo "</script>";
	  } else if ($mode == "edit" || $mode == "cmt_new" || $mode == "cmt_del") header("Location: view.php?type=$type&page=$page&s_type=$s_type&s_text=$s_text&no=$no");
	  else if ($mode == "del" || $mode == "reply") header("Location: list.php?type=$type&page=$page&s_type=$s_type&s_text=$s_text");
		else header("Location: list.php?type=$type");
	}
?>