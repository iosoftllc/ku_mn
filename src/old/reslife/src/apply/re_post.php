<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/refund_tpl.php");
	
			$on_load .= "document.RefundForm.student.focus();";
	
			include_once("../common/header_tpl.php");
	
			$tpl->define_dynamic(array(year_row  => "body",
			                           month_row => "body"));
	
			for ($i = 1950; $i <= date("Y") + 1; $i++) {
				$tpl->assign(YEAR_VALUE, $i);
				$tpl->parse(YEAR_ROWS, ".year_row");
			}
			for ($i = 1; $i <= 12; $i++) {
				$temp = $i;
				if ($temp < 10) $temp = "0" . $temp;
				$tpl->assign(MONTH_VALUE, $temp);
				$tpl->parse(MONTH_ROWS, ".month_row");
			}

			if ($mode == "edit") {
				$page_name .= " 수정";
				$refund->getRefundInfo($no);
				$apply_no = $refund->refundApply;
				$cf_apply_no = $refund->refundCFApply;
				$kind = $refund->refundKind;
				$student = $refund->refundStudent;
				$fname = $refund->refundName1;
				$mname = $refund->refundName2;
				$lname = $refund->refundName3;
				$dob = explode("-", $refund->refundDOB);
				$email = $refund->refundEmail;
				if ($refund->refundVacate == "0000-00-00") $vacate_flag = "Y";
				else $vacate_flag = "N";
				$vacate = explode("-", $refund->refundVacate);
				$reason = $refund->refundReason;
				$method = $refund->refundMethod;
				$info1 = $refund->refundMethod1;
				$info2 = $refund->refundMethod2;
				$info3 = $refund->refundMethod3;
				$info4 = $refund->refundMethod4;
				$info5 = $refund->refundMethod5;
				$info6 = $refund->refundMethod6;
				$dorm = $refund->refundDorm;
				$room = $refund->refundRoom;
				if ($refund->refundPeriod2 == "") $refund_flag = "Y";
				else $refund_flag = "N";
				$old = $refund->refundPeriod1;
				$new = $refund->refundPeriod2;
				if (!$new && $method == "M") $info2 = $refund->refundAddrLine1;
				$addr_line2 = $refund->refundAddrLine2;
				$addr_line3 = $refund->refundAddrLine3;
				$addr_city = $refund->refundAddrCity;
				$addr_state = $refund->refundAddrState;
				$addr_country = $refund->refundAddrCountry;
				$addr_postal = $refund->refundAddrPostal;
				$admin = $refund->refundAdmin;
				$photo = getUploadImage("$pht_dir/$no.jpg");
			} else {
				$page_name .= " 추가";
				$apply_no = "";
				$cf_apply_no = "";
				$kind = "U";
				$student = "";
				$fname = "";
				$mname = "";
				$lname = "";
				$dob = array();
				$email = "";
				$vacate_flag = "Y";
				$vacate = array();
				$reason = "";
				$method = "W";
				$info1 = "";
				$info2 = "";
				$info3 = "";
				$info4 = "";
				$info5 = "";
				$info6 = "";
				$addr_line2 = "";
				$addr_line3 = "";
				$addr_city = "";
				$addr_state = "";
				$addr_country = "";
				$addr_postal = "";
				$dorm = "";
				$room = "";
				$refund_flag = "Y";
				$old = "";
				$new = "";
				$admin = "";
				$photo = "";
			}
	
			$tpl->assign(array(MODE             => $mode,
			                   SEL_PAGE         => $page,
			                   SEARCH_TYPE      => $s_type,
			                   SEARCH_TEXT      => $s_text,
			                   SEARCH_APPROVE   => $s_app,
			                   SEARCH_KIND      => $s_kind,
			                   SEARCH_NEW       => $s_new,
			                   SEARCH_PERIOD    => $s_period,
			                   SORT1_VALUE      => $sort1,
			                   SORT2_VALUE      => $sort2,
			                   REFUND_NUMBER    => $no,
			                   REFUND_APPLY     => $apply_no,
			                   REFUND_CF_APPLY  => $cf_apply_no,
			                   REFUND_KIND      => $kind,
			                   REFUND_STUDENT   => $student,
			                   REFUND_FNAME     => stripslashes($fname),
			                   REFUND_MNAME     => stripslashes($mname),
			                   REFUND_LNAME     => stripslashes($lname),
			                   REFUND_DOB_YY    => $dob[0],
			                   REFUND_DOB_MM    => $dob[1],
			                   REFUND_DOB_DD    => $dob[2],
			                   REFUND_EMAIL     => $email,
			                   REFUND_VACATE    => $vacate_flag,
			                   REFUND_VACATE_YY => $vacate[0],
			                   REFUND_VACATE_MM => $vacate[1],
			                   REFUND_VACATE_DD => $vacate[2],
			                   REFUND_REASON    => stripslashes($reason),
			                   REFUND_METHOD    => $method,
			                   REFUND_INFO1     => stripslashes($info1),
			                   REFUND_INFO2     => stripslashes($info2),
			                   REFUND_INFO3     => stripslashes($info3),
			                   REFUND_INFO4     => stripslashes($info4),
			                   REFUND_INFO5     => stripslashes($info5),
			                   REFUND_INFO6     => stripslashes($info6),
			                   ADDRESS_LINE2    => $addr_line2,
			                   ADDRESS_LINE3    => $addr_line3,
			                   ADDRESS_CITY     => $addr_city,
			                   ADDRESS_STATE    => $addr_state,
			                   ADDRESS_COUNTRY  => $addr_country,
			                   ADDRESS_POSTAL   => $addr_postal,
			                   REFUND_DORM      => $dorm,
			                   REFUND_ROOM      => $room,
			                   REFUND_FLAG      => $refund_flag,
			                   REFUND_OLD       => $old,
			                   REFUND_NEW       => $new,
			                   REFUND_ADMIN     => stripslashes($admin),
			                   REFUND_PHOTO     => $photo));

			$refund->closeDatabase();
			unset($refund);
	
			include_once("../common/footer_tpl.php");
		}
	}
?>