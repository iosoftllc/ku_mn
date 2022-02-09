<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/room_tpl.php");

			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$record = "Room,Rate,Phone,IP\n";
			$room->getRoomList($s_rate, "", "", $s_type, $s_text, $sort);
			for ($i = 0; $i < count($room->roomListCode); $i++) {
		    $record .= "\"" . $room->roomListCode[$i] . "\",\"";
		    $record .= $room->getRateName($room->roomListRate[$i]) . "\",\"";
		    $record .= $room->roomListPhone[$i] . "\",\"";
		    $record .= $room->roomListIP[$i] . "\"\n";
			}
			$record = substr($record, 0, strlen($record) - 1);

			$room->closeDatabase();
			unset($room);

			$csv_file = "../../../upload/temp.csv";
	    $fp = fopen($csv_file, "w");
	    fputs($fp, $record);
	    fclose($fp);

  	  $date = date("Ymd");
  	  header("Content-type: application/octet-stream");
  	  header("Content-Length: " . filesize($csv_file));
  	  header("Content-Disposition: attachment; filename=room_$date.csv");
  	  header("Content-Transfer-Encoding: binary");
  	  header("Pragma: no-cache");
  	  header("Expires: 0");

    	$fp = fopen($csv_file, "r"); 
    	if(!fpassthru($fp)) fclose($fp);

    	unlink($csv_file);
		}
	}
?>