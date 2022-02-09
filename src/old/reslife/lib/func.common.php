<?
	//include_once("func.date.php");

	function getRequestVariable($name, $search=false) {
		$returnValue = trim($_GET[$name]);
		if ($returnValue == "") $returnValue = trim($_POST[$name]);
		$returnValue = htmlspecialchars($returnValue);
		if ($search) $returnValue = stripslashes($returnValue);
		return $returnValue;
	}

	function is_leaf_year($year) {
		if ($year % 400 == 0) return true;
		else if ($year % 100 == 0) return false;
		else if ($year % 4 == 0) return true;
		else return false;
	}

	function get_days($mon, $year) {
		$_month_table_normal = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		$_month_table_leaf = array(0, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		$_total_date = 0;
		for ($i = 1900; $i <= $year; $i++) {
			if(is_leaf_year($i)) {
				$loop_table = $_month_table_leaf;
				$_add_date = 366;
			} else {
				$loop_table = $_month_table_normal;
				$_add_date = 365;
			}
			if ($i < $year) $_total_date += $_add_date;
			else {
				for ($j = 1; $j < $mon; $j++) {
					$_total_date += $loop_table[$j];
				}
			}
		}
		return $_total_date;
	}

	function new_mktime($hour, $min, $sec, $mon, $day, $year) {
		$hour = intval($hour);
		$min = intval($min);
		$sec = intval($sec);
		$mon = intval($mon);
		$day = intval($day);
		$year = intval($year);
	
		$gmt_different = mktime() - gmmktime();
		$_day_power = 86400;
		$_hour_power = 3600;
		$_min_power = 60;
	
		if ($sec < 0) {
			$sec = abs($sec);
			if ($sec % 60) {
				$s1 = intval($sec / 60) + 1;
				$min -= $s1;
				$sec = 60 - ($sec % 60);
			} else {
				$s1 = intval($sec / 60);
				$min -= $s1;
				$sec = 0;
			}
		} else if ($sec > 0) {
			$s1 = intval($sec / 60);
			$min += $s1;
			$sec = $sec % 60;
		} else $sec = 0;
		if ($min < 0) {
			$min = abs($min);
			if ($min % 60) {
				$m1 = intval($min / 60) + 1;
				$hour -= $s1;
				$min = 60 - ($min % 60);
			} else {
				$m1 = intval($min / 60);
				$hour -= $m1;
				$min = 0;
			}
		} else if ($min > 0) {
			$m1 = intval($min / 60);
			$hour += $m1;
			$min = $min % 60;
		} else $min = 0;
		if ($hour < 0) {
			$hour = abs($hour);
			if ($hour % 24) {
				$h1 = intval($hour / 24) + 1;
				$day -= $h1;
				$hour = 24 - ($hour % 24);
			} else {
				$h1 = intval($hour / 24);
				$day -= $h1;
				$hour = 0;
			}
		} else if ($hour > 0) {
			$h1 = intval($hour / 24);
			$day += $h1;
			$hour = $hour % 24;
		} else $hour = 0;
		$day--;
		if ($mon <= 0) {
			$mon = abs($mon);
			if ($mon == 0) {
				$year--;
				$mon = 12;
			} else {
				$mn1 = intval($mon / 12) + 1;
				$year -= $mn1;
				$mon = 12 - ($mon % 12);
			}
		}
		if ($mon > 0) {
			$mn1 = intval(($mon - 1) / 12);
			$year += $mn1;
			$mon = (($mon - 1) % 12) + 1;
		}
		if ($year < 1900) return false;
	
		$_days = (get_days($mon, $year) - 25567) + $day;
		$_timestamp = ($_days * $_day_power) + ($hour * $_hour_power) + ($min * $_min_power) + $sec + $gmt_different;
		if ($_timestamp > 2147483647 || $_timestamp < -2147483647) return false;

		if($_timestamp >= -2147483647 && $_timestamp <= -2053933200) $_timestamp += 1800; 
		if($_timestamp >= -1325496600 && $_timestamp <= -1199264401) $_timestamp += 1800; 
		if($_timestamp >= -498132000 && $_timestamp <= -264934801) $_timestamp += 3600; 
		if($_timestamp >= -264933000 && $_timestamp <= -39517201) $_timestamp += 1800; 
		if($_timestamp >= 547574400 && $_timestamp <= 592325999) $_timestamp -= 3600;

		return $_timestamp;
	}

	function dateDiff($dateTimeBegin, $dateTimeEnd) {
		$time = (strtotime($dateTimeEnd) - strtotime($dateTimeBegin)) / 86400;
		return $time;
	}

	function getUploadImage($dir) {
		$returnValue = "";
		if (file_exists("$dir")) $returnValue = "현재 등록된 이미지가 있습니다. <a href=\"javascript:previewImage('$dir');\">[이미지보기]</a>";
		return $returnValue;
	}

	function getListImage($dir) {
		$returnValue = "";
		if (file_exists("$dir")) {
			$img_size = getimagesize("../../images/main/icon_img.jpg");
			$img_width = $img_size[0];
			$img_height = $img_size[1];
			$returnValue = "<a href=\"javascript:previewImage('$dir')\"><img src=\"../../images/main/icon_img.jpg\" width=\"$img_width\" height=\"$img_height\" border=\"0\"></a>";
		}
		return $returnValue;
	}

	function getOriginalImage($dir) {
		$returnValue = "";
		if (file_exists("$dir")) {
			$img_size = getimagesize("$dir");
			$img_width = $img_size[0];
			$img_height = $img_size[1];
			$returnValue = "<img src='$dir?tmp=" . md5(time()) . "' width='$img_width' height='$img_height' border='0'>";
		}
		return $returnValue;
	}

	function getMemberGrade($grade) {
		$returnValue = "";
		if ($grade == "9") $returnValue = "슈퍼관리자";
		else if ($grade == "8") $returnValue = "학생동관리자";
		else if ($grade == "7") $returnValue = "교수동관리자";
		else if ($grade == "3") $returnValue = "유지보수관리자";
		else if ($grade == "2") $returnValue = "사감장";
		else if ($grade == "1") $returnValue = "부장";
		else if ($grade == "0") $returnValue = "과장";
		return $returnValue;
	}

	function getAddressValue($line1, $line2, $line3, $city, $state, $country, $postal) {
		$returnValue = $line1;
		if ($line2) $returnValue .= ", " . $line2;
		if ($line3) $returnValue .= ", " . $line3;
		if ($city) $returnValue .= ", " . $city;
		if ($state) $returnValue .= ", " . $state;
		if ($country) $returnValue .= ", " . $country;
		if ($postal) $returnValue .= " [" . $postal . "]";
		return stripslashes($returnValue);
	}

	function getContents($str, $html) {
		if ($html == "N") {
			$str = stripslashes($str);
			$str = htmlspecialchars($str);
			$str = nl2br($str);
		} else if ($html == "M") {
			$str = stripslashes($str);
			$str = nl2br($str);
		}
		return $str;
	}
	
	function getMessage($nm, $dt, $sub, $cont) {
		$msg = "\n\n\n";
		$msg .= "--------------- Original Message ---------------\n";
		$msg .= "Writer: " . $nm . "\n";
		$msg .= "Date: " . $dt . "\n";
		$msg .= "Subject: " . $sub . "\n";
		$msg .= "\n";
		$msg .= $cont;
		return $msg;
	}
	
	function getReplyTo($name, $email) {
		if ($email != "") $str = $name . "<" . $email . ">";
		return $str;
	}
	
	function getTotalPage($count, $list) {
		$num = (int)($count / $list);
		if (($num * $list) != $count) $num++;
		return $num;
	}
	
	function getCurrentPage($pg, $total) {
		if ($pg == "0" || $pg  == "") $pg = 1;
		if ($total < $pg) $pg = $total;
		return $pg;
	}
	
	function getNextPage($pg) {
		if (substr($pg, strlen($pg)-1, 1) == "0") $num = (int)substr($pg, 0, strlen($pg)-1);
		else $num = (int)substr($pg, 0, strlen($pg)-1) + 1;
		$num .= "1";
		return $num;
	}
	
	function getPrePage($next) {
		$num = "";
		if ((int)$next > 10) $num = (int)$next - 20;
		if ((int)$num < 1) $num = "";
		return $num;
	}
	
	function getOrderNumber($cnt, $list, $pg) {
		$num = $cnt - ($list * ($pg - 1));
		return $num;
	}
	
	function getOffset($pg, $list) {
		$num = ($pg - 1) * $list;
		if ($num < 0) $num = 0;
		return $num;
	}
	
	function getShortDate($dt) {
		$sdt = substr($dt, 0, 10);
		return $sdt;
	}
	
	function getEnglishDate($dt) {
		$str = "";
		$yy = (int)substr($dt, 0, 4);
		$mm = (int)substr($dt, 5, 2);
		$dd = (int)substr($dt, 8, 2);
		if ($yy && $mm && $dd) {
			//echo $dt . "<br>";
			$timestamp = new_mktime("", "", "", $mm, $dd, $yy);
			$str = date("F j, Y", $timestamp);
		}
		return $str;
	}

	function getFullDate($dt) {
		$yy = (int)substr($dt, 0, 4);
		$mm = (int)substr($dt, 5, 2);
		$dd = (int)substr($dt, 8, 2);
		$hh = (int)substr($dt, 11, 2);
		$nn = (int)substr($dt, 14, 2);
		$ss = (int)substr($dt, 17, 2);
		if (substr($dt, 11, 2) == "") {
			if ($yy == "1987" || $yy == "1988") $timestamp = mktime("", "", "", $mm, $dd, $yy);
			else $timestamp = new_mktime("", "", "", $mm, $dd, $yy);
			$str = date("Y년 n월 j일", $timestamp);
		} else {
			if ($yy == "1987" || $yy == "1988") $timestamp = mktime($hh, $nn, $ss, $mm, $dd, $yy);
			else $timestamp = new_mktime($hh, $nn, $ss, $mm, $dd, $yy);
			$str = date("Y년 n월 j일", $timestamp);
			switch (date("w", $timestamp)) {
				case 0:
					$str .= " 일요일 ";
					break;
				case 1:
					$str .= " 월요일 ";
					break;
				case 2:
					$str .= " 화요일 ";
					break;
				case 3:
					$str .= " 수요일 ";
					break;
				case 4:
					$str .= " 목요일 ";
					break;
				case 5:
					$str .= " 금요일 ";
					break;
				case 6:
					$str .= " 토요일 ";
					break;
			}
			if (substr($dt, 14, 2) != "") {
				if (date("a", $timestamp) == "am") $str .= " 오전 ";
				else $str .= " 오후 ";
				$str .= date("g시 i분 s초", $timestamp);
			}
		}
		return $str;
	}
	
	function getFullTime($dt) {
		$yy = (int)substr($dt, 0, 4);
		$mm = (int)substr($dt, 5, 2);
		$dd = (int)substr($dt, 8, 2);
		$hh = (int)substr($dt, 11, 2);
		$nn = (int)substr($dt, 14, 2);
		$ss = (int)substr($dt, 17, 2);
		$timestamp = new_mktime($hh, $nn, $ss, $mm, $dd, $yy);
		if (date("a", $timestamp) == "am") $str = " 오전 ";
		else $str = " 오후 ";
		if (substr($dt, 17, 2) == "00") $str .= date("h시 i분", $timestamp);
		else $str .= date("h시 i분 s초", $timestamp);
		return $str;
	}
	
	function getReplyImage($level) {
		$img = "";
		if ($level != "") {
			$step = strlen($level) / 2;
			for ($j = 0; $j < $step; $j++) {
				$img .= "&nbsp;&nbsp;";
			}
			$img .= "<img src=\"../../images/board/re.jpg\" width=\"28\" height=\"17\" border=\"0\" align=\"absmiddle\">";
		}
		return $img;
	}

	function getSelectedReplyImage($level) {
		$img = "";
		if ($level != "") {
			$step = strlen($level) / 2;
			for ($j = 0; $j < $step; $j++) {
				$img .= "&nbsp;&nbsp;";
			}
			$img .= "<img src=\"../../images/board/sel_re.jpg\" width=\"28\" height=\"17\" border=\"0\" align=\"absmiddle\">";
		}
		return $img;
	}

	function getNewImage($dt, $new) {
		$img = "";
		if ($dt >= date("Y-m-d", new_mktime(0, 0, 0, date("m"), date("d") - (int)$new, date("Y")))) $img .= " <img src=\"../../images/board/new.jpg\" width=\"27\" height=\"15\" border=\"0\" align=\"absmiddle\">";
		return $img;
	}

	function getHotImage($hot, $read) {
		$img = "";
		if ((int)$read > (int)$hot) $img .= " <img src=\"../../images/board/hot.jpg\" width=\"27\" height=\"15\" border=\"0\" align=\"absmiddle\">";
		return $img;
	}
	
	function getSubject($head, $sub) {
		if ($head == "") $str = $sub;
		else $str = "[" . $head . "]" . $sub;
		return $str;
	}

	function getSubjectLength($len, $level, $cmt, $cnt, $reply, $new, $hot) {
		if ($cmt == "Y" && (int)$cnt > 0) $len = $len - strlen($cnt) - 2;
		if ($reply != "") {
			$len -= strlen($level) / 2;
			$len -= 4;
		}
		if ($new != "") $len -= 5;
		if ($hot != "") $len -= 5;
		return $len;
	}
	
	function cutString($str, $len, $tail=" ...") {
		if (strlen($str) > $len) {
			for ($i = 0; $i < $len; $i++) {
				if (ord($str[$i]) > 127) $i++;
			}
			$str = substr($str, 0, $i) . $tail;
		}
		return $str;
	}
	
	function sendEmail($to, $from, $sub, $msg) {
		global $web_http_url;
		$tpl = new rFastTemplate("../../../tpl/main");
		$tpl->define(array(main => "letter.html"));
		$tpl->assign(array(DOMAIN_URL => $web_http_url,
		                   MESSAGE    => $msg));
		$tpl->parse(FINAL, "main");
		$content = $tpl->GetTemplate(FINAL);
		$headers = "Return-Path: " . $from . "\n";
		$headers .= "Reply-To: " . $from . "\n";
		$headers .= "From: " . $from . "\n";
		$headers .= "Content-Type: text/html; charset=euc-kr\n";
		$headers .= "Mime-Version: 1.0\n";
		$flag = mail($to, $sub, $content, $headers);
		return $flag;
	}

	function makeAutoLink($str) {
		$regex['file'] = "gz|tgz|tar|gzip|zip|rar|mpeg|mpg|exe|rpm|dep|rm|ram|asf|ace|viv|avi|mid|gif|jpg|png|bmp|eps|mov";
		$regex['file'] = "(\.({$regex['file']})\") TARGET=\"_blank\"";
		$regex['http'] = "(http|https|ftp|telnet|news|mms):\/\/(([\xA1-\xFEa-z0-9:_\-]+\.[\xA1-\xFEa-z0-9,:;&#=_~%\[\]?\/.,+\-]+)([.]*[\/a-z0-9\[\]]|=[\xA1-\xFE]+))";
		$regex['mail'] = "([\xA1-\xFEa-z0-9_.-]+)@([\xA1-\xFEa-z0-9_-]+\.[\xA1-\xFEa-z0-9._-]*[a-z]{2,3}(\?[\xA1-\xFEa-z0-9=&\?]+)*)";
		// &lt; 로 시작해서 3줄뒤에 &gt; 가 나올 경우와
		// IMG tag 와 A tag 의 경우 링크가 여러줄에 걸쳐 이루어져 있을 경우
		// 이를 한줄로 합침 (합치면서 부가 옵션들은 모두 삭제함)
		$src[] = "/<([^<>\n]*)\n([^<>\n]+)\n([^<>\n]*)>/i";
		$tar[] = "<\\1\\2\\3>";
		$src[] = "/<([^<>\n]*)\n([^\n<>]*)>/i";
		$tar[] = "<\\1\\2>";
		$src[] = "/<(A|IMG)[^>]*(HREF|SRC)[^=]*=[ '\"\n]*({$regex['http']}|mailto:{$regex['mail']})[^>]*>/i";
		$tar[] = "<\\1 \\2=\"\\3\">";
		// email 형식이나 URL 에 포함될 경우 URL 보호를 위해 @ 을 치환
		$src[] = "/(http|https|ftp|telnet|news|mms):\/\/([^ \n@]+)@/i";
		$tar[] = "\\1://\\2_HTTPAT_\\3";
		// 특수 문자를 치환 및 html사용시 link 보호
		$src[] = "/&(quot|gt|lt|nbsp)/i";
		$tar[] = "!\\1";
		$src[] = "/<a([^>]*)href=[\"' ]*({$regex['http']})[\"']*[^>]*>/i";
		$tar[] = "<A\\1HREF=\"\\3_orig://\\4\" TARGET=\"_blank\">";
		$src[] = "/href=[\"' ]*mailto:({$regex['mail']})[\"']*>/i";
		$tar[] = "HREF=\"mailto:\\2#-#\\3\">";
		$src[] = "/<([^>]*)(background|codebase|src)[ \n]*=[\n\"' ]*({$regex['http']})[\"']*/i";
		$tar[] = "<\\1\\2=\"\\4_orig://\\5\"";
		// 링크가 안된 url및 email address 자동링크
		$src[] = "/((SRC|HREF|BASE|GROUND)[ ]*=[ ]*|[^=]|^)({$regex['http']})/i";
		$tar[] = "\\1<A HREF=\"\\3\" TARGET=\"_blank\">\\3</a>";
		$src[] = "/({$regex['mail']})/i";
		$tar[] = "<A HREF=\"mailto:\\1\">\\1</a>";
		$src[] = "/<A HREF=[^>]+>(<A HREF=[^>]+>)/i";
		$tar[] = "\\1";
		$src[] = "/<\/A><\/A>/i";
		$tar[] = "</A>";
		// 보호를 위해 치환한 것들을 복구
		$src[] = "/!(quot|gt|lt|nbsp)/i";
		$tar[] = "&\\1";
		$src[] = "/(http|https|ftp|telnet|news|mms)_orig/i";
		$tar[] = "\\1";
		$src[] = "'#-#'";
		$tar[] = "@";
		$src[] = "/{$regex['file']}/i";
		$tar[] = "\\1";
		$src[] = "/_HTTPAT_/";
		$tar[] = "@";
		// 이미지에 보더값 0 을 삽입
		$src[] = "/<(IMG SRC=\"[^\"]+\")>/i";
		$tar[] = "<\\1 BORDER=0>";
		$str = preg_replace($src, $tar, $str);
		return $str;
	}

	function resizeImage($rewidth, $reheight, $smallfile, $picture){
		$picsize = getimagesize($picture);
		$px = 0;
		$py = 0;
		$pw = $picsize[0];
		$ph = $picsize[1];
		if ($picsize[0] > $rewidth && $picsize[1] > $reheight) {
			$xper = $picsize[0] / $rewidth;
			if ((int)$reheight == 0) $yper = $xper;
			else $yper = $picsize[1] / $reheight;
			$chkper = $xper - $yper;
			if ($chkper > 0 ) {
				$pw = intval($rewidth * $yper); 
				$px = intval(($picsize[0] - $pw) / 2); 
			} else if ($chkper < 0) {
				$ph = intval($reheight * $xper); 
				$py = intval(($picsize[1] - $ph) / 2); 
			} else {
				$reheight = $picsize[1] * $rewidth / $picsize[0];
			}
			if ($picsize[2] == 1) {
				$dstimg = imagecreate($rewidth, $reheight);
				$srcimg = imagecreatefromgif($picture);
				$tmpimg = imagecreate($pw, $ph);
				imagecolorallocate($dstimg, 255, 255, 255);
				imagecolorallocate($tmpimg, 255, 255, 255);
				imagecopy($tmpimg, $srcimg, 0, 0, $px, $py, $pw, $ph);
				imagecopyresampled($dstimg, $srcimg, 0, 0, $px, $py, $rewidth, $reheight, $pw, $ph);
				imageinterlace($dstimg);
				//header("Content-Type: imgage/gif");
				imagegif($dstimg, $smallfile, 100);
			} else if ($picsize[2] == 2) {
				$dstimg = imagecreatetruecolor($rewidth, $reheight);
				$srcimg = imagecreatefromjpeg($picture);
				$tmpimg = imagecreatetruecolor($pw, $ph);
				imagecolorallocate($dstimg, 255, 255, 255);
				imagecolorallocate($tmpimg, 255, 255, 255);
				imagecopy($tmpimg, $srcimg, 0, 0, $px, $py, $pw, $ph);
				imagecopyresampled($dstimg, $tmpimg, 0, 0, 0, 0, $rewidth, $reheight, $pw, $ph);
				imageinterlace($dstimg);
				//header("Content-Type: images/jpeg");
				imagejpeg($dstimg, $smallfile, 100);
			} else if ($picsize[2] == 3) {
				$dstimg = imagecreatetruecolor($rewidth, $reheight);
				$srcimg = imagecreatefrompng($picture);
				$tmpimg = imagecreatetruecolor($pw, $ph);
				imagecolorallocate($dstimg, 255, 255, 255);
				imagecolorallocate($tmpimg, 255, 255, 255);
				imagecopy($tmpimg, $srcimg, 0, 0, $px, $py, $pw, $ph);
				imagecopyresampled($dstimg, $srcimg, 0, 0, $px, $py, $rewidth, $reheight, $pw, $ph);
				imageinterlace($dstimg);
				//header("Content-Type: images/png");
				imagepng($dstimg, $smallfile, 100);
			}
			@imagedestroy($tmpimg);
			@imagedestroy($dstimg);
			@imagedestroy($srcimg); 
		}
	}

	function downloadFile($file, $name, $view, $speed, $limit) { // 경로, 원파일명, 다운 0/보임 1, 다운속도, 속도제한여부
		if (!file_exists($file)) die("File not exist!");
		$size = filesize($file);
		$name = rawurldecode($name);
		if (preg_match("#Opera(/| )([0-9].[0-9]{1,2})#", $_SERVER["HTTP_USER_AGENT"])) $UserBrowser = "Opera";
		else if (preg_match("#MSIE ([0-9].[0-9]{1,2})#", $_SERVER["HTTP_USER_AGENT"])) $UserBrowser = "IE";
		else $UserBrowser = "";
		$view = ($view) ? "attachment" : "inline"; 
		$mime_type = ($UserBrowser == "IE" || $UserBrowser == "Opera")? "application/octetstream" : "application/octet-stream";
		Header("Content-Type: " . $mime_type);
		Header("Content-Disposition: " . $view . "; filename=\"" . $name . "\"");
		Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		Header("Accept-Ranges: bytes");
		Header("Cache-control: private");
		Header("Pragma: private");
		// multipart-download and resume-download
		if (isset($_SERVER["HTTP_RANGE"])) {
			list($a, $range) = explode("=", $_SERVER["HTTP_RANGE"]);
			str_replace($range, "-", $range);
			$size2 = $size - 1;
			$new_length = $size - $range;
			Header("HTTP/1.1 206 Partial Content");
			Header("Content-Length: $new_length");
			Header("Content-Range: bytes $range$size2/$size");
		} else {
			$size2 = $size - 1;
			Header("Content-Length: " . $size);
		}
		$chunksize = 1 * (1024 * $speed);
		$bytes_send = 0;
		if ($file = fopen($file, "rb")) {
			if (isset($_SERVER["HTTP_RANGE"])) fseek($file, $range);
			while (!feof($file) && connection_status() == 0) {
				$buffer = fread($file, $chunksize);
				print($buffer);//echo($buffer); // is also possible
				flush();
				$bytes_send += strlen($buffer);
				if($limit) sleep(1); // 다운로드 속도제한
			}
			fclose($file);
		} else die("Error can not open file!!");
		if (isset($new_length)) $size = $new_length;
		die();
		Header("Connection: close");
	}
?>