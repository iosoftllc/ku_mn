<?
	#
	# Web Configuration
	#
	$webdir = $HTTP_SERVER_VARS["DOCUMENT_ROOT"];
	$rootdir = $webdir . "/admin";
	$web_http_url = $HTTP_SERVER_VARS["SERVER_NAME"];
	$http_url = $HTTP_SERVER_VARS["HTTP_HOST"] . "/admin";
	$temp = explode("/", $HTTP_SERVER_VARS["SCRIPT_NAME"]);
	$html_dir = $temp[3];
	$html_file = substr($temp[4], 0, strrpos($temp[4], "."));

	#
	# MYSQL Configuration
	#
	$mysqlhost = "localhost";
	$mysqldb = "reslife";
	$mysqluser = "reslife";
	$mysqlpass = "19741109";

	#
	# Table Name Configuration
	#
	$accountTable = "intia_account";
	$adminTable = "intia_admin";
	$applicantTable = "intia_applicant";
	$attachTable = "intia_attach";
	$boardTable = "intia_board";
	$boardTypeTable = "intia_boardtype";
	$commentTable = "intia_comment";
	$counterTable = "intia_counter";
	$mailboxTable = "intia_mailbox";
	$paymentTable = "intia_payment";
	$periodTable = "intia_period";
	$preferenceTable = "intia_preference";
	$priceTable = "intia_price";
	$rateTable = "intia_rate";
	$refundTable = "intia_refund";
	$roomTable = "intia_room";
	$spamTable = "intia_spam";
	$facultyTable = "intia_faculty";
	$facultyAttachTable = "intia_faculty_attach";
	$bookTable = "intia_book";
	$rate1Table = "intia_rate1";
	$payment1Table = "intia_payment1";
	$facilityTable = "intia_facility";
	$studentTable = "intia_student";
	$deferTable = "intia_defer";

	$graduateApplicantTable = "intia_grad_applicant";
	$graduatePaymentTable = "intia_grad_payment";
	$graduatePeriodTable = "intia_grad_period";
	$graduatePreferenceTable = "intia_grad_preference";
	$graduatePriceTable = "intia_grad_price";
	$graduateRateTable = "intia_grad_rate";
	$graduateRefundTable = "intia_grad_refund";
	$graduateStudentTable = "intia_grad_student";

	$historyAccessTable = "history_access";
	$historyWorkTable = "history_work";

	#
	# Company Information
	#
	$comp_name = "IHouse";
	$comp_email = "reslife@korea.ac.kr";

	$cf_email_under = "reslife@korea.ac.kr";
	$cf_email_graduate = "reslife_grad@korea.ac.kr";
	$cf_email_faculty = "reslife_prof@korea.ac.kr";
	$cf_email_facility = "reslife_prof@korea.ac.kr";

	#
	# Cache Configuration
	#
	//header("Cache-Control: no-cache, must-revalidate");
	//header("Pragma: no-cache");
	ini_set("session.use_trans_sid", 0);
	ini_set("session.cache_expire", "86400");
	ini_set("session.gc_maxlifetime", "86400");
	//ini_set("session.cookie_domain", ".");
	ini_set("SMTP", "smtp.korea.ac.kr");
	session_save_path("$webdir/session");
?>