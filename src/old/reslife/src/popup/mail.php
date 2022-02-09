<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../../lib/func.common.php");
		include_once("../../lib/class.rFastTemplate.php");
	
		$attach = $_POST["attach"];
		$mail_no = $_POST["mail_no"];
		$msg = $_POST["msg"];
		if ($attach == "") $attach = $_GET["attach"];
		if ($mail_no == "") $mail_no = $_GET["mail_no"];
		if ($msg == "") $msg = $_GET["msg"];

		if ($attach) $img_tag = "<center><img src=\"$attach\" border=\"0\"></center><br><br>";
		else if ($mail_no && file_exists("../../../upload/mail/$mail_no.jpg")) $img_tag = "<center><img src=\"../../../upload/mail/$mail_no.jpg\" border=\"0\"></center><br><br>";
		$msg = $img_tag . getContents($msg, "N");
		$msg .= "<br><br>Korea University<br>Anam Residence Life<br>International Residence<br>Email: reslife@korea.ac.kr<br>Webpage: http://reslife.korea.ac.kr";

		$tpl = new rFastTemplate("../../../tpl/main");
		$tpl->define(array(main => "letter.html"));
	
		$tpl->assign(array(DOMAIN_URL => $HTTP_SERVER_VARS["HTTP_HOST"],
		                   MESSAGE    => stripslashes($msg)));
	
		$tpl->parse(FINAL, "main");
		$tpl->FastPrint(FINAL);
	}
?>