<?
	include_once("lib/conf.common.php");
	include_once("lib/func.common.php");
	include_once("lib/class.cFaculty.php");

	$room = array();
	$room[] = "302";
	$room[] = "412";
	$room[] = "207";
	$room[] = "505";
	$room[] = "303";
	$room[] = "302";
	$room[] = "304";
	$room[] = "305";
	$room[] = "306";
	$room[] = "310";
	$room[] = "311";
	$room[] = "402";
	$room[] = "403";
	$room[] = "409";
	$room[] = "410";
	$room[] = "411";
	$room[] = "503";
	$room[] = "504";
	$room[] = "301";
	$room[] = "202";
	$room[] = "203";
	$room[] = "204";
	$room[] = "205";
	$room[] = "206";
	$room[] = "208";
	$room[] = "307";
	$room[] = "308";
	$room[] = "309";
	$room[] = "405";
	$room[] = "406";
	$room[] = "407";
	$room[] = "501";
	$room[] = "621";
	$room[] = "312";
	$room[] = "408";
	$room[] = "N434";
	$room[] = "E219";
	$room[] = "N331";
	$room[] = "N433";
	$room[] = "N124";
	$room[] = "N330";

	$name = array();
	$name[] = "Yoon K, Choi";
	$name[] = "Felicia, Nimue Ackerman";
	$name[] = "Richard, Nichols";
	$name[] = "Anders, Karlsson";
	$name[] = "Abraham, Shragge";
	$name[] = "Steven, Lee";
	$name[] = "Angie, Chung";
	$name[] = "QuanSheng, Zhao";
	$name[] = "Milan, Svolik";
	$name[] = "Kenton, Whitmire";
	$name[] = "Bill, Seaman";
	$name[] = "Yu, Jaehyuk";
	$name[] = "Kathleen, King";
	$name[] = "Hilary, Silver";
	$name[] = "Jeff, Kentor";
	$name[] = "YongChan, Ro";
	$name[] = "Richard, McBride";
	$name[] = "Charles, Cameron";
	$name[] = "O Yul, Kwon";
	$name[] = "Kerk, Philips";
	$name[] = "Edward, Monsour";
	$name[] = "Murray,  Johannsen";
	$name[] = "Wilfred, Ethier";
	$name[] = "Thomas, Byrne";
	$name[] = "Tony, Rothman";
	$name[] = "David, Rousseau";
	$name[] = "Bojan, Petrovic";
	$name[] = "Marc, Mehlman";
	$name[] = "Min, Zhou";
	$name[] = "Thomas, Doherty";
	$name[] = "Adam, S Goodie";
	$name[] = "Naresh, Malhotra";
	$name[] = "Goran, Thereborn";
	$name[] = "Block";
	$name[] = "Block";
	$name[] = "Burglind, Jungmann";
	$name[] = "Wayne, Smith";
	$name[] = "Evan, Berman";
	$name[] = "Stephen, Jackson";
	$name[] = "Michael, Miller";
	$name[] = "Teofilo, Daquila";

	$in = array();
	$in[] = "2007-06-21";
	$in[] = "2007-06-26";
	$in[] = "2007-06-27";
	$in[] = "2007-06-29";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-07-01";
	$in[] = "2007-06-29";
	$in[] = "2007-06-29";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-06-30";
	$in[] = "2007-07-01";

	$out = array();
	$out[] = "2007-08-15";
	$out[] = "2007-08-13";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-12";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-13";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-10";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-11";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-11";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";
	$out[] = "2007-08-15";

	$faculty = new cFaculty($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $facultyTable, $rate1Table, $payment1Table, $roomTable, $bookTable);
	$faculty->connectDatabase();

	for ($i = 0; $i < count($room); $i++) {
		if ($room[$i] && $name[$i] && $in[$i] && $out[$i]) {
			if (!$faculty->getFacultyNumber(date("Y").date("m"))) $no = date("Y"). date("m") . "0001";
			else $no = "";
			$rate = $faculty->getRateCode($room[$i]);
			$temp_name = explode(",", $name[$i]);
			$flag = $faculty->insertFaculty1($no, trim($temp_name[1]), trim($temp_name[0]), "2007 International Summer Campus", $in[$i], $out[$i], $rate);
			if ($flag) {
				$no = $faculty->facultyNumber;
				$flag = $faculty->insertRoom($no, $room[$i]);
				if ($flag) {
					$affiliate = "Y";
					$count_dd = 0;
					$count_mm = 0;
					$count_temp = 1;
					$count_flag = true;
					$count_total = dateDiff($in[$i], $out[$i]);
					while ($count_flag) {
						$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($in[$i], 5, 2) + $count_temp, substr($in[$i], 8, 2), substr($in[$i], 0, 4)));
						if ($out[$i] < $temp_dt) {
							$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($in[$i], 5, 2) + $count_temp - 1, substr($in[$i], 8, 2), substr($in[$i], 0, 4)));
							$count_dd = dateDiff($temp_dt, $out[$i]);
							$count_flag = false;
						} else {
							$count_mm++;
							$count_temp++;
						}
					}
					$faculty->calculateFee($rate, $affiliate, $count_dd, $count_mm, $count_total);
					$room_cnt = $faculty->getRoomCount($no);
					$deposit = (int)$faculty->feeDeposit * $room_cnt;
					$rental = (int)$faculty->feeRental * $room_cnt;
					$flag = $faculty->updateDepositFee($no, $deposit);
					$flag = $faculty->updateRentalFee($no, $rental);
					$flag = $faculty->updateFacultyState($no, "AS");
				}
			}
			echo "" . ($i + 1) . " - $no - $flag <br>";
		}
		//echo $no[$i] . " " . $rate[$i] . " " . $period[$i] . "<br>";
	}

	$faculty->closeDatabase();
	unset($faculty);
?>