<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 3) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/header_tpl.php");

			$main_index = 0;
			$sub_index = 1;
			$page_name = "";
			$on_load = "document.MailForm.to.focus();";

			$s_type = $_GET["s_type"];
			$s_text = $_GET["s_text"];
			$s_term = $_GET["s_term"];
			$s_state = $_GET["s_state"];
			$s_kind = $_GET["s_kind"];
			$s_current = $_GET["s_current"];
			$s_period = $_GET["s_period"];
			$s_rate = $_GET["s_rate"];
			$s_room = $_GET["s_room"];
			$s_dorm = $_GET["s_dorm"];
			$s_year1 = $_GET["s_year1"];
			$s_month1 = $_GET["s_month1"];
			$s_day1 = $_GET["s_day1"];
			$s_year2 = $_GET["s_year2"];
			$s_month2 = $_GET["s_month2"];
			$s_day2 = $_GET["s_day2"];
			$no = $_GET["no"];
			$email = $_GET["email"];
			if (!$s_type) $s_type = $_POST["s_type"];
			if (!$s_text) $s_text = $_POST["s_text"];
			if (!$s_term) $s_term = $_POST["s_term"];
			if (!$s_state) $s_state = $_POST["s_state"];
			if (!$s_kind) $s_kind = $_POST["s_kind"];
			if (!$s_current) $s_current = $_POST["s_current"];
			if (!$s_period) $s_period = $_POST["s_period"];
			if (!$s_rate) $s_rate = $_POST["s_rate"];
			if (!$s_room) $s_room = $_POST["s_room"];
			if (!$s_dorm) $s_dorm = $_POST["s_dorm"];
			if (!$s_year1) $s_year1 = $_POST["s_year1"];
			if (!$s_month1) $s_month1 = $_POST["s_month1"];
			if (!$s_day1) $s_day1 = $_POST["s_day1"];
			if (!$s_year2) $s_year2 = $_POST["s_year2"];
			if (!$s_month2) $s_month2 = $_POST["s_month2"];
			if (!$s_day2) $s_day2 = $_POST["s_day2"];
			if (!$no) $no = $_POST["no"];
			if (!$email) $email = $_POST["email"];
			if (!is_numeric($no)) $no = 0;

			$subject = "";
			$content = "";
			$img_file = "";
			if ($no) {
				include_once("../../lib/class.cMailbox.php");
				$mailbox = new cMailbox($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $mailboxTable, $applicantTable);
				$mailbox->connectDatabase();
				$mailbox->getMailInfo($no);
				if (file_exists("../../../upload/mail/".$no.".jpg")) $img_file = "���� ��ϵ� �̹����� <a href=\"javascript:previewImage('../../../upload/mail/$no.jpg')\">" . $mailbox->mailFileName . "</a>(" . round((int)$mailbox->mailFileSize / 1024, 1) . "KB) �Դϴ�.";
				$email = "";
				if ($mailbox->mailReceiver == "�˻��� ����ڿ���" || $mailbox->mailReceiver == "�˻��� �����ڿ���" || $mailbox->mailReceiver == "�˻��� �л��� �����ڿ���" || $mailbox->mailReceiver == "�˻��� ���д� �����ڿ���" || $mailbox->mailReceiver == "�˻��� ������ �����ڿ���" || $mailbox->mailReceiver == "�˻��� �ü� �����ڿ���") $to = "";
				else $to = $mailbox->mailReceiver;
				$subject = $mailbox->mailSubject;
				$content = $mailbox->mailContent;
				$mailbox->closeDatabase();
				unset($mailbox);
			} else {
				if ($email == "mem" || $email == "grad_mem") $to = "�˻��� ����ڿ���";
				else if ($email == "app" || $email == "grad_app") $to = "�˻��� �����ڿ���";
				else if ($email == "stu") $to = "�˻��� �л��� �����ڿ���";
				else if ($email == "lan") $to = "�˻��� ���д� �����ڿ���";
				else if ($email == "fac") $to = "�˻��� ������ �����ڿ���";
				else if ($email == "hall") $to = "�˻��� �ü� �����ڿ���";
				else if ($email == "defer") $to = "�˻��� ���ο����ڿ���";
				else {
					$to = $email;
					$email = "";
				}
			}

			if ($to) $read_only = "readOnly";
			else $read_only = "";

			$tpl->assign(array(SEARCH_TYPE    => $s_type,
			                   SEARCH_TEXT    => $s_text,
			                   SEARCH_TERM    => $s_term,
			                   SEARCH_STATE   => $s_state,
			                   SEARCH_KIND    => $s_kind,
			                   SEARCH_CURRENT => $s_current,
			                   SEARCH_PERIOD  => $s_period,
			                   SEARCH_RATE    => $s_rate,
			                   SEARCH_ROOM    => $s_room,
			                   SEARCH_DORM    => $s_dorm,
			                   SEARCH_YEAR1   => $s_year1,
			                   SEARCH_MONTH1  => $s_month1,
			                   SEARCH_DAY1    => $s_day1,
			                   SEARCH_YEAR2   => $s_year2,
			                   SEARCH_MONTH2  => $s_month2,
			                   SEARCH_DAY2    => $s_day2,
			                   EMAIL_ADDRESS  => $email,
			                   TO_ADDRESS     => htmlspecialchars($to),
			                   READ_ONLY      => $read_only,
			                   MAIL_NUMBER    => $no,
			                   MAIL_SUBJECT   => htmlspecialchars($subject),
			                   IMAGE_FILE     => $img_file,
			                   MAIL_CONTENT   => stripslashes($content)));

			include_once("../common/footer_tpl.php");
		}
	}
?>