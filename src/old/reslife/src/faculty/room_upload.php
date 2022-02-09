<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] == 8 || (int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/faculty_tpl.php");
			$row = 0;
			$insert = 0;
			$update = 0;
			$none = 0;
			$less = 0;
			$exist = 0;
			$book = 0;
			$fee = 0;
			$error = 0;
			$fp = fopen ("../../../upload/upload_faculty.csv", "r");
			while ($data = fgetcsv($fp, 1000, ",")) {
				if (!$row) {
					$row++;
					continue;
				}
				$row++;
				//������ȣ		 0 $apply_no
				//��������		 1 $state
				//��Ÿ��			 2 $rate_code
				//ȣ��				 3 $room_code
				//��					 4 $lname
				//�̸�1				 5 $fname
				//�̸�2				 6 $mname
				//������			 7 $arrival
				//�����			 8 $departure
				//���μ�		 9 $depart_ku
				//���	10 $request
				//�����ڳ�Ʈ	11 $admin
				$apply_no = $data[0];
				$state = $data[1];
				$rate_code = $data[2];
				$room_code = $data[3];
				$lname = $data[4];
				$fname = $data[5];
				$mname = $data[6];
				$arrival = $data[7];
				$departure = $data[8];
				$depart_ku = $data[9];
				$request = $data[10];
				$admin = $data[11];
				if (!$state) $state = "IW";
				if ($affiliate != "N") $affiliate = "Y";
				if (!$faculty->getFacultyNumber(date("Y").date("m"))) $apply_no = date("Y"). date("m") . "0001";
				else $apply_no = "";
				$count_dd = 0;
				$count_mm = 0;
				$count_temp = 1;
				$count_flag = true;
				$count_total = dateDiff($arrival, $departure);
				while ($count_flag) {
					$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($arrival, 5, 2) + $count_temp, substr($arrival, 8, 2), substr($arrival, 0, 4)));
					if ($departure < $temp_dt) {
						$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($arrival, 5, 2) + $count_temp - 1, substr($arrival, 8, 2), substr($arrival, 0, 4)));
						$count_dd = dateDiff($temp_dt, $departure);
						$count_flag = false;
					} else {
						$count_mm++;
						$count_temp++;
					}
				}
				//if (($rate == "STUDIO2" || $rate == "1BED" || $rate == "2BED" || $rate == "DEPART") && $affiliate == "N") $none++;
				//else if (($rate == "TRIPLE" || $rate == "QUAD" || $rate == "QUINT" || $rate == "OCTET" || $rate == "HANDICAP") && $affiliate == "N") $none++;
				//else if (($rate == "STUDIO2" || $rate == "1BED" || $rate == "2BED") && $count_mm == 0) $less--;
				//else {
					$flag = $faculty->insertUpload($apply_no, $state, $lname, $fname, $mname, $depart_ku, $arrival, $departure, $rate_code, $request, $admin);
					if (!$flag) $error++;
					else {
						$apply_no = $faculty->facultyNumber;
						//if ($faculty->isRoomExist($apply_no, $room_code)) $exist++;
						//else if (!$faculty->isRoomAvailable($apply_no, $room_code)) $book++;
						//else {
							$flag = $faculty->insertRoom($apply_no, $room_code);
							if ($flag) {
								$faculty->calculateFee($rate_code, $affiliate, $count_dd, $count_mm, $count_total);
								$room_cnt = $faculty->getRoomCount($apply_no);
								$deposit = (int)$faculty->feeDeposit * $room_cnt;
								$rental = (int)$faculty->feeRental * $room_cnt;
								$flag = $faculty->updateDepositFee($apply_no, $deposit);
								$flag = $faculty->updateRentalFee($apply_no, $rental);
								//$flag = $faculty->updateFacultyState($apply_no, "AS");
							} else $fee++;
						//}
						$insert++;
					}
				//}
			}
			$faculty->closeDatabase();
			unset($faculty);
			echo "<script language=\"javascript\">";
			echo "alert(\"�۾����� ������ �����ϴ�.\\n\\n�Ѱ���:" . ($row - 1) . ".\\n\\n�߰�:$insert.\\n\\n��⸸:$less.\\n\\n�����:$exist.\\n\\n����:$book.\\n\\n��ݿ���:$fee.\\n\\n����:$error.\");";
			echo "</script>";
		}
	}
?>