<?
	#
	# Web Configuration
	#
	$rootdir = $HTTP_SERVER_VARS["DOCUMENT_ROOT"] . "/v1";
	$http_url = $HTTP_SERVER_VARS["HTTP_HOST"];

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

	#
	# Company Information
	#
	$comp_name = "IHouse";
	$comp_email = "reslife@korea.ac.kr";

	$cf_email_under = "reslife@korea.ac.kr";
	$cf_email_graduate = "reslife_grad@korea.ac.kr";
	$cf_email_faculty = "reslife_prof@korea.ac.kr";
	$cf_email_facility = "reslife_prof@korea.ac.kr";

	ini_set("SMTP", "smtp.korea.ac.kr");
?>